<?php
/**
 * Load admin view for login and registration form settings.
 *
 * @package miniorange-firebase-sms-otp-verification/controller/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use MoOTP\Helper\MoConstants;
use MoOTP\Helper\MoUtility;
use MoOTP\Objects\PluginPageDetails;
use MoOTP\Objects\Tabs;

$mo_create_new_page                 = admin_url() . 'post-new.php?post_type=page';
$mo_firebase_loginreg_form_css_file = wp_remote_get( MOFLR_URL . 'includes/css/mofr_loginreg_form.min.css' );
if ( is_wp_error( $mo_firebase_loginreg_form_css_file ) ) {
	$mo_firebase_loginreg_form_css_file = '';
} else {
	$mo_firebase_loginreg_form_css_file = wp_remote_retrieve_body( $mo_firebase_loginreg_form_css_file );
}
$mo_firebase_loginreg_form_css = get_mofr_option( 'loginreg_form_css' ) ? get_mofr_option( 'loginreg_form_css' ) : $mo_firebase_loginreg_form_css_file;

$mo_firebase_login_form_enable        = get_mofr_option( 'login_form_enable' ) ? 'checked' : '';
$log_redirect_page                    = get_mofr_option( 'login_form_redirecturl' );
$mo_firebase_loginredirect_pageid     = MoUtility::is_blank( $log_redirect_page ) ? '' : get_posts(
	array(
		'title'     => $log_redirect_page,
		'post_type' => 'page',
	)
)[0]->ID;
$reg_redirect_page                    = get_mofr_option( 'reg_form_redirecturl' );
$mo_firebase_regredirect_pageid       = MoUtility::is_blank( $reg_redirect_page ) ? '' : get_posts(
	array(
		'title'     => $reg_redirect_page,
		'post_type' => 'page',
	)
)[0]->ID;
$mo_firebase_dropdown_form_enable     = get_mofr_option( 'mo_firebase_dropdown_form_enable' ) ? 'checked' : '';
$mo_firebase_loginredirect_pageurl    = site_url();
$mo_firebase_wc_form_enable           = get_mofr_option( 'wc_form_enable' ) ? 'checked' : '';
$mo_firebase_wc_form_reg_enable       = get_mofr_option( 'wc_form_reg_enable' ) ? 'checked' : '';
$mo_firebase_wc_form_checkout_enable  = get_mofr_option( 'wc_form_checkout_enable' ) ? 'checked' : '';
$mo_firebase_wc_form_log_enable       = get_mofr_option( 'wc_form_log_enable' ) ? 'checked' : '';
$mo_firebase_um_reg_form_enable       = get_mofr_option( 'um_reg_form_enable' ) ? 'checked' : '';
$um_forms                             = admin_url() . 'edit.php?post_type=um_form';
$um_otp_meta_key                      = get_mofr_option( 'um_otp_field_meta_key' );
$mo_firebase_gravity_form_enable      = get_mofr_option( 'gf_contact_enable' ) ? 'checked' : '';
$gravity_forms                        = admin_url() . '?page=gf_edit_forms';
$gravity_otp_button_text              = get_mofr_option( 'gf_button_text' );
$gf_otp_enabled                       = get_mofr_option( 'gf_otp_enabled' );
$mo_firebase_registration_form_enable = get_mofr_option( 'registration_form_enable' ) ? 'checked' : '';
$mo_firebase_regredirect_pageurl      = site_url();
$mo_firebase_default_user_role        = get_mofr_option( 'default_user_role' ) ? get_mofr_option( 'default_user_role' ) : 'administrator';

$mo_nonce_mo_firebase_form_save_option = wp_create_nonce( 'mo_nonce_mo_firebase_form_save_option' );

require MOFLR_DIR . 'views/loginregistrationform.php';
