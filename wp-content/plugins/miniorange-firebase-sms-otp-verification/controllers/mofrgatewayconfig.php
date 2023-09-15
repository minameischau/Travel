<?php
/**
 * Load admin view for gateway configurations.
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

$mo_firebase_registration_form_enable = 'checked';
$mo_firebase_registration_form_css    = '#mo_otp{color:red;}';

require MOFLR_DIR . 'views/mofrgatewayconfig.php';
