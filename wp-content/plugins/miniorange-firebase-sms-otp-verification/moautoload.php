<?php
/**
 * Initializes plugin data.
 * Contains defination of common functions.
 *
 * @package miniorange-firebase-sms-otp-verification
 */

use MoOTP\SplClassLoader;
use MoOTP\Helper\MoUtility;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MOFLR_DIR', plugin_dir_path( __FILE__ ) );
define( 'MOFLR_URL', plugin_dir_url( __FILE__ ) );
define( 'MOFLR_TYPE', 'MoFirebaseFreePlan' );
define( 'MOFLR_VERSION', '3.1.0' );
define( 'MOFLR_SSL_VERIFY', false );
define( 'MOFLR_SESSION_TYPE', 'SESSION' );
define( 'MOFLR_FIREBASE_API_HOST', 'https://www.googleapis.com/' );
define( 'MOFLR_HOST', 'https://login.xecurify.com' );
define( 'MOFLR_LICENSE_TYPE', 'MoFirebaseFreePlan' );

define( 'MOFLR_ICON', MOFLR_URL . '/includes/images/miniorange_icon.png' );
define( 'MOFLR_LOADER_URL', MOFLR_URL . 'includes/images/loader.gif' );
define( 'MOFLR_MAIL_LOGO', MOFLR_URL . 'includes/images/mo_support_icon.png' );
define( 'MOFLR_LOGO_URL', MOFLR_URL . 'includes/images/logo.png' );
define( 'MOFLR_FIREBASE_LOGO', MOFLR_URL . 'includes/images/firebase_logo.png' );
define( 'MOFLR_ACCOUNT_LOGO', MOFLR_URL . 'includes/images/account.png' );
define( 'MOFLR_GATEWAY_LOGO', MOFLR_URL . 'includes/images/Gateway.png' );
define( 'MOFLR_GUIDE_LOGO', MOFLR_URL . 'includes/images/Guide.png' );
define( 'MOFLR_FORMS_LOGO', MOFLR_URL . 'includes/images/Forms.png' );
define( 'MOFLR_EYEICON_LOGO', MOFLR_URL . 'includes/images/eyeicon.png' );
define( 'MOFLR_LICENSE_LOGO', MOFLR_URL . 'includes/images/licensing.png' );
define( 'MOFLR_USE_POLYLANG', true );

define( 'MOFLR_CSS_URL', MOFLR_URL . 'includes/css/mofr_customer_validation_style.min.css?version=' . MOFLR_VERSION );
define( 'MOFLR_FORM_CSS', MOFLR_URL . 'includes/css/mo_forms_css.min.css?version=' . MOFLR_VERSION );
define( 'MOFLR_INTTELINPUT_CSS', MOFLR_URL . 'includes/css/intlTelInput.min.css?version=' . MOFLR_VERSION );
define( 'MOFLR_BOOT_CSS', MOFLR_URL . 'includes/css/mo_fr_otp_boot.min.css?version=' . MOFLR_VERSION );
define( 'MOFLR_JS_URL', MOFLR_URL . 'includes/js/settings.min.js?version=' . MOFLR_VERSION );
define( 'MOFLR_INTTELINPUT_JS', MOFLR_URL . 'includes/js/intlTelInput.min.js?version=' . MOFLR_VERSION );
define( 'MOFLR_DROPDOWN_JS', MOFLR_URL . 'includes/js/dropdown.min.js?version=' . MOFLR_VERSION );
define( 'MOFLR_MAIN_CSS', MOFLR_URL . 'includes/css/main.min.css' );

require 'class-splclassloader.php';

$idp_class_loader = new SplClassLoader( 'MoOTP', realpath( __DIR__ . DIRECTORY_SEPARATOR . '..' ) );
$idp_class_loader->register();
require_once 'views/common-elements.php';
mofirebase_initialize_forms();

/**
 * Initializes hanlders of forms.
 */
function mofirebase_initialize_forms() {
	$iterator = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator( MOFLR_DIR . 'handler/forms', RecursiveDirectoryIterator::SKIP_DOTS ),
		RecursiveIteratorIterator::LEAVES_ONLY
	);

	if ( MoUtility::micr() ) {

		foreach ( $iterator as $it ) {
			$filename   = $it->getFilename();
			$filename   = str_replace( 'class-', '', $filename );
			$class_name = 'MoOTP\\Handler\\Forms\\' . str_replace( '.php', '', $filename );

			$form_handler = $class_name::instance();
		}
	}

}

/**
 * Used for transalating the string
 *
 * @param string $string - option name to be deleted.
 */
function mofr_( $string ) {
	$string = preg_replace( '/\s+/S', ' ', $string );
	return is_scalar( $string )
			? ( MoUtility::is_polylang_installed() && MOFLR_USE_POLYLANG ? pll__( $string ) : __( $string, 'miniorange-firebase-otp' ) ) // phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText --common function for string translation.
			: $string;
}

/**
 * Returns wp ajax url.
 */
function wp_ajax_fr_url() {
	return admin_url( 'admin-ajax.php' ); }

/**
 * Retrieved the value of the option in the wp_option table.
 *
 * @param string $string - option name to be deleted.
 * @param string $prefix - prefix of the option.
 */
function get_mofr_option( $string, $prefix = null ) {
	$string = ( null === $prefix ? 'mo_firebase_loginreg_' : $prefix ) . $string;
	return apply_filters( 'get_mofr_option', get_site_option( $string ) );
}

/**
 * Updates the option set in the wp_option table.
 *
 * @param string $string - option name to be deleted.
 * @param string $value - value of the option.
 * @param string $prefix - prefix of the option.
 */
function update_mofr_option( $string, $value, $prefix = null ) {
	$string = ( null === $prefix ? 'mo_firebase_loginreg_' : $prefix ) . $string;
	update_site_option( $string, apply_filters( 'update_mofr_option', $value, $string ) );
}

/**
 * Deletes the option set in the wp_option table.
 *
 * @param string $string - option name to be deleted.
 * @param string $prefix - prefix of the option.
 */
function delete_mofr_option( $string, $prefix = null ) {
	$string = ( null === $prefix ? 'mo_firebase_loginreg_' : $prefix ) . $string;
	delete_site_option( $string );
}
