<?php
/**
 * Comman handler to check the registration.
 *
 * @package miniorange-firebase-sms-otp-verification/handler
 */

namespace MoOTP\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use MoOTP\Helper\MoConstants;
use MoOTP\Helper\MocURLOTP;
use MoOTP\Helper\MoMessages;
use MoOTP\Helper\MoUtility;
use MoOTP\Objects\BaseActionHandler;
use MoOTP\Traits\Instance;
use MoOTP\Helper\AEncryption;

/**
 * This is the MoRegistrationHandler class. This class handles all the
 * functionality related to MoRegistrationHandler. It extends the FormHandler
 * and implements the IFormHandler class to implement some much needed functions.
 */
if ( ! class_exists( 'MoRegistrationHandler' ) ) {
	/**
	 * This class handles all the Registration related functionality.
	 *
	 * @todo need to modularize the code further
	 */
	class MoRegistrationHandler extends BaseActionHandler {
		use Instance;
		/**
		 * Undocumented function
		 * Initializes values
		 */
		public function __construct() {
			parent::__construct();
			$this->nonce = 'mofr_reg_actions';
			add_action( 'admin_init', array( $this, 'handle_customer_registration' ) );
		}
		/**
		 * ApplicationName used in API calls
		 *
		 * @var string ApplicationName used in API calls.
		 */
		protected $application_name = 'wp_email_verification_intranet';

		/**
		 * This function hooks into the admin_init hook and routes the data
		 * to the correct functions for processsing. Makes sure the user
		 * has enough capabilities to be able to register.
		 */
		public function handle_customer_registration() {

			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}
			if ( isset( $_POST['_wpnonce'] ) && isset( $_POST['option'] ) && ! check_ajax_referer( 'mofr_firebase_actions', '_wpnonce', false ) ) {
				wp_send_json( MoUtility::create_json( 'Invalid Operation. Please Try Again !', 'error' ) );
			}
			if ( ! isset( $_POST['option'] ) ) {
				return;
			}
			$post = MoUtility::sanitize_post_data( $_POST );

			if ( ! isset( $post['option'] ) ) {
				return;
			}
			switch ( $post['option'] ) {
				case 'mofr_registration_register_customer':
					$this->mofr_register_customer( $_POST );
					break;
				case 'mofr_registration_connect_verify_customer':
					$this->mofr_verify_customer( $_POST );
					break;
				case 'mofr_registration_validate_otp':
					$this->mofr_validate_otp( $_POST );
					break;
				case 'mofr_registration_resend_otp':
					$this->send_otp_token( get_mofr_option( 'admin_email' ), '', 'EMAIL' );
					break;
				case 'mofr_registration_phone_verification':
					$this->mofr_send_phone_otp_token( $_POST );
					break;
				case 'mofr_registration_go_back':
					$this->mofr_revert_back_registration();
					break;
				case 'mo_registration_mofr_forgot_password':
					$this->mofr_reset_password();
					break;
				case 'mofr_go_to_login_page':
				case 'mofr_remove_account':
					$this->mofr_remove_account();
					break;
				case 'mofr_registration_verify_license':
					$this->mofr_vlk( $_POST );
					break;
			}
		}


		/**
		 * Process the registration form and register the user. Checks if the password
		 * and confirm password match the correct format and email and password fields
		 * are not empty or null. First checks if a customer exists in the system Based
		 * on that decides if a new user needs to be created or fetch user info instead.
		 *
		 * @param array $post - the posted data.
		 */
		public function mofr_register_customer( $post ) {
			$email            = sanitize_email( $post['email'] );
			$company          = sanitize_text_field( $post['company'] );
			$first_name       = sanitize_text_field( $post['fname'] );
			$last_name        = sanitize_text_field( $post['lname'] );
			$password         = sanitize_text_field( $post['password'] );
			$confirm_password = sanitize_text_field( $post['confirmPassword'] );

			if ( strlen( $password ) < 6 || strlen( $confirm_password ) < 6 ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::PASS_LENGTH ), 'ERROR' );
				return;
			}

			if ( $password !== $confirm_password ) {
				delete_mofr_option( 'verify_customer' );
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::PASS_MISMATCH ), 'ERROR' );
				return;
			}

			if ( MoUtility::is_blank( $email ) || MoUtility::is_blank( $password ) || MoUtility::is_blank( $confirm_password ) ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::REQUIRED_FIELDS ), 'ERROR' );
				return;
			}

			update_mofr_option( 'company_name', $company );
			update_mofr_option( 'first_name', $first_name );
			update_mofr_option( 'last_name', $last_name );
			update_mofr_option( 'admin_email', $email );
			update_mofr_option( 'admin_password', $password );

			$content = json_decode( MocURLOTP::mofr_check_customer( $email ), true );
			switch ( $content['status'] ) {
				case 'CUSTOMER_NOT_FOUND':
					$this->handle_without_ckey_cid_regisgtration( $email, $company, $password, '', $first_name, $last_name );
					break;
				default:
					$this->mofr_get_current_customer( $email, $password );
					break;
			}

		}


		/**
		 * This function is called to send the OTP token to the user.
		 *
		 * @param string $email - the email provided by the user.
		 * @param string $phone - the phone number provided by the user.
		 * @param string $auth_type - email or sms verification.
		 */
		public function send_otp_token( $email, $phone, $auth_type ) {
			$content = json_decode( MocURLOTP::mofr_send_otp_token( $auth_type, $email, $phone ), true );
			if ( strcasecmp( $content['status'], 'SUCCESS' ) === 0 ) {
				update_mofr_option( 'transactionId', $content['txId'] );
				update_mofr_option( 'registration_status', 'MO_OTP_DELIVERED_SUCCESS' );
				if ( 'EMAIL' === $auth_type ) {
					do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::OTP_SENT, array( 'method' => $email ) ), 'SUCCESS' );
				} else {
					do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::OTP_SENT, array( 'method' => $phone ) ), 'SUCCESS' );
				}
			} else {
				update_mofr_option( 'registration_status', 'MO_OTP_DELIVERED_FAILURE' );
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::ERR_OTP ), 'ERROR' );
			}
		}


		/**
		 * Function to fetch customer details from the server and save in
		 * the local WordPress Database.
		 *
		 * @param string $email email of the user.
		 * @param string $password password of the user.
		 */
		private function mofr_get_current_customer( $email, $password ) {
			$content      = MocURLOTP::mofr_get_customer_key( $email, $password );
			$customer_key = json_decode( $content, true );
			if ( json_last_error() === JSON_ERROR_NONE ) {
				update_mofr_option( 'admin_email', $email );
				if ( isset( $customer_key['phone'] ) ) {
					update_mofr_option( 'admin_phone', $customer_key['phone'] );
				} else {
					update_mofr_option( 'admin_phone', '' );
				}
				$this->save_success_customer_config( $customer_key['id'], $customer_key['apiKey'], $customer_key['token'], $customer_key['appSecret'] );
				MoUtility::mofr_handle_mo_check_ln( false, $customer_key['id'], $customer_key['apiKey'] );
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::REG_SUCCESS ), 'SUCCESS' );
			} else {
				update_mofr_option( 'admin_email', $email );
				update_mofr_option( 'verify_customer', 'true' );
				delete_mofr_option( 'new_registration' );
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::ACCOUNT_EXISTS ), 'ERROR' );
			}
		}
		/**
		 * Save all required fields on customer registration/retrieval complete.
		 *
		 * @param string $id the id of the admin.
		 * @param string $api_key the api key of the admin.
		 * @param string $token the token of the admin.
		 * @param string $app_secret the app secret of the admin.
		 */
		private function save_success_customer_config( $id, $api_key, $token, $app_secret ) {
			update_mofr_option( 'admin_customer_key', $id );
			update_mofr_option( 'admin_api_key', $api_key );
			update_mofr_option( 'customer_token', $token );
			update_mofr_option( 'plugin_activation_date', gmdate( 'Y-m-d h:i:sa' ) );
			delete_mofr_option( 'verify_customer' );
			delete_mofr_option( 'new_registration' );
			delete_mofr_option( 'admin_password' );
		}

		/**
		 * Validate OTP posted by the user
		 *
		 * @param array $post   the $_POST array.
		 */
		public function mofr_validate_otp( $post ) {
			$otp_token = sanitize_text_field( $post['otp_token'] );
			$email     = get_mofr_option( 'admin_email' );
			$company   = get_mofr_option( 'company_name' );
			$password  = get_mofr_option( 'admin_password' );

			if ( MoUtility::is_blank( $otp_token ) ) {
				update_mofr_option( 'registration_status', 'MO_OTP_VALIDATION_FAILURE' );
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::REQUIRED_OTP ), 'ERROR' );
				return;
			}

			$content = json_decode( MocURLOTP::mofr_validate_otp_token( get_mofr_option( 'transactionId' ), $otp_token ), true );
			if ( strcasecmp( $content['status'], 'SUCCESS' ) === 0 ) {
				$customer_key = json_decode(
					MocURLOTP::mofr_create_customer( $email, $company, $password, $phone = '', $first_name = '', $last_name = '' ),
					true
				);
				if ( strcasecmp( $customer_key['status'], 'INVALID_EMAIL_QUICK_EMAIL' ) === 0 ) {
					do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::ENTERPRIZE_EMAIL ), 'ERROR' );
				}
				if ( strcasecmp( $customer_key['status'], 'CUSTOMER_USERNAME_ALREADY_EXISTS' ) === 0 ) {
					$this->mofr_get_current_customer( $email, $password );
				} elseif ( strcasecmp( $customer_key['status'], 'EMAIL_BLOCKED' ) === 0 && 'error.enterprise.email' === $customer_key['message'] ) {
					do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::ENTERPRIZE_EMAIL ), 'ERROR' );
				} elseif ( strcasecmp( $customer_key['status'], 'FAILED' ) === 0 ) {
					do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::REGISTRATION_ERROR ), 'ERROR' );
				} elseif ( strcasecmp( $customer_key['status'], 'SUCCESS' ) === 0 ) {
					$this->save_success_customer_config( $customer_key['id'], $customer_key['apiKey'], $customer_key['token'], $customer_key['appSecret'] );
					update_mofr_option( 'registration_status', 'MO_CUSTOMER_VALIDATION_REGISTRATION_COMPLETE' );

					do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::REG_COMPLETE ), 'SUCCESS' );
					header( 'Location: admin.php?page=mofrotpaccount' );
				}
			} else {
				update_mofr_option( 'registration_status', 'MO_OTP_VALIDATION_FAILURE' );
				do_action( 'mo_registration_show_message', MoUtility::get_invalid_otp_method(), 'ERROR' );
			}
		}
		/**
		 * Function to fetch customer details from the server and save in
		 * the local WordPress Database.
		 *
		 * @param string $email email of the user.
		 * @param string $company company of the user.
		 * @param string $password password of the user.
		 * @param string $phone phone of the user.
		 * @param string $first_name first_name of the user.
		 * @param string $last_name last_name of the user.
		 */
		private function handle_without_ckey_cid_regisgtration( $email, $company, $password, $phone, $first_name, $last_name ) {

			$customer_key = json_decode( MocURLOTP::mofr_create_customer( $email, $company, $password, $phone, $first_name, $last_name ), true );
			if ( strcasecmp( $customer_key['status'], 'INVALID_EMAIL_QUICK_EMAIL' ) === 0 ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::ENTERPRIZE_EMAIL ), 'ERROR' );
			}
			if ( strcasecmp( $customer_key['status'], 'CUSTOMER_USERNAME_ALREADY_EXISTS' ) === 0 ) {
				$this->mofr_get_current_customer( $email, $password );
			} elseif ( strcasecmp( $customer_key['status'], 'EMAIL_BLOCKED' ) === 0 && 'error.enterprise.email' === $customer_key['message'] ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::ENTERPRIZE_EMAIL ), 'ERROR' );
			} elseif ( strcasecmp( $customer_key['status'], 'FAILED' ) === 0 ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::REGISTRATION_ERROR ), 'ERROR' );
			} elseif ( strcasecmp( $customer_key['status'], 'SUCCESS' ) === 0 ) {
				$this->save_success_customer_config( $customer_key['id'], $customer_key['apiKey'], $customer_key['token'], $customer_key['appSecret'] );
				update_mofr_option( 'registration_status', 'MO_CUSTOMER_VALIDATION_REGISTRATION_COMPLETE' );
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::REG_COMPLETE ), 'SUCCESS' );
				header( 'Location: admin.php?page=mofrotpaccount' );
			}
		}
		/**
		 * Function to send otp token to phone
		 *
		 * @param array $post data of the user.
		 */
		public function mofr_send_phone_otp_token( $post ) {
			$phone   = sanitize_text_field( $post['phone_number'] );
			$phone   = str_replace( ' ', '', $phone );
			$pattern = '/[\+][0-9]{1,3}[0-9]{10}/';
			if ( preg_match( $pattern, $phone, $matches, PREG_OFFSET_CAPTURE ) ) {
				update_mofr_option( 'admin_phone', $phone );
				$this->send_otp_token( '', $phone, 'SMS' );
			} else {
				update_mofr_option( 'registration_status', 'MO_OTP_DELIVERED_FAILURE' );
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::INVALID_SMS_OTP ), 'ERROR' );
			}
		}

		/**
		 * Function to verify customer details. Checks if email and
		 * password has been submitted and then fetches customer info.
		 *
		 * @param array $post data of the user.
		 */
		public function mofr_verify_customer( $post ) {
			$email    = sanitize_email( $post['email'] );
			$password = stripslashes( $post['password'] );

			if ( MoUtility::is_blank( $email ) || MoUtility::is_blank( $password ) ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::REQUIRED_FIELDS ), 'ERROR' );
				return;
			}
			$this->mofr_get_current_customer( $email, $password );
		}


		/**
		 * Reset Administrator's miniOrange password.
		 * This calls the server to send a forgot password email.
		 */
		public function mofr_reset_password() {
			$email = get_mofr_option( 'admin_email' );
			if ( ! $email ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::MOFR_FORGOT_PASSWORD_MESSAGE ), 'SUCCESS' );
			} else {
				$mofr_forgot_password_response = json_decode( MocURLOTP::mofr_forgot_password( $email ) );
				if ( 'SUCCESS' === $mofr_forgot_password_response->status ) {
					do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::RESET_PASS ), 'SUCCESS' );
				} else {
					do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::UNKNOWN_ERROR ), 'ERROR' );
				}
			}
		}


		/**
		 * In case of an error delete all option values to revert back
		 * all the data as was at the beginning of the registration process.
		 */
		public function mofr_revert_back_registration() {
			update_mofr_option( 'registration_status', '' );
			delete_mofr_option( 'new_registration' );
			delete_mofr_option( 'verify_customer' );
			delete_mofr_option( 'admin_email' );
			delete_mofr_option( 'sms_otp_count' );
			delete_mofr_option( 'email_otp_count' );
			delete_mofr_option( 'plugin_activation_date' );
		}


		/**
		 * This function runs when the user wants to remove his account. Used to delete
		 * a few values so that the user has to login again when he wishes to.
		 */
		public function mofr_remove_account() {
			$this->mius();

			wp_clear_scheduled_hook( 'hourlySync' );
			delete_mofr_option( 'transactionId' );
			delete_mofr_option( 'admin_password' );
			delete_mofr_option( 'registration_status' );
			delete_mofr_option( 'admin_phone' );
			delete_mofr_option( 'new_registration' );
			delete_mofr_option( 'admin_customer_key' );
			delete_mofr_option( 'admin_api_key' );
			delete_mofr_option( 'customer_token' );
			delete_mofr_option( 'verify_customer' );
			delete_mofr_option( 'message' );
			delete_mofr_option( 'check_ln' );
			delete_mofr_option( 'site_email_ckl' );
			delete_mofr_option( 'email_verification_lk' );
			update_mofr_option( 'verify_customer', true );
			delete_mofr_option( 'plugin_activation_date' );
		}

		/**
		 * This function is used to verify the license key entered
		 * by the user while activating the plugin.
		 *
		 * @param array $post - all the data sent in form post to validate the license key.
		 */
		public function mofr_vlk( $post ) {
			if ( MoUtility::is_blank( $post['email_lk'] ) ) {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::REQUIRED_FIELDS ), MoConstants::ERROR );
				return;
			}
			$code   = trim( sanitize_text_field( $post['email_lk'] ) );
			$result = json_decode( $this->ccl(), true );
			switch ( $result['status'] ) {
				case 'SUCCESS':
					$this->mofr_vlk_success( $code );
					break;
				default:
					$this->mofr_vlk_fail();
					break;
			}
		}
		/**
		 * This function is called on successful verification of the license key entered
		 * by the user while activating the plugin.
		 *
		 * @param string $code - license key of email.
		 */
		private function mofr_vlk_success( $code ) {
			$content = json_decode( $this->vml( $code ), true );
			if ( isset( $content['status'] ) && strcasecmp( $content['status'], 'SUCCESS' ) === 0 ) {
				$key = get_mofr_option( 'customer_token' );
				update_mofr_option( 'email_verification_lk', $code );
				update_mofr_option( 'site_email_ckl', 'true' );
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::VERIFIED_LK ), 'SUCCESS' );
			} elseif ( isset( $content['status'] ) && strcasecmp( $content['status'], 'FAILED' ) === 0 ) {
				if ( strcasecmp( $content['message'], 'Code has Expired' ) === 0 ) {
					do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::LK_IN_USE ), 'ERROR' );
				} else {
					do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::INVALID_LK ), 'ERROR' );
				}
			} else {
				do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::UNKNOWN_ERROR ), 'ERROR' );
			}
		}
		/**
		 * This function is called on failed verification of the license key entered
		 * by the user while activating the plugin.
		 */
		private function mofr_vlk_fail() {
			$key = get_mofr_option( 'customer_token' );
			update_mofr_option( 'site_email_ckl', 'false' );
			do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::NEED_UPGRADE_MSG ), 'ERROR' );
		}
		/** MofrInternal Function
		 */
		private function ccl() {
			$url          = MoConstants::HOSTNAME . '/moas/rest/customer/license';
			$api_key      = get_mofr_option( 'admin_api_key' );
			$customer_key = get_mofr_option( 'admin_customer_key' );

			$fields = array(
				'customerId'      => $customer_key,
				'applicationName' => $this->application_name,
			);

			$json        = wp_json_encode( $fields );
			$auth_header = MocURLOTP::mofr_create_authheader( $customer_key, $api_key );
			$response    = MocURLOTP::mofr_call_api( $url, $json, $auth_header );
			return $response;
		}
		/** MofrInternal Function
		 */
		private function mius() {
			$url          = MoConstants::HOSTNAME . '/moas/api/backupcode/updatestatus';
			$customer_key = get_mofr_option( 'admin_customer_key' );
			$api_key      = get_mofr_option( 'admin_api_key' );
			$key          = get_mofr_option( 'customer_token' );
			$code         = get_mofr_option( 'email_verification_lk' );
			$fields       = array(
				'code'        => $code,
				'customerKey' => $customer_key,
			);
			$json         = wp_json_encode( $fields );
			$auth_header  = MocURLOTP::mofr_create_authheader( $customer_key, $api_key );
			$response     = MocURLOTP::mofr_call_api( $url, $json, $auth_header );
			return $response;
		}
		/**
		 * MofrInternal Function
		 *
		 * @param string $code - license key of email.
		 */
		private function vml( $code ) {
			$url          = MoConstants::HOSTNAME . '/moas/api/backupcode/verify';
			$customer_key = get_mofr_option( 'admin_customer_key' );
			$api_key      = get_mofr_option( 'admin_api_key' );

			$fields = array(
				'code'             => $code,
				'customerKey'      => $customer_key,
				'additionalFields' => array(
					'field1' => site_url(),
				),
			);

			$json        = wp_json_encode( $fields );
			$auth_header = MocURLOTP::mofr_create_authheader( $customer_key, $api_key );
			$response    = MocURLOTP::mofr_call_api( $url, $json, $auth_header );
			return $response;
		}
	}
}
