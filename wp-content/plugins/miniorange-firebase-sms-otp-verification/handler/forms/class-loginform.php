<?php
/**
 * Load admin view for Login Form.
 *
 * @package miniorange-firebase-sms-otp-verification/handler/forms
 */

namespace MoOTP\Handler\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MoOTP\Helper\MoPHPSessions;
use MoOTP\Traits\Instance;
use MoOTP\Helper\MoUtility;
use MoOTP\Objects\FormHandler;
use MoOTP\Objects\IFormHandler;
use \WP_Error;
use \WP_User;
/**
 * This is the Login Form class. This class handles all the
 * functionality related to Login Form. It extends the FormHandler
 * and implements the IFormHandler class to implement some much needed functions.
 */
if ( ! class_exists( 'LoginForm' ) ) {
	/**
	 * Login form class.
	 */
	class LoginForm extends FormHandler implements IFormHandler {
		use Instance;

		/**
		 * Login form css
		 *
		 * @var string
		 */
		protected $login_form_css;
		/**
		 * Nonce for login form
		 *
		 * @var string
		 */
		protected $nonce = 'frb_form_nonce';
		/**
		 * Action to generate OTP
		 *
		 * @var string
		 */
		protected $generate_otp_action = 'miniorange_frb_login_generate_otp';
		/**
		 * Undocumented function
		 * Initializes values
		 */
		protected function __construct() {
			$this->is_form_enabled     = get_mofr_option( 'login_form_enable' );
			$this->is_dropdown_enabled = get_mofr_option( 'mo_firebase_dropdown_form_enable' );
			$this->phone_key           = 'mofr_loginwithotp_phone';
			$this->phone_form_id       = array(
				'.class_' . $this->phone_key,
				'input[name=' . $this->phone_key . ' ]',
			);
			$this->get_user_phone      = true;
			$this->nonce               = 'mofr_firebase_actions';
			add_action( 'init', array( $this, 'handle_mofirebase_form' ), 1 );
			parent::__construct();
		}

		/**
		 * Function checks if form has been enabled by the admin and initializes
		 * all the class variables. This function also defines all the hooks to
		 * hook into to make OTP Verification possible.
		 */
		public function handle_mofirebase_form() {

			add_shortcode( 'mo_wp_login_form', array( $this, 'show_mo_wp_login_form' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'miniorange_login_mofirebaselogin_script' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'miniorange_reset_password_script' ) );

			add_action( 'wp_ajax_mofr_login_with_otp_sendotp', array( $this, 'send_otp' ) );
			add_action( 'wp_ajax_nopriv_mofr_login_with_otp_sendotp', array( $this, 'send_otp' ) );

			add_action( 'wp_ajax_mofr_reset_pass', array( $this, 'reset_pass_otp' ) );
			add_action( 'wp_ajax_nopriv_mofr_reset_pass', array( $this, 'reset_pass_otp' ) );

			add_action( 'wp_ajax_mofr_login_with_email_pass', array( $this, 'mofr_login_with_email_pass' ) );
			add_action( 'wp_ajax_nopriv_mofr_login_with_email_pass', array( $this, 'mofr_login_with_email_pass' ) );

			add_action( 'wp_ajax_mofr_login_with_otp_verifyotp', array( $this, 'mofr_validate_otp_token' ) );
			add_action( 'wp_ajax_nopriv_mofr_login_with_otp_verifyotp', array( $this, 'mofr_validate_otp_token' ) );

			add_action( 'wp_ajax_mofr_reset_pass_verifyotp', array( $this, 'mofr_validate_reset_pass_otp_token' ) );
			add_action( 'wp_ajax_nopriv_mofr_reset_pass_verifyotp', array( $this, 'mofr_validate_reset_pass_otp_token' ) );

			add_action( 'wp_ajax_mofr_reset_new_pass', array( $this, 'reset_password' ) );
			add_action( 'wp_ajax_nopriv_mofr_reset_new_pass', array( $this, 'reset_password' ) );

			if ( isset( $_POST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ), 'mofr_firebase_actions' ) ) {
				return;
			}

			$post = MoUtility::sanitize_post_data( $_POST );

			if ( ( isset( $post['option'] ) && ( 'mo_firebase_login_form_save_option' === $post['option'] ) ) && $post['option'] && isset( $post['nonce_mo_firebase_login_form_save_option'] ) && wp_verify_nonce( $post['nonce_mo_firebase_login_form_save_option'], 'mo_nonce_mo_firebase_form_save_option' ) ) {
				$this->handle_mofirebase_form_options();
			}

		}
		/**
		 * The function checks if the user has eneterd correct email and password and allows user to login.
		 */
		public function mofr_login_with_email_pass() {

			if ( ! check_ajax_referer( $this->nonce, 'user_nonce_login_with_emailpass', false ) ) {
				wp_send_json( MoUtility::create_json( 'Invalid Operation. Please Try Again !', 'error' ) );
			}

			$post = MoUtility::sanitize_post_data( $_POST );

			$user_data = sanitize_text_field( $post['user_data'] );
			$user_pass = sanitize_text_field( $post['user_pass'] );

			if ( is_email( $user_data ) ) {
				$user     = get_user_by( 'email', $user_data );
				$username = $user->user_login;
			} else {
				$username = $user_data;
			}

			$user = wp_authenticate_username_password( null, $username, $user_pass );

			if ( is_wp_error( $user ) ) {
				wp_send_json( MoUtility::create_json( 'Invalid Username or Password !', 'error' ) );
			} else {
				wp_set_auth_cookie( $user->data->ID );
				wp_send_json( MoUtility::create_json( 'validation successful', 'success' ) );
				exit();
			}
		}
		/**
		 * The function checks if the phone number is registered and send the OTP during login.
		 */
		public function send_otp() {

			if ( ! check_ajax_referer( $this->nonce, 'user_nonce_login_with_otp', false ) ) {
				wp_send_json( MoUtility::create_json( 'Invalid Operation. Please Try Again !', 'error' ) );
			}

			$post  = MoUtility::sanitize_post_data( $_POST );
			$token = sanitize_text_field( $post['recaptcha_token'] );
			$phone = sanitize_text_field( $post['user_phone'] );
			$user  = $this->getUserFromPhoneNumber( $phone );

			if ( ! $user ) {
				wp_send_json( MoUtility::create_json( 'Please enter a registered Phone Number', 'error' ) );
			} else {
				MoPHPSessions::add_session_var( 'mofr_login_phone_verified', $phone );
			}
		}
		/**
		 * The function checks if the phone number or email is registered and send the OTP during reset password.
		 */
		public function reset_pass_otp() {

			if ( ! check_ajax_referer( $this->nonce, 'user_nonce_reset_pass', false ) ) {
				wp_send_json( MoUtility::create_json( 'Invalid Operation. Please Try Again !', 'error' ) );
			}

			$post = MoUtility::sanitize_post_data( $_POST );

			$token = sanitize_text_field( $post['recaptcha_token'] );

			$email      = sanitize_text_field( $post['user_email'] );
			$user       = get_user_by( 'email', $email );
			$user_id    = $user->ID;
			$phone      = get_user_meta( $user_id, 'billing_phone' );
			$user_phone = $phone[0];

			if ( MoUtility::is_blank( $user_phone ) ) {
				wp_send_json( MoUtility::create_json( 'Please enter a registered email address!', 'error' ) );
			} else {
				MoPHPSessions::add_session_var( 'mofr_reset_pass_email_verified', $email );
				wp_send_json( MoUtility::create_json( $user_phone, 'success' ) );
			}
		}
		/**
		 * The function validates the OTP during login.
		 */
		public function mofr_validate_otp_token() {
			if ( ! check_ajax_referer( $this->nonce, 'user_nonce_verify_login_with_otp', false ) ) {
				wp_send_json( MoUtility::create_json( 'Invalid Operation. Please Try Again !', 'error' ) );
			}

			$post = MoUtility::sanitize_post_data( $_POST );
			if ( 'OTP verified successfully!!!' === $post['mofrlogin_text'] ) {
				$otp_token = sanitize_text_field( $post['otp_token'] );
				$user      = $this->getUserFromPhoneNumber( sanitize_text_field( $post['user_phone'] ) );
				$phone     = sanitize_text_field( $post['user_phone'] );
				if ( MoPHPSessions::get_session_var( 'mofr_login_phone_verified' ) !== $phone ) {
					wp_send_json( MoUtility::create_json( 'The phone number OTP was sent to and the phone number in contact submission do not match.', 'error' ) );
				} else {
					wp_set_auth_cookie( $user->ID );
					wp_send_json( MoUtility::create_json( 'otp_validated_successfully', 'success' ) );
				}
			}
		}
		/**
		 * The function validates the OTP during reset password.
		 */
		public function mofr_validate_reset_pass_otp_token() {
			if ( ! check_ajax_referer( $this->nonce, 'user_nonce_reset_pass_verify', false ) ) {
				wp_send_json( MoUtility::create_json( 'Invalid Operation. Please Try Again !', 'error' ) );
			}

			$post = MoUtility::sanitize_post_data( $_POST );
			if ( 'OTP verified successfully!!!' === $post['moResetPassText'] ) {
				$email = sanitize_text_field( $post['user_email'] );
				if ( MoPHPSessions::get_session_var( 'mofr_reset_pass_email_verified' ) !== $email ) {
					wp_send_json( MoUtility::create_json( 'The Email OTP was sent to and the Email in contact submission do not match.', 'error' ) );
				} else {
					wp_send_json( MoUtility::create_json( 'otp_validated_successfully', 'success' ) );
				}
			}
		}
		/**
		 * The function returns if a string contains special character.
		 *
		 * @param string $str - string to be checked.
		 */
		private function containsSpecialChars( $str ) {
			$special_chars = preg_match( '[@_!#$%^&*()<>?/|}{~:]', $str );
			return $special_chars;
		}
		/**
		 * The function resets the password for a authenticated user.
		 */
		public function reset_password() {
			if ( ! check_ajax_referer( $this->nonce, 'user_nonce_reset_new_pass', false ) ) {
				wp_send_json( MoUtility::create_json( 'Invalid Operation. Please Try Again !', 'error' ) );
			}

			$post = MoUtility::sanitize_post_data( $_POST );
			global $wpdb;

			$user_data = sanitize_text_field( $post['user_email'] );
			$user      = get_user_by( 'email', $user_data );
			$user_id   = $user->ID;

			$new_pass = sanitize_text_field( $post['new_pass'] );

			$confirm_pass = sanitize_text_field( $post['confirm_pass'] );

			if ( $new_pass !== $confirm_pass ) {
				wp_send_json( MoUtility::create_json( 'Set Password field and Confirm password fields are not same.', 'error' ) );
			} elseif ( strlen( $new_pass ) < 6 && ! $this->containsSpecialChars( $new_pass ) ) {
				wp_send_json( MoUtility::create_json( 'Password must contain atleast 6 characters and 1 special character.', 'error' ) );
			} else {
				if ( isset( $new_pass ) ) {
					wp_set_password( $new_pass, $user->ID );
				}
				wp_send_json( MoUtility::create_json( 'Password updated succesfully!', 'success' ) );
			}
		}
		/**
		 * This functions fetches the user associated with a phone number
		 *
		 * @param string $username  the user's username.
		 * @return bool|WP_User
		 */
		private function getUserFromPhoneNumber( $username ) {
			global $wpdb;
			$key     = 'billing_phone';
			$results = $wpdb->get_row( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery, Direct database call without caching detected -- DB Direct Query is necessary here.
				$wpdb->prepare(
					"SELECT `user_id` FROM `{$wpdb->prefix}usermeta`"
									. 'WHERE `meta_key` = %s AND `meta_value` = %s',
					array( $key, $username )
				)
			);
			return ! MoUtility::is_blank( $results ) ? get_userdata( $results->user_id ) : false;
		}
		/**
		 * Register the javascript to be added to the frontend which will handle
		 * submission of the login form.
		 */
		public function miniorange_login_mofirebaselogin_script() {
			wp_register_script( 'mofrloginform', MOFLR_URL . 'includes/js/mofrloginform.min.js', array( 'jquery' ), MOFLR_VERSION, true );
			wp_localize_script(
				'mofrloginform',
				'mofrloginform',
				array(
					'siteURL'     => wp_ajax_fr_url(),
					'nonce'       => wp_create_nonce( $this->nonce ),
					'generateURL' => $this->generate_otp_action,
					'redirecturl' => get_page_link( get_mofr_option( 'login_form_redirecturl' ) ),
				)
			);
			wp_enqueue_script( 'mofrloginform' );
		}
		/**
		 * Register the javascript to be added to the frontend which will handle
		 * submission of the reset password form.
		 */
		public function miniorange_reset_password_script() {

			wp_register_script( 'mofrresetpass', MOFLR_URL . 'includes/js/mofr_reset_pass.min.js', array( 'jquery' ), MOFLR_VERSION, true );
			wp_localize_script(
				'mofrresetpass',
				'mofrresetpass',
				array(
					'siteURL'     => wp_ajax_fr_url(),
					'nonce'       => wp_create_nonce( $this->nonce ),
					'generateURL' => $this->generate_otp_action,
					'user_phone'  => $this->get_user_phone,
					'redirecturl' => get_page_link( get_mofr_option( 'login_form_redirecturl' ) ),
				)
			);
			wp_enqueue_script( 'mofrresetpass' );
		}
		/**
		 * The function shows the login form using the shortcode.
		 */
		public function show_mo_wp_login_form() {
			if ( is_user_logged_in() ) {
				return;
			} else {
				$custom_css = get_mofr_option( 'login_form_css' );
				include MOFLR_DIR . 'views/shortcodes/mo-user-login-form-shortcode.php';
			}
		}
		/**
		 * This function is called by the filter mofr_phone_dropdown_selector
		 * to return the Jquery selector of the phone field. The function will
		 * push the formID to the selector array if OTP Verification for the
		 * form has been enabled.
		 *
		 * @param array $selector - the Jquery selector to be modified.
		 * @return array
		 */
		public function getPhoneNumberSelector( $selector ) {
			if ( $this->is_form_enabled && $this->is_dropdown_enabled ) {
				$selector = array_merge( $selector, $this->phone_form_id );
			}
			return $selector;
		}
		/**
		 * Handles saving all the Login Form and reset password form related options by the admin.
		 */
		public function handle_mofirebase_form_options() {
			$post_id                   = isset( $_POST['page_id'] ) ? get_the_title( sanitize_text_field( wp_unslash( $_POST['page_id'] ) ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- No need for nonce verification as the nonce is already verified.
			$this->is_form_enabled     = $this->sanitize_form_post( 'login_form_enable' );
			$this->login_form_css      = $this->sanitize_form_post( 'login_form_css' );
			$this->redirecturl         = isset( $post_id ) ? $post_id : '';
			$this->is_dropdown_enabled = $this->sanitize_form_post( 'dropdown_form_enable' );

			update_mofr_option( 'login_form_enable', $this->is_form_enabled );
			update_mofr_option( 'login_form_css', $this->login_form_css );
			if ( file_exists( MOFLR_DIR . 'helper/class-mofirebasepremiumplan.php' ) ) {
				update_mofr_option( 'login_form_redirecturl', $this->redirecturl );
			}
		}
	}
}
