<?php
/**
 * Load admin view for login and registration form.
 *
 * @package miniorange-firebase-sms-otp-verification/handler
 */

namespace MoOTP\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MoOTP\Helper\MoPHPSessions;
use MoOTP\Traits\Instance;
use MoOTP\Helper\MoUtility;
use MoOTP\Objects\FormHandler;
use MoOTP\Objects\IFormHandler;

/**
 * This is the LoginRegistration Form class. This class handles all the
 * functionality related to LoginRegistration Form. It extends the FormHandler
 * and implements the IFormHandler class to implement some much needed functions.
 */
if ( ! class_exists( 'LoginRegistrationForm' ) ) {
	/**
	 * Registration and Login form class.
	 */
	class LoginRegistrationForm extends FormHandler implements IFormHandler {
		use Instance;

		/**
		 * Login form css
		 *
		 * @var string
		 */
		protected $loginreg_form_css;
		/**
		 * Undocumented function
		 * Initializes values
		 */
		protected function __construct() {
			$this->nonce = 'mofr_logreg_form_actions';
			add_action( 'init', array( $this, 'handle_mofirebase_form' ), 1 );
		}
		/**
		 * Function checks if form has been enabled by the admin and initializes
		 * all the class variables. This function also defines all the hooks to
		 * hook into to make OTP Verification possible.
		 */
		public function handle_mofirebase_form() {

			add_shortcode( 'mo_wp_loginreg_form', array( $this, 'show_mo_wp_loginreg_form' ) );
			if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ), 'mofr_firebase_actions' ) ) {
				return;
			}

			$post = MoUtility::sanitize_post_data( $_POST );

			if ( isset( $post['option'] ) && 'mo_firebase_loginreg_form_save_option' === $post['option'] && isset( $post['nonce_mo_firebase_loginreg_form_save_option'] ) && wp_verify_nonce( $post['nonce_mo_firebase_loginreg_form_save_option'], 'mo_nonce_mo_firebase_form_save_option' ) ) {
				$this->handle_mofirebase_form_options();
			}
		}
		/**
		 * The function shows the login and registration form using the shortcode.
		 */
		public function show_mo_wp_loginreg_form() {
			if ( is_user_logged_in() ) {
				return;
			} else {
				$mo_firebase_loginreg_form_css_file = wp_remote_get( MOFLR_URL . 'includes/css/mofr_loginreg_form.min.css' );
				if ( is_wp_error( $mo_firebase_loginreg_form_css_file ) ) {
					$mo_firebase_loginreg_form_css_file = '';
				} else {
					$mo_firebase_loginreg_form_css_file = wp_remote_retrieve_body( $mo_firebase_loginreg_form_css_file );
				}
				$customloginreg_css          = get_mofr_option( 'loginreg_form_css' ) ? get_mofr_option( 'loginreg_form_css' ) : $mo_firebase_loginreg_form_css_file;
				$is_registration_otp_enabled = get_mofr_option( 'registration_form_enable' );
				$is_login_otp_enabled        = get_mofr_option( 'login_form_enable' );
				$is_dropdown_enabled         = get_mofr_option( 'dropdown_form_enable' );
				ob_start();
				include MOFLR_DIR . 'views/shortcodes/mo-user-loginreg-form-shortcode.php';
				$output = ob_get_clean();
				return $output;
			}
		}
		/**
		 * Handles saving all the Registration Form related options by the admin.
		 */
		public function handle_mofirebase_form_options() {
			$mo_firebase_loginreg_form_css_file = wp_remote_get( MOFLR_URL . 'includes/css/mofr_loginreg_form.min.css' );
			if ( is_wp_error( $mo_firebase_loginreg_form_css_file ) ) {
				$mo_firebase_loginreg_form_css_file = '';
			} else {
				$mo_firebase_loginreg_form_css_file = wp_remote_retrieve_body( $mo_firebase_loginreg_form_css_file );
			}
			$this->loginreg_form_css = $this->sanitize_form_post( 'loginreg_form_css' ) ? $this->sanitize_form_post( 'loginreg_form_css' ) : $mo_firebase_loginreg_form_css_file;
			update_mofr_option( 'loginreg_form_css', $this->loginreg_form_css );
		}
	}
}
