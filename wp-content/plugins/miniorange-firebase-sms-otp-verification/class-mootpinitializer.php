<?php
/**Load Main File MoOTPInitializer
 *
 * @package miniorange-otp-verification
 */

namespace MoOTP;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use MoOTP\Traits\Instance;
use MoOTP\Helper\MenuItems;
use MoOTP\Handler\MofrOTPActionHandlerHandler;
use MoOTP\Handler\LoginRegistrationForm;
use MoOTP\Handler\MoRegistrationHandler;
use MoOTP\Helper\MoDisplayMessages;
use MoOTP\Helper\MoMessages;
use MoOTP\Helper\CountryList;
use MoOTP\Helper\MoUtility;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoOTPInitializer' ) ) {
	/**
	 * Final class that runs base functionalities of the plugin.
	 * It initializes some of the common helper and handler for the plugin
	 * classes.
	 */
	final class MoOTPInitializer {


		use Instance;
		/** Constructor */
		private function __construct() {
			$this->initialize_values();
			$this->initialize_hooks();
			$this->initialize_helpers();
			$this->initialize_handlers();

		}
		/**
		 * Initialize all the main hooks needed for the plugin
		 */
		private function initialize_hooks() {
			add_action( 'plugins_loaded', array( $this, 'mofr_otp_load_textdomain' ) );
			add_action( 'admin_menu', array( $this, 'miniorange_customer_validation_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'mo_registration_plugin_settings_style' ), 1, 0 );
			add_action( 'admin_enqueue_scripts', array( $this, 'mo_registration_plugin_settings_script' ) );
			add_action( 'mo_registration_show_message', array( $this, 'mo_show_otp_message' ), 1, 2 );
			add_action( 'admin_footer', array( $this, 'mofr_feedback_request' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'mo_registration_plugin_frontend_scripts' ), 99 );
			add_action( 'login_enqueue_scripts', array( $this, 'mo_registration_plugin_frontend_scripts' ), 99 );

		}

		/**
		 * Function hooks into the admin_footer hook to append the feedback form in the
		 * footer section of the page.
		 */
		public function mofr_feedback_request() {
			include MOFLR_DIR . 'controllers/mofrfeedback.php';
		}

		/**
		 * Initialize all the values
		 */
		private function initialize_values() {
			if ( ! get_mofr_option( 'mofr_firebase_auth_key' ) && ( get_mofr_option( 'mofr_firebase_auth_key' ) !== 'expired' ) ) {
					update_mofr_option( 'mofr_firebase_auth_key', 10 );
			}
		}

		/**
		 * Initialize all the Template Handlers
		 */
		private function initialize_handlers() {
			MofrOTPActionHandlerHandler::instance();
			LoginRegistrationForm::instance();
			MoRegistrationHandler::instance();

		}

		/**
		 * Initialize all the helper classes
		 */
		private function initialize_helpers() {
			MoMessages::instance();
		}
		/**
		 * This function hooks into the admin_menu WordPress hook to generate
		 * WordPress menu items. You define all the options and links you want
		 * to show to the admin in the WordPress sidebar.
		 */
		public function miniorange_customer_validation_menu() {
			MenuItems::instance();
		}

		/**
		 * Function tells where to look for translations.
		 * <b>PLEASE NOTE:</b> Dont be clever and try to replace the Text domain 'miniorange-otp-verification'
		 * with a constant value. Its kept as string for a reason. Its so that other automated
		 * tools can read it and use it for automatic translation.
		 */
		public function mofr_otp_load_textdomain() {
			load_plugin_textdomain( 'miniorange-firebase-otp', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
			do_action( 'mofr_firebase_otp_add_on_lang_files' );
		}

		/**
		 * This function is called to append our CSS file
		 * in the backend and frontend. Uses the admin_enqueue_scripts
		 * and enqueue_scripts WordPress hook.
		 */
		public function mo_registration_plugin_settings_style() {
			wp_enqueue_style( 'mofr_customer_validation_admin_settings_style', MOFLR_CSS_URL, array(), MOFLR_VERSION );
			wp_enqueue_style( 'mofr_customer_validation_inttelinput_style', MOFLR_INTTELINPUT_CSS, array(), MOFLR_VERSION );
			wp_enqueue_style( 'mofr_customer_validation_firebase_boot_style', MOFLR_BOOT_CSS, array(), MOFLR_VERSION );
			wp_enqueue_style( 'mofr_main_css', MOFLR_MAIN_CSS, array(), MOFLR_VERSION );
		}

		/**
		 * This function is called to append our CSS file
		 * in the backend and frontend. Uses the admin_enqueue_scripts
		 * and enqueue_scripts WordPress hook.
		 */
		public function mo_registration_plugin_settings_script() {
			$country_val = array();
			wp_enqueue_script( 'mofr_customer_validation_admin_settings_script', MOFLR_JS_URL, array( 'jquery' ), MOFLR_VERSION, false );
		}

		/**
		 * This function is called to append certain javascripts
		 * to the frontend. Mostly used for the appending a country
		 * code dropdown to the phone number field.
		 */
		public function mo_registration_plugin_frontend_scripts() {
			$country_val = array();
			if ( ! get_mofr_option( 'mo_firebase_dropdown_form_enable' ) ) {
				return;
			}
			$selector = apply_filters( 'mofr_phone_dropdown_selector', array() );
			if ( MoUtility::is_blank( $selector ) ) {
				return;
			}
			$selector       = array_unique( $selector );
			$countriesavail = CountryList::get_country_code_list();
			$countriesavail = apply_filters( 'selected_countries', $countriesavail );
			foreach ( $countriesavail as $key => $value ) {
				array_push( $country_val, $value );
			}
			$default_country = CountryList::get_default_country_iso_code();
			$get_ip_country  = apply_filters( 'mofr_get_default_country', $default_country );
			wp_register_script( 'mofr_customer_validation_inttelinput_script', MOFLR_INTTELINPUT_JS, array( 'jquery' ), MOFLR_VERSION, false );
			wp_localize_script(
				'mofr_customer_validation_inttelinput_script',
				'moselecteddropdown',
				array(
					'selecteddropdown' => $country_val,

				)
			);
			wp_enqueue_script( 'mofr_customer_validation_inttelinput_script' );

			wp_enqueue_style( 'mofr_customer_validation_inttelinput_style', MOFLR_INTTELINPUT_CSS, array(), MOFLR_VERSION, false );
			wp_register_script( 'mofr_customer_validation_dropdown_script', MOFLR_DROPDOWN_JS, array( 'jquery' ), MOFLR_VERSION, true );
			wp_localize_script(
				'mofr_customer_validation_dropdown_script',
				'modropdownvars',
				array(
					'selector'       => wp_json_encode( $selector ),
					'defaultCountry' => $get_ip_country,
					'onlyCountries'  => CountryList::get_only_country_list(),
				)
			);
			wp_enqueue_script( 'mofr_customer_validation_dropdown_script' );
		}
		/**
		 * This function runs when mo_registration_show_message hook
		 * is initiated. The hook runs to show a plugin generated
		 * message to the user in the admin dashboard.
		 *
		 * @param string $content refers to the message content.
		 * @param string $type refers to the type of message.
		 */
		public function mo_show_otp_message( $content, $type ) {
			new MoDisplayMessages( $content, $type );
		}

		/**
		 * The main callback function for each of the menu links. This function
		 * is called when user visits any one of the menu URLs.
		 */
		public function mo_customer_validation_options() {
			include MOFLR_DIR . 'controllers/main-controller.php';
		}

	}
}
