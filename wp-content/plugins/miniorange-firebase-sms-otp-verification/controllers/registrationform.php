<?php
/**
 * Load admin view for registration form settings.
 *
 * @package miniorange-firebase-sms-otp-verification/controller/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use MoOTP\Helper\MoConstants;
use MoOTP\Helper\MoUtility;
use MoOTP\Objects\PluginPageDetails;
use MoOTP\Objects\Tabs;

$mo_firebase_registration_form_enable = get_mofr_option( 'registration_form_enable' ) ? 'checked' : '';
$mo_firebase_dropdown_form_enable     = get_mofr_option( 'mo_firebase_dropdown_form_enable' ) ? 'checked' : '';
$mo_firebase_registration_form_css    = get_mofr_option( 'registration_form_css' );
$mo_firebase_regredirect_pageurl      = MoUtility::is_blank( get_mofr_option( 'reg_form_redirecturl' ) ) ? '' : get_mofr_option( 'reg_form_redirecturl' );
$mo_firebase__default_user_role       = get_mofr_option( 'default_user_role' );

require MOFLR_DIR . 'views/registrationform.php';
