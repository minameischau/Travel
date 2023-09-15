<?php
/**
 * Load user view for admin panel.
 *
 * @package minorange-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use MoOTP\Helper\CountryList;
use MoOTP\Helper\MoUtility;

/**
 * Display a tooltip with the appropriate header and message on the page
 *
 * @param  string $header  - the header of the tooltip.
 * @param  string $message - the body of the tooltip message.
 */
function mofr_draw_tooltip( $header, $message ) {
	echo '<span class="tooltip">
			<span class="dashicons dashicons-editor-help"></span>
			<span class="tooltiptext">
				<span class="header"><b><i>' . esc_html( mofr_( $header ) ) . '</i></b></span><br/><br/>
				<span class="body">' . esc_html( mofr_( $message ) ) . '</span>
			</span>
		  </span>';
}

/**
 * Display a dropdown with country and it's respective country code.
 */
function mofr_get_country_code_dropdown() {
	echo '<select name="default_country_code" id="mofr_country_code">';
	echo '<option value="" disabled selected="selected">
			' . esc_html( mofr_( 'Select your Country' ) ) . '
		  </option>';
	foreach ( CountryList::get_country_code_list() as $key => $country ) {
		echo '<option data-countrycode="' . esc_attr( $country['countryCode'] ) . '" value="' . esc_attr( $key ) . '"';
		echo CountryList::is_country_selected( esc_attr( $country['countryCode'] ), esc_attr( $country['alphacode'] ) ) ? 'selected' : '';
		echo '>' . esc_attr( $country['name'] ) . '</option>';
	}
	echo '</select>';
}
/**
 * This function is called to generate the form details fields for a form.
 *
 * @param array  $form_details the details posted by the user.
 * @param string $show_verify_field show verify fields.
 * @param string $show_email_and_phone_field show email and phone field.
 * @param string $disabled disabled attribute.
 * @param string $key the name attribute of the hidden field.
 * @param string $form_name the name of the form.
 * @param string $key_type the type of the key.
 * @return mixed
 */
function get_multiple_form_select( $form_details, $show_verify_field, $show_email_and_phone_field, $disabled, $key, $form_name, $key_type ) {

	$row_template = "<div id='row{FORM}{KEY}_{INDEX}'>
                            %s : 
                            <input 	id='{FORM}_form_{KEY}_{INDEX}' 
                                    class='field_data' 
                                    name='{FORM}_form[form][]' 
                                    type='text' 
                                    value='{FORM_ID_VAL}'>
                                    {EMAIL_AND_PHONE_FIELD}
                                    {VERIFY_FIELD}
                        </div>";

	$email_and_phone_field = " <span {HIDDEN1}>
                                    %s: 
                                    <input  id='{FORM}_form_email_{KEY}_{INDEX}' 
                                            class='field_data' 
                                            name='{FORM}_form[emailkey][]' 
                                            type='text' 
                                            value='{EMAIL_KEY_VAL}'>
                                </span>
                                <span {HIDDEN2}>
                                    %s: 
                                    <input  id='{FORM}_form_phone_{KEY}_{INDEX}' 
                                            class='field_data'  
                                            name='{FORM}_form[phonekey][]' 
                                            type='text' value='{PHONE_KEY_VAL}'>
                                </span>";

	$verify_field = "<span>
                            %s: 
                            <input 	class='field_data' 
                                    id='{FORM}_form_verify_{KEY}_{INDEX}' 
                                    name='{FORM}_form[verifyKey][]' 
                                    type='text' value='{VERIFY_KEY_VAL}'>
                        </span>";

	$verify_field = $show_verify_field ? $verify_field : '';

	$email_and_phone_field = $show_email_and_phone_field ? $email_and_phone_field : '';

	$row_template = MoUtility::replace_string(
		array(
			'VERIFY_FIELD'          => $verify_field,
			'EMAIL_AND_PHONE_FIELD' => $email_and_phone_field,
		),
		$row_template
	);

	$row_template = sprintf(
		$row_template,
		mofr_( 'Form ID' ),
		mofr_( 'Email Field' . $key_type ),
		mofr_( 'Phone Field' . $key_type ),
		mofr_( 'Verification Field' . $key_type )
	);

	$counter = 0;
	if ( MoUtility::is_blank( $form_details ) ) {
		$details = array(
			'KEY'            => $key,
			'INDEX'          => 0,
			'FORM'           => $form_name,
			'HIDDEN1'        => 2 === $key ? 'hidden' : '',
			'HIDDEN2'        => 1 === $key ? 'hidden' : '',
			'FORM_ID_VAL'    => '',
			'EMAIL_KEY_VAL'  => '',
			'PHONE_KEY_VAL'  => '',
			'VERIFY_KEY_VAL' => '',
		);
		echo wp_kses(
			MoUtility::replace_string( $details, $row_template ),
			array(
				'div'   => array( 'id' => array() ),
				'input' => array(
					'id'    => array(),
					'class' => array(),
					'name'  => array(),
					'type'  => array(),
					'value' => array(),
				),
				'span'  => array(
					'hidden' => array(),
				),
			)
		);
	} else {
		foreach ( $form_details as $form_key => $form_detail ) {
			$details = array(
				'KEY'            => $key,
				'INDEX'          => $counter,
				'FORM'           => $form_name,
				'HIDDEN1'        => 2 === $key ? 'hidden' : '',
				'HIDDEN2'        => 1 === $key ? 'hidden' : '',
				'FORM_ID_VAL'    => $show_email_and_phone_field ? $form_key : $form_detail,
				'EMAIL_KEY_VAL'  => $show_email_and_phone_field ? $form_detail['email_show'] : '',
				'PHONE_KEY_VAL'  => $show_email_and_phone_field ? $form_detail['phone_show'] : '',
				'VERIFY_KEY_VAL' => $show_verify_field ? $form_detail['verify_show'] : '',
			);
			echo wp_kses(
				MoUtility::replace_string( $details, $row_template ),
				array(
					'div'   => array( 'id' => array() ),
					'input' => array(
						'id'    => array(),
						'class' => array(),
						'name'  => array(),
						'type'  => array(),
						'value' => array(),
					),
					'span'  => array(
						'hidden' => array(),
					),
				)
			);
			$counter++;
		}
	}
	$result['counter'] = $counter;
	return $result;
}
/**
 * This function is used to generate the scripts necessary to add or remove
 * fields for taking form details from the admin.
 *
 * @param string $show_verify_field show verify fields.
 * @param string $show_email_and_phone_field show email and phone field.
 * @param string $form_name the name of the form.
 * @param string $key_type the type of the key.
 * @param string $counters the counters.
 */
function multiple_from_select_script_generator( $show_verify_field, $show_email_and_phone_field, $form_name, $key_type, $counters ) {
	$row_template = "<div id='row{FORM}{KEY}_{INDEX}'>
                            %s : 
                            <input  id='{FORM}_form_{KEY}_{INDEX}' 
                                    class='field_data' 
                                    name='{FORM}_form[form][]' 
                                    type='text' 
                                    value=''> 
                                    {EMAIL_AND_PHONE_FIELD}{VERIFY_FIELD} 
                        </div>";

	$verify_field          = "<span> %s:
                            <input 	class='field_data' 
                                    id='{FORM}_form_verify_{KEY}_{INDEX}' 
                                    name='{FORM}_form[verifyKey][]' 
                                    type='text' value=''>
                        </span>";
	$email_and_phone_field = "<span class='{HIDDEN1}'> %s:
                                    <input 	id='{FORM}_form_email_{KEY}_{INDEX}' 
                                            class='field_data' 
                                            name='{FORM}_form[emailkey][]' 
                                            type='text' value=''>
                                </span>
                                <span class='{HIDDEN2}'> %s: 
                                    <input 	id='{FORM}_form_phone_{KEY}_{INDEX}' 
                                            class='field_data'  
                                            name='{FORM}_form[phonekey][]' 
                                            type='text' 
                                            value=''>
                                </span>";

	$verify_field          = $show_verify_field ? $verify_field : '';
	$email_and_phone_field = $show_email_and_phone_field ? $email_and_phone_field : '';

	$row_template = MoUtility::replace_string(
		array(
			'VERIFY_FIELD'          => $verify_field,
			'EMAIL_AND_PHONE_FIELD' => $email_and_phone_field,
		),
		$row_template
	);

	$row_template = sprintf(
		$row_template,
		mofr_( 'Form ID' ),
		mofr_( 'Email Field' . $key_type ),
		mofr_( 'Phone Field' . $key_type ),
		mofr_( 'Verification Field' . $key_type )
	);

	$row_template = trim( preg_replace( '/\s\s+/', ' ', $row_template ) );

	$script_template = '<script>
                                var {FORM}_counter1, {FORM}_counter2, {FORM}_counter3;
                                jQuery(document).ready(function(){  
                                    {FORM}_counter1 = ' . $counters[0] . '; {FORM}_counter2 = ' . $counters[1] . '; {FORM}_counter3 = ' . $counters[2] . "; 
                                });
                            </script>
                            <script>
                                function add_{FORM}( t, n )
                                {
                                    var count = this['{FORM}_counter'+n];
                                    var hidden1='',hidden2='',both='';
                                    var html = \"" . $row_template . "\";
                                    if(n===1) hidden2 = 'hidden';
                                    if(n===2) hidden1 = 'hidden';
                                    if(n===3) both = 'both_';
                                    count++;
                                    html = html.replace('{KEY}', n).replace('{INDEX}',count).replace('{HIDDEN1}',hidden1).replace('{HIDDEN2}',hidden2);
									if(count!==0) {
                                        \$mo(html.replace('{KEY}', n).replace('{INDEX}',count).replace('{HIDDEN1}',hidden1).replace('{HIDDEN2}',hidden2)).insertAfter(\$mo('#row{FORM}'+n+'_'+(count-1)+''));
                                    }
                                    this['{FORM}_counter'+n]=count;
                                }
                            
                                function remove_{FORM}( n )
                                {
                                    var count =   Math.max(this['{FORM}_counter1'],this['{FORM}_counter2'],this['{FORM}_counter3']);
                                    if(count !== 0) {
                                        \$mo('#row{FORM}1_' + count).remove();
                                        \$mo('#row{FORM}2_' + count).remove();
                                        \$mo('#row{FORM}3_' + count).remove();
                                        count--;
                                        this['{FORM}_counter3']=this['{FORM}_counter1']=this['{FORM}_counter2']=count;
                                    }       
                                }
                            </script>";
	$script_template = MoUtility::replace_string( array( 'FORM' => $form_name ), $script_template );
	echo wp_kses(
		$script_template,
		array(
			'div'    => array(
				'name'   => array(),
				'id'     => array(),
				'class'  => array(),
				'title'  => array(),
				'style'  => array(),
				'hidden' => array(),
			),
			'script' => array(),
			'span'   => array(
				'class'  => array(),
				'title'  => array(),
				'style'  => array(),
				'hidden' => array(),
			),
			'input'  => array(
				'type'        => array(),
				'id'          => array(),
				'name'        => array(),
				'value'       => array(),
				'class'       => array(),
				'size '       => array(),
				'tabindex'    => array(),
				'hidden'      => array(),
				'style'       => array(),
				'placeholder' => array(),
				'disabled'    => array(),
			),
		)
	);
}
