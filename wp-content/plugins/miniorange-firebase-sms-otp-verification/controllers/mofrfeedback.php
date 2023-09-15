<?php
/**
 * Loads deactivation feedback form.
 *
 * @package miniorange-firebase-sms-otp-verification
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use MoOTP\Handler\MofrOTPActionHandlerHandler;
use MoOTP\Helper\MoConstants;

$message = mofr_( 'We are sad to see you go :( Have you found a bug? Did you feel something was missing? Whatever it is, we\'d love to hear from you and get better.' );

$submit_message  = mofr_( 'Submit & Deactivate' );
$submit_message2 = mofr_( 'Submit' );

$admin_handler       = MofrOTPActionHandlerHandler::instance();
$deactivationreasons = $admin_handler->mo_feedback_reasons();

require MOFLR_DIR . 'views/mofrfeedback.php';



