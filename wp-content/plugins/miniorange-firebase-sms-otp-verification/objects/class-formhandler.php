<?php
/**Load Interface FormHandler
 *
 * @package miniorange-firebase-sms-otp-verification/objects
 */

namespace MoOTP\Objects;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MoOTP\Helper\MoConstants;
use MoOTP\Helper\ShowContactUs;
use MoOTP\Helper\MoMessages;
use MoOTP\Helper\MoPHPSessions;
use MoOTP\Helper\MoFirebaseFreePlan;
use MoOTP\Helper\MoFirebasePremiumPlan;
use MoOTP\Helper\MoUtility;
use MoOTP\Traits\Instance;
use MoOTP\Helper\MocURLOTP;

if ( ! class_exists( 'FormHandler' ) ) {
	/**
	 * Interface class that needs to be extended by each form class.
	 * It defines some of the common actions and functions for each form
	 * class.
	 */
	class FormHandler {

		use Instance;
		/**
		 * The phone HTML tag
		 *
		 * @var string
		 */

		protected $type_phone_tag;
		/**
		 * The email HTML tag
		 *
		 * @var string
		 */

		protected $type_email_tag;
		/**
		 * The both HTML tag
		 *
		 * @var string
		 */

		protected $type_both_tag;

		/**
		 * The form key
		 *
		 * @var string
		 */
		protected $redirecturl;

		/**
		 * The form key
		 *
		 * @var string
		 */
		protected $form_key;

		/**
		 * The name of the form
		 *
		 * @var string
		 */
		protected $form_name;

		/**
		 * Email or sms verification ( type of otp enabled by admin )
		 *
		 * @var string
		 */
		protected $otp_type;

		/**
		 * The form javascript selector used by the script
		 * file to append country code dropdown
		 *
		 * @var string|array
		 */
		protected $phone_form_id;

		/**
		 * Is form enabled or not
		 *
		 * @var string
		 */
		protected $is_form_enabled;

		/**
		 * Is dropdown enabled or not
		 *
		 * @var string
		 */
		protected $is_dropdown_enabled;

		/**
		 * Meta key against which phone number is stored
		 *
		 * @var string
		 */
		protected $phone_meta_key;

		/**
		 * Restrict duplicate phone number entries
		 *
		 * @var string
		 */
		protected $restrict_duplicates;

		/**
		 * Option to by pass otp verification for logged in users
		 *
		 * @var string
		 */
		protected $by_pass_login;

		/**
		 * Is the form in question a login or social form
		 *
		 * @var string
		 */

		protected $is_login_or_social_form;
		/**
		 * Is the form an ajax form or not
		 *
		 * @var string
		 */

		protected $is_ajax_form;

		/**
		 * The key value of the phone field
		 *
		 * @var string
		 */
		protected $phone_key;

		/**
		 * The key value of the email field
		 *
		 * @var string
		 */
		protected $email_key;


		/**
		 * Text of the button
		 *
		 * @var string
		 */
		protected $button_text;
		/**
		 * The form details - formid, phonekey / emailkey etc
		 *
		 * @var array
		 */

		protected $form_details;

		/**
		 * Option set by the admin to disable auto activation of users after successful verification
		 *
		 * @var string
		 */

		protected $disable_auto_activate;
		/**
		 * The session variable associated with Form
		 *
		 * @var string
		 */

		protected $form_session_var;

		/**
		 * The session variable associated with WordPress Form
		 *
		 * @var string
		 */
		protected $form_session_var2;

		/**
		 * The nonce key for all forms
		 *
		 * @var string
		 */
		protected $nonce = 'form_nonce';

		/**
		 * The session Id which stores the transaction ids
		 *
		 * @var string
		 */

		/**
		 * The form options for all forms
		 *
		 * @var string
		 */
		protected $form_option = 'mo_customer_validation_settings';

		/**
		 * The generateOTPAction Key
		 *
		 * @var string
		 */
		protected $generate_otp_action;

		/**
		 * The key to check if the replace WC Checkout form is enabled.
		 *
		 * @var string
		 */
		protected $is_replace_wc_enabled;

		/**
		 * The generateOTPAction Key
		 *
		 * @var string
		 */
		protected $validate_otp_action;

		/**
		 * Get user phone number
		 *
		 * @var string
		 */
		protected $get_user_phone;

		/**
		 * Nonce key against with the nonce value is passed
		 *
		 * @var string
		 */
		protected $nonce_key = 'security';

		/**
		 * Value that indicates if the form in question is an AddOn Form
		 *
		 * @var bool
		 */
		protected $is_add_on_form = false;

		/**
		 * The form documents array
		 *
		 * @var array
		 */
		protected $form_documents = array();

		/**
		 * The gateway selected
		 *
		 * @var object
		 */
		private $gateway;

		/**
		 * Convert plugin type into class
		 *
		 * @var array
		 * Plugin Type to Class Map
		 */
		public $plugin_type_to_class = array(
			'MoFirebaseFreePlan'    => 'MoOTP\Helper\MoFirebaseFreePlan',
			'MoFirebasePremiumPlan' => 'MoOTP\Helper\MoFirebasePremiumPlan',
		);

		const VALIDATED           = 'VALIDATED';
		const VERIFICATION_FAILED = 'verification_failed';
		const VALIDATION_CHECKED  = 'validationChecked';

		/** Constructor */
		public function __construct() {
			$plugin_type   = $this->plugin_type_to_class[ MOFLR_LICENSE_TYPE ];
			$this->gateway = $plugin_type::instance();

			add_filter( 'mofr_phone_dropdown_selector', array( $this, 'getPhoneNumberSelector' ), 1, 1 );
			add_action( 'wp_enqueue_scripts', array( $this, 'mo_registration_plugin_frontend_scripts' ), 1 );
		}

		/**
		 * This function is called to append certain javascripts
		 * to the frontend. Mostly used for the appending a country
		 * code dropdown to the phone number field.
		 */
		public function mo_registration_plugin_frontend_scripts() {

			wp_register_script( 'firebase', MOFLR_URL . 'includes/js/mofrcommon.min.js', array( 'jquery' ), MOFLR_VERSION, true );
			wp_localize_script(
				'firebase',
				'firebaseAjax',
				array(
					'ajaxurl'                    => admin_url( 'admin-ajax.php' ),
					'firebase_apiKey'            => get_mofr_option( 'gateway_apiKey' ),
					'firebase_authDomain'        => get_mofr_option( 'gateway_authdomain' ),
					'firebase_databaseURL'       => get_mofr_option( 'gateway_databaseurl' ),
					'firebase_projectId'         => get_mofr_option( 'gateway_projectid' ),
					'firebase_storageBucket'     => get_mofr_option( 'gateway_storagebucket' ),
					'firebase_messagingSenderId' => get_mofr_option( 'gateway_messagingsenderid' ),
					'firebase_appId'             => get_mofr_option( 'gateway_appid' ),
				)
			);

			wp_enqueue_script( 'firebase' );
			wp_enqueue_script( 'firebase-app', MOFLR_URL . 'library/firebase/app.js', array( 'jquery' ), MOFLR_VERSION, true );
			wp_enqueue_script( 'firebase-auth', MOFLR_URL . 'library/firebase/auth.js', array( 'jquery' ), MOFLR_VERSION, true );

			wp_enqueue_style( 'mofr_form_main_css', MOFLR_FORM_CSS, array(), MOFLR_VERSION );

		}

		/**
		 * Check the POST output buffer and return the value if a value exists
		 * otherwise return a null or '0'
		 * <br/>Appends {@code mo_firebase_} to the key.
		 *
		 * @param string $param - the key to check the post buffer for.
		 * @param string $prefix - prefix to the key if any.
		 * @return bool|string|array
		 */
		public function sanitize_form_post( $param, $prefix = null ) {
			$param = ( null === $prefix ? 'mo_firebase_' : '' ) . $param;
			return MoUtility::sanitize_check( $param, $_POST );// phpcs:ignore WordPress.Security.NonceVerification.Missing
		}


		/**
		 * This function is called from every form handler class to start the OTP
		 * Verification process. Keeps certain variables in session and start the
		 * OTP Verification process. Calls the mo_generate_otp hook to start
		 * the OTP Verification process.
		 *
		 * @param string $phone_number  phone number submitted by the user.
		 * @param bool   $recaptcha_token   Recaptcha Token.
		 */
		public function send_challenge( $phone_number, $recaptcha_token ) {
			$this->gateway->mo_firebase_send_otp( $phone_number, $recaptcha_token );
		}

		/**Will be implemented for future plans
		 * */
		public function get_application_name() {
			return $this->gateway->get_application_name();
		}

		/**
		 * Checks if the request made is a valid ajax request or not.
		 * Only checks the none value for now.
		 */
		protected function validate_ajax_request() {
			if ( ! check_ajax_referer( $this->nonce, $this->nonce_key ) ) {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::show_message( BaseMessages::INVALID_OP ),
						MoConstants::ERROR
					)
				);
				exit;
			}
		}

	}
}
