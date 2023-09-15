<?php
/**
 * Comman Handler .
 *
 * @package miniorange-firebase-sms-otp-verification/handler
 */

namespace MoOTP\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use MoOTP\Objects\TabDetails;
use MoOTP\Objects\Tabs;
use MoOTP\Helper\MoConstants;
use MoOTP\Traits\Instance;
use MoOTP\Helper\MoMessages;
use MoOTP\Helper\MoUtility;
use MoOTP\Objects\BaseActionHandler;
use MoOTP\Helper\MocURLOTP;
use MoOTP\Helper\CountryList;

/**
 * This is the MofrOTPActionHandlerHandler class. This class handles all the
 * functionality related to MofrOTPActionHandlerHandler. It extends the FormHandler
 * and implements the IFormHandler class to implement some much needed functions.
 */
if ( ! class_exists( 'MofrOTPActionHandlerHandler' ) ) {
	/**
	 * This class handles all the Admin related actions of the user related to the
	 * OTP Verification Plugin.
	 */
	class MofrOTPActionHandlerHandler extends BaseActionHandler {
		use Instance;
		/**
		 * Undocumented function
		 * Initializes values
		 */
		public function __construct() {
			parent::__construct();
			$this->nonce = 'mofr_admin_actions';

			add_action( 'admin_init', array( $this, 'mofr_handle_admin_actions' ) );
		}


		/**
		 * The function hooks into the admin_init WordPress hook. This function
		 * checks the form being posted and routes the data to the correct function
		 * for processing. The 'option' value in the form post is checked to make
		 * the diversion.
		 */
		public function mofr_handle_admin_actions() {

			if ( isset( $_POST['nonce_mo_firebase_form_save_option'] ) && ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['nonce_mo_firebase_form_save_option'] ) ), 'mo_nonce_mo_firebase_form_save_option' ) ) {
				return;
			}
			$post = MoUtility::sanitize_post_data( $_POST );

			if ( ! isset( $post['option'] ) ) {
				return;
			}
			switch ( sanitize_text_field( $post['option'] ) ) {
				case 'mo_firebase_gateway_deatils_save_option':
					$this->mo_save_firebase_gateway_details( $post );
					break;
				case 'mofr_check_mo_ln':
					$this->mofr_check_l();
					break;
				case 'mofr_validation_contact_us_query_option':
					$this->mofr_validation_support_query( $post );
					break;
				case 'mo_firebase_dropdown_form_save_option':
					$this->save_extra_settings( $post );
					break;
				case 'mofr_otp_feedback_option':
					$this->mofr_validation_feedback_query( $post );
					break;
			}
		}

		/**
		 * This function processes the support form data before sending it to the server.
		 *
		 * @param array $post_data data submitted by the user.
		 */
		private function mofr_validation_support_query( $post_data ) {
			$email = MoUtility::sanitize_check( 'query_email', $post_data );
			$query = MoUtility::sanitize_check( 'query', $post_data );
			$phone = MoUtility::sanitize_check( 'query_phone', $post_data );

			if ( ! $email || ! $query ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::SUPPORT_FORM_VALUES ), 'ERROR' );
				return;
			}

			$submitted = MocURLOTP::mofr_submit_contact_us( $email, $phone, $query );

			if ( json_last_error() === JSON_ERROR_NONE && $submitted ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::SUPPORT_FORM_SENT ), 'SUCCESS' );
				return;
			}

			do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::SUPPORT_FORM_ERROR ), 'ERROR' );
		}
		/**
		 * This function processes the feedback form data and send it to the server.
		 *
		 * @param array $post data submitted by the user.
		 */
		private function mofr_validation_feedback_query( $post ) {
			$submit_type         = sanitize_text_field( $post['miniorange_fr_feedback_submit'] );
			$deactivating_plugin = strcasecmp( sanitize_text_field( $post['plugin_deactivated'] ), 'true' ) === 0;
			$type                = ! $deactivating_plugin ? mofr_( '[ Plugin Feedback ] : ' ) : mofr_( '[ Plugin Deactivated ]' );
			$views               = array();
			$deactivationreasons = $this->mo_feedback_reasons();
			if ( isset( $post['miniorange_fr_feedback_submit'] ) ) {
				if ( ! empty( $post['reason'] ) ) {
					$data = MoUtility::mofr_sanitize_array( $post['reason'] );
					foreach ( $data as $value ) {
						$views[] = $deactivationreasons[ $value ];
					}
				}
			}
			$feedback                  = implode( ' , ', $views ) . ' , ' . sanitize_text_field( $post['query_feedback'] );
			$feedback_template_request = wp_remote_get( MOFLR_URL . 'includes/html/feedback.min.html' );

			if ( is_wp_error( $feedback_template_request ) ) {
				$feedback_template = '';
			} else {
				$feedback_template = wp_remote_retrieve_body( $feedback_template_request );
			}

			$mofr_current_user = wp_get_current_user();
			$email             = get_mofr_option( 'admin_email' );
			$feedback_template = str_replace( '{{FIRST_NAME}}', $mofr_current_user->first_name, $feedback_template );
			$feedback_template = str_replace( '{{LAST_NAME}}', $mofr_current_user->last_name, $feedback_template );
			$feedback_template = str_replace( '{{PLUGIN_TYPE}}', MOFLR_TYPE . ': ', $feedback_template );
			$feedback_template = str_replace( '{{SERVER}}', isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( esc_url_raw( wp_unslash( $_SERVER['SERVER_NAME'] ) ) ) : '', $feedback_template );
			$feedback_template = str_replace( '{{EMAIL}}', $email, $feedback_template );
			$feedback_template = str_replace( '{{PLUGIN}}', MoConstants::PLUGIN_NAME, $feedback_template );
			$feedback_template = str_replace( '{{VERSION}}', MOFLR_VERSION, $feedback_template );
			$feedback_template = str_replace( '{{TYPE}}', $type, $feedback_template );
			$feedback_template = str_replace( '{{FEEDBACK}}', $feedback, $feedback_template );

			$notif = MoUtility::send_email_notif(
				$email,
				'Xecurify',
				MoConstants::FEEDBACK_EMAIL,
				'Firebase OTP Verification Plugin Feedback',
				$feedback_template
			);

			if ( $notif ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::FEEDBACK_SENT ), 'SUCCESS' );
			} else {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::FEEDBACK_ERROR ), 'ERROR' );
			}

			if ( $deactivating_plugin ) {
				deactivate_plugins( array( MOFLR_PLUGIN_NAME ) );
			}
		}
		/**
		 * This function saves the firebase gateway details submitted by the admin.
		 *
		 * @param array $data data submitted by the user.
		 */
		private function mo_save_firebase_gateway_details( $data ) {
			update_mofr_option( 'gateway_apiKey', MoUtility::sanitize_check( 'mo_firebase_gateway_apiKey', $data ) );
			update_mofr_option( 'gateway_authdomain', MoUtility::sanitize_check( 'mo_firebase_gateway_authdomain', $data ) );
			update_mofr_option( 'gateway_databaseurl', MoUtility::sanitize_check( 'mo_firebase_gateway_databaseurl', $data ) );
			update_mofr_option( 'gateway_projectid', MoUtility::sanitize_check( 'mo_firebase_gateway_projectid', $data ) );
			update_mofr_option( 'gateway_storagebucket', MoUtility::sanitize_check( 'mo_firebase_gateway_storagebucket', $data ) );
			update_mofr_option( 'gateway_messagingsenderid', MoUtility::sanitize_check( 'mo_firebase_gateway_messagingsenderid', $data ) );
			update_mofr_option( 'gateway_appid', MoUtility::sanitize_check( 'mo_firebase_gateway_appid', $data ) );

			$firebase_gateway_details = array(
				'gateway_apiKey'            => MoUtility::sanitize_check( 'mo_firebase_gateway_apiKey', $data ),
				'gateway_authdomain'        => MoUtility::sanitize_check( 'mo_firebase_gateway_authdomain', $data ),
				'gateway_databaseurl'       => MoUtility::sanitize_check( 'mo_firebase_gateway_databaseurl', $data ),
				'gateway_projectid'         => MoUtility::sanitize_check( 'mo_firebase_gateway_projectid', $data ),
				'gateway_storagebucket'     => MoUtility::sanitize_check( 'mo_firebase_gateway_storagebucket', $data ),
				'gateway_messagingsenderid' => MoUtility::sanitize_check( 'mo_firebase_gateway_messagingsenderid', $data ),
				'gateway_appid'             => MoUtility::sanitize_check( 'mo_firebase_gateway_appid', $data ),
			);

			update_mofr_option( 'firebase_gateway_details', maybe_serialize( $firebase_gateway_details ) );
		}
		/**
		 * This function returns the array of feedback reasons.
		 *
		 * @return array
		 */
		public function mo_feedback_reasons() {
			$deactivationreasons = array(
				'unable_to_setup_plugin'  => 'Unable to setup plugin',
				'not_the_feture_i_wanted' => 'Features I wanted are missing',
				'lack_of_documentation'   => 'Lack of documentation',
				'cost_is_too_high'        => 'Cost is too high',
				'found_a_better_plugin'   => 'Found a better plugin',
			);

			return $deactivationreasons;
		}
		/**
		 * This function save the extra setting submitted by the admin.
		 *
		 * @param array $posted data submitted by the user.
		 */
		private function save_extra_settings( $posted ) {
			delete_site_option( 'default_country_code' );
			$default_country = isset( $posted['default_country_code'] ) ? sanitize_text_field( $posted['default_country_code'] ) : '';

			update_mofr_option( 'default_country', maybe_serialize( CountryList::$countries[ $default_country ] ) );
			update_mofr_option( 'mo_firebase_dropdown_form_enable', MoUtility::sanitize_check( 'mo_firebase_dropdown_form_enable', $posted ) );
		}
		/**
		 * This function chceks if the user is valid.
		 */
		private function mofr_check_l() {
			$this->is_valid_request();
			MoUtility::mofr_handle_mo_check_ln(
				true,
				get_mofr_option( 'admin_customer_key' ),
				get_mofr_option( 'admin_api_key' )
			);
		}
	}
}
