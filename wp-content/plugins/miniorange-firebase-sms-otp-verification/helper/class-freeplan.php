<?php
/**
 * Free plan.
 *
 * @package miniorange-validaition-settings
 */

namespace MoOTP\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use MoOTP\MoOTPInitializer;
use MoOTP\Objects\PluginPageDetails;
use MoOTP\Objects\TabDetails;
use MoOTP\Traits\Instance;
if ( ! class_exists( 'FreePlan' ) ) {

	/**Free plan */
	final class FreePlan {
		use Instance;
		/**
		 * Undocumented function
		 * Initializes values
		 */
		private function __construct() {}

	}
}
