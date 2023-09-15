<?php
/**
 * Load admin view for miniorange login and registration form.
 *
 * @package minorange-firebase-sms-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$button             = '<div style="margin-top: 2%;">' .
						'<div class="">' .
								'<input type="button" style="width:100%;" class="mofr-btn mofr-primary mofr-br-rounded" ' .
												'id="miniorange_otp_token_submit" ' .
												'title="' . esc_attr( mofr_( 'Please Enter your phone details to enable this. ' ) ) . '" value="' . esc_attr( mofr_( 'Send OTP' ) ) . '" />' .
						'</div>' .
					'</div>';
$mo_recaptcha_token = '<input type="hidden" value="" name="moRecaptchaToken" id="moRecaptchaToken">';
$messagebox         = '<div>' .
												'<div id="mofrreg_sendotp_message" class="mofr-err-container" ' .
												'</div>' .
											'</div>';

$show_otp_verification_fields_on_reg_form = $is_registration_otp_enabled ? 'block' : 'none';

$show_login_with_phone_form = $is_login_otp_enabled ? 'flex' : 'none';

$show_dropdownon_form = $is_dropdown_enabled ? 'flex' : 'none';

echo '<style>
				' . esc_attr( $customloginreg_css ) . '    
			</style>';
echo '<script>

				function toggleSignInForm(event,showForm, hideForm) {
					event.preventDefault();
					document.getElementById(showForm) .style.display = "block";
					document.getElementById(hideForm) .style.display = "none";
				}
			
				function toggleSigninMethodForm(event,formName, selectedTab) {
					event.preventDefault()
					var i, tabcontent, tablinks;
					tabcontent = document.getElementsByClassName("mofr-tabcontent" ) ;
					for (i = 0; i < tabcontent.length; i++) {
						tabcontent[i].style.display = "none";
					}
					tablinks = document.getElementsByClassName("tab-item" ) ;
					for (i = 0; i < tablinks.length; i++) {
						tablinks[i].className = tablinks[i].className.replace(" tab-active", "" ) ;
					}
					document.getElementById(formName) .style.display = "block";
					document.getElementById(selectedTab) .className += " tab-active";
				}

	</script>
	
	<div id="mofr-form-container" class="mofr-form-container">
				<input type="hidden" id="mofr-current-tab" name="mofr-current-tab" value="tab-signin">
				<div class="flex justify-center">
					<div class="mofr-tabs-container" id="mofr_login_reg_tab">
						<div id="tab-signin" class="tab-item tab-active"
								onclick="toggleSigninMethodForm(event,\'signin-section\',\'tab-signin\')">
								' . esc_attr( mofr_( 'Sign in' ) ) . '
						</div>
						<div id="tab-signup" class="tab-item"
								onclick="toggleSigninMethodForm(event,\'signup-section\',\'tab-signup\')">
								' . esc_attr( mofr_( 'Create Account' ) ) . '
						</div>
					</div>
				</div>

				<!-- Forgot Password Section -->
				<form id="mofr_reset_password" class="mofr-forgot-password mofr-flex-column" name="mofr_reset_password">
					<div id="mofr-reset-password" style="display:none;">
						
						<input type="hidden" value="" name="moRecaptchaToken" id="moRecaptchaToken">

						<div class="mofr_go_back">
							<a href="' . esc_attr( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' ) . '" >Go Back</a>
						</div><br>
						<div class="mt-regular"></div>
						<div class="floating">
							<input name="mofr_reset_pass_email" id="mofr_reset_pass_email" class="mo-input floating__input" type="email" value="" required placeholder="Email"/>
							<label for="mofr_reset_pass_email" class="floating__label" data-content="Email">
						</div>

						<div class="mt-regular"></div>
						<input type="button" id="mofr_reset_pass_sendotp" name="mofr_reset_pass_sendotp" class="mo-input mofr-button primary" value="' . esc_attr( mofr_( 'Send OTP' ) ) . '">


						<div class="mofr-reset-pass-otp" style="display:none;">
							<div id="mofr_reset_pass_message" class="mofr-message-container mofr-error-message"></div>
							
							<div class="mt-large"></div>

							<div class="floating">
								<input name="mofr_reset_pass_otpfield" id="mofr_reset_pass_otpfield" class="mo-input floating__input" type="email" value="" required placeholder="Enter Verification Code"/>
								<label for="mofr_reset_pass_otpfield" class="floating__label" data-content="Enter Verification Code">
							</div>

							<div class="mt-regular"></div>

							<input type="button" id="mofr_reset_pass_verifyotp" name="mofr_reset_pass_verifyotp" class="mo-input mofr-button primary" value="' . esc_attr( mofr_( 'Verify OTP' ) ) . '">

						</div>
					</div>
				</form>

				<!-- Save Password Section -->
				<form id="mofr_new_password" class="mofr-save-password mofr-flex-column" name="mofr_new_password">
					<div id="mofr-new-password" style="display:none;" class="mt-large mofr-save-password-section flex-col mofr-tabcontent">
						<div class="mt-regular"></div>
						<div class="mofr_go_back">
							<a href="' . esc_attr( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' ) . '" >Go Back</a>
						</div><br>
						<div class="relative floating mt-large">
								<input id="show_new_password" type="checkbox" style="display:none;">
								<label class="mofr-toggle-passwordview" for="show_new_password" id="resetPasswordVisibilityIcon"><img src="' . esc_url( MOFLR_EYEICON_LOGO ) . '"/></label>
								<input class="mo-input floating__input" name="mofr_save_new_password" id="mofr_save_new_password" type="password" value="" required placeholder="Enter New Password"/>
								<label for="mofr_save_new_password" class="floating__label" data-content="Enter New Password">
						</div>

						<div class="mt-large"></div>
						<div class="floating">
								<input class="mo-input floating__input" name="mofr_confirm_password" id="mofr_confirm_password" type="password" value="" required placeholder="Enter Confirm Password"/>
								<label for="mofr_confirm_password" class="floating__label" data-content="Enter Confirm password">
						</div>
						<div class="mt-regular"></div>

						<div id="mofr_reset_new_pass_message" class="mofr-message-container mofr-error-message" style="display:none;"></div>
						
						<div class="mt-regular"></div>            
						<input type="button" id="mofr_reset_new_pass" name="mofr_reset_new_pass" class="rounded-full mo-input mofr-button primary" value="' . esc_attr( mofr_( 'Save Password' ) ) . '">
					</div>
				</form>

				
				<div class="mofr-form-content">

					<!-- Sign in Section -->
					<div id="signin-section" class="mt-large mofr-signin-section flex-col mofr-tabcontent">
						<form id="mofr-email-login" class="mofr-email-signin mofr-flex-column">
							
							<div class="floating">
								<input id="mofr_loginwithemail_email" class="mo-input floating__input" name="mofr_loginwithemail_email" placeholder="Enter Your Email" type="email" value="" required />
								<label for="mofr_loginwithemail_email" class="floating__label" data-content="Email / Username">
							</div>

							<div class="relative floating mt-large">
								<input id="show_password_login" type="checkbox" style="display:none;">
								<label class="mofr-toggle-passwordview" for="show_password_login" id="loginPasswordVisibilityIcon"><img src="' . esc_url( MOFLR_EYEICON_LOGO ) . '"/></label>
								<input class="floating__input" name="mofr_loginwithemail_password" id="mofr_loginwithemail_password" type="password" placeholder="Enter Password" required />
								<label for="mofr_loginwithemail_password" class="floating__label" data-content="Password">
							</div>

							<p id="mo_forgot_password" type="button" class="forgot-password">Forgot Password?</p>


							<button class="mofr-button primary" id="mofr_loginwithemail_submit">' . esc_html( mofr_( 'Sign in' ) ) . '</button>
							<div id="mofr_signin_using_phone_container" style="display:' . esc_attr( $show_login_with_phone_form ) . '">
							<button class="mt-regular mofr-button secondary" id="mofr_signin_using_phone" onclick="toggleSignInForm(event,\'mofr_phone_otp_login\',\'mofr-email-login\')">' . esc_html( mofr_( 'Sign in with Phone Number' ) ) . '</button>
							</div>
							<div style="display:none" id="mofr_loginwithemail_error" class="mofr-message-container mofr-error-message"></div>

							
						</form>

						<!-- Phone Signin Section -->
							<div id="mofr_phone_otp_login" class="mofr-phone-signin mofr-flex-column mofr-hide">
								<form id="mofr_phone_otp_login_form" class="mofr-email-signin mofr-flex-column"  name="mofr_phone_otp_login_form">
									<input type="hidden" value="" name="moRecaptchaToken" id="moRecaptchaToken">
									<div class="mofr-space-lg"></div>

									<div class="floating">
										<input class="mofr-input floating__input" type="text" autocomplete="off" name="mofr_loginwithotp_phone" required="" value=""  placeholder="Enter Your Phone Number" id="mofr_loginwithotp_phone">
										<label for="mofr_loginwithotp_phone" class="floating__label" data-content="Phone Number">
									</div>

									<div class="mt-regular"></div>
									<input type="button" id="mofr_loginwithotp_sendotp" name="mofr_loginwithotp_sendotp" class="rounded-full mt-regular mo-input mofr-button primary" value="' . esc_attr( mofr_( 'Verify Phone Number' ) ) . '">
									<div class= "mofrloader" style="display:none;"></div>
									
									<div id= "mofr_loginwithotp_fields" style = "display:none;">
										<div id="mofr_loginwithotp_message" class="mofr-message-container">
											<div class="mofr-message-content error"></div>
										</div>

										<div class="mt-large floating">
											<input class="floating__input" id="mofr_loginwithotp_otpfield"  name="mofr_loginwithotp_otpfield" type="text" value="" required/>
											<label for="mofr_loginwithotp_otpfield" class="floating__label" data-content="Enter OTP Code">
										</div>

										<div class="mt-regular"></div>
										<input type="button" id="mofr_loginwithotp_verifyotp" name="mofr_loginwithotp_verifyotp" class="rounded-full mo-input mofr-button primary" value="' . esc_attr( mofr_( 'Verify & Login' ) ) . '" >
									</div>
									
									<button class="mt-regular mofr-button secondary" 
										onclick="toggleSignInForm(event,\'mofr-email-login\',\'mofr_phone_otp_login\')">
										' . esc_html( mofr_( 'Sign in using Email/Username' ) ) . '
									</button>

								</form>
							</div>
						</div>

					<!-- Signup Section -->  
					<div id="signup-section" class="mofr-signup-section mofr-flex-column mofr-tabcontent mofr-hide">
						<form name="moregistrationform" id="moregistrationform" method="post" class="flex flex-col">
							<div class="mt-large"></div>
							<!-- Username Field -->
							<div class="floating">
								<input class="floating__input" name="mofr_reg_username" id="mofr_reg_username" placeholder="Username" required   type="text" />
								<label for="mofr_reg_username" class="floating__label" data-content="Username">
							</div>

							<!-- Email Field -->
							<div class="mt-large floating">
								<input class="floating__input" required name="mofr_reg_email" id="mofr_reg_email" placeholder="Email" type="email" />
								<label for="mofr_reg_email" class="floating__label" data-content="Email">
							</div>

							<!-- Phone Number Field -->
							<div class="mt-large floating">
								<input class="floating__input" type="text" autocomplete="off" name="mofr_reg_phone" required="" value="" placeholder="Enter Your Phone Number" id="mofr_reg_phone">
								<label for="mofr_reg_phone" class="floating__label" data-content="Phone Number">
							</div>
							<div class="mt-regular"></div>
						

							<div class="otpverificationfields" style="display:' . esc_attr( $show_otp_verification_fields_on_reg_form ) . '">
								<input type="button" class="rounded-full mo-input mofr-button secondary" id="miniorange_otp_token_submit_reg"
										title="' . esc_attr( mofr_( 'Please Enter your phone details to enable this. ' ) ) . '" value="' . esc_attr( mofr_( 'Send Verification Code' ) ) . '" />
								<div class= "mofrloader" style="display:none;"></div>
								<input type="hidden" value="" name="moRecaptchaToken" id="moRecaptchaToken">

								<div id="mofr_signupwithotp_fields" style="display:none;">
									
									<div id="mofrreg_sendotp_message" class="mofr-message-container error">
									</div>

									<div class="mt-regular"></div>
									<div class="mt-large floating" id="reg_verification_field">
										<input type="text" name="mofr_otp_field" id="mofr_otp_field" required class="floating__input" value="" placeholder="Verification Code">
										<label for="mofr_reg_phone" class="floating__label" data-content="Verification Code">
									</div>

									<input type="button" id="miniorange_otp_token_verify" class="rounded-full mo-input mofr-button primary" value="' . esc_attr( mofr_( 'Verify OTP' ) ) . '" style="width: 100%; margin-top: 15px; margin-bottom: 15px; margin-right: 0px;">
								
								</div> 
							</div>  
							
							<div class="relative floating mt-large">
								<input id="show_password_reg" type="checkbox" style="display:none;">
								<label class="mofr-toggle-passwordview" for="show_password_reg" id="regPasswordVisibilityIcon"><img src="' . esc_url( MOFLR_EYEICON_LOGO ) . '"/></label>
								<input class="floating__input" name="mofr_reg_password" id="mofr_reg_password" type="password" placeholder="Enter Password" required />
								<label for="mofr_reg_password" class="floating__label" data-content="Password">
							</div> 

							<div class="mt-regular"></div>

							<button type="submit" class="mofr-button primary" name="mofr-register-submit" id="mofr-register-submit">' . esc_html( mofr_( 'Sign up' ) ) . '</button>
					
							<div style="display:none" id="mofrreg_validation_message" class="mofr-message-container mofr-error-message"></div>
						 
							<div class="mofr-space-rg"></div>
						</form>
					</div>
		</div>
';
