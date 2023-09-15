<?php
/**
 * This class loads all the classes.
 *
 * @package miniorange-firebase-sms-otp-verification
 */

namespace MoOTP;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'SplClassLoader' ) ) {
	/**
	 * This class loads all the classes.
	 */
	final class SplClassLoader {

		/**
		 * File extention.
		 *
		 * @var string
		 */
		private $file_extension = '.php';

		/**
		 * Namespace value for the plugin.
		 *
		 * @var string
		 */
		private $name_space;

		/**
		 * Include path.
		 *
		 * @var string
		 */
		private $include_path;

		/**
		 * Namespace separator.
		 *
		 * @var string
		 */
		private $name_space_seperator = '\\';

		/**
		 * Initilaizes values.
		 *
		 * @param string $ns namespace value.
		 * @param string $include_path directory path.
		 */
		public function __construct( $ns = null, $include_path = null ) {
			$this->name_space   = $ns;
			$this->include_path = $include_path;
		}

		/**
		 * Includes all the class.
		 */
		public function register() {
			spl_autoload_register( array( $this, 'load_class' ) );
		}

		/**
		 * Unregisters all the class.
		 */
		public function unregister() {
			spl_autoload_unregister( array( $this, 'load_class' ) );
		}

		/**
		 * Loads all the class.
		 *
		 * @param string $class_name name of the class to include.
		 */
		public function load_class( $class_name ) {
			if ( null === $this->name_space || $this->is_same_name_space( $class_name ) ) {
				$file_name   = '';
				$namespace   = '';
				$last_ns_pos = strripos( $class_name, $this->name_space_seperator );

				if ( false !== ( $last_ns_pos ) ) {
					$namespace  = strtolower( substr( $class_name, 0, $last_ns_pos ) );
					$class_name = substr( $class_name, $last_ns_pos + 1 );
					$file_name  = str_replace( $this->name_space_seperator, DIRECTORY_SEPARATOR, $namespace ) . DIRECTORY_SEPARATOR;
				}
				$class_file_name = strtolower( $class_name );
				$file_name      .= str_replace( '_', DIRECTORY_SEPARATOR, 'class-' . $class_file_name ) . $this->file_extension;
				$file_name       = str_replace( 'mootp', MOFLR_NAME, $file_name );
				if ( null !== $this->include_path ) {
					require $this->include_path . DIRECTORY_SEPARATOR . $file_name;
				} else {
					require $file_name;
				}
			}
		}

		/**
		 * Checks if a class name is a namspace.
		 *
		 * @param string $class_name name of the class.
		 */
		private function is_same_name_space( $class_name ) {
			return substr( $class_name, 0, strlen( $this->name_space . $this->name_space_seperator ) ) === $this->name_space . $this->name_space_seperator;
		}
	}
}
