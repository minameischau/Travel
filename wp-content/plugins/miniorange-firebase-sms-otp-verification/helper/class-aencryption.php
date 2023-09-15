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
if ( ! class_exists( 'AEncryption' ) ) {
	/**
	 * AEncryption class
	 */
	class AEncryption {
		/**
		 * Encrypt data
		 *
		 * @param string $string string.
		 * @param string $pass pass.
		 */
		public static function encrypt_data( $string, $pass ) {
			$result        = '';
			$string_length = strlen( $string );
			for ( $i = 0; $i < $string_length; $i++ ) {
				$char    = substr( $string, $i, 1 );
				$keychar = substr( $pass, ( $i % strlen( $pass ) ) - 1, 1 );
				$char    = chr( ord( $char ) + ord( $keychar ) );
				$result .= $char;
			}

			return base64_encode( $result );//phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Base64 is needed.
		}

		/**
		 * Decrypt data
		 *
		 * @param string $string string.
		 * @param string $pass pass.
		 */
		public static function decrypt_data( $string, $pass ) {
			$result = '';
			$string = base64_decode( $string );//phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode -- Base64 is needed.

			$string_length = strlen( $string );
			for ( $i = 0; $i < $string_length; $i++ ) {
				$char    = substr( $string, $i, 1 );
				$keychar = substr( $pass, ( $i % strlen( $pass ) ) - 1, 1 );
				$char    = chr( ord( $char ) - ord( $keychar ) );
				$result .= $char;
			}

			return $result;
		}
	}
}
