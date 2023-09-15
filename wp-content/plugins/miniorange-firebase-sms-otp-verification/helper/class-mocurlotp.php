<?php
/**Load adminstrator changes for MocURLCall
 *
 * @package miniorange-firebase-sms-otp-verification/helper
 */

namespace MoOTP\Helper;

use MoOTP\Objects\NotificationSettings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class denotes all the cURL related functions to make API calls
 * to the miniOrange server. You can read about cURL here : {@link https://curl.haxx.se/}
 * and read how it is implemented in PHP here: {@link http://php.net/manual/en/book.curl.php}
 *
 * CURL is required by the plugin for OTP Verification to work. Without
 * cURL the plugin is as good as useless.
 */
if ( ! class_exists( 'MocURLCall' ) ) {
	/**
	 * MocURLCall class
	 */
	class MocURLOTP {

		/** MoInternal Function
		 *
		 * @param string $email email address.
		 * @param string $company comapany name.
		 * @param string $password password of user.
		 * @param string $phone phone number of user.
		 * @param string $first_name first name of user.
		 * @param string $last_name last name of user.
		 */
		public static function mofr_create_customer( $email, $company, $password, $phone = '', $first_name = '', $last_name = '' ) {
			$url                         = MoConstants::HOSTNAME . '/moas/rest/customer/add';
			$fields                      = array(
				'companyName'    => $company,
				'areaOfInterest' => MoConstants::AREA_OF_INTEREST,
				'firstname'      => $first_name,
				'lastname'       => $last_name,
				'email'          => $email,
				'phone'          => $phone,
				'password'       => $password,
			);
			$json                        = wp_json_encode( $fields );
			$current_timestamp_in_millis = self::mofr_get_timestamp();
			if ( MoUtility::is_blank( $current_timestamp_in_millis ) ) {
				$current_timestamp_in_millis = round( microtime( true ) * 1000 );
				$current_timestamp_in_millis = number_format( $current_timestamp_in_millis, 0, '', '' );
			}
			$header      = hash( 'sha512', $current_timestamp_in_millis );
			$auth_header = array(
				'Content-Type'  => 'application/json',
				'Timestamp'     => $current_timestamp_in_millis,
				'Authorization' => $header,
			);
			$response    = self::mofr_call_api( $url, $json, $auth_header );
			return $response;
		}
		/** MoInternal Function
		 *
		 * @param string $email email address.
		 * @param string $password password of user.
		 */
		public static function mofr_get_customer_key( $email, $password ) {
			$url = MoConstants::HOSTNAME . '/moas/rest/customer/key';

			$fields = array(
				'email'    => $email,
				'password' => $password,
			);
			$json   = wp_json_encode( $fields );

			$current_timestamp_in_millis = self::mofr_get_timestamp();
			if ( MoUtility::is_blank( $current_timestamp_in_millis ) ) {
				$current_timestamp_in_millis = round( microtime( true ) * 1000 );
				$current_timestamp_in_millis = number_format( $current_timestamp_in_millis, 0, '', '' );
			}
			$header      = hash( 'sha512', $current_timestamp_in_millis );
			$auth_header = array(
				'Content-Type'  => 'application/json',
				'Timestamp'     => $current_timestamp_in_millis,
				'Authorization' => $header,
			);
			$response    = self::mofr_call_api( $url, $json, $auth_header );
			return $response;
		}
		/** MoInternal Function
		 *
		 * @param string $email email address.
		 */
		public static function mofr_check_customer( $email ) {
			$url = MoConstants::HOSTNAME . '/moas/rest/customer/check-if-exists';

			$fields                      = array(
				'email' => $email,
			);
			$json                        = wp_json_encode( $fields );
			$current_timestamp_in_millis = self::mofr_get_timestamp();
			if ( MoUtility::is_blank( $current_timestamp_in_millis ) ) {
				$current_timestamp_in_millis = round( microtime( true ) * 1000 );
				$current_timestamp_in_millis = number_format( $current_timestamp_in_millis, 0, '', '' );
			}
			$header      = hash( 'sha512', $current_timestamp_in_millis );
			$auth_header = array(
				'Content-Type'  => 'application/json',
				'Timestamp'     => $current_timestamp_in_millis,
				'Authorization' => $header,
			);

			$response = self::mofr_call_api( $url, $json, $auth_header );
			return $response;
		}
		/** MoInternal Function
		 *
		 * @param string $auth_type authentication type wither SMS or Email.
		 * @param string $email email address.
		 * @param string $phone phone number of user.
		 */
		public static function mofr_send_otp_token( $auth_type, $email = '', $phone = '' ) {
			$url          = MoConstants::HOSTNAME . '/moas/api/auth/challenge';
			$customer_key = get_mofr_option( 'admin_customer_key' );
			$api_key      = get_mofr_option( 'admin_api_key' );
			$fields       = array(
				'customerKey'     => $customer_key,
				'email'           => $email,
				'phone'           => $phone,
				'authType'        => $auth_type,
				'transactionName' => MoConstants::AREA_OF_INTEREST,
			);
			$json         = wp_json_encode( $fields );
			$auth_header  = self::mofr_create_authheader( $customer_key, $api_key );
			$response     = self::mofr_call_api( $url, $json, $auth_header );
			return $response;
		}
		/** Validate_otp_token Function
		 *
		 * @param string $transaction_id transaction id.
		 * @param string $otp_token otp token.
		 */
		public static function mofr_validate_otp_token( $transaction_id, $otp_token ) {
			$url          = MoConstants::HOSTNAME . '/moas/api/auth/validate';
			$customer_key = get_mofr_option( 'admin_customer_key' );
			$api_key      = get_mofr_option( 'admin_api_key' );
			$fields       = array(
				'txId'  => $transaction_id,
				'token' => $otp_token,
			);
			$json         = wp_json_encode( $fields );
			$auth_header  = self::mofr_create_authheader( $customer_key, $api_key );
			$response     = self::mofr_call_api( $url, $json, $auth_header );
			return $response;
		}

		/** MoInternal Function
		 *
		 * @param string $q_email email address.
		 * @param string $q_phone phone number of user.
		 * @param string $query query of user.
		 */
		public static function mofr_submit_contact_us( $q_email, $q_phone, $query ) {
			$mofr_current_user = wp_get_current_user();
			$url               = MoConstants::HOSTNAME . '/moas/rest/customer/contact-us';
			$query             = '[' . MoConstants::AREA_OF_INTEREST . '(' . MoConstants::PLUGIN_TYPE . ' )]: ' . $query;
			$customer_key      = get_mofr_option( 'admin_customer_key' );
			$api_key           = get_mofr_option( 'admin_api_key' );
			$fields            = array(
				'firstName' => $mofr_current_user->user_firstname,
				'lastName'  => $mofr_current_user->user_lastname,
				'company'   => isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( esc_url_raw( wp_unslash( $_SERVER['SERVER_NAME'] ) ) ) : null,
				'email'     => $q_email,
				'ccEmail'   => MoConstants::FEEDBACK_EMAIL,
				'phone'     => $q_phone,
				'query'     => $query,
			);
			$field_string      = wp_json_encode( $fields );
			$auth_header       = self::mofr_create_authheader( $customer_key, $api_key );
			$response          = self::mofr_call_api( $url, $field_string, $auth_header );
			return true;
		}
		/** MoInternal Function
		 *
		 * @param string $email email address.
		 */
		public static function mofr_forgot_password( $email ) {
			$url          = MoConstants::HOSTNAME . '/moas/rest/customer/password-reset';
			$customer_key = get_mofr_option( 'admin_customer_key' );
			$api_key      = get_mofr_option( 'admin_api_key' );

			$fields = array(
				'email' => $email,
			);

			$json        = wp_json_encode( $fields );
			$auth_header = self::mofr_create_authheader( $customer_key, $api_key );
			$response    = self::mofr_call_api( $url, $json, $auth_header );
			return $response;
		}
		/** MoInternal Function
		 *
		 * @param string $customer_key internal use.
		 * @param string $api_key api key of user.
		 * @param string $app_name plugin name of user.
		 */
		public static function mofr_check_customer_ln( $customer_key, $api_key, $app_name ) {
			$url    = MoConstants::HOSTNAME . '/moas/rest/customer/license';
			$fields = array(
				'customerId'      => $customer_key,
				'applicationName' => $app_name,
				'licenseType'     => ! MoUtility::micr() ? 'DEMO' : 'PREMIUM',
			);

			$json        = wp_json_encode( $fields );
			$auth_header = self::mofr_create_authheader( $customer_key, $api_key );
			$response    = self::mofr_call_api( $url, $json, $auth_header );
			return $response;
		}
		/** MoInternal Function
		 *
		 * @param string $customer_key internal use.
		 * @param string $api_key api key of user.
		 */
		public static function mofr_create_authheader( $customer_key, $api_key ) {
			$current_timestamp_in_millis = self::mofr_get_timestamp();
			if ( MoUtility::is_blank( $current_timestamp_in_millis ) ) {
				$current_timestamp_in_millis = round( microtime( true ) * 1000 );
				$current_timestamp_in_millis = number_format( $current_timestamp_in_millis, 0, '', '' );
			}
			$string_to_hash = $customer_key . $current_timestamp_in_millis . $api_key;
			$auth_header    = hash( 'sha512', $string_to_hash );

			$header = array(
				'Content-Type'  => 'application/json',
				'Customer-Key'  => $customer_key,
				'Timestamp'     => $current_timestamp_in_millis,
				'Authorization' => $auth_header,
			);
			return $header;
		}
		/** MoInternal Function
		 */
		public static function mofr_get_timestamp() {
			$url = MoConstants::HOSTNAME . '/moas/rest/mobile/get-timestamp';
			return self::mofr_call_api( $url, null, array() );
		}
		/**
		 * Send Notification Email to either customer or user
		 *
		 * @param NotificationSettings $settings settings object.
		 * @return string
		 */
		public static function send_notif( NotificationSettings $settings ) {
			$url          = MoConstants::HOSTNAME . '/moas/api/notify/send';
			$customer_key = get_mofr_option( 'admin_customer_key' );
			$api_key      = get_mofr_option( 'admin_api_key' );
			$fields       = array(
				'customerKey' => $customer_key,
				'sendEmail'   => $settings->send_email,
				'sendSMS'     => $settings->send_sms,
				'email'       => array(
					'customerKey' => $customer_key,
					'fromEmail'   => $settings->from_email,
					'bccEmail'    => $settings->bcc_email,
					'fromName'    => $settings->from_name,
					'toEmail'     => $settings->to_email,
					'toName'      => $settings->to_email,
					'subject'     => $settings->subject,
					'content'     => $settings->message,
				),
				'sms'         => array(
					'customerKey' => $customer_key,
					'phoneNumber' => $settings->phone_number,
					'message'     => $settings->message,
				),
			);

			$json        = wp_json_encode( $fields );
			$auth_header = self::create_auth_header( $customer_key, $api_key );
			$response    = self::call_api( $url, $json, $auth_header );
			return $response;
		}

		/** MoInternal Function
		 *
		 * @param string $customer_key internal use.
		 * @param string $api_key api key of user.
		 */
		public static function create_auth_header( $customer_key, $api_key ) {
			$current_timestamp_in_millis = self::get_timestamp();
			if ( MoUtility::is_blank( $current_timestamp_in_millis ) ) {
				$current_timestamp_in_millis = round( microtime( true ) * 1000 );
				$current_timestamp_in_millis = number_format( $current_timestamp_in_millis, 0, '', '' );
			}
			$string_to_hash = $customer_key . $current_timestamp_in_millis . $api_key;
			$auth_header    = hash( 'sha512', $string_to_hash );

			$header = array(
				'Content-Type'  => 'application/json',
				'Customer-Key'  => $customer_key,
				'Timestamp'     => $current_timestamp_in_millis,
				'Authorization' => $auth_header,
			);
			return $header;
		}

		/** MoInternal Function
		 */
		public static function get_timestamp() {
			$url = MoConstants::HOSTNAME . '/moas/rest/mobile/get-timestamp';
			return self::call_api( $url, null, array() );
		}


		/**
		 *  Uses WordPress HTTP API to make cURL calls to miniOrange server
		 *  <br/>Arguments that you can pass
		 * <ol>
		 *  <li>'timeout'     => 5,</li>
		 *  <li>'redirection' => 5,</li>
		 *  <li>'httpversion' => '1.0',</li>
		 *  <li>'user-agent'  => 'WordPress/' . $wp_version . '; ' . home_url(),</li>
		 *  <li>'blocking'    => true,</li>
		 *  <li>'headers'     => array(),</li>
		 *  <li>'cookies'     => array(),</li>
		 *  <li>'body'        => null,</li>
		 *  <li>'compress'    => false,</li>
		 *  <li>'decompress'  => true,</li>
		 *  <li>'sslverify'   => true,</li>
		 *  <li>'stream'      => false,</li>
		 *  <li>'filename'    => null</li>
		 * </ol>
		 *
		 * @param string $url URL to post to.
		 * @param string $json_string json encoded post data.
		 * @param array  $headers headers to be passed in the call.
		 * @param string $method GET or POST or PUT HTTP Method.
		 * @return string
		 */
		public static function call_api( $url, $json_string, $headers = array( 'Content-Type' => 'application/json' ), $method = 'POST' ) {
			$args     = array(
				'method'      => $method,
				'body'        => $json_string,
				'timeout'     => '10000',
				'redirection' => '10',
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => $headers,
				'sslverify'   => MOFLR_SSL_VERIFY,
			);
			$response = wp_remote_post( $url, $args );
			if ( is_wp_error( $response ) ) {
				wp_die( esc_attr( "Something went wrong: <br/> {mo_esc_string( $response->get_error_message() )}" ) );
			}
			return wp_remote_retrieve_body( $response );
		}


		/**
		 *  Uses WordPress HTTP API to make cURL calls to miniOrange server
		 *  <br/>Arguments that you can pass
		 * <ol>
		 *  <li>'timeout'     => 5,</li>
		 *  <li>'redirection' => 5,</li>
		 *  <li>'httpversion' => '1.0',</li>
		 *  <li>'user-agent'  => 'WordPress/' . $wp_version . '; ' . home_url(),</li>
		 *  <li>'blocking'    => true,</li>
		 *  <li>'headers'     => array(),</li>
		 *  <li>'cookies'     => array(),</li>
		 *  <li>'body'        => null,</li>
		 *  <li>'compress'    => false,</li>
		 *  <li>'decompress'  => true,</li>
		 *  <li>'sslverify'   => true,</li>
		 *  <li>'stream'      => false,</li>
		 *  <li>'filename'    => null</li>
		 * </ol>
		 *
		 * @param string $url URL to post to.
		 * @param string $json_string json encoded post data.
		 * @param array  $headers headers to be passed in the call.
		 * @param string $method GET or POST or PUT HTTP Method.
		 * @return string
		 */
		public static function mofr_call_api( $url, $json_string, $headers = array( 'Content-Type' => 'application/json' ), $method = 'POST' ) {
			$args     = array(
				'method'      => $method,
				'body'        => $json_string,
				'timeout'     => '10000',
				'redirection' => '10',
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => $headers,
				'sslverify'   => MOFLR_SSL_VERIFY,
			);
			$response = wp_remote_post( $url, $args );
			if ( is_wp_error( $response ) ) {
				wp_die( wp_kses( "Something went wrong: <br/> {mo_esc_string($response->get_error_message())}", array( 'br' => array() ) ) );
			}
			return wp_remote_retrieve_body( $response );
		}
	}
}
