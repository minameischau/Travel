<?php
/**Load adminstrator changes for MenuItems
 *
 * @package miniorange-firebase-sms-otp-verification/helper
 */

namespace MoOTP\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use MoOTP\MoOTPInitializer;
use MoOTP\Objects\PluginPageDetails;
use MoOTP\Objects\TabDetails;
use MoOTP\Traits\Instance;

/**
 * This class simply adds menu items for the plugin
 * in the WordPress dashboard.
 */
if ( ! class_exists( 'MenuItems' ) ) {
	/**
	 * MenuItems class
	 */
	final class MenuItems {
		use Instance;
		/**
		 * The URL for the plugin icon to be shown in the dashboard
		 *
		 * @var string
		 */
		private $call_back;
		/**
		 * The call back function for the menu items
		 *
		 * @var string
		 */
		private $menu_slug;

		/**
		 * The slug for the main menu
		 *
		 * @var string
		 */
		private $menu_logo;

		/**
		 * Array of PluginPageDetails Object detailing
		 * all the page menu options.
		 *
		 * @var array $tab_details
		 */
		private $tab_details;

		/**
		 * MenuItems constructor.
		 */
		private function __construct() {
			$this->call_back = array( MoOTPInitializer::instance(), 'mo_customer_validation_options' );
			$this->menu_logo = MOFLR_ICON;

			$tab_details       = TabDetails::instance();
			$this->tab_details = $tab_details->tab_details;
			$this->menu_slug   = $tab_details->parent_slug;
			$this->add_main_menu();
			$this->add_sub_menus();
		}

		/**
		 * Adding MainMenu.
		 */
		private function add_main_menu() {
			add_menu_page(
				'Firebase Login/Registation',
				'Firebase Login/Registation',
				'manage_options',
				$this->menu_slug,
				$this->call_back,
				$this->menu_logo
			);
		}
		/**
		 * Adding Sub Menu.
		 */
		private function add_sub_menus() {
			foreach ( $this->tab_details as $tab_details ) {
				add_submenu_page(
					$this->menu_slug,
					$tab_details->page_title,
					$tab_details->menu_title,
					'manage_options',
					$tab_details->menu_slug,
					$this->call_back
				);
			}
		}
	}
}
