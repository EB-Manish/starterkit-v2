<?php
/**
 * Eway API.
 *
 * @package WooCommerce Eway Payment Gateway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WC_EWAY_API' ) ) {
	/**
	 * WC_EWAY_API class.
	 */
	class WC_EWAY_API {

		const PRODUCTION_ENDPOINT = 'https://api.ewaypayments.com';

		const TEST_ENDPOINT = 'https://api.sandbox.ewaypayments.com';

		/**
		 * API endpoint to use (production or test).
		 *
		 * @var string
		 */
		public $endpoint;

		/**
		 * Eway API key.
		 *
		 * @var string
		 */
		public $api_key;

		/**
		 * Eway API password.
		 *
		 * @var string
		 */
		public $api_password;

		/**
		 * Whether debug mode is enabled ('on' or 'off').
		 *
		 * @var string
		 */
		public $debug_mode;

		/**
		 * Constructor
		 *
		 * @param string $api_key Eway API key.
		 * @param string $api_password Eway API password.
		 * @param string $environment Whether API is running in production or test environment.
		 * @param string $debug_mode Whether debug mode is enabled ('on' or 'off').
		 */
		public function __construct( $api_key, $api_password, $environment, $debug_mode ) {
			$this->api_key      = $api_key;
			$this->api_password = $api_password;
			$this->endpoint     = ( 'production' === $environment ) ? self::PRODUCTION_ENDPOINT : self::TEST_ENDPOINT;
			$this->debug_mode   = $debug_mode;
		}

		/**
		 * Perform a request to Eway API.
		 *
		 * @param string $endpoint API endpoint.
		 * @param string $json Request body.
		 * @throws Exception If an error occurs during API request.
		 */
		private function perform_request( $endpoint, $json ) {
			$args = array(
				'timeout'     => apply_filters( 'wc_eway_api_timeout', 45 ), // Default to 45 seconds.
				'redirection' => 0,
				'httpversion' => '1.0',
				'sslverify'   => false,
				'blocking'    => true,
				'headers'     => array(
					'accept'        => 'application/json',
					'content-type'  => 'application/json',
					'authorization' => 'Basic ' . base64_encode( $this->api_key . ':' . $this->api_password ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions
				),
				'body'        => $json,
				'cookies'     => array(),
				'user-agent'  => 'PHP ' . PHP_VERSION . '/WooCommerce ' . get_option( 'woocommerce_db_version' ),
			);

			$this->debug_message( json_decode( $json ) );

			$response = wp_remote_post( $this->endpoint . $endpoint, $args );

			$this->debug_message( $response );

			if ( is_wp_error( $response ) ) {
				throw new Exception( $response->get_error_message() );
			}

			if ( 200 !== $response['response']['code'] ) {
				throw new Exception( $response['response']['message'] );
			}

			return $response['body'];
		}

		/**
		 * Perform an HTTP GET request to Eway API.
		 *
		 * @param string $endpoint API endpoint.
		 * @throws Exception If an error occurs during API request.
		 */
		private function perform_get_request( $endpoint ) {
			$args = array(
				'timeout'     => apply_filters( 'wc_eway_api_timeout', 45 ), // Default to 45 seconds.
				'redirection' => 0,
				'httpversion' => '1.0',
				'sslverify'   => false,
				'blocking'    => true,
				'headers'     => array(
					'authorization' => 'Basic ' . base64_encode( $this->api_key . ':' . $this->api_password ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions
				),
				'cookies'     => array(),
				'user-agent'  => 'PHP ' . PHP_VERSION . '/WooCommerce ' . get_option( 'woocommerce_db_version' ),
			);

			$response = wp_remote_get( $this->endpoint . $endpoint, $args );

			$this->debug_message( $response );

			if ( is_wp_error( $response ) ) {
				throw new Exception( $response->get_error_message() );
			}

			if ( 200 !== $response['response']['code'] ) {
				throw new Exception( $response['response']['message'] );
			}

			return $response['body'];
		}

		/**
		 * Request an access code for use in an Eway Transparent Redirect payment
		 * See: https://eway.io/api-v3/#transparent-redirect
		 *
		 * @param WC_Order $order        The order to access.
		 * @param string   $method       The "Method" parameter, see: https://eway.io/api-v3/#payment-methods.
		 * @param string   $trx_type     The "TransactionType" parameter, see: https://eway.io/api-v3/#transaction-types.
		 * @param mixed    $order_total  The amount to charge for this transaction.
		 * @return mixed     JSON response from /CreateAccessCode.json on success
		 * @throws Exception Thrown on failure.
		 */
		public function request_access_code( $order, $method = 'ProcessPayment', $trx_type = 'Purchase', $order_total = null ) {
			$order_id  = $order->get_id();
			$order_key = $order->get_order_key();

			$customer_ip = $order->get_customer_ip_address();

			// If an order total isn't provided (in the case of a subscription), grab it from the Order itself.
			if ( is_null( $order_total ) ) {
				$order_total = $order->get_total() * 100.00;
			}

			// Set up request object.
			$request = array(
				'Method'          => $method,
				'TransactionType' => $trx_type,
				'RedirectUrl'     => add_query_arg(
					array(
						'wc-api'    => 'WC_Gateway_EWAY',
						'order_id'  => $order_id,
						'order_key' => $order_key,
						'sig_key'   => md5( $order_key . 'WOO' . $order_id ),
					),
					home_url( '/' )
				),
				'CustomerIP'      => $customer_ip,
				'DeviceID'        => '0b38ae7c3c5b466f8b234a8955f62bdd',
				'PartnerID'       => '0b38ae7c3c5b466f8b234a8955f62bdd',
				'Payment'         => array(
					'TotalAmount'        => $order_total,
					'CurrencyCode'       => $order->get_currency(),
					'InvoiceDescription' => apply_filters( 'woocommerce_eway_description', '', $order ),
					'InvoiceNumber'      => ltrim( $order->get_order_number(), _x( '#', 'hash before order number', 'woocommerce' ) ),
					'InvoiceReference'   => $this->get_invoice_reference( $order ),
				),
				'Customer'        => array(
					'FirstName'   => $order->get_billing_first_name(),
					'LastName'    => $order->get_billing_last_name(),
					'CompanyName' => $order->get_billing_company(),
					'Street1'     => $order->get_billing_address_1(),
					'Street2'     => $order->get_billing_address_2(),
					'City'        => $order->get_billing_city(),
					'State'       => $order->get_billing_state(),
					'PostalCode'  => $order->get_billing_postcode(),
					'Country'     => strtolower( $order->get_billing_country() ),
					'Email'       => $order->get_billing_email(),
					'Phone'       => $order->get_billing_phone(),
				),
			);

			// Add customer ID if logged in.
			if ( is_user_logged_in() ) {
				$request['Options'][] = array( 'customerID' => get_current_user_id() );
			}
			return $this->perform_request( '/CreateAccessCode.json', wp_json_encode( $request ) );
		}

		/**
		 * Perform API call to get access code result.
		 *
		 * @param string $access_code Access code.
		 * @return string
		 */
		public function get_access_code_result( $access_code ) {
			$request = array(
				'AccessCode' => $access_code,
			);

			return $this->perform_request( '/GetAccessCodeResult.json', wp_json_encode( $request ) );
		}

		/**
		 * Perform API call to make a direct payment for an order.
		 *
		 * @param WC_Order   $order The order associated with the payment.
		 * @param int|string $token_customer_id The customer's token customer id to include in direct payment request.
		 * @param int        $amount The amount to charge for the order.
		 */
		public function direct_payment( $order, $token_customer_id, $amount = 0 ) {
			$order_id    = $order->get_id();
			$order_key   = $order->get_order_key();
			$amount      = intval( $amount );
			$customer_ip = $order->get_customer_ip_address();

			// Check for 0 value order.
			if ( 0 === $amount ) {
				$return_object = array(
					'Payment'         => array(
						'InvoiceReference' => $this->get_invoice_reference( $order ),
					),
					'ResponseMessage' => 'A2000',
					'TransactionID'   => '',
				);
				return wp_json_encode( $return_object );
			}
			$request = array(
				'DeviceID'        => '0b38ae7c3c5b466f8b234a8955f62bdd',
				'PartnerID'       => '0b38ae7c3c5b466f8b234a8955f62bdd',
				'TransactionType' => 'Recurring',
				'Method'          => 'TokenPayment',
				'CustomerIP'      => $customer_ip,
				'Customer'        => array(
					'TokenCustomerID' => $token_customer_id,
				),
				'Payment'         => array(
					'TotalAmount'        => $amount,
					'CurrencyCode'       => $order->get_currency(),
					'InvoiceDescription' => apply_filters( 'woocommerce_eway_description', '', $order ),
					'InvoiceNumber'      => ltrim( $order->get_order_number(), _x( '#', 'hash before order number', 'woocommerce' ) ),
					'InvoiceReference'   => $this->get_invoice_reference( $order ),
				),
				'Options'         => array(
					array( 'OrderID' => $order_id ),
					array( 'OrderKey' => $order_key ),
					array( 'SigKey' => md5( $order_key . 'WOO' . $order_id ) ),
				),
			);
			return $this->perform_request( '/DirectPayment.json', wp_json_encode( $request ) );
		}

		/**
		 * Perform API call to refund an order for some amount.
		 *
		 * @param WC_Order   $order The order to access.
		 * @param string     $transaction_id The transaction to refund.
		 * @param float|null $amount The refund amount.
		 * @param string     $reason The reason for refund.
		 */
		public function direct_refund( $order, $transaction_id, $amount = 0, $reason = '' ) {
			$request = array(
				'DeviceID'  => '0b38ae7c3c5b466f8b234a8955f62bdd',
				'PartnerID' => '0b38ae7c3c5b466f8b234a8955f62bdd',
				'Refund'    => array(
					'TotalAmount'        => $amount,
					'TransactionID'      => $transaction_id,
					'InvoiceNumber'      => ltrim( $order->get_order_number(), _x( '#', 'hash before order number', 'woocommerce' ) ),
					'InvoiceReference'   => $this->get_invoice_reference( $order ),
					'InvoiceDescription' => $reason,
				),
			);
			return $this->perform_request( '/DirectRefund.json', wp_json_encode( $request ) );
		}

		/**
		 * Log a debugging message.
		 *
		 * @param array|object|string $message The message to log.
		 */
		public function debug_message( $message ) {
			if ( 'on' === $this->debug_mode ) {
				WC_Gateway_EWAY::log( is_array( $message ) || is_object( $message ) ? print_r( $message, true ) : $message ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions
			}
		}

		/**
		 * Perform API call to get a customer by their token customer id.
		 *
		 * @param string $token_customer_id The token customer id to look up.
		 */
		public function lookup_customer( $token_customer_id ) {
			return $this->perform_get_request( '/Customer/' . $token_customer_id );
		}

		/**
		 * Get an order's possibly modified reference number.
		 *
		 * @param WC_Order $order The full order object.
		 */
		public function get_invoice_reference( $order ) {
			$order_id = $order->get_id();

			/**
			 * Allows the invoice reference to be modified.
			 *
			 * @param int      $order_id The ID of the order.
			 * @param WC_Order $order    The full order object.
			 * @return string
			 */
			return apply_filters( 'woocommerce_eway_payment_reference', $order_id, $order );
		}
	}
}
