<?php
/**
 * Load admin view for miniorange Registration details.
 *
 * @package minorange-firebase-smsotp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
echo '	<form name="f" method="post" action="" id="register-form" class="mofr-content-wrapper justify-center items-center">';
			wp_nonce_field( 'mofr_firebase_actions' );
echo '		<input type="hidden" name="option" value="mofr_registration_register_customer" />
			<div class="bg-white rounded-xl w-[428px] flex flex-col gap-mofr-4">
				<p class="mofr-heading mb-mofr-6">Create new account</p>
				<div class="w-full mofr-input-wrapper group group">
					<label  class="mofr-input-label">Email</label>
					<input class="w-full mofr-input" type="email" name="email"
							required placeholder=""
							value="' . esc_attr( $mofr_current_user->user_email ) . '" />
				</div>

				<div class="w-full mofr-input-wrapper group group">
					<label  class="mofr-input-label">Website or Company Name</label>
					<input class="w-full mofr-input" type="text" name="company"
							required placeholder=""
							value="' . esc_attr( sanitize_text_field( isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '' ) ) . '" />
				</div>
				
				<div class="flex items-center gap-mofr-4">

					<div class="w-full mofr-input-wrapper group group">
						<label  class="mofr-input-label">First Name</label>
						<input class="w-full mofr-input" type="text" name="fname"
							placeholder=""
							value="' . esc_attr( $mofr_current_user->user_firstname ) . '" />
					</div>
				
					<div class="w-full mofr-input-wrapper group group">
						<label  class="mofr-input-label">Last Name</label>
						<input class="w-full mofr-input" type="text" name="lname"
							placeholder=""
							value="' . esc_attr( $mofr_current_user->user_lastname ) . '" />
					</div>

				</div>

				<div class="flex items-center gap-mofr-4">

					<div class="w-full mofr-input-wrapper group group">
						<label class="mofr-input-label">Password Min. Length 6</label>
						<input class="w-full mofr-input" type="text" name="password"
							placeholder=""
							value="' . esc_attr( $mofr_current_user->user_firstname ) . '" />
					</div>
				
					<div class="w-full mofr-input-wrapper group group">
						<label class="mofr-input-label">Confirm Password</label>
						<input class="w-full mofr-input" type="text" name="confirmPassword"
							placeholder=""
							value="' . esc_attr( $mofr_current_user->user_lastname ) . '" />
					</div>

				</div>

				<input type="submit" name="submit" value="' . esc_attr( mofr_( 'Register' ) ) . '"
							class="mofr-button primary" />
				<a href="#goToLoginPage" class="mofr-button secondary">' . esc_html( mofr_( 'Already Have an Account? Sign In' ) ) . '</a>

			</div>
		</form>
		<form id="goToLoginPageForm" method="post" action="">';
		wp_nonce_field( 'mofr_firebase_actions' );
echo '		<input type="hidden" name="option" value="mofr_go_to_login_page" />
		</form>
		<script>
			jQuery(document ) .  ready(function(){
				$mo(\'a[href="#mofr_forgot_password"]\' ) .  click(function(){
					$mo("#forgotpasswordform" ) .  submit();
				});
			
				$mo(\'a[href="#goToLoginPage"]\' ) .  click(function(){
					$mo("#goToLoginPageForm" ) .  submit();
				});
			});
		</script>';
