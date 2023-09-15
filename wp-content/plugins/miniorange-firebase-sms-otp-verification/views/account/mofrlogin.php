<?php
/**
 * Load admin view for miniorange Login Form.
 *
 * @package minorange-firebase-sms-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
echo '	<form name="f" method="post" action="" class="mofr-content-wrapper justify-center items-center">';
		wp_nonce_field( 'mofr_firebase_actions' );
echo '		<input type="hidden" name="option" value="mofr_registration_connect_verify_customer" />
			<div class="bg-white rounded-xl w-[368px] flex flex-col gap-mofr-4">
				<p class="mofr-heading mb-mofr-6">Login in using<br>your miniorange account</p>
				<div class="w-full mofr-input-wrapper group group">
                    <label for="mo_firebase_gateway_databaseurl" class="mofr-input-label">Email</label>
                    <input class="w-full mofr-input" type="email" name="email"
								required placeholder=""/>
                </div>

				<div class="w-full mofr-input-wrapper group group">
                    <label for="mo_firebase_gateway_databaseurl" class="mofr-input-label">Password</label>
                    <input class="w-full mofr-input" required type="password"
								name="password" placeholder="" />
                </div>			

				<a href="https://login.xecurify.com/moas/idp/resetpassword" target="_blank" class="text-right font-bold hover:underline">Forgot Password</a>
				<input type="submit" class="mofr-button primary" value="Login"/>
				<a href="#goBackButton" class="mofr-button secondary">Register</a>

			</div>
		</form>
		<form id="forgotpasswordform" method="post" action="">';
			wp_nonce_field( 'mofr_firebase_actions' );
echo '		<input type="hidden" name="option" value="mo_registration_mofr_forgot_password" />
		</form>
		<form id="goBacktoRegistrationPage" method="post" action="">';
			wp_nonce_field( 'mofr_firebase_actions' );
echo '		<input type="hidden" name="option" value="mofr_registration_go_back" />
		</form>
		<script>
			jQuery(document).ready(function(){
				$mo(\'a[href="#mofr_forgot_password"]\').click(function(){
					$mo("#forgotpasswordform").submit();
				});

				$mo(\'a[href="#goBackButton"]\').click(function(){
					$mo("#goBacktoRegistrationPage").submit();
				});
			});
		</script>';
