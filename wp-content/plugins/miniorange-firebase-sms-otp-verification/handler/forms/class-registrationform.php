<?php
/**
 * Load admin view for registration form.
 *
 * @package miniorange-firebase-sms-otp-verification/handler/forms
 */

namespace MoOTP\Handler\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MoOTP\Helper\MoPHPSessions;
use MoOTP\Helper\MoConstants;
use MoOTP\Helper\MoMessages;
use MoOTP\Traits\Instance;
use MoOTP\Objects\FormHandler;
use MoOTP\Objects\IFormHandler;
use MoOTP\Helper\MoUtility;
/**
 * This is the Registration Form class. This class handles all the
 * functionality related to Registration Form. It extends the FormHandler
 * and implements the IFormHandler class to implement some much needed functions.
 */
if ( ! class_exists( 'RegistrationForm' ) ) {
	/**
	 * Registration Form class
	 */
	class RegistrationForm extends FormHandler implements IFormHandler {
		use Instance;

		/**
		 * Registration form css
		 *
		 * @var string
		 */
		protected $registration_form_css;
		/**
		 * Action to generate OTP
		 *
		 * @var string
		 */
		protected $generate_otp_action = 'miniorange_frb_registration_generate_otp';
		/**
		 * Nonce for registration form
		 *
		 * @var string
		 */
		protected $nonce = 'frb_form_nonce';
		/**
		 * Default role of the user during registration.
		 *
		 * @var string
		 */
		protected $default_user_role;
		/**
		 * Undocumented function
		 * Initializes values
		 */
		protected function __construct() {
			$this->is_form_enabled = get_mofr_option( 'registration_form_enable' );
			add_action( 'init', array( $this, 'handle_mofirebase_form' ), 1 );
			$this->phone_key           = 'mofr_reg_phone';
			$this->phone_form_id       = array(
				'.class_' . $this->phone_key,
				'input[name=' . $this->phone_key . ']',
			);
			$this->is_dropdown_enabled = get_mofr_option( 'mo_firebase_dropdown_form_enable' );

			parent::__construct();
		}
		/**
		 * Function checks if form has been enabled by the admin and initializes
		 * all the class variables. This function also defines all the hooks to
		 * hook into to make OTP Verification possible.
		 */
		public function handle_mofirebase_form() {

			add_shortcode( 'mo_wp_registration_form', array( $this, 'show_mo_wp_registration_form' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'miniorange_register_mofirebasereg_script' ) );

			add_action( 'wp_ajax_mo_firebase_reg_send_form', array( $this, 'send_otp' ) );
			add_action( 'wp_ajax_nopriv_mo_firebase_reg_send_form', array( $this, 'send_otp' ) );

			add_action( 'wp_ajax_mo_firebase_verify_otp', array( $this, 'mofr_validate_otp_token' ) );
			add_action( 'wp_ajax_nopriv_mo_firebase_verify_otp', array( $this, 'mofr_validate_otp_token' ) );

			add_action( 'wp_ajax_mo_firebase_reg_submit', array( $this, 'validate_form_submission' ) );
			add_action( 'wp_ajax_nopriv_mo_firebase_reg_submit', array( $this, 'validate_form_submission' ) );

			if ( isset( $_POST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ), 'mofr_firebase_actions' ) ) {
				return;
			}

			$post = MoUtility::sanitize_post_data( $_POST );

			if ( isset( $post['option'] ) && 'mo_firebase_registration_form_save_option' === $post['option'] ) {
				$this->handle_mofirebase_form_options();
			}
		}
		/**
		 * This functions fetches the user associated with a phone number
		 *
		 * @param string $username  the user's username.
		 * @return bool|\WP_User
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
		 * The function checks if the phone number is registered and send the OTP during registration.
		 */
		public function send_otp() {
			if ( ! check_ajax_referer( $this->nonce, 'security', false ) ) {
				wp_send_json( MoUtility::create_json( 'Invalid Operation. Please Try Again !', 'error' ) );
			}

			$post = MoUtility::sanitize_post_data( $_POST );

			$nonce = sanitize_text_field( $post['security'] );

			$token = sanitize_text_field( $post['recaptcha_token'] );
			$phone = sanitize_text_field( $post['user_phone'] );
			$user  = $this->getUserFromPhoneNumber( $phone );

			if ( $user ) {
				$content = array( 'status' => MoConstants::FAILURE );
				wp_send_json( MoUtility::create_json( 'Phone Number already exists.', 'error' ) );
			} elseif ( MoUtility::is_blank( $phone ) ) {
				wp_send_json( MoUtility::create_json( 'Please enter a valid phone number!', 'error' ) );
			} else {
				MoPHPSessions::add_session_var( 'mo_otptoken', true );
				MoPHPSessions::add_session_var( 'mo_registration_phone_verified', $phone );
			}
		}
		/**
		 * The function validates the OTP during registration.
		 */
		public function mofr_validate_otp_token() {
			if ( ! check_ajax_referer( $this->nonce, 'security', false ) ) {
				wp_send_json( MoUtility::create_json( 'Invalid Operation. Please Try Again !', 'error' ) );
			}

			$post = MoUtility::sanitize_post_data( $_POST );
			if ( 'OTP verified successfully!!!' === $post['mofrreg_text'] ) {
				MoPHPSessions::add_session_var( 'is_regform_validated', true );
				wp_send_json( MoUtility::create_json( 'otp_validated_successfully', 'success' ) );
			}
		}
		/**
		 * The function validates the fields submitted during registration.
		 */
		public function validate_form_submission() {
			if ( ! check_ajax_referer( $this->nonce, 'user_nonce_registration_submit', false ) ) {
				wp_send_json( MoUtility::create_json( 'Invalid Operation. Please Try Again !', 'error' ) );
			}

			$post = MoUtility::sanitize_post_data( $_POST );
			if ( ! is_email( sanitize_email( $post['user_email'] ) ) ) {
				wp_send_json( MoUtility::create_json( 'Enter a valid email address', 'error' ) );
			}

			if ( get_user_by( 'email', sanitize_email( $post['user_email'] ) ) ) {
				wp_send_json( MoUtility::create_json( 'Email Address already used !', 'error' ) );
			}

			if ( get_user_by( 'login', sanitize_user( $post['user_name'] ) ) ) {
				wp_send_json( MoUtility::create_json( 'Username already used !', 'error' ) );
			}
			if ( ! sanitize_text_field( $post['user_phone'] ) ) {
				wp_send_json( MoUtility::create_json( 'Enter a valid phone number !', 'error' ) );
			}
			if ( ! sanitize_text_field( $post['user_pass'] ) ) {
				wp_send_json( MoUtility::create_json( 'Enter a valid password !', 'error' ) );
			}
			if ( $this->is_form_enabled ) {
				if ( ! MoPHPSessions::get_session_var( 'is_regform_validated' ) ) {
					wp_send_json( MoUtility::create_json( 'Please verify yourself !', 'error' ) );
				} elseif ( MoPHPSessions::get_session_var( 'mo_registration_phone_verified' ) !== sanitize_text_field( $post['user_phone'] ) ) {
					wp_send_json( MoUtility::create_json( 'Phone on which OTP was sent and phone submitted does not match', 'error' ) );
				}
			}
			$userdata = array(
				'user_login' => sanitize_user( $post['user_name'] ),
				'user_pass'  => sanitize_text_field( $post['user_pass'] ),
				'user_email' => sanitize_email( $post['user_email'] ),
				'role'       => get_mofr_option( 'default_user_role' ) ? get_mofr_option( 'default_user_role' ) : 'administrator',
			);

			$user_id = wp_insert_user( $userdata );

			update_user_meta( $user_id, 'billing_phone', sanitize_text_field( $post['user_phone'] ) );

			MoPHPSessions::unset_session( 'mo_otptoken' );
			wp_set_auth_cookie( $user_id );

			wp_send_json( MoUtility::create_json( 'form_validated_successfully', 'success' ) );

		}
		/**
		 * Register the javascript to be added to the frontend which will handle
		 * submission of the registration form.
		 */
		public function miniorange_register_mofirebasereg_script() {

			wp_register_script( 'mofrregistrationform', MOFLR_URL . 'includes/js/mofrregistrationform.min.js', array( 'jquery' ), MOFLR_VERSION, true );
			wp_localize_script(
				'mofrregistrationform',
				'mofrregistrationform',
				array(
					'siteURL'     => wp_ajax_fr_url(),
					'nonce'       => wp_create_nonce( $this->nonce ),
					'generateURL' => $this->generate_otp_action,
					'redirecturl' => get_page_link( get_mofr_option( 'reg_form_redirecturl' ) ),
				)
			);
			wp_enqueue_script( 'mofrregistrationform' );

		}
		/**
		 * The function shows the registration form using the shortcode.
		 */
		public function show_mo_wp_registration_form() {
			if ( is_user_logged_in() ) {
				return;
			} else {
				$custom_css = get_mofr_option( 'registration_form_css' );
				ob_start();
				include MOFLR_DIR . 'views/shortcodes/mo-user-registration-form-shortcode.php';
				$output = ob_get_clean();
				return $output;
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
		 * Handles saving all the Registration Form related options by the admin.
		 */
		public function handle_mofirebase_form_options() {
			$post_id                     = isset( $_POST['page_id'] ) ? get_the_title( sanitize_text_field( wp_unslash( $_POST['page_id'] ) ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- No need for nonce verification as the nonce is already verified.
			$this->is_form_enabled       = $this->sanitize_form_post( 'registration_form_enable' );
			$this->registration_form_css = $this->sanitize_form_post( 'registration_form_css' );
			$this->redirecturl           = isset( $post_id ) ? $post_id : '';
			$this->is_dropdown_enabled   = $this->sanitize_form_post( 'dropdown_form_enable' );
			$this->default_user_role     = $this->sanitize_form_post( 'default_user_role' );

			update_mofr_option( 'registration_form_enable', $this->is_form_enabled );
			update_mofr_option( 'registration_form_css', $this->registration_form_css );
			if ( file_exists( MOFLR_DIR . 'helper/class-mofirebasepremiumplan.php' ) ) {
				update_mofr_option( 'reg_form_redirecturl', $this->redirecturl );
				update_mofr_option( 'default_user_role', $this->default_user_role );
			}
		}
	}
}
