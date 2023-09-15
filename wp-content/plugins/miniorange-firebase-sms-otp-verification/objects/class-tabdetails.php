<?php
/**Load Interface TabDetails
 *
 * @package miniorange-firebase-sms-otp-verification/objects
 */

namespace MoOTP\Objects;

use MoOTP\Helper\MoUtility;
use MoOTP\Traits\Instance;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'TabDetails' ) ) {
	/**
	 * This class is used to define the Tab details interface functions taht needs to be implementated
	 */
	final class TabDetails {
		use Instance;

		/**
		 * Array of PluginPageDetails Object detailing
		 * all the page menu options.
		 *
		 * @var array[PluginPageDetails] $tab_details
		 */
		public $tab_details;

		/**
		 * The parent menu slug
		 *
		 * @var string $_parentSlug
		 */
		public $parent_slug;
		/** Private constructor to avoid direct object creation */
		private function __construct() {
			$registered        = MoUtility::micr();
			$this->parent_slug = 'registrationform';
			$url               = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			$request_uri       = remove_query_arg( 'addon', $url );

			$this->tab_details = array(
				Tabs::LOGINREGISTRATIONFORMS => new PluginPageDetails(
					'icon_registrationform',
					'OTP Verification - Login/Registration Form',
					'registrationform',
					mofr_( 'Form Settings' ),
					MOFLR_FORMS_LOGO,
					mofr_( 'Form Settings' ),
					$request_uri,
					'loginregistrationform.php',
					'tabID',
					'background:#D8D8D8'
				),
				Tabs::GATEWAY_CONFIG         => new PluginPageDetails(
					'icon_mofrgatewayconfig',
					'OTP Verification - Gateway Config',
					'mofrgatewayconfig',
					mofr_( 'Gateway Settings' ),
					MOFLR_GATEWAY_LOGO,
					mofr_( 'Gateway Settings' ),
					$request_uri,
					'mofrgatewayconfig.php',
					'emailSmsTemplate',
					'background:#D8D8D8'
				),

				Tabs::ACCOUNT                => new PluginPageDetails(
					'icon_mofrotpaccount',
					'OTP Verification - Accounts',
					'mofrotpaccount',
					! $registered ? 'Setup Account' : 'Account Details',
					MOFLR_ACCOUNT_LOGO,
					! $registered ? 'Setup Account' : 'Account Details',
					$request_uri,
					'mofraccount.php',
					'account',
					'',
					'background:#D8D8D8'
				),

				Tabs::LICENSE_PLAN           => new PluginPageDetails(
					'icon_mofrlincense',
					'OTP Verification - Licensing Plans',
					'mofrotplicense',
					mofr_( 'Licensing Plans' ),
					MOFLR_LICENSE_LOGO,
					mofr_( 'Licensing Plans' ),
					$request_uri,
					'mofrlicense.php',
					'license',
					'',
					'background:#D8D8D8'
				),
			);
		}
	}
}
