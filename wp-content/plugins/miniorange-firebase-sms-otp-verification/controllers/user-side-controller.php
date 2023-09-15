<?php
/**
 * Loads contact us form on frontend view.
 *
 * @package miniorange-firebase-sms-otp-verification
 */

use MoOTP\Handler\MofrOTPActionHandlerHandler;
use MoOTP\Helper\MoUtility;
use MoOTP\Objects\PluginPageDetails;
use MoOTP\Objects\TabDetails;
use MoOTP\Helper\MoConstants;


$plan          = MoUtility::micv();
$email         = get_mofr_option( 'admin_email' );
$phone         = get_mofr_option( 'admin_phone' );
$controller    = MOFLR_DIR . 'controllers/';
$admin_handler = MofrOTPActionHandlerHandler::instance();
$support       = MoConstants::FEEDBACK_EMAIL;

require MOFLR_DIR . 'views/user-side-controller.php';
