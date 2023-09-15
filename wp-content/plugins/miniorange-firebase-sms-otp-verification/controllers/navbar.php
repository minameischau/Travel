<?php
/**
 * Controller For Navbar.
 *
 * @package miniorange-firebase-sms-otp-verification/controllers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use MoOTP\Helper\MoConstants;
use MoOTP\Helper\MoMessages;
use MoOTP\Objects\Tabs;
use MoOTP\Helper\MoUtility;

$server_uri  = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) : null;
$request_uri = remove_query_arg( array( 'addon', 'form', 'subpage' ), $server_uri );
$profile_url = add_query_arg( array( 'page' => $tab_details->tab_details[ Tabs::ACCOUNT ]->menu_slug ), $request_uri );
$active_tab  = isset( $_GET['page'] ) ? sanitize_text_field( esc_url_raw( wp_unslash( $_GET['page'] ) ) ) : null; // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.NonceVerification.Recommended -- Reading GET parameter from the URL for checking the tab name, doesn't require nonce verification.

require MOFLR_DIR . 'views/navbar.php';
