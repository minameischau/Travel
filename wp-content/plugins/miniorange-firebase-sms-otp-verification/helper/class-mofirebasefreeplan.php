<?php
/**Load adminstrator changes for Firebase free paln
 *
 * @package miniorange-firebase-sms-otp-verification/helper
 */

namespace MoOTP\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use MoOTP\Helper\MoPHPSessions;
use MoOTP\Traits\Instance;

/**
 * Firebase free plan
 */
if ( ! class_exists( 'MoFirebaseFreePlan' ) ) {
	/**
	 * MoFirebaseFreePlan class
	 */
	final class MoFirebaseFreePlan {

		use Instance;
		/**Global variable
		 *
		 * @var string application_name used in API calls */
		protected $application_name = 'wp_otp_verification';
		/**Constructor
		 **/
		private function __construct() {

		}
		/**
		 * This function returns if the user is valid.
		 */
		public function check_user_validity() {
			$mofr_firebase_auth_key = get_mofr_option( 'mofr_firebase_auth_key' );
			if ( get_mofr_option( 'mofr_firebase_auth_key' ) <= 1 ) {
				update_mofr_option( 'mofr_firebase_auth_key', 'expired' );
				wp_send_json( MoUtility::create_json( 'You have exhausted free transcations limit for your account. Please contact otpsupport@xecurify.com', 'error' ) );
				return false;
			} else {
				update_mofr_option( 'mofr_firebase_auth_key', $mofr_firebase_auth_key - 1 );
				return true;
			}
		}
		/** MoInternal Function
		 *
		 * @return bool
		 */
		public function mclv() {
			return true;
		}
		/**
		 * Returns the application Name for the gateway
		 *
		 * @return string
		 */
		public function get_application_name() {
			return $this->application_name;
		}



	}
}
