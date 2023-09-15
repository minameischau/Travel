<?php
/**Load Tabs
 *
 * @package miniorange-firebase-sms-otp-verification/objects
 */

namespace MoOTP\Objects;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Tabs' ) ) {
	/**
	 * This class is used to define the base url of tabs of plugin
	 */
	final class Tabs {

		const LOGINFORMS             = 'loginforms';
		const REGISTRATIONFORMS      = 'registrationforms';
		const LOGINREGISTRATIONFORMS = 'loginregistrationforms';
		const OTP_SETTINGS           = 'otp_settings';
		const ACCOUNT                = 'account';
		const GATEWAY_CONFIG         = 'gateway_config';
		const LICENSE_PLAN           = 'license_plan';
		const MESSAGES               = 'messages';
		const DESIGN                 = 'design';
		const CONTACT_US             = 'contact_us';
		const PRICING                = 'pricing';
		const ADD_ONS                = 'addons';
		const CUSTOM_FORM            = 'customization';
		const WHATSAPP               = 'whatsapp';

	}
}
