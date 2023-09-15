<?php
/**
 * Load admin view for Feedback Pop Up.
 *
 * @package minorange-firebase-sms-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
echo '
			<div class="deactivation_popup_container" id="support_form"  style="display: none;" >
				<div id="deactivation_popup_wrapper" class="deactivation_popup_wrapper" tabindex="-1" role="dialog" style="display: none;" >
							<div class="mofr-section-header" >
								<h4 class="font-bold grow" >Feedback</h4>
								<a class ="close mofr-button secondary" id="mo_feedback_cancel_btn" href="#" onclick="mo_otp_feedback_goback()">' . esc_html( mofr_( 'Go Back' ) ) . '</a>
							  
							</div>
							<form class="p-mofr-6 flex flex-col gap-mofr-6" id="mofr_otp_feedback_form" name="f" method="post" action="">
									<div class="deactivation_message">' . esc_html( $message ) . '</div>
									<div class="flex flex-col gap-mofr-3">';
foreach ( $deactivationreasons as $code => $name ) {
	echo '
		<label class="mofr-checkbox-container pl-mofr-9">
			<input  type="checkbox" name="reason[]" id="dropdownEnable" value=' . esc_attr( $code ) . ' class="sr-only"/>
			<div class="mofr-checkmark"></div>
			<p class="text-base font-normal">' . esc_html( $name ) . '</p>
		</label> 
	';
}
echo '                                  
									</div>
										<input type="hidden" name="option" value="mofr_otp_feedback_option"/>
										<input type="hidden" value="false" id="feedback_fr_type" name="plugin_deactivated"/>';

echo '                                  <textarea id="query_feedback"
													class="mofr-textarea"
													name="query_feedback" 
													style="width:100%" 
													rows="4" 
													placeholder="Type your feedback here"></textarea>
										<div class="mofr_otp_note" hidden id="feedback_message" style="padding:10px;color:darkred;"></div>
										<textarea hidden id="feedback" name="feedback" style="width:100%" rows="2" placeholder="Type your feedback here"></textarea>
		';
echo '                          <div class="mofr_customer_validation-modal-footer" >    
									<input type="submit" name="miniorange_fr_feedback_submit" class="mofr-button primary"  style="float: right;"
										data-sm="' . esc_attr( $submit_message ) . '" data-sm2="' . esc_attr( $submit_message2 ) . '" value="' . esc_attr( $submit_message ) . '" />';
echo '                                        
								</div>
							</form>    
						
				</div>
			</div>
	   ';
