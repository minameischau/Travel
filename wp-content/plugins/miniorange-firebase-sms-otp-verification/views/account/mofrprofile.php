<?php
/**
 * Load admin view for miniorange profile details.
 *
 * @package minorange-firebase-smsotp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
echo '
	<div>
	
		<div class="mofr-section-header">
        	<p class="mofr-heading grow">Account Details</p>
			<form id="remove_accnt_form" style="display:none;" action="" method="post">';
			wp_nonce_field( 'mofr_firebase_actions' );
		echo '<input type="hidden" name="option" value="mofr_remove_account" />
			</form>

			<input  type="button" ' . esc_attr( $disabled ) . ' 
                    name="remove_accnt" 
                    id="remove_accnt" 
                    class="mofr-button secondary"
                    value="' . esc_attr( mofr_( 'Log out' ) ) . '"/>
        </div>
		
		<div class="p-mofr-8">
			<table class="mofr-table">
        		<tbody>
        		    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
        		        <th scope="row" class="mofr-trowhead">
        		            Registered Email
        		        </th>
        		        <td class="mofr-table-block">
        		           ' . esc_html( $admin_email ) . '
        		        </td>
        		    </tr>
        		    <tr class="bg-slate-100 border-b dark:bg-gray-800 dark:border-gray-700">
        		        <th scope="row" class="mofr-trowhead">
        		            Customer ID
        		        </th>
        		        <td class="mofr-table-block">
        		            ' . esc_html( $customer_id ) . '
        		        </td>
        		    </tr>
        		    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
        		        <th scope="row" class="mofr-trowhead">
        		            API Key
        		        </th>
        		        <td class="mofr-table-block">
        		            ' . esc_html( $api_key ) . '
        		        </td>
        		    </tr>
        		    <tr class="bg-slate-100 border-b dark:bg-gray-800 dark:border-gray-700">
        		        <th scope="row" class="mofr-trowhead">
        		            Token Key
        		        </th>
        		        <td class="mofr-table-block">
        		            ' . esc_html( $token ) . '
        		        </td>
        		    </tr>
        		</tbody>
    		</table>
		</div>
	</div>
';
