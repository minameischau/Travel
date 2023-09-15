<?php
/**
 * Controller for settings
 *
 * @package miniorange-firebase-sms-otp-verification/controller
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use MoOTP\Helper\MoConstants;
use MoOTP\Helper\MoUtility;
use MoOTP\Objects\PluginPageDetails;
use MoOTP\Objects\Tabs;

$mo_firebase_login_form_enable     = get_mofr_option( 'login_form_enable' ) ? 'checked' : '';
$mo_firebase_registration_form_css = get_mofr_option( 'login_form_css' );
$mo_firebase_loginredirect_pageid  = MoUtility::is_blank( get_mofr_option( 'login_form_redirecturl' ) ) ? '' : get_mofr_option( 'login_form_redirecturl' );
$mo_firebase_dropdown_form_enable  = get_mofr_option( 'mo_firebase_dropdown_form_enable' ) ? 'checked' : '';


require MOFLR_DIR . 'views/settings.php';
