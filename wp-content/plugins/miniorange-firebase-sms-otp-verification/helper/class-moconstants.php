<?php
/**Load administrator changes for MoConstants
 *
 * @package miniorange-firebase-sms-otp-verification/helper
 */

namespace MoOTP\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class lists down all the OTP Constant variables.
 */
if ( ! class_exists( 'MoConstants' ) ) {
	/**
	 * MoConstants class
	 */
	class MoConstants {
		const HOSTNAME             = MOFLR_HOST;
		const PLUGIN_TYPE          = MOFLR_LICENSE_TYPE;
		const FROM_EMAIL           = 'no-reply@xecurify.com';
		const SUPPORT_EMAIL        = 'info@xecurify.com';
		const FEEDBACK_EMAIL       = 'otpsupport@xecurify.com';
		const AREA_OF_INTEREST     = 'WP OTP Firebase Plugin';
		const PLUGIN_NAME          = 'Firebase Plugin';
		const FAILURE              = 'FAILURE';
		const SUCCESS              = 'SUCCESS';
		const ERROR                = 'error';
		const PATTERN_PHONE        = '/^[\+]\d{1,4}\d{7,12}$|^[\+]\d{1,4}[\s]\d{7,12}$/';
		const PATTERN_COUNTRY_CODE = '/^[\+]\d{1,4}.*/';
		const PATTERN_SPACES_HYPEN = '/([\(\) \-]+)/';
		const MOFLRFREE_PLUGIN     = MOFLR_LICENSE_TYPE;
	}
}
