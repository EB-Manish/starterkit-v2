<?php
/**
 * Main Eway Gateway Class
 *
 * @package WooCommerce Eway Payment Gateway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WC_Gateway_EWAY' ) ) {

	/**
	 * WC_Gateway_EWAY class.
	 *
	 * @extends WC_Payment_Gateway
	 */
	class WC_Gateway_EWAY extends WC_Payment_Gateway {

		/**
		 * Eway API object.
		 *
		 * @var WC_EWAY_API
		 */
		protected $api;

		/**
		 * Plugin URL.
		 *
		 * @var string
		 */
		protected $plugin_url;

		/**
		 * Success Response Messages.
		 *
		 * @var array
		 */
		protected $success_response_messages;

		/**
		 * Whether or not logging is enabled.
		 *
		 * @var boolean
		 */
		public static $log_enabled = false;

		/**
		 * Logger instance.
		 *
		 * @var WC_Logger
		 */
		public static $log = false;

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->id                 = 'eway';
			$this->method_title       = __( 'Eway', 'wc-eway' );
			$this->method_description = __( 'Allow customers to securely save their credit card to their account for use with single purchases and subscriptions.', 'wc-eway' );
			$this->supports           = array(
				'subscriptions',
				'products',
				'refunds',
				'subscription_cancellation',
				'subscription_reactivation',
				'subscription_suspension',
				'subscription_amount_changes',
				'subscription_date_changes',
				'subscription_payment_method_change',
				'subscription_payment_method_change_customer',
				'subscription_payment_method_change_admin',
				'multiple_subscriptions',
				'subscription_payment_method_delayed_change',
				'tokenization',
			);

			$this->has_fields = true;

			$this->card_types = '';

			$this->success_response_messages = array( 'A2000', 'A2008', 'A2010', 'A2011', 'A2016' );

			// Load the form fields.
			$this->init_form_fields();

			// Load the settings.
			$this->init_settings();

			// Define user set variables.
			foreach ( $this->settings as $setting_key => $setting ) {
				$this->$setting_key = $setting;
			}

			$this->saved_cards = $this->get_option( 'saved_cards' ) === 'yes' ? true : false;
			self::$log_enabled = 'on' === $this->get_option( 'debug_mode', 'off' );

			// Pay page fallback.
			add_action( 'woocommerce_receipt_' . $this->id, array( $this, 'receipt_page' ) );

			// Save settings.
			if ( is_admin() ) {
				add_action( 'woocommerce_update_options_payment_gateways', array( $this, 'process_admin_options' ) );
				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
			}

			// Enqueue some JS functions and CSS.
			add_filter( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			// Listen for results from Eway.
			add_action( 'woocommerce_api_wc_gateway_eway', array( $this, 'response_listener' ) );

			// Validate value lengths during checkout.
			add_action( 'woocommerce_after_checkout_validation', array( $this, 'validate_checkout_values' ), 10, 2 );

			// Migrate legacy payment tokens when accessing customer payment tokens.
			if ( $this->saved_cards ) {
				add_filter( 'woocommerce_get_customer_payment_tokens', array( $this, 'get_customer_payment_tokens' ), 10, 3 );
			}
		}

		/**
		 * Logging method.
		 *
		 * @param string $message Message to log.
		 */
		public static function log( $message ) {
			if ( self::$log_enabled ) {
				if ( empty( self::$log ) ) {
					self::$log = new WC_Logger();
				}
				self::$log->add( 'eway', $message );
			}
		}

		/**
		 * Initialize Gateway Settings form fields.
		 *
		 * @return void
		 */
		public function init_form_fields() {
			$this->form_fields = array(
				'enabled'           => array(
					'title'       => __( 'Enable/Disable', 'wc-eway' ),
					'label'       => __( 'Enable Eway', 'wc-eway' ),
					'type'        => 'checkbox',
					'description' => '',
					'default'     => 'no',
				),
				'title'             => array(
					'title'       => __( 'Title', 'wc-eway' ),
					'type'        => 'text',
					'description' => __( 'This controls the title which the user sees during checkout.', 'wc-eway' ),
					'default'     => __( 'Credit Card', 'wc-eway' ),
				),
				'description'       => array(
					'title'       => __( 'Description', 'wc-eway' ),
					'type'        => 'text',
					'description' => __( 'This controls the description which the user sees during checkout.', 'wc-eway' ),
					'default'     => 'Pay securely using your credit card.',
				),
				'customer_api'      => array(
					'title'       => __( 'Eway Customer API Key', 'wc-eway' ),
					'type'        => 'text',
					'description' => __( 'User API Key can be found in MYeWAY.', 'wc-eway' ),
					'default'     => '',
					'css'         => 'width: 400px',
				),
				'customer_password' => array(
					'title'       => __( 'Eway Customer Password', 'wc-eway' ),
					'type'        => 'password',
					'description' => __( 'Your Eway Password.', 'wc-eway' ),
					'default'     => '',
				),
				'card_types'        => array(
					'title'   => __( 'Allowed Card Types', 'wc-eway' ),
					'type'    => 'multiselect',
					'class'   => 'chosen_select',
					'css'     => 'width: 450px;',
					'default' => array(
						'visa',
						'mastercard',
						'discover',
						'amex',
						'dinersclub',
						'maestro',
						'unionpay',
						'jcb',
					),
					'options' => array(
						'visa'       => 'Visa',
						'mastercard' => 'MasterCard',
						'discover'   => 'Discover',
						'amex'       => 'AmEx',
						'dinersclub' => 'Diners',
						'maestro'    => 'Maestro',
						'unionpay'   => 'UnionPay',
						'jcb'        => 'JCB',
					),
				),
				'saved_cards'       => array(
					'title'       => __( 'Saved cards', 'wc-eway' ),
					'label'       => __( 'Enable saved cards', 'wc-eway' ),
					'type'        => 'checkbox',
					'description' => __( 'If enabled, users will be able to pay with a saved card during checkout. Card details are saved on Eway servers, not on your store.', 'wc-eway' ),
					'default'     => 'no',
				),
				'testmode'          => array(
					'title'       => __( 'Eway Sandbox', 'wc-eway' ),
					'label'       => __( 'Enable Eway sandbox', 'wc-eway' ),
					'type'        => 'checkbox',
					'description' => __( 'Place the payment gateway in development mode.', 'wc-eway' ),
					'default'     => 'no',
				),
				'debug_mode'        => array(
					'title'    => __( 'Debug Mode', 'wc-eway' ),
					'type'     => 'select',
					'desc_tip' => __( 'Show Detailed Error Messages and API requests in the gateway log.', 'wc-eway' ),
					'default'  => 'off',
					'options'  => array(
						'off' => __( 'Off', 'wc-eway' ),
						'on'  => __( 'On', 'wc-eway' ),
					),
				),
			);
		}

		/**
		 * Check if gateway meets all the requirements to be used.
		 *
		 * @return bool
		 */
		public function is_available() {
			// Check if enabled.
			$is_available = parent::is_available();

			// Check for required fields.
			if ( empty( $this->customer_api ) || empty( $this->customer_password ) ) {
				$is_available = false;
			}

			return apply_filters( 'woocommerce_eway_is_available', $is_available );
		}

		/**
		 * Show error in admin options if the store's currency is not an Eway-supported currency.
		 */
		public function admin_options() {
			if ( ! in_array( get_woocommerce_currency(), array( 'AUD', 'NZD', 'SGD', 'HKD', 'MYR' ), true ) ) {
				echo '<div class="notice notice-error"><p>';
				echo esc_html( __( 'To use Eway payment method, currency must be set as AUD, NZD, SGD, HKD or MYR for your store.', 'wc-eway' ) );
				echo '</p></div>';
			}
			parent::admin_options();
		}

		/**
		 * Make a direct payment through the API for an order and handle the result.
		 *
		 * @param WC_Order   $order The order to process.
		 * @param int        $amount_to_charge The amount to charge for the order.
		 * @param int|string $eway_token_customer_id The customer's TokenCustomerID to include in direct payment request.
		 * @return null|object JSON parsed API response on success, or null on failure
		 * @throws Exception If order does not exist or if payment gateway fails.
		 */
		protected function process_payment_request( $order, $amount_to_charge, $eway_token_customer_id ) {
			$order_id = $order->get_id();

			self::log( $order_id . ': Processing payment request' );

			$result = json_decode( $this->get_api()->direct_payment( $order, $eway_token_customer_id, $amount_to_charge * 100.00 ) );

			if ( intval( $result->Payment->InvoiceReference ) !== $order_id ) {
				throw new Exception( __( 'Order does not exist.', 'wc-eway' ) );
			}

			if ( in_array( $result->ResponseMessage, $this->success_response_messages, true ) ) {
				self::log( $order_id . ': Processing payment completed' );
				// translators: %s Response message.
				$order->add_order_note( sprintf( __( 'Eway token payment completed - %s', 'wc-eway' ), $this->response_message_lookup( $result->ResponseMessage ) ) );
				$this->set_token_customer_id( $order, $eway_token_customer_id );
				$order->payment_complete( $result->TransactionID );

				/**
				 * Triggered when a payment with the gateway is completed.
				 *
				 * @param WC_Order        $order The order whose payment failed.
				 * @param stdClass        $result The result from the API call.
				 * @param WC_Gateway_EWAY $gateway The instance of the gateway.
				 */
				do_action( 'woocommerce_api_wc_gateway_eway_payment_completed', $order, $result, $this );
			} else {
				self::log( $order_id . ': Processing payment failed' );
				if ( isset( $result->Errors ) && ! is_null( $result->Errors ) ) {
					$error = $this->response_message_lookup( $result->Errors );
				} else {
					$error = $this->response_message_lookup( $result->ResponseMessage );
				}

				// translators: %s Error message.
				$order->update_status( 'failed', sprintf( __( 'Eway token payment failed - %s', 'wc-eway' ), $error ) );

				/**
				 * Triggered when a payment with the gateway fails.
				 *
				 * @param WC_Order        $order The order whose payment failed.
				 * @param stdClass        $result The result from the API call.
				 * @param string          $error The error message.
				 * @param WC_Gateway_EWAY $gateway The instance of the gateway.
				 */
				do_action( 'woocommerce_api_wc_gateway_eway_payment_failed', $order, $result, $error, $this );

				throw new Exception( $error );
			}

			return $result;
		}

		/**
		 * Check for token payments and process the payment, otherwise redirect to pay page.
		 *
		 * @param int $order_id The ID of the order.
		 * @return vpod
		 * phpcs:ignore Squiz.Commenting.FunctionCommentThrowTag.Missing
		 */
		public function process_payment( $order_id ) {
			$order = wc_get_order( $order_id );

			self::log( $order_id . ': Processing payment' );

			// Token payment.
			if (
				is_user_logged_in() &&
				isset( $_POST['_eway_nonce'] ) &&
				isset( $_POST['eway_card_id'] )
			) {
				if ( ! wp_verify_nonce( sanitize_key( $_POST['_eway_nonce'] ), 'eway_use_saved_card' ) ) {
					self::log( $order_id . ': Processing payment with token failed nonce check' );
					return;
				}

				$token_id = sanitize_text_field( wp_unslash( $_POST['eway_card_id'] ) );

				if ( 'new' === $token_id ) {
					self::log( $order_id . ': Processing payment with new token' );
					$this->set_token_customer_id( $order, 'new' );
				} else {
					try {
						$token = new WC_Payment_Token_Eway_CC( $token_id );

						if ( ! $token->get_id() || intval( $token->get_user_id() ) !== intval( $order->get_customer_id() ) ) {
							throw new Exception( __( 'The payment token is invalid', 'wc-eway' ) );
						}

						self::log( $order_id . ': Processing payment with token' );

						$this->process_payment_request( $order, $order->get_total(), $token->get_token() );

						WC()->cart->empty_cart();

						self::log( $order_id . ': Redirecting to thanks url' );

						// Return to thankyou page if successful.
						return array(
							'result'   => 'success',
							'redirect' => $this->get_return_url( $order ),
						);

					} catch ( Exception $e ) {
						self::log( $order_id . ': Processing payment with token failed - ' . $e->getMessage() );
						wc_add_notice( $e->getMessage(), 'error' );
						return array(
							'message' => $e->getMessage(),
						);
					}
				}
			} elseif (
				$this->saved_cards &&
				is_user_logged_in() &&
				! empty( $_POST['createaccount'] )
			) {
				// Handle saved cards for newly created user during checkout.
				// If Eway saved cards is enabled and User account is created during checkout and user is logged-in.
				self::log( $order_id . ': Processing payment with new token for newly created account' );
				$this->set_token_customer_id( $order, 'new' );
			}

			self::log( $order_id . ': Redirecting to payment URL' );

			// Redirect to pay/receipt page to follow normal credit card payment.
			return array(
				'result'   => 'success',
				'redirect' => $order->get_checkout_payment_url( true ),
			);
		}

		/**
		 * Request an access code for use in an Eway Transparent Redirect payment.
		 *
		 * @since 3.5.1 Set transaction type to 'Purchase'.
		 *
		 * @param WC_Order $order The order whose token customer id should be used.
		 * @return mixed JSON response from API.
		 * @throws Exception If error occurs during API request.
		 */
		protected function request_access_code( $order ) {

			$token_payment = $this->get_token_customer_id( $order );

			if ( $token_payment && 'new' === $token_payment ) {
				$result = json_decode( $this->get_api()->request_access_code( $order, 'TokenPayment' ) );
			} elseif ( 0 === $order->get_total() && 'shop_subscription' === $order->get_type() ) {
				$result = json_decode( $this->get_api()->request_access_code( $order, 'CreateTokenCustomer' ) );
			} else {
				$result = json_decode( $this->get_api()->request_access_code( $order ) );
			}

			if ( isset( $result->Errors ) && ! is_null( $result->Errors ) ) {
				throw new Exception( $this->response_message_lookup( $result->Errors ) );
			}

			return $result;

		}

		/**
		 * Load the payment form.
		 *
		 * @param  int $order_id The order to load.
		 * @return void
		 */
		public function receipt_page( $order_id ) {
			wp_enqueue_script( 'eway-credit-card-form' );

			// Get the order.
			$order = wc_get_order( $order_id );

			try {

				$result = $this->request_access_code( $order );
				$this->print_receipt_page_css();

				ob_start();
				$full_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
				wc_get_template( 'eway-cc-form.php', array(), 'eway/', plugin_dir_path( __FILE__ ) . '../templates/' );
				echo '<input type="hidden" name="EWAY_ACCESSCODE" value="' . esc_attr( $result->AccessCode ) . '"/>';
				echo '<input type="hidden" name="EWAY_CARDNAME" value="' . esc_attr( $full_name ) . '"/>';
				echo '<input type="hidden" name="EWAY_CARDNUMBER" id="EWAY_CARDNUMBER" value=""/>';
				echo '<input type="hidden" name="EWAY_CARDEXPIRYMONTH" id="EWAY_CARDEXPIRYMONTH" value=""/>';
				echo '<input type="hidden" name="EWAY_CARDEXPIRYYEAR" id="EWAY_CARDEXPIRYYEAR" value=""/>';
				$form  = '<form method="post" id="eway_credit_card_form">';
				$form .= '<input type="hidden" id="EWAY_SUBMIT_URL" value="' . esc_url( $result->FormActionURL ) . '"/>';
				$form .= ob_get_clean();
				$form .= '</form>';
				echo $form; // phpcs:ignore WordPress.Security.EscapeOutput
			} catch ( Exception $e ) {
				self::log( 'CC Form display error: ' . $e->getMessage() );
				wc_add_notice( $e->getMessage() . ': ' . __( 'Please check your Eway API key and password.', 'wc-eway' ), 'error' );
				wc_print_notices();
				return;
			}
		}

		/**
		 * Print the css needed to show the card type inside the CC input box.
		 *
		 * @since 3.1.10 introduced
		 */
		public function print_receipt_page_css() {

			$card_types = array(
				'visa',
				'mastercard',
				'dinersclub',
				'jcb',
				'amex',
				'discover',
			);

			$css = '.wc-credit-card-form-card-number{ font-size: 1.5em; padding: 8px; background-repeat: no-repeat; background-position: right;  }' . PHP_EOL;
			foreach ( $card_types as $card_type ) {
				$card_image_filename = 'dinersclub' === $card_type ? 'diners' : $card_type;
				$card_image_url      = WC()->plugin_url() . "/assets/images/icons/credit-cards/{$card_image_filename}.png";
				$css                .= ".woocommerce-checkout.woocommerce-order-pay  .wc-credit-card-form-card-number.$card_type{  background-image: url( $card_image_url ); }" . PHP_EOL;
			}

			echo '<style>', esc_html( $css ), '</style>';
		}

		/**
		 * Get the Eway API object.
		 *
		 * @return object WC_EWAY_API
		 */
		public function get_api() {
			if ( is_object( $this->api ) ) {
				return $this->api;
			}

			require 'class-wc-eway-api.php';

			$this->api = new WC_EWAY_API( $this->customer_api, $this->customer_password, 'yes' === $this->testmode ? 'sandbox' : 'production', $this->debug_mode );

			return $this->api;
		}

		/**
		 * Return all icons for card types supported by Eway.
		 *
		 * @return array
		 */
		protected function get_all_payment_icons() {
			$plugin_url = $this->plugin_url();
			return array(
				'visa'       => '<img src="' . $plugin_url . 'assets/images/visa.svg" class="eway-icon" alt="Visa" />',
				'mastercard' => '<img src="' . $plugin_url . 'assets/images/mastercard.svg" class="eway-icon" alt="MasterCard" />',
				'discover'   => '<img src="' . $plugin_url . 'assets/images/discover.svg" class="eway-icon" alt="Discover" />',
				'amex'       => '<img src="' . $plugin_url . 'assets/images/amex.svg" class="eway-icon" alt="Amex" />',
				'dinersclub' => '<img src="' . $plugin_url . 'assets/images/diners.svg" class="eway-icon" alt="Diners" />',
				'maestro'    => '<img src="' . $plugin_url . 'assets/images/maestro.svg" class="eway-icon" alt="Maestro" />',
				'unionpay'   => '<img src="' . $plugin_url . 'assets/images/unionpay.svg" class="eway-icon" alt="UnionPay" />',
				'jcb'        => '<img src="' . $plugin_url . 'assets/images/jcb.svg" class="eway-icon" alt="JCB" />',
			);
		}

		/**
		 * Return icons for allowed card types.
		 *
		 * @return string
		 */
		public function get_icon() {
			wp_enqueue_style( 'eway-styles' );
			$icons      = $this->get_all_payment_icons();
			$icons_html = '';

			if ( is_array( $this->card_types ) ) {
				foreach ( $this->card_types as $card_type ) {
					$icons_html .= isset( $icons[ $card_type ] ) ? $icons[ $card_type ] : '';
				}
			}
			return apply_filters( 'woocommerce_gateway_icon', apply_filters( 'woocommerce_eway_icon', $icons_html ), $this->id );
		}

		/**
		 * Get the token customer id for an order
		 *
		 * @param WC_Order $order The order to access.
		 * @return array|mixed
		 */
		protected function get_token_customer_id( $order ) {

			return $order->get_meta( '_eway_token_customer_id', true );

		}

		/**
		 * Enqueue scripts.
		 *
		 * @return void
		 */
		public function enqueue_scripts() {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_register_script( 'eway-credit-card-form', $this->plugin_url() . 'assets/js/frontend/eway-credit-card-form' . $suffix . '.js', array( 'jquery', 'jquery-payment' ), WOOCOMMERCE_GATEWAY_EWAY_VERSION, true );
			$form_errors = array(
				'anotherPaymentMethod' => __( 'Error: Please check details and try again. If this still does not work contact the store admin or use another means of payment.', 'wc-eway' ),
			);
			wp_localize_script(
				'eway-credit-card-form',
				'eway_settings',
				array(
					'card_types' => $this->card_types,
					'formErrors' => $form_errors,
				)
			);
			wp_register_style( 'eway-styles', $this->plugin_url() . 'assets/css/eway-styles.css', array(), WOOCOMMERCE_GATEWAY_EWAY_VERSION );
		}

		/**
		 * Get the plugin URL.
		 *
		 * @return string
		 */
		private function plugin_url() {
			if ( isset( $this->plugin_url ) ) {
				return trailingslashit( $this->plugin_url );
			}

			if ( is_ssl() ) {
				$this->plugin_url = str_replace( 'http://', 'https://', WP_PLUGIN_URL ) . '/' . plugin_basename( dirname( dirname( __FILE__ ) ) );
			} else {
				$this->plugin_url = WP_PLUGIN_URL . '/' . plugin_basename( dirname( dirname( __FILE__ ) ) );
			}

			return trailingslashit( $this->plugin_url );
		}

		/**
		 * Listen for a response from Eway on API URL and Process request.
		 *
		 * @return void
		 */
		public function response_listener() {
			if ( isset( $_GET['AccessCode'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$access_code = sanitize_text_field( wp_unslash( $_GET['AccessCode'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$result      = json_decode( $this->get_api()->get_access_code_result( $access_code ) );

				self::log( 'Response listener result: ' . print_r( $result, true ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions

				// Use InvoiceRef temp, until Eway sorts out empty options echo.
				$order = wc_get_order( intval( $result->InvoiceReference ) );

				if ( ! $order ) {
					self::log( 'Response listener order not found: ' . intval( $result->InvoiceReference ) );
					return;
				}

				if ( in_array( $result->ResponseMessage, $this->success_response_messages, true ) ) {
					if ( isset( $result->TokenCustomerID ) && ! empty( $result->TokenCustomerID ) ) {
						$user_id = $order->get_customer_id();

						// Check if masked card number was passed otherwise look it up.
						if ( isset( $result->Customer->CardDetails ) && ! empty( $result->Customer->CardDetails ) ) {
							$card_details = $result->Customer->CardDetails;
						} else {
							$customer_result = json_decode( $this->get_api()->lookup_customer( $result->TokenCustomerID ) );
							if ( isset( $customer_result->Customers[0] ) ) {
								$card_details = $customer_result->Customers[0]->CardDetails;
							}
						}

						if ( isset( $card_details ) ) {
							$wc_token = new WC_Payment_Token_Eway_CC();

							$wc_token->set_gateway_id( $this->id );
							$wc_token->set_token( $result->TokenCustomerID );
							$wc_token->set_user_id( $user_id );
							$wc_token->set_number( $card_details->Number );
							$wc_token->set_expiry_year( $card_details->ExpiryYear );
							$wc_token->set_expiry_month( $card_details->ExpiryMonth );
							$wc_token->save();

							$this->set_token_customer_id( $order, $result->TokenCustomerID );
							// translators: %1$s Token customer ID, %2$s Token Masked card number.
							$order->add_order_note( sprintf( __( 'Eway Token Customer Created - TokenCustomerID: %1$s Masked Card: %2$s', 'wc-eway' ), $result->TokenCustomerID, $card_details->Number ) );
						}
					}
					// translators: %s Response message.
					$order->add_order_note( sprintf( __( 'Eway payment completed - %s', 'wc-eway' ), $this->response_message_lookup( $result->ResponseMessage ) ) );
					$order->payment_complete( $result->TransactionID );

					/**
					 * Triggered when a payment with the gateway is completed.
					 *
					 * @param WC_Order        $order The order whose payment failed.
					 * @param stdClass        $result The result from the API call.
					 * @param WC_Gateway_EWAY $gateway The instance of the gateway.
					 */
					do_action( 'woocommerce_api_wc_gateway_eway_payment_completed', $order, $result, $this );
				} else {
					if ( isset( $result->Errors ) && ! is_null( $result->Errors ) ) {
						$error = $this->response_message_lookup( $result->Errors );
					} else {
						$error = $this->response_message_lookup( $result->ResponseMessage );
					}
					// translators: %s Error message.
					$order->update_status( 'failed', sprintf( __( 'Eway payment failed - %s', 'wc-eway' ), $error ) );

					/**
					 * Triggered when a payment with the gateway fails.
					 *
					 * @param WC_Order        $order The order whose payment failed.
					 * @param stdClass        $result The result from the API call.
					 * @param string          $error The error message.
					 * @param WC_Gateway_EWAY $gateway The instance of the gateway.
					 */
					do_action( 'woocommerce_api_wc_gateway_eway_payment_failed', $order, $result, $error, $this );
				}
				WC()->cart->empty_cart();
				wp_safe_redirect( $this->get_return_url( $order ) );
				exit;
			} else {
				self::log( 'Response listener called without AccessCode' );
			}
		}

		/**
		 * Show description and option to save cards, or pay with new cards on checkout.
		 *
		 * @return void
		 */
		public function payment_fields() {
			$checked = 1;
			if ( $this->description ) {
				echo '<p>' . wp_kses_post( $this->description ) . '</p>';
			}

			if ( $this->saved_cards && is_user_logged_in() && is_checkout() ) {
				$eway_cards = WC_Payment_Tokens::get_customer_tokens( get_current_user_id(), $this->id );
				?>
					<p class="form-row form-row-wide">
						<?php if ( $eway_cards ) : ?>
							<?php foreach ( (array) $eway_cards as $card ) : ?>
								<label for="eway_card_<?php echo esc_attr( $card->get_id() ); ?>">
									<input type="radio" id="eway_card_<?php echo esc_attr( $card->get_id() ); ?>" name="eway_card_id" value="<?php echo esc_attr( $card->get_id() ); ?>" <?php checked( $card->is_default() ); ?> />
									<?php printf( esc_html( $card->get_display_name() ) ); ?>
								</label>
								<?php
								$checked = 0;
							endforeach;
							?>
						<?php endif; ?>
						<label for="new">
							<input type="radio" id="new" name="eway_card_id" <?php checked( $checked, 1 ); ?> value="new" />
							<?php esc_html_e( 'Use a new credit card', 'wc-eway' ); ?>
						</label>
					</p>
				<?php
				wp_nonce_field( 'eway_use_saved_card', '_eway_nonce' );
			}
		}

		/**
		 * Return payment tokens for the current user.
		 * If needed, migrate legacy Eway payment tokens stored in user_meta to WooCommerce Payment Token API.
		 *
		 * @param WC_Payment_Token[] $tokens Array of token objects.
		 * @param int                $customer_id Customer ID.
		 * @param string             $gateway_id Gateway ID for getting tokens for a specific gateway.
		 * @return WC_Payment_Token[] Array of token objects.
		 */
		public function get_customer_payment_tokens( $tokens, $customer_id, $gateway_id ) {
			// Limit updates to current user and when the gateway is involved in the query (i.e. not specified or specifically eWAY).
			if ( ( $gateway_id && $gateway_id !== $this->id ) || ( ! is_user_logged_in() || get_current_user_id() !== $customer_id ) ) {
				return $tokens;
			}

			// Get legacy payment tokens to migrate.
			$eway_cards = get_user_meta( $customer_id, '_eway_token_cards', true );
			if ( ! is_array( $eway_cards ) || empty( $eway_cards ) ) {
				return $tokens;
			}

			// Unhook early to prevent other code from triggering the migration routine again (can happen when saving tokens).
			remove_filter( 'woocommerce_get_customer_payment_tokens', array( $this, 'get_customer_payment_tokens' ), 10 );

			// Get current tokens to avoid migrating duplicates.
			$token_ids = wc_list_pluck(
				array_filter(
					$tokens,
					function( $token ) {
						return $token->get_gateway_id() === $this->id;
					}
				),
				'get_token'
			);

			foreach ( $eway_cards as $card ) {
				// Skip legacy tokens that already have corresponding WC_Payment_Token objects.
				if ( in_array( strval( $card['id'] ), $token_ids, true ) ) {
					continue;
				}

				$wc_token = new WC_Payment_Token_Eway_CC();
				$wc_token->set_gateway_id( $this->id );
				$wc_token->set_token( $card['id'] );
				$wc_token->set_user_id( $customer_id );
				$wc_token->set_number( $card['number'] );
				$wc_token->set_expiry_year( $card['exp_year'] );
				$wc_token->set_expiry_month( $card['exp_month'] );
				$wc_token->save();
			}

			delete_user_meta( $customer_id, '_eway_token_cards' );

			// Get customer tokens including newly migrated tokens.
			return WC_Payment_Tokens::get_customer_tokens( $customer_id, $gateway_id );
		}

		/**
		 * Process refunds for WC 2.2+
		 *
		 * @param  int        $order_id The order ID.
		 * @param  float|null $amount The amount to refund. Default null.
		 * @param  string     $reason The reason for the refund. Default null.
		 * @return bool|WP_Error
		 */
		public function process_refund( $order_id, $amount = null, $reason = null ) {
			$order = wc_get_order( $order_id );

			if ( ! is_a( $order, 'WC_Order' ) ) {
				return new WP_Error( 'eway_refund_error', __( 'Order not valid', 'wc-eway' ) );
			}

			$transction_id = $order->get_meta( '_transaction_id', true );

			if ( ! $transction_id || empty( $transction_id ) ) {
				return new WP_Error( 'eway_refund_error', __( 'No valid Transaction ID found', 'wc-eway' ) );
			}

			if ( is_null( $amount ) || $amount <= 0 ) {
				return new WP_Error( 'eway_refund_error', __( 'Amount not valid', 'wc-eway' ) );
			}

			if ( is_null( $reason ) || '' === $reason ) {
				// translators: %s Order number.
				$reason = sprintf( __( 'Refund for Order %s', 'wc-eway' ), $order->get_order_number() );
			}

			try {
				$result = json_decode( $this->get_api()->direct_refund( $order, $transction_id, $amount * 100, $reason ) );
				if ( in_array( $result->ResponseMessage, $this->success_response_messages, true ) ) {
					return true;
				} else {
					if ( isset( $result->Errors ) && ! is_null( $result->Errors ) ) {
						return new WP_Error( 'eway_refund_error', $this->response_message_lookup( $result->Errors ) );
					} else {
						return new WP_Error( 'eway_refund_error', $this->response_message_lookup( $result->ResponseMessage ) );
					}
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'eway_refund_error', $e->getMessage() );
			}
		}

		/**
		 * Lookup Response / Error messages based on codes.
		 *
		 * @param  string $response_message Response code from API.
		 * @return string
		 */
		public function response_message_lookup( $response_message ) {
			$messages = array(
				'A2000' => 'Transaction Approved',
				'A2008' => 'Honour With Identification',
				'A2010' => 'Approved For Partial Amount',
				'A2011' => 'Approved, VIP',
				'A2016' => 'Approved, Update Track 3',
				'D4401' => 'Refer to Issuer',
				'D4402' => 'Refer to Issuer, special',
				'D4403' => 'No Merchant',
				'D4404' => 'Pick Up Card',
				'D4405' => 'Do Not Honour',
				'D4406' => 'Error',
				'D4407' => 'Pick Up Card, Special',
				'D4409' => 'Request In Progress',
				'D4412' => 'Invalid Transaction',
				'D4413' => 'Invalid Amount',
				'D4414' => 'Invalid Card Number',
				'D4415' => 'No Issuer',
				'D4419' => 'Re-enter Last Transaction',
				'D4421' => 'No Action Taken',
				'D4422' => 'Suspected Malfunction',
				'D4423' => 'Unacceptable Transaction Fee',
				'D4425' => 'Unable to Locate Record On File',
				'D4430' => 'Format Error',
				'D4431' => 'Bank Not Supported By Switch',
				'D4433' => 'Expired Card, Capture',
				'D4434' => 'Suspected Fraud, Retain Card',
				'D4435' => 'Card Acceptor, Contact Acquirer, Retain Card',
				'D4436' => 'Restricted Card, Retain Card',
				'D4437' => 'Contact Acquirer Security Department, Retain Card',
				'D4438' => 'PIN Tries Exceeded, Capture',
				'D4439' => 'No Credit Account',
				'D4440' => 'Function Not Supported',
				'D4441' => 'Lost Card',
				'D4442' => 'No Universal Account',
				'D4443' => 'Stolen Card',
				'D4444' => 'No Investment Account',
				'D4451' => 'Insufficient Funds',
				'D4452' => 'No Cheque Account',
				'D4453' => 'No Savings Account',
				'D4454' => 'Expired Card',
				'D4455' => 'Incorrect PIN',
				'D4456' => 'No Card Record',
				'D4457' => 'Function Not Permitted to Cardholder',
				'D4458' => 'Function Not Permitted to Terminal',
				'D4459' => 'Suspected Fraud',
				'D4460' => 'Acceptor Contact Acquirer',
				'D4461' => 'Exceeds Withdrawal Limit',
				'D4462' => 'Restricted Card',
				'D4463' => 'Security Violation',
				'D4464' => 'Original Amount Incorrect',
				'D4466' => 'Acceptor Contact Acquirer, Security',
				'D4467' => 'Capture Card',
				'D4475' => 'PIN Tries Exceeded',
				'D4482' => 'CVV Validation Error',
				'D4490' => 'Cut off In Progress',
				'D4491' => 'Card Issuer Unavailable',
				'D4492' => 'Unable To Route Transaction',
				'D4493' => 'Cannot Complete, Violation Of The Law',
				'D4494' => 'Duplicate Transaction',
				'D4496' => 'System Error',
				'D4497' => 'MasterPass Error',
				'D4498' => 'PayPal Create Transaction Error',
				'S5000' => 'System Error',
				'S5085' => 'Started 3dSecure',
				'S5086' => 'Routed 3dSecure',
				'S5087' => 'Completed 3dSecure',
				'S5088' => 'PayPal Transaction Created',
				'S5099' => 'Incomplete (Access Code in progress/incomplete)',
				'S5010' => 'Unknown error returned by gateway',
				'V6000' => 'Validation error',
				'V6001' => 'Invalid CustomerIP',
				'V6002' => 'Invalid DeviceID',
				'V6003' => 'Invalid Request PartnerID',
				'V6004' => 'Invalid Request Method',
				'V6010' => 'Invalid TransactionType, account not certified for eCome only MOTO or Recurring available',
				'V6011' => 'Invalid Payment TotalAmount',
				'V6012' => 'Invalid Payment InvoiceDescription',
				'V6013' => 'Invalid Payment InvoiceNumber',
				'V6014' => 'Invalid Payment InvoiceReference',
				'V6015' => 'Invalid Payment CurrencyCode',
				'V6016' => 'Payment Required',
				'V6017' => 'Payment CurrencyCode Required',
				'V6018' => 'Unknown Payment CurrencyCode',
				'V6021' => 'EWAY_CARDHOLDERNAME Required',
				'V6022' => 'EWAY_CARDNUMBER Required',
				'V6023' => 'EWAY_CARDCVN Required',
				'V6033' => 'Invalid Expiry Date',
				'V6034' => 'Invalid Issue Number',
				'V6035' => 'Invalid Valid From Date',
				'V6040' => 'Invalid TokenCustomerID',
				'V6041' => 'Customer Required',
				'V6042' => 'Customer FirstName Required',
				'V6043' => 'Customer LastName Required',
				'V6044' => 'Customer CountryCode Required',
				'V6045' => 'Customer Title Required',
				'V6046' => 'TokenCustomerID Required',
				'V6047' => 'RedirectURL Required',
				'V6051' => 'Invalid Customer FirstName',
				'V6052' => 'Invalid Customer LastName',
				'V6053' => 'Invalid Customer CountryCode',
				'V6058' => 'Invalid Customer Title',
				'V6059' => 'Invalid RedirectURL',
				'V6060' => 'Invalid TokenCustomerID',
				'V6061' => 'Invalid Customer Reference',
				'V6062' => 'Invalid Customer CompanyName',
				'V6063' => 'Invalid Customer JobDescription',
				'V6064' => 'Invalid Customer Street1',
				'V6065' => 'Invalid Customer Street2',
				'V6066' => 'Invalid Customer City',
				'V6067' => 'Invalid Customer State',
				'V6068' => 'Invalid Customer PostalCode',
				'V6069' => 'Invalid Customer Email',
				'V6070' => 'Invalid Customer Phone',
				'V6071' => 'Invalid Customer Mobile',
				'V6072' => 'Invalid Customer Comments',
				'V6073' => 'Invalid Customer Fax',
				'V6074' => 'Invalid Customer URL',
				'V6075' => 'Invalid ShippingAddress FirstName',
				'V6076' => 'Invalid ShippingAddress LastName',
				'V6077' => 'Invalid ShippingAddress Street1',
				'V6078' => 'Invalid ShippingAddress Street2',
				'V6079' => 'Invalid ShippingAddress City',
				'V6080' => 'Invalid ShippingAddress State',
				'V6081' => 'Invalid ShippingAddress PostalCode',
				'V6082' => 'Invalid ShippingAddress Email',
				'V6083' => 'Invalid ShippingAddress Phone',
				'V6084' => 'Invalid ShippingAddress Country',
				'V6085' => 'Invalid ShippingAddress ShippingMethod',
				'V6086' => 'Invalid ShippingAddress Fax ',
				'V6091' => 'Unknown Customer CountryCode',
				'V6092' => 'Unknown ShippingAddress CountryCode',
				'V6100' => 'Invalid EWAY_CARDNAME',
				'V6101' => 'Invalid EWAY_CARDEXPIRYMONTH',
				'V6102' => 'Invalid EWAY_CARDEXPIRYYEAR',
				'V6103' => 'Invalid EWAY_CARDSTARTMONTH',
				'V6104' => 'Invalid EWAY_CARDSTARTYEAR',
				'V6105' => 'Invalid EWAY_CARDISSUENUMBER',
				'V6106' => 'Invalid EWAY_CARDCVN',
				'V6107' => 'Invalid EWAY_ACCESSCODE',
				'V6108' => 'Invalid CustomerHostAddress',
				'V6109' => 'Invalid UserAgent',
				'V6110' => 'Invalid EWAY_CARDNUMBER',
				'V6111' => 'Unauthorised API Access, Account Not PCI Certified',
			);
			return isset( $messages[ $response_message ] ) ? $messages[ $response_message ] : $response_message;
		}

		/**
		 * Save the token customer id on the order being made.
		 *
		 * @param  WC_Order $order The order being made.
		 * @param  int      $token_customer_id The token customer id to associate with order.
		 */
		protected function set_token_customer_id( $order, $token_customer_id ) {

			$order->update_meta_data( '_eway_token_customer_id', $token_customer_id );
			$order->save_meta_data();

		}

		/**
		 * Verifies that no customer fields exceed the allowed lengths.
		 *
		 * @param array    $values The values of the submitted fields.
		 * @param WP_Error $errors Validation errors. This is a reference.
		 */
		public function validate_checkout_values( $values, $errors ) {
			if ( $this->id !== $values['payment_method'] ) {
				// No need to validate for other gateways.
				return;
			}

			// Load the fields that are used on the checkout page to make sure they exist and use their labels.
			$checkout_fields = WC()->countries->get_address_fields( $values['billing_country'], 'billing_' );

			$requirements = array(
				'billing_first_name' => 50,
				'billing_last_name'  => 50,
				'billing_company'    => 50,
				'billing_address_1'  => 50,
				'billing_address_2'  => 50,
				'billing_city'       => 50,
				'billing_state'      => 50,
				'billing_postcode'   => 30,
				'billing_country'    => 2,
				'billing_email'      => 50,
				'billing_phone'      => 32,
			);

			foreach ( $requirements as $name => $length ) {
				if ( ! isset( $checkout_fields[ $name ], $values[ $name ] ) ) {
					// The field is not available.
					continue;
				}

				$value = $values[ $name ];
				if ( empty( $value ) || strlen( $value ) <= $length ) {
					continue;
				}

				$errors->add(
					'validation',
					sprintf(
						/* translators: %1$s Checkout field label, %2$d Number of characters. */
						__( 'The value of "%1$s" must not exceed the length of %2$d characters for payments with Eway.', 'wc-eway' ),
						$checkout_fields[ $name ]['label'],
						$length
					)
				);
			}
		}

		/**
		 * Get the settings keys required for setup during onboarding.
		 *
		 * @return array
		 */
		public function get_required_settings_keys() {
			return array(
				'customer_api',
				'customer_password',
			);
		}

		/**
		 * Get help text to display during onboarding setup.
		 *
		 * @return string
		 */
		public function get_setup_help_text() {
			return sprintf(
				/* translators: %s Eway URL. */
				__( 'Your API details can be obtained from your <a href="%s" target="_blank">Eway account</a>.', 'wc-eway' ),
				'https://www.eway.com.au/'
			);
		}

		/**
		 * Determine if the gateway still requires setup.
		 *
		 * @return bool
		 */
		public function needs_setup() {
			return ! $this->get_option( 'customer_api' ) || ! $this->get_option( 'customer_password' );
		}

	}
}
