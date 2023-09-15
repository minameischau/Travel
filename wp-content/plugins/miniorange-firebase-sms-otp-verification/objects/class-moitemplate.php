<?php
/**Load Interface MoITemplate
 *
 * @package miniorange-firebase-sms-otp-verification/objects
 */

namespace MoOTP\Objects;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

interface MoITemplate {

	/**MoInternal Function
	 *
	 * @return mixed
	 */
	public static function instance();

}
