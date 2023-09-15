<?php
/**
 * Loads view for accounts tab.
 *
 * @package miniorange-firebase-sms-otp-verification/controller/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MoOTP\Handler\MoRegistrationHandler;
use MoOTP\Helper\MoConstants;
use MoOTP\Helper\MoUtility;

$url = MoConstants::HOSTNAME . '/moas/login?redirectUrl=' . MoConstants::HOSTNAME . '/moas/viewlicensekeys';

$handler = MoRegistrationHandler::instance();
$nonce   = $handler->get_nonce_value();

if ( get_mofr_option( 'registration_status' ) === 'MO_OTP_DELIVERED_SUCCESS'
		|| get_mofr_option( 'registration_status' ) === 'MO_OTP_VALIDATION_FAILURE'
		|| get_mofr_option( 'registration_status' ) === 'MO_OTP_DELIVERED_FAILURE' ) {
	$admin_phone = get_mofr_option( 'admin_phone' ) ? get_mofr_option( 'admin_phone' ) : '';
	include MOFLR_DIR . 'views/account/mofrverify.php';
} elseif ( get_mofr_option( 'verify_customer' ) ) {
	$admin_email = get_mofr_option( 'admin_email' ) ? get_mofr_option( 'admin_email' ) : '';
	include MOFLR_DIR . 'views/account/mofrlogin.php';
} elseif ( ! MoUtility::micr() ) {
	$mofr_current_user = wp_get_current_user();
	$admin_phone       = get_mofr_option( 'admin_phone' ) ? get_mofr_option( 'admin_phone' ) : '';
	delete_site_option( 'password_mismatch' );
	update_mofr_option( 'new_registration', 'true' );
	include MOFLR_DIR . 'views/account/mofrregister.php';
} elseif ( MoUtility::micr() && ! MoUtility::mclv() ) {
	include MOFLR_DIR . 'views/account/mofrverify-lk.php';
} else {
	$admin_email = get_mofr_option( 'admin_email' ) ? get_mofr_option( 'admin_email' ) : '';
	$customer_id = get_mofr_option( 'admin_customer_key' );
	$api_key     = get_mofr_option( 'admin_api_key' );
	$token       = get_mofr_option( 'customer_token' );
	$vl          = MoUtility::mclv() && ! MoUtility::is_mg();
	include MOFLR_DIR . 'views/account/mofrprofile.php';
}
