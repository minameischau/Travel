<?php
/**
 * Load admin view for navbar.
 *
 * @package minorange-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
echo '
	<div id="mofr-plugin-container" class="mofr-plugin-container pb-mofr-14">';

if ( ! esc_attr( $registered ) ) {
	echo '<div  class="mofr-alert mofr-error" role="alert">
				<h6 class="mofr-otp-h6"><a href=' . esc_url( $profile_url ) . ' style="color:blue">Register or Login with miniOrange</a> 
												to enable OTP Verification</h6>
			</div>';
} elseif ( ! esc_attr( $activated ) ) {
	echo '<div class="mofr-alert mofr-success">
				<h6 class="mofr-otp-h6"><a href=' . esc_url( $profile_url ) . '>Complete plugin activation process</a> 
												to enable OTP Verification</h6>
			</div>';
}

echo '   <div id="mofr-plugin-wrapper" class="mofr-plugin-wrapper">   
			   
			<div class="mofr-sidenav">';
foreach ( $tab_details->tab_details as $mofr_tabs ) {
	if ( $mofr_tabs->show_in_nav ) {
		echo '
			<a class="mofr-sidenav-item
				' . ( esc_attr( $active_tab ) === esc_attr( $mofr_tabs->menu_slug ) ? ' active' : '' ) . '"
				href="' . esc_url( $mofr_tabs->url ) . '"
				id="' . esc_attr( $mofr_tabs->id ) . '">
				<img src="' . esc_url( $mofr_tabs->tab_icon ) . '"/>
				<p>' . esc_attr( $mofr_tabs->tab_name ) . '</p>
			</a>
		';
	}
}

			echo '
				<a class="mofr-sidenav-item" target="_blank"
				href="https://plugins.miniorange.com/how-to-configure-firebase-gateway-for-otp-verification"
				id="">
				<img src="' . esc_url( MOFLR_GUIDE_LOGO ) . '"/>
				<p>Setup Guide</p>
				</a>
				<a class="mofr-sidenav-item" target="_blank"
				href="https://dev-miniorange-firebase.pantheonsite.io/my-account/"
				id="">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" >
					<g id="a5d3a6a2">
						<path id="8b7c5dea" d="M3 3L10.07 19.97L12.58 12.58L19.97 10.07L3 3Z" stroke="#4B515E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
						<path id="181e1d5a" d="M13 13L19 19" stroke="#4B515E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
					</g>
				</svg>
				<p>Live Demo</p>
				</a>
			</div>
			
			<div class="mofr-tab-content">';
