<?php
/**Load Interface IFormHandler
 *
 * @package miniorange-firebase-sms-otp-verification/objects
 */

namespace MoOTP\Objects;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface IFormHandler {
	/**
	 * Function checks if form has been enabled by the admin and initializes
	 * all the class variables. This function also defines all the hooks to
	 * hook into to make OTP Verification possible.
	 *
	 * @throws ReflectionException .
	 */
	public function handle_mofirebase_form();
	/**
	 * Handles saving all the Caldera Form related options by the admin.
	 */
	public function handle_mofirebase_form_options();


}
