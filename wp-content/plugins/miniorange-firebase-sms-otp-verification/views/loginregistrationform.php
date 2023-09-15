<?php
/**
 * Load admin view for miniorange login and registration form.
 *
 * @package minorange-firebase-smsotp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use MoOTP\Helper\MoMessages;
use MoOTP\Helper\MoConstants;
use MoOTP\Helper\MoUtility;

if ( ! empty( $prem_disabled ) ) {
	add_filter( 'wp_dropdown_pages', 'mo_disable_pages_dropdown' );
}
/**
 * This function is called by the filter mofr_phone_dropdown_selector
 * to disable the dropdown of pages list.
 *
 * @param array $output - the html of select tag to select the page in the dropdown.
 * @return array
 */
function mo_disable_pages_dropdown( $output ) {
	return str_replace( '<select ', '<select disabled ', $output );
}

$crown_svg = empty( $prem_disabled ) ? '' : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <g id="d4a43e0162b45f718f49244b403ea8f4">
                                        <g id="4ea4c3dca364b4cff4fba75ac98abb38">
                                            <g id="2413972edc07f152c2356073861cb269">
                                                <path id="2deabe5f8681ff270d3f37797985a977" d="M20.8007 20.5644H3.19925C2.94954 20.5644 2.73449 20.3887 2.68487 20.144L0.194867 7.94109C0.153118 7.73681 0.236091 7.52728 0.406503 7.40702C0.576651 7.28649 0.801941 7.27862 0.980492 7.38627L7.69847 11.4354L11.5297 3.72677C11.6177 3.54979 11.7978 3.43688 11.9955 3.43531C12.1817 3.43452 12.3749 3.54323 12.466 3.71889L16.4244 11.3598L23.0197 7.38654C23.1985 7.27888 23.4233 7.28702 23.5937 7.40728C23.7641 7.52754 23.8471 7.73707 23.8056 7.94136L21.3156 20.1443C21.2652 20.3887 21.0501 20.5644 20.8007 20.5644Z" fill="#facc15"><title>Premium Feature</title></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>';

$crown_svg_lg = empty( $prem_disabled ) ? '' : ' <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <g id="d4a43e0162b45f718f49244b403ea8f4">
                                        <g id="4ea4c3dca364b4cff4fba75ac98abb38">
                                            <g id="2413972edc07f152c2356073861cb269">
                                                <path id="2deabe5f8681ff270d3f37797985a977" d="M20.8007 20.5644H3.19925C2.94954 20.5644 2.73449 20.3887 2.68487 20.144L0.194867 7.94109C0.153118 7.73681 0.236091 7.52728 0.406503 7.40702C0.576651 7.28649 0.801941 7.27862 0.980492 7.38627L7.69847 11.4354L11.5297 3.72677C11.6177 3.54979 11.7978 3.43688 11.9955 3.43531C12.1817 3.43452 12.3749 3.54323 12.466 3.71889L16.4244 11.3598L23.0197 7.38654C23.1985 7.27888 23.4233 7.28702 23.5937 7.40728C23.7641 7.52754 23.8471 7.73707 23.8056 7.94136L21.3156 20.1443C21.2652 20.3887 21.0501 20.5644 20.8007 20.5644Z" fill="#facc15"><title>Premium Feature</title></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>';

echo '  <div>
					<form name="f" method="post" action="" id="mo_firebase_loginregform_settings" class="w-full h-[368px]">
						<input type="hidden" name="option" value="mo_firebase_loginreg_form_save_option" />
						<input type="hidden" name="nonce_mo_firebase_loginreg_form_save_option" value="' . esc_attr( $mo_nonce_mo_firebase_form_save_option ) . '" />';
						wp_nonce_field( 'mofr_firebase_actions' );
echo '			<div class="mofr-section-header">
							<p class="mofr-heading grow">Custom CSS Settings</p>
							<input ' . esc_attr( $disabled ) . ' type="submit" name="mo_firebase_login_form_save" ' . esc_attr( $disabled ) . 'id="mo_firebase_login_form_save"  class="mofr-button primary"
										value="' . esc_attr( mofr_( 'Save Settings' ) ) . '">
						</div>
						<div class="mofr-content-wrapper">
							<div class="w-1/2 flex flex-col gap-mofr-8">

									<div class="flex w-full gap-mofr-4">
										<div class="mofr-step">1</div>
										<p class="mofr-title">Use this shortcode to show the login form <b>[mo_wp_loginreg_form]</b></p>
									</div>

									<div class="flex w-full gap-mofr-4">
										<div class="mofr-step">2</div>
										<div>
											<p class="mofr-title">Create new page
											<a href="' . esc_url( $mo_create_new_page ) . '" target="_blank">Click here to create</a></p>
										</div>
									</div>
									
									<div class="flex w-full gap-mofr-4 grow">
										<div class="mofr-step">3</div>
										<p class="mofr-title">Add your own CSS Styles for Login and<br>Registration Form</p>
									</div>
							</div>
							
							<div class="w-1/2">
								<textarea id="mo_firebase_loginreg_form_css" ' . esc_attr( $disabled ) . ' class="mofr-textarea w-full h-full " 
								name="mo_firebase_loginreg_form_css" placeholder="Write your custom CSS here" />' . esc_attr( $mo_firebase_loginreg_form_css ) . '</textarea>              
							</div>
						</div>
					</form>
					
					<form name="f" method="post" action="" id="mo_firebase_loginform_settings">
						<input type="hidden" name="option" value="mo_firebase_login_form_save_option" />
						<input type="hidden" name="nonce_mo_firebase_login_form_save_option" value="' . esc_attr( $mo_nonce_mo_firebase_form_save_option ) . '" />';
							wp_nonce_field( 'mofr_firebase_actions' );
echo '      <div class="mofr-section-header">
							<p class="mofr-heading grow">Login Form Settings</p>
							<input ' . esc_attr( $disabled ) . ' type="submit" name="mo_firebase_login_form_save" id="mo_firebase_login_form_save"  class="mofr-button primary"
										value="' . esc_attr( mofr_( 'Save Settings' ) ) . '">
						</div>
						
						<div class="px-mofr-8 py-mofr-4 mt-mofr-4 flex items-center">
							<label class="mofr-checkbox-container pl-mofr-9">
								<input  type="checkbox" ' . esc_attr( $disabled ) . ' id="mo_firebase_login_form_enable" value="1" data-toggle="mo_firebase_login_form_enable_options" 
									class="sr-only" ' . esc_attr( $mo_firebase_login_form_enable ) . ' name="mo_firebase_login_form_enable" />
								<span class="mofr-checkmark"></span>
								<p class="mofr-title">Enable OTP Verification for login form</p>
							</label>             
						</div> 

						<div class="px-mofr-8 py-mofr-4">
							<div class="flex flex-row items-center">
								<div class="grow">
								<p class="mofr-title flex flex-row gap-mofr-2">Select Page to Redirect after login ' . wp_kses( $crown_svg, MoUtility::mofr_allow_svg_array() ) . '</p>
								</div>';
								wp_dropdown_pages( array( 'selected' => esc_attr( $mo_firebase_loginredirect_pageid ) ) );
echo '              
							</div>
						</div>
							 
					</form>
					
					<form name="f" method="post" action="" id="mo_firebase_registrationform_settings" class="mt-mofr-14">
						<input type="hidden" name="option" value="mo_firebase_registration_form_save_option" />
						<input type="hidden" name="nonce_mo_firebase_registration_form_save_option" value="' . esc_attr( $mo_nonce_mo_firebase_form_save_option ) . '" />';
						wp_nonce_field( 'mofr_firebase_actions' );
echo '			<div class="mofr-section-header">
							<p class="mofr-heading grow">Registration Form Settings</p>
							<input ' . esc_attr( $disabled ) . ' type="submit" name="mo_firebase_registration_form_save" id="mo_firebase_registration_form_save"  class="mofr-button primary"
										value="' . esc_attr( mofr_( 'Save Settings' ) ) . '">
						</div>
						
						<div class="px-mofr-8 py-mofr-4 mt-mofr-4">     
							<label class="mofr-checkbox-container pl-mofr-9">
								<input  type="checkbox" ' . esc_attr( $disabled ) . ' id="mo_firebase_registration_form_enable" value="1" data-toggle="mo_firebase_registration_form_enable_options" 
								class="sr-only" ' . esc_attr( $mo_firebase_registration_form_enable ) . ' name="mo_firebase_registration_form_enable" />
								<span class="mofr-checkmark"></span>
								<p class="mofr-title">Enable OTP Verification for Registration form</p>
							</label>                                    
						</div> 
						</div>
						<div class="px-mofr-8 py-mofr-4">
							<div class="flex flex-row items-center">
								<div class="grow">
								<p class="mofr-title flex flex-row gap-mofr-2">Select Page to Redirect after Registration ' . wp_kses( $crown_svg, MoUtility::mofr_allow_svg_array() ) . '</p>
								</div>';
								wp_dropdown_pages( array( 'selected' => esc_attr( $mo_firebase_regredirect_pageid ) ) );
echo '             
							</div>
						</div> 

						<div class="px-mofr-8 py-mofr-4">
							<div class="flex flex-row items-center">
								<div class="grow">
									<p class="mofr-title bold flex flex-row gap-mofr-2">Select User Role  ' . wp_kses( $crown_svg, MoUtility::mofr_allow_svg_array() ) . '</p>
								</div>
									<select ' . esc_attr( $prem_disabled ) . ' name="mo_firebase_default_user_role" id="mo_firebase_default_user_role">';
										global $wp_roles;
										$selected = '';
foreach ( $wp_roles->roles as $key => $value ) {
	if ( $key === $mo_firebase_default_user_role ) {
		$selected = 'selected';
	}
	echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '">' . esc_html( $value['name'] ) . '</option>';
	$selected = '';
}
echo '            					</select> 
								</div>
							</div>     
							<br>
							<br>         
						</form>  

						<form name="f" method="post" action="" id="mo_firebase_wcform_settings">
							<input type="hidden" name="option" value="mo_firebase_wc_form_save_option" />
							<input type="hidden" name="nonce_mo_firebase_login_form_save_option" value="' . esc_attr( $mo_nonce_mo_firebase_form_save_option ) . '" />';
							wp_nonce_field( 'mofr_firebase_actions' );
echo '							<div class="mofr-section-header">
							<p class="mofr-heading grow flex flex-row gap-mofr-2">Woocommerce Form Settings  ' . wp_kses( $crown_svg_lg, MoUtility::mofr_allow_svg_array() ) . '</p>
							<input ' . esc_attr( $prem_disabled ) . ' type="submit" name="mo_firebase_wc_form_save" id="mo_firebase_wc_form_save"  class="mofr-button primary"
									value="' . esc_attr( mofr_( 'Save Settings' ) ) . '">
							</div>
							
							<div class="px-mofr-8 py-mofr-4 mt-mofr-4 flex items-center">
							<label class="mofr-checkbox-container pl-mofr-9">
								<input  type="checkbox" ' . esc_attr( $prem_disabled ) . ' id="mo_firebase_wc_form_enable" value="1" data-toggle="mo_firebase_wc_form_enable_options" 
								class="sr-only" ' . esc_attr( $mo_firebase_wc_form_enable ) . ' name="mo_firebase_wc_form_enable"  />
								<span class="mofr-checkmark"></span>
								<p class="mofr-title">Replace Woocommerce login/registration form with miniOrange form</p>
							</label>             
							</div> 

							<div class="px-mofr-8 py-mofr-4 mt-mofr-4 flex items-center">
							<label class="mofr-checkbox-container pl-mofr-9">
								<input  type="checkbox" ' . esc_attr( $prem_disabled ) . ' id="mo_firebase_wc_form_reg_enable" value="1" data-toggle="mo_firebase_wc_form_reg_enable_options" 
								class="sr-only" ' . esc_attr( $mo_firebase_wc_form_reg_enable ) . ' name="mo_firebase_wc_form_reg_enable"  />
								<span class="mofr-checkmark"></span>
								<p class="mofr-title">Enable OTP Verification on Default WooCommerce Registration Form</p>
							</label>             
							</div> 

							<div class="px-mofr-8 py-mofr-4 mt-mofr-4 flex items-center">
							<label class="mofr-checkbox-container pl-mofr-9">
								<input  type="checkbox" ' . esc_attr( $prem_disabled ) . ' id="mo_firebase_wc_form_log_enable" value="1" data-toggle="mo_firebase_wc_form_log_enable_options" 
								class="sr-only" ' . esc_attr( $mo_firebase_wc_form_log_enable ) . ' name="mo_firebase_wc_form_log_enable"  />
								<span class="mofr-checkmark"></span>
								<p class="mofr-title">Enable OTP Verification on Default WooCommerce Login Form</p>
							</label>             
							</div> 

							<div class="px-mofr-8 py-mofr-4 mt-mofr-4 flex items-center">
							<label class="mofr-checkbox-container pl-mofr-9">
								<input  type="checkbox" ' . esc_attr( $prem_disabled ) . ' id="mo_firebase_wc_form_checkout_enable" value="1" data-toggle="mo_firebase_wc_form_checkout_enable_options" 
								class="sr-only" ' . esc_attr( $mo_firebase_wc_form_checkout_enable ) . ' name="mo_firebase_wc_form_checkout_enable"  />
								<span class="mofr-checkmark"></span>
								<p class="mofr-title">Enable OTP Verification on Default WooCommerce Checkout Form</p>
							</label>             
							</div> 

							<br>
							<br>
						</form>

						<form name="f" method="post" action="" id="mo_firebase_umform_settings">
							<input type="hidden" name="option" value="mo_firebase_um_form_save_option" />
							<input type="hidden" name="nonce_mo_firebase_login_form_save_option" value="' . esc_attr( $mo_nonce_mo_firebase_form_save_option ) . '" />';
							wp_nonce_field( 'mofr_firebase_actions' );
echo '						<div class="mofr-section-header">
								<p class="mofr-heading grow flex flex-row gap-mofr-2">Ultimate Member Form Settings ' . wp_kses( $crown_svg_lg, MoUtility::mofr_allow_svg_array() ) . '</p>
								<input ' . esc_attr( $prem_disabled ) . ' type="submit" name="mo_firebase_um_form_save" id="mo_firebase_um_form_save"  class="mofr-button primary"
										value="' . esc_attr( mofr_( 'Save Settings' ) ) . '">
							</div>
							
							<div class="px-mofr-8 py-mofr-4 mt-mofr-4 flex items-center">
								<label class="mofr-checkbox-container pl-mofr-9">
									<input  type="checkbox" ' . esc_attr( $prem_disabled ) . ' id="mo_firebase_um_reg_form_enable" value="1" data-toggle="mo_firebase_um_reg_form_enable_options" 
									class="sr-only" ' . esc_attr( $mo_firebase_um_reg_form_enable ) . ' name="mo_firebase_um_reg_form_enable"  />
									<span class="mofr-checkmark"></span>
									<p class="mofr-title">Enable OTP Verification on Ultimate Member Registration Form</p>
								</label>             
							</div>

							<div class="px-mofr-4 mt-mofr-4" style="margin-left:2%;">
								<ol>
									<li>
									1. <a href="' . esc_url( $um_forms ) . '"  target="_blank" style="color:rgb(29 78 216);">' .
										esc_html( mofr_( 'Click Here' ) ) .
									'</a> ' . esc_html( mofr_( ' to see your list of forms' ) ) . '
									</li>
									<li>2. ' . wp_kses( mofr_( 'Click on the <b>Edit link</b> of your form.' ), array( 'b' => array() ) ) . '</li>
									<li>4. ' . wp_kses( mofr_( 'Add a new <b>Mobile Number</b> Field from the list of predefined fields.' ), array( 'b' => array() ) ) . '</li>
									<li>5. ' . wp_kses( mofr_( 'Click on <b>update</b> to save your form.' ), array( 'b' => array() ) ) . '</li>
								</ol>
								<p style="margin-left:2%;margin-top:1%;">
									<i><b>' . esc_html( mofr_( 'Mobile Number Field Meta Key' ) ) . ':</b></i>
										<input  class="mo_registration_table_textbox" 
										name="mo_firebase_um_verify_meta_key" 
										type="text" 
										value="' . esc_attr( $um_otp_meta_key ) . '">         
								</p>
							</div>

							<br>
							<br>
						</form>

						<form name="f" method="post" action="" id="mo_firebase_gravity_form_settings">
							<input type="hidden" name="option" value="mo_firebase_gravity_form_save_option" />
							<input type="hidden" name="nonce_mo_firebase_login_form_save_option" value="' . esc_attr( $mo_nonce_mo_firebase_form_save_option ) . '" />';
							wp_nonce_field( 'mofr_firebase_actions' );
echo '						<div class="mofr-section-header">
								<p class="mofr-heading grow flex flex-row gap-mofr-2">Gravity Form Settings ' . wp_kses( $crown_svg_lg, MoUtility::mofr_allow_svg_array() ) . '</p>
								<input ' . esc_attr( $prem_disabled ) . ' type="submit" name="mo_firebase_gravity_form_save" id="mo_firebase_gravity_form_save"  class="mofr-button primary"
										value="' . esc_attr( mofr_( 'Save Settings' ) ) . '">
							</div>
							
							<div class="px-mofr-8 py-mofr-4 mt-mofr-4 flex items-center">
								<label class="mofr-checkbox-container pl-mofr-9">
									<input  type="checkbox" ' . esc_attr( $prem_disabled ) . ' id="mo_firebase_gravity_form_enable" value="1" data-toggle="mo_firebase_gravity_form_enable_options" 
									class="sr-only" ' . esc_attr( $mo_firebase_gravity_form_enable ) . ' name="mo_firebase_gravity_form_enable"  />
									<span class="mofr-checkmark"></span>
									<p class="mofr-title">Enable OTP Verification on Gravity Form</p>
								</label>             
							</div>

							<div class="px-mofr-4 mt-mofr-4" style="margin-left:2%;">
								<ol>
									<li>
									1. <a href="' . esc_url( $gravity_forms ) . '"  target="_blank" style="color:rgb(29 78 216);">' .
										esc_html( mofr_( 'Click Here' ) ) .
									'</a> ' . esc_html( mofr_( ' to see your list of forms' ) ) . '
									</li>
									<li>2. ' . wp_kses( mofr_( 'Click on the <b>Edit link</b> of your form.' ), array( 'b' => array() ) ) . '</li>
									<li>4. ' . wp_kses( mofr_( 'Add a new <b>Mobile Number</b> Field from the list of predefined fields.' ), array( 'b' => array() ) ) . '</li>
									<li>5. ' . wp_kses( mofr_( 'Click on <b>update</b> to save your form.' ), array( 'b' => array() ) ) . '</li>
									<br/><div style="display:flex;    gap: 0.5rem;">' . esc_html( mofr_( 'Add Form' ) ) . ' : <input type="button"  value="+" ' . esc_attr( $prem_disabled ) . '
																							onclick="add_gravity(\'phone\',2);"
																							class="mofr-button primary"/>&nbsp;
													<input  type="button" value="-" ' . esc_attr( $prem_disabled ) . '
															onclick="remove_gravity(2);"
															class="mofr-button primary" /></div><br/><br/>';

												$gf_form_results = get_multiple_form_select(
													$gf_otp_enabled,
													true,
													true,
													$prem_disabled,
													2,
													'gravity',
													'Label'
												);
												$gfcounter2      = ! MoUtility::is_blank( $gf_form_results['counter'] ) ? max( $gf_form_results['counter'] - 1, 0 ) : 0;

												echo '</ol>
								<p style="margin-left:2%;margin-top:1%;">
									<i><b>' . esc_html( mofr_( 'Verification Button Text ' ) ) . ':</b></i>
										<input  class="mo_registration_table_textbox" 
										name="mo_firebase_gravity_verify_button_text" 
										type="text" 
										value="' . esc_attr( $gravity_otp_button_text ) . '">         
								</p>

							</div>

							<br>
							<br>
						</form>

						<form name="f" method="post" action="" id="mo_firebase_dropdown_form_settings">
								<input type="hidden" name="option" value="mo_firebase_dropdown_form_save_option" />
								<input type="hidden" name="nonce_mo_firebase_form_save_option" value="' . esc_attr( $mo_nonce_mo_firebase_form_save_option ) . '" />
									<div class="mofr-section-header">
										<p class="mofr-heading grow">Country Code Dropdown</p>
										<input ' . esc_attr( $disabled ) . ' type="submit" name="mo_firebase_country_dropdown_save" id="mo_firebase_country_dropdown_save"  class="mofr-button primary"
											value="' . esc_attr( mofr_( 'Save Settings' ) ) . '">
									</div>

									<div class="px-mofr-8 py-mofr-4 mt-mofr-4">     
										<label class="mofr-checkbox-container pl-mofr-9">
												<input  type="checkbox" ' . esc_attr( $disabled ) . 'id="mo_firebase_dropdown_form_enable" value="1" data-toggle="mo_firebase_dropdown_form_enable_options" 
													class="sr-only" ' . esc_attr( $mo_firebase_dropdown_form_enable ) . ' name="mo_firebase_dropdown_form_enable" />
													<span class="mofr-checkmark"></span>
													<p class="mofr-title">' . esc_html( mofr_( 'Show a country code dropdown on the phone field.' ) ) . '</p>
										</label>
									</div>
									
									<div class="px-mofr-8 py-mofr-4">
																						<div class="flex flex-row items-center">
																							<div class="grow">
																								<p class="mofr-title">' . esc_html( mofr_( 'Select Default Country Code' ) ) . ':</p>
																							</div>';
																									mofr_get_country_code_dropdown();
												echo '                
																						</div>
									</div>';

												echo '<div class="px-mofr-8 py-mofr-4">
														<div class="flex flex-row items-center">
															<div class="grow">
																<p class="mofr-title bold">' . esc_html( mofr_( 'Country Code' ) ) . ':</p>
															</div>
															<span id="country_code"></span>
														</div>
													</div>
												<br>';
												echo '</form>        
												</div>';

												multiple_from_select_script_generator( true, true, 'gravity', 'Label', array( 0, $gfcounter2, 0 ) );

