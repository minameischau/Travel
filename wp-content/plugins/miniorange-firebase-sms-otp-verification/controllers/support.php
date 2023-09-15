<?php
/**
 * Loads support form view.
 *
 * @package miniorange-firebase-sms-otp-verification
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use MoOTP\Helper\MoConstants;

$mofr_current_user = wp_get_current_user();
$email             = get_mofr_option( 'admin_email' ); // registrationandplans.
$phone             = get_mofr_option( 'admin_phone' ); // registrationandplans.
$phone             = $phone ? $phone : ''; // registrationandplans.
$support           = MoConstants::FEEDBACK_EMAIL;

require MOFLR_DIR . 'views/support.php';
