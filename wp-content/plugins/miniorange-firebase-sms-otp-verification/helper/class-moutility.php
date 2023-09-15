<?php
/**Load adminstrator changes for MoUtility
 *
 * @package miniorange-firebase-sms-otp-verification/helper
 */

namespace MoOTP\Helper;

use MoOTP\Objects\TabDetails;
use MoOTP\Objects\Tabs;
use MoOTP\Helper\MocURLOTP;
use MoOTP\Objects\NotificationSettings;
use MoOTP\Objects\FormHandler;
use MoOTP\Helper\MoFirebaseFreePlan;
use MoOTP\Helper\MoFirebasePremiumPlan;
use \ReflectionClass;
use ReflectionException;
use \stdClass;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This is the main Utility class of the plugin.
 * Lists down all the necessary common utility
 * functions being used in the plugin.
 */
if ( ! class_exists( 'MoUtility' ) ) {
	/**
	 * MoUtility class
	 */
	class MoUtility {

		/**
		 * Function generates a random alphanumeric value and returns it.
		 */
		public static function rand() {
			$length        = wp_rand( 0, 15 );
			$characters    = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$random_string = '';
			for ( $i = 0; $i < $length; $i++ ) {
				$random_string .= $characters[ wp_rand( 0, strlen( $characters ) - 1 ) ];
			}
			return $random_string;
		}
		/**
		 * Process the value being passed and checks if it is empty or null
		 *
		 * @param string $value - the value to be checked.
		 *
		 * @return bool
		 */
		public static function is_blank( $value ) {
			return ! isset( $value ) || empty( $value );
		}

		/**
		 * Creates and returns the JSON response.
		 *
		 * @param string $message - the message.
		 * @param string $type - the type of result ( success or error ).
		 * @return array
		 */
		public static function create_json( $message, $type ) {
			return array(
				'message' => $message,
				'result'  => $type,
			);
		}

		/**
		 * Checks if user has completed his registration in miniOrange.
		 */
		public static function micr() {
			$email        = get_mofr_option( 'admin_email' );
			$customer_key = get_mofr_option( 'admin_customer_key' );
			if ( ! $email || ! $customer_key || ! is_numeric( trim( $customer_key ) ) ) {
				return 0;
			} else {
				return 1;
			}
		}

		/**
		 * Checks if user has upgraded to one of the plans.
		 */
		public static function micv() {
			$email        = get_mofr_option( 'admin_email' );
			$customer_key = get_mofr_option( 'admin_customer_key' );
			$check_ln     = get_mofr_option( 'check_ln' );
			if ( ! $email || ! $customer_key || ! is_numeric( trim( $customer_key ) ) ) {
				return 0;
			} else {
				return $check_ln ? $check_ln : 0;
			}
		}

		/**Sanitizing array
		 *
		 * @param array $raw_array data array to be sanitized.
		 * @return string
		 */
		public static function sanitize_post_data( $raw_array ) {

			$sanitized_array = array();
			foreach ( $raw_array as $key => $value ) {
				$sanitized_array[ $key ] = sanitize_text_field( $value );
			}
			return $sanitized_array;

		}

		/**MofrInternal Function
		 */
		public static function mofr_allow_svg_array() {
			$allowed_tags = array(
				'svg'    => array(
					'class'   => true,
					'width'   => true,
					'height'  => true,
					'viewbox' => true,
					'fill'    => true,
				),
				'circle' => array(
					'id'           => true,
					'cx'           => true,
					'cy'           => true,
					'cz'           => true,
					'r'            => true,
					'stroke'       => true,
					'stroke-width' => true,
				),
				'g'      => array(
					'fill' => true,
					'id'   => true,
				),
				'path'   => array(
					'd'              => true,
					'fill'           => true,
					'id'             => true,
					'stroke'         => true,
					'stroke-width'   => true,
					'stroke-linecap' => true,
				),
				'title'  => array(
					'style' => true,
				),
			);
			return $allowed_tags;
		}

		/**
		 * Take an array of string having the keyword to replace
		 * and the keyword to be replaced. This is used to modify
		 * the SMS templates that the user might have saved in the
		 * settings or the default ones by the plugin.
		 *
		 * @param array  $replace the array containing search and replace keywords.
		 * @param string $string entire string to be modified.
		 *
		 * @return mixed
		 */
		public static function replace_string( array $replace, $string ) {
			foreach ( $replace as $key => $value ) {
				$string = str_replace( '{' . $key . '}', $value, $string );
			}

			return $string;
		}

		/**
		 * This function checks the license of the customer. Updates the license plan,
		 * sms and email remaining values in the database if user has upgraded.
		 *
		 * @param string $show_message - show message or not.
		 * @param string $customer_key - customer_key of the admin.
		 * @param string $api_key - api_key of the admin.
		 */
		public static function mofr_handle_mo_check_ln( $show_message, $customer_key, $api_key ) {
			$msg          = MoMessages::FREE_PLAN_MSG;
			$plan         = array();
			$form_handler = FormHandler::instance();
			$plan_type    = $form_handler->plugin_type_to_class[ MOFLR_LICENSE_TYPE ];
			$plugin_type  = $plan_type::instance();
			$content      = (array) json_decode( MocURLOTP::mofr_check_customer_ln( $customer_key, $api_key, $plugin_type->get_application_name() ) );

			if ( strcasecmp( $content['status'], 'SUCCESS' ) === 0 ) {

				$email_remaining = isset( $content['emailRemaining'] ) ? $content['emailRemaining'] : 0;
				$sms_remaining   = isset( $content['smsRemaining'] ) ? $content['smsRemaining'] : 0;

				if ( self::sanitize_check( 'licensePlan', $content ) ) {
					if ( strcmp( MOFLR_LICENSE_TYPE, 'MoFirebasePremiumPlan' ) === 0 ) {
						$msg  = MoMessages::UPGRADE_MSG;
						$plan = array(
							'plan'  => $content['licensePlan'],
							'sms'   => $sms_remaining,
							'email' => $email_remaining,
						);

					} else {
						$msg  = MoMessages::UPGRADE_MSG;
						$plan = array( 'plan' => $content['licensePlan'] );
					}
					update_mofr_option( 'check_ln', base64_encode( $content['licensePlan'] ) );//phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Base64 is needed.
				}
			} else {
				$content = json_decode( MocURLOTP::mofr_check_customer_ln( $customer_key, $api_key, $plugin_type->get_application_name() ), true );
				if ( self::sanitize_check( 'licensePlan', $content ) ) {
					$msg = MoMessages::INSTALL_PREMIUM_PLUGIN;
				}
			}
			if ( $show_message ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( $msg, $plan ), 'SUCCESS' );
			}
		}

		/**
		 * This function validates the phone number format and checks if it has country code appended.
		 * Return True or false.
		 *
		 * @param string $phone - the phone number to be checked.
		 *
		 * @return bool
		 */
		public static function is_country_code_appended( $phone ) {
			return preg_match( MoConstants::PATTERN_COUNTRY_CODE, $phone, $matches ) ? true : false;
		}

		/**
		 * Process the phone number. Check if country code is appended to the phone number. If
		 * country code is not appended then add the default country code if set any by the
		 * admin.
		 *
		 * @param string $phone - the phone number to be processed.
		 *
		 * @return mixed
		 */
		public static function process_phone_number( $phone ) {
			$phone                = preg_replace( MoConstants::PATTERN_SPACES_HYPEN, '', ltrim( trim( $phone ), '0' ) );
			$default_country_code = CountryList::get_default_countrycode();
			$phone                = ! isset( $default_country_code ) || self::is_country_code_appended( $phone ) ? $phone : $default_country_code . $phone;
			return apply_filters( 'mo_process_phone', $phone );
		}

		/**
		 * Returns the invalid OTP message. This function checks if admin has set an
		 * invalid otp message in the settings. If so then that is returned instead of the default.
		 */
		public static function get_invalid_otp_method() {
			return get_mofr_option( 'invalid_message', 'mo_otp_' ) ? mofr_( get_mofr_option( 'invalid_message', 'mo_otp_' ) )
				: MoMessages::show_message( MoMessages::INVALID_OTP );
		}

		/**
		 * Returns TRUE or FALSE depending on if the POLYLANG plugin is active.
		 * This is used to check if the translation should use the polylang
		 * function or the default local translation.
		 *
		 * @return boolean
		 */
		public static function is_polylang_installed() {
			return function_exists( 'pll__' ) && function_exists( 'pll_register_string' );
		}

		/**
		 * Check if there is an existing value in the array/buffer and return the value
		 * that exists against that key otherwise return false.
		 * <p></p>
		 * The function also makes sure to sanitize the values being fetched.
		 * <p></p>
		 * If the buffer to fetch the value from is not an array then return buffer as it is.
		 *
		 * @param  string       $key    the key to check against.
		 * @param  string|array $buffer the post/get or array.
		 * @return string|bool|array
		 */
		public static function sanitize_check( $key, $buffer ) {
			if ( ! is_array( $buffer ) ) {
				return $buffer;
			}
			$value = ! array_key_exists( $key, $buffer ) || self::is_blank( $buffer[ $key ] ) ? false : $buffer[ $key ];
			return is_array( $value ) ? $value : sanitize_text_field( $value );
		}

		/**Sanitizing array
		 *
		 * @param array $data data array to be sanitized.
		 * @return array
		 */
		public static function mofr_sanitize_array( $data ) {
			$sanitized_data = array();
			foreach ( $data as $key => $value ) {
				if ( is_array( $value ) ) {
					$sanitized_data[ $key ] = self::mo_sanitize_array( $value );
				} else {
					$sanitized_data[ $key ] = sanitize_text_field( $value );
				}
			}
			return $sanitized_data;
		}

		/**
		 * Checks if user has upgraded to the on-prem plugin
		 */
		public static function mclv() {
			/**
			 * Declare formhandler functions.
			 *
			 * @var FormHandler */
			$form_handler = FormHandler::instance();
			$plan_type    = $form_handler->plugin_type_to_class[ MOFLR_LICENSE_TYPE ];
			$plugin_type  = $plan_type::instance();
			return $plugin_type->mclv();
		}

		/**
		 * Send the notification to the email provided and
		 * process the response to check if the message was sent
		 * successfully or not. Return TRUE or FALSE based on the
		 * API call response.
		 *
		 * @param string $from_email The From Email.
		 * @param string $from_name  The From Name.
		 * @param string $to_email   The email to send message to.
		 * @param string $subject   The subject of the email.
		 * @param string $message   The message to be sent.
		 *
		 * @return bool
		 */
		public static function send_email_notif( $from_email, $from_name, $to_email, $subject, $message ) {
			$api_call_result = function( $from_email, $from_name, $to_email, $subject, $message ) {
				$notification_settings = new NotificationSettings( $from_email, $from_name, $to_email, $subject, $message );
				return json_decode( MocURLOTP::send_notif( $notification_settings ) );
			};

			$content = $api_call_result( $from_email, $from_name, $to_email, $subject, $message );
			return strcasecmp( $content->status, 'SUCCESS' ) === 0 ? true : false;

		}

		/**
		 * Checks if the current plugin is MiniOrangeGateway Plugin
		 *
		 * @return bool
		 */
		public static function is_mg() {
			return false;
		}

		/**Sanitizing array
		 *
		 * @param array $data data array to be sanitized.
		 * @return string
		 */
		public static function mo_sanitize_array( $data ) {
			$sanitized_data = array();
			foreach ( $data as $key => $value ) {
				if ( is_array( $value ) ) {
					$sanitized_data[ $key ] = self::mo_sanitize_array( $value );
				} else {
					$sanitized_data[ $key ] = sanitize_text_field( $value );
				}
			}
			return $sanitized_data;
		}

		/**MoInternal Function
		 */
		public static function mo_allow_html_array() {
			$allowed_tags = array(
				'a'          => array(
					'style'   => array(),
					'onclick' => array(),
					'class'   => array(),
					'href'    => array(),
					'rel'     => array(),
					'title'   => array(),
					'hidden'  => array(),
				),
				'b'          => array(
					'style' => array(),
					'class' => array(),
					'id'    => array(),
				),
				'blockquote' => array(
					'cite' => array(),
				),
				'code'       => array(),
				'del'        => array(
					'datetime' => array(),
					'title'    => array(),
				),
				'div'        => array(
					'name'   => array(),
					'id'     => array(),
					'class'  => array(),
					'title'  => array(),
					'style'  => array(),
					'hidden' => array(),
				),
				'script'     => array(),
				'style'      => array(),
				'dl'         => array(),
				'dt'         => array(),
				'em'         => array(),
				'h1'         => array(),
				'h2'         => array(),
				'h3'         => array(),
				'h4'         => array(),
				'h5'         => array(),
				'h6'         => array(),
				'hr'         => array(),
				'i'          => array(),
				'textarea'   => array(
					'id'          => array(),
					'class'       => array(),
					'name'        => array(),
					'row'         => array(),
					'style'       => array(),
					'placeholder' => array(),
					'readonly'    => array(),
				),
				'img'        => array(
					'alt'    => array(),
					'class'  => array(),
					'height' => array(),
					'style'  => array(),
					'src'    => array(),
					'width'  => array(),
					'href'   => array(),
					'hidden' => array(),
				),
				'link'       => array(
					'rel'    => array(),
					'type'   => array(),
					'href'   => array(),
					'hidden' => array(),
				),
				'li'         => array(
					'class'  => array(),
					'hidden' => array(),
				),
				'ol'         => array(
					'class' => array(),
				),
				'p'          => array(
					'class'  => array(),
					'hidden' => array(),
				),
				'q'          => array(
					'cite'  => array(),
					'title' => array(),
				),
				'span'       => array(
					'class'  => array(),
					'title'  => array(),
					'style'  => array(),
					'hidden' => array(),
				),
				'strike'     => array(),
				'strong'     => array(),
				'u'          => array(),
				'ul'         => array(
					'class' => array(),
					'style' => array(),
				),
				'form'       => array(
					'name'   => array(),
					'method' => array(),
					'id'     => array(),
					'style'  => array(),
					'hidden' => array(),
				),
				'table'      => array(
					'class' => array(),
					'style' => array(),
				),
				'tbody'      => array(),
				'tr'         => array(),
				'td'         => array(
					'class' => array(),
					'style' => array(),
				),
				'input'      => array(
					'type'        => array(),
					'id'          => array(),
					'name'        => array(),
					'value'       => array(),
					'class'       => array(),
					'size '       => array(),
					'tabindex'    => array(),
					'hidden'      => array(),
					'style'       => array(),
					'placeholder' => array(),
					'disabled'    => array(),
				),
				'br'         => array(),
				'svg'        => array(
					'class'   => true,
					'width'   => true,
					'height'  => true,
					'viewbox' => true,
					'fill'    => true,
				),
				'circle'     => array(
					'id'           => true,
					'cx'           => true,
					'cy'           => true,
					'cz'           => true,
					'r'            => true,
					'stroke'       => true,
					'stroke-width' => true,
				),
				'g'          => array(
					'fill' => true,
					'id'   => true,
				),
				'title'      => array(
					'title' => true,
				),
				'path'       => array(
					'd'              => true,
					'fill'           => true,
					'id'             => true,
					'stroke'         => true,
					'stroke-width'   => true,
					'stroke-linecap' => true,
				),
			);
			return $allowed_tags;
		}
	}
}
