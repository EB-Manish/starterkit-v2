<?php
/**
 * WC_Gateway_EWAY_Subscriptions class.
 *
 * @package WooCommerce Eway Payment Gateway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WC_Gateway_EWAY_Subscriptions' ) ) {
	/**
	 * WC_Gateway_EWAY_Subscriptions class.
	 *
	 * @extends WC_Gateway_EWAY
	 */
	class WC_Gateway_EWAY_Subscriptions extends WC_Gateway_EWAY {

		/**
		 * Constructor
		 */
		public function __construct() {

			parent::__construct();

			add_action( 'woocommerce_scheduled_subscription_payment_' . $this->id, array( $this, 'scheduled_subscription_payment' ), 10, 2 );
			add_action( 'woocommerce_subscription_failing_payment_method_updated_' . $this->id, array( $this, 'update_failing_payment_method' ), 10, 2 );

			// Display the current payment method used for a subscription in the "My Subscriptions" table.
			add_filter( 'woocommerce_my_subscriptions_payment_method', array( $this, 'maybe_render_subscription_payment_method' ), 10, 2 );

			// Allow store managers to manually set Eway as the payment method on a subscription.
			add_filter( 'woocommerce_subscription_payment_meta', array( $this, 'add_subscription_payment_meta' ), 10, 2 );
			add_filter( 'woocommerce_subscription_validate_payment_meta', array( $this, 'validate_subscription_payment_meta' ), 10, 2 );

			// Don't update payment methods immediately when changing payment for subscriptions to Eway - wait until we get payment token.
			add_filter( 'woocommerce_subscriptions_update_payment_via_pay_shortcode', array( $this, 'maybe_update_payment_method' ), 10, 3 );

			add_action( 'woocommerce_api_wc_gateway_eway_payment_completed', array( $this, 'maybe_update_all_subscriptions_payment' ), 10, 3 );
		}

		/**
		 * Maybe update payment method of all subscriptions.
		 *
		 * @param WC_Order        $order The order whose payment failed.
		 * @param stdClass        $result The result from the API call.
		 * @param WC_Gateway_EWAY $gateway The instance of the gateway.
		 */
		public function maybe_update_all_subscriptions_payment( $order, $result, $gateway ) {
			if ( $this->id !== $gateway->id ) {
				return;
			}

			if ( ! wcs_is_subscription( $order ) ) {
				return;
			}

			if ( ! WC_Subscriptions_Change_Payment_Gateway::will_subscription_update_all_payment_methods( $order ) ) {
				return;
			}

			if ( in_array( $result->ResponseMessage, $this->success_response_messages, true ) ) {
				if ( empty( $result->TokenCustomerID ) ) {
					return;
				}
				WC_Subscriptions_Change_Payment_Gateway::update_all_payment_methods_from_subscription( $order, $gateway->id );
			}
		}

		/**
		 * Updates payment method if necessary.
		 *
		 * When changing payment to Eway for subscriptions it doesn't update payment methods immediately but waits until payment token available.
		 *
		 * @param  bool            $update Existing value for if payment method should update immediately.
		 * @param  string          $new_payment_method Updated payment method.
		 * @param  WC_Subscription $subscription Subscrption to update.
		 * @return bool
		 */
		public function maybe_update_payment_method( $update, $new_payment_method, $subscription ) {
			if ( empty( $_POST['update_all_subscriptions_payment_method'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
				return $update;
			}

			if ( $this->id !== $new_payment_method ) {
				return $update;
			}

			/*
			 * So that 'pay for order' page shows the credit card form, the order whose
			 * payment method is to be changed needs to have payment method = eway.
			 * That's why, when payment method is not eway, we want to update it immediately.
			 * Hence, return $update here.
			 */
			if ( $this->id !== $subscription->get_payment_method() ) {
				return $update;
			}

			$is_new_card = ! isset( $_POST['eway_card_id'] ) || 'new' === $_POST['eway_card_id']; // phpcs:ignore WordPress.Security.NonceVerification.Missing
			if ( ! $is_new_card ) {
				return $update;
			}

			// Don't update payment methods immediately when changing payment for subscriptions to Eway - wait until we get payment token.
			return false;
		}

		/**
		 * Include the payment meta data required to process automatic recurring payments so that store managers can
		 * manually set up automatic recurring payments for a customer via the Edit Subscriptions screen in 2.0+.
		 *
		 * @param array           $payment_meta associative array of meta data required for automatic payments.
		 * @param WC_Subscription $subscription An instance of a subscription object.
		 * @return array
		 */
		public function add_subscription_payment_meta( $payment_meta, $subscription ) {

			$payment_meta[ $this->id ] = array(
				'post_meta' => array(
					'_eway_token_customer_id' => array(
						'value' => $subscription->get_meta( '_eway_token_customer_id', true ),
						'label' => 'Eway Token Customer ID',
					),
				),
			);

			return $payment_meta;
		}

		/**
		 * Returns the WC_Subscription(s) tied to a WC_Order, or a boolean false.
		 *
		 * @param  WC_Order $order The order from which to get subscriptions.
		 * @return bool|WC_Subscription
		 */
		protected function get_subscriptions_from_order( $order ) {

			if ( $this->order_contains_subscription( $order ) ) {

				$subscriptions = wcs_get_subscriptions_for_order( $order );

				if ( $subscriptions ) {

					return $subscriptions;

				}
			}

			return false;

		}

		/**
		 * Get the token customer id for an order
		 *
		 * @param WC_Order $order The order from which to get token customer id.
		 * @return array|mixed
		 */
		protected function get_token_customer_id( $order ) {

			$subscriptions = $this->get_subscriptions_from_order( $order );

			if ( $subscriptions ) {

				$subscription = array_shift( $subscriptions );

				return $subscription->get_meta( '_eway_token_customer_id', true );

			}

			return parent::get_token_customer_id( $order );

		}

		/**
		 * Render the payment method used for a subscription in the "My Subscriptions" table
		 *
		 * @param string $payment_method_to_display The default payment method text to display.
		 * @param object $subscription The subscription to render.
		 * @return string The subscription payment method.
		 */
		public function maybe_render_subscription_payment_method( $payment_method_to_display, $subscription ) {
			$customer_id    = $subscription->get_customer_id();
			$payment_method = $subscription->get_payment_method();

			// Bail for other payment methods.
			if ( ( $payment_method !== $this->id ) || ! $customer_id ) {
				return $payment_method_to_display;
			}

			$order_token_id = $subscription->get_meta( '_eway_token_customer_id', true );
			$eway_cards     = WC_Payment_Tokens::get_customer_tokens( $customer_id, $this->id );

			if ( $eway_cards && ! empty( $eway_cards ) ) {
				foreach ( $eway_cards as $card ) {
					if ( strval( $card->get_token() ) === $order_token_id ) {
						// translators: %s Card number.
						$payment_method_to_display = sprintf( __( 'Via card %s', 'wc-eway' ), $card->get_number() );
						break;
					}
				}
			}

			return $payment_method_to_display;
		}

		/**
		 * Check if order contains subscriptions.
		 *
		 * @param  WC_Order $order The order to check.
		 * @return bool
		 */
		protected function order_contains_subscription( $order ) {
			return function_exists( 'wcs_order_contains_subscription' ) && ( wcs_order_contains_subscription( $order ) );
		}


		/**
		 * Process a subscription payment.
		 *
		 * @param mixed $order The order to process.
		 * @param int   $amount The amount to process. Default 0.
		 * @return null|object JSON parsed API response on success, or null on failure
		 * @throws WP_Error If no token customer id or error during payment.
		 */
		public function process_subscription_payment( $order = '', $amount = 0 ) {
			$eway_token_customer_id = $this->get_token_customer_id( $order );

			if ( ! $eway_token_customer_id ) {
				return new WP_Error( 'eway_error', __( 'Token Customer ID not found', 'wc-eway' ) );
			}

			if ( ! $this->check_customer_has_token( $eway_token_customer_id, $order ) ) {
				return new WP_Error( 'eway_error', __( 'Token Customer ID invalid', 'wc-eway' ) );
			}

			// Charge the customer.
			try {
				return $this->process_payment_request( $order, $amount, $eway_token_customer_id );
			} catch ( Exception $e ) {
				return new WP_Error( 'eway_error', $e->getMessage() );
			}
		}

		/**
		 * Checks if the customer has that token to prevent fraud.
		 *
		 * @param string   $eway_token_customer_id eway token.
		 * @param WC_Order $order being processed.
		 * @return bool
		 */
		private function check_customer_has_token( $eway_token_customer_id, $order ) {
			$customer_id     = $order->get_customer_id();
			$customer_tokens = WC_Payment_Tokens::get_tokens(
				array(
					'token'      => $eway_token_customer_id,
					'user_id'    => $customer_id,
					'gateway_id' => $this->id,
				)
			);

			return count( $customer_tokens ) > 0;
		}

		/**
		 * API call to get Eway access code.
		 *
		 * @since 3.5.1 Set transaction type to 'Purchase'.
		 *
		 * @param WP_Order $order The order to access.
		 * @return array|mixed|object
		 * @throws Exception If API error when requesting access code.
		 */
		protected function request_access_code( $order ) {

			// Check if order is for a subscription, if it is check for fee and charge that.
			if ( $this->order_contains_subscription( $order ) || $this->is_subscription( $order ) ) {

				$method = 'TokenPayment';

				if ( 0.0 === floatval( $order->get_total() ) ) {
					$method = 'CreateTokenCustomer';
				}

				$order_total = $order->get_total() * 100;

				$result = json_decode( $this->get_api()->request_access_code( $order, $method, 'Purchase', $order_total ) );

				if ( isset( $result->Errors ) && ! is_null( $result->Errors ) ) {
					throw new Exception( $this->response_message_lookup( $result->Errors ) );
				}

				return $result;

			} else {

				return parent::request_access_code( $order );

			}

		}

		/**
		 * Wrapper for WooCommerce subscription function wc_is_subscription.
		 *
		 * @param WC_Order $order The order.
		 * @return bool
		 */
		public function is_subscription( $order ) {

			if ( function_exists( 'wcs_is_subscription' ) ) {
				return wcs_is_subscription( $order );
			} else {
				return false;
			}

		}

		/**
		 * Schedule a subscription payment for an order.
		 *
		 * @param float    $amount_to_charge The amount to charge.
		 * @param WC_Order $order The WC_Order object of the order which the subscription was purchased in.
		 * @return void
		 */
		public function scheduled_subscription_payment( $amount_to_charge, $order ) {

			$result = $this->process_subscription_payment( $order, $amount_to_charge );

			if ( is_wp_error( $result ) ) {

				// translators: %s Error message.
				$order->add_order_note( sprintf( __( 'Eway subscription renewal failed - %s', 'wc-eway' ), $this->response_message_lookup( $result->get_error_message() ) ) );

			}

		}

		/**
		 * Save the token customer id on the subscription(s) being made.
		 *
		 * @param WC_Order $order The order in which to save the token customer id.
		 * @param int      $token_customer_id The token customer id to set.
		 */
		protected function set_token_customer_id( $order, $token_customer_id ) {

			$subscriptions = $this->get_subscriptions_from_order( $order );

			if ( $subscriptions ) {

				foreach ( $subscriptions as $subscription ) {

					parent::set_token_customer_id( $subscription, $token_customer_id );

				}
			}

			parent::set_token_customer_id( $order, $token_customer_id );

		}

		/**
		 * Update the customer_id for a subscription after using Eway to complete a payment to make up for
		 * an automatic renewal payment which previously failed.
		 *
		 * @param WC_Subscription $subscription The subscription for which the failing payment method relates.
		 * @param WC_Order        $renewal_order The order which recorded the successful payment (to make up for the failed automatic payment).
		 */
		public function update_failing_payment_method( $subscription, $renewal_order ) {
			$subscription->update_meta_data( '_eway_token_customer_id', $renewal_order->get_meta( '_eway_token_customer_id', true ) );
			$subscription->save_meta_data();
		}

		/**
		 * Validate the payment meta data required to process automatic recurring payments so that store managers can
		 * manually set up automatic recurring payments for a customer via the Edit Subscriptions screen in 2.0+.
		 *
		 * @param string $payment_method_id The ID of the payment method to validate.
		 * @param array  $payment_meta associative array of meta data required for automatic payments.
		 * @throws Exception If token customer ID is missing or invalid.
		 */
		public function validate_subscription_payment_meta( $payment_method_id, $payment_meta ) {

			if ( $this->id === $payment_method_id ) {

				if ( ! isset( $payment_meta['post_meta']['_eway_token_customer_id']['value'] ) || empty( $payment_meta['post_meta']['_eway_token_customer_id']['value'] ) ) {

					throw new Exception( 'A "_eway_token_customer_id" value is required.' );

				} elseif ( ! is_numeric( $payment_meta['post_meta']['_eway_token_customer_id']['value'] ) ) {

					throw new Exception( 'Invalid Token Customer ID. A valid "_eway_token_customer_id" must be numeric.' );

				} elseif ( strlen( $payment_meta['post_meta']['_eway_token_customer_id']['value'] ) > 16 ) {

					throw new Exception( 'Invalid Token Customer ID. A valid "_eway_token_customer_id" must be 16 digits or less.' );

				}
			}
		}

	}
}
