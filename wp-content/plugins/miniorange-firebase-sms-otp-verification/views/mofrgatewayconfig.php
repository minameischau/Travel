<?php
/**
 * Load admin view for gateway configuration tab.
 *
 * @package minorange-firebase-sms-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use MoOTP\Helper\MoMessages;

echo '<div>
        <form name="f" method="post" action="" id="mo_firebase_gateway_settings">
            <div class="mofr-section-header">
                <p class="grow mofr-heading">Gateway Configuration Settings</p>
                <input  type="submit" ' . esc_attr( $disabled ) . ' name="mo_firebase_registration_form_save" id="mo_firebase_registration_form_save"  class="mofr-button primary"
                value="' . esc_attr( mofr_( 'Save Settings' ) ) . '">
            </div>    
            <input type="hidden" name="option" value="mo_firebase_gateway_deatils_save_option" />
            <div class="mofr-content-wrapper">
                <div class="w-1/2 flex flex-col gap-mofr-8"> 
                    <div class="relative w-full group">
                        <label for="mo_firebase_gateway_apiKey" class="mofr-input-label">API Key</label>
                        <input type="text" ' . esc_attr( $disabled ) . ' id="mo_firebase_gateway_apiKey" class="w-full w-full mofr-input" name="mo_firebase_gateway_apiKey" placeholder="" value="' . esc_attr( get_mofr_option( 'gateway_apiKey' ) ) . '" required="">
                    </div>
                    <div class="w-full mofr-input-wrapper group" style="display:none;">
                        <label for="mo_firebase_gateway_authdomain" class="mofr-input-label">Auth Domain</label>
                        <input type="text" ' . esc_attr( $disabled ) . ' id="mo_firebase_gateway_authdomain" class="peer w-full w-full mofr-input" name="mo_firebase_gateway_authdomain" placeholder="" value="gateway_authdomain" required=""> 
                    </div>
                    <div class="w-full mofr-input-wrapper group group" style="display:none;">
                        <label for="mo_firebase_gateway_databaseurl" class="mofr-input-label">Database URL</label>
                        <input type="text" ' . esc_attr( $disabled ) . ' id="mo_firebase_gateway_databaseurl" class="w-full w-full mofr-input" name="mo_firebase_gateway_databaseurl" placeholder="" value="databaseUrl" required="">
                    </div>
                    <div class="w-full mofr-input-wrapper group" style="display:none;">
                        <label for="mo_firebase_gateway_projectid" class="mofr-input-label">Project ID</label>
                        <input type="text" ' . esc_attr( $disabled ) . ' id="mo_firebase_gateway_projectid" class="w-full mofr-input" name="mo_firebase_gateway_projectid" placeholder="" value="gateway_projectid" required="">
                    </div>
                    <div class="w-full mofr-input-wrapper group" style="display:none;">
                        <label for="mo_firebase_gateway_storagebucket" class="mofr-input-label">Storage Bucket</label>
                        <input type="text" ' . esc_attr( $disabled ) . ' id="mo_firebase_gateway_storagebucket" class="w-full mofr-input" name="mo_firebase_gateway_storagebucket" placeholder="" value="gateway_storagebucket" required="">
                    </div>

                    <div class="w-full mofr-input-wrapper group" style="display:none;">
                        <label for="mo_firebase_gateway_messagingsenderid" class="mofr-input-label">Messaging Sender ID</label>
                        <input type="text" ' . esc_attr( $disabled ) . ' id="mo_firebase_gateway_messagingsenderid" class="w-full mofr-input" name="mo_firebase_gateway_messagingsenderid" placeholder="" value="gateway_messagingsenderid" required="">              
                    </div>

                    <div class="w-full mofr-input-wrapper group" style="display:none;">
                        <label for="mo_firebase_gateway_appid" class="mofr-input-label">App ID</label>
                        <input type="text" ' . esc_attr( $disabled ) . ' id="mo_firebase_gateway_appid" class="w-full mofr-input" name="mo_firebase_gateway_appid" placeholder="" value="gateway_appid" required="">          
                    </div>
                    <input  type="submit" ' . esc_attr( $disabled ) . ' name="mo_firebase_registration_form_save" id="mo_firebase_registration_form_save"  class="mofr-button primary"
                    value="' . esc_attr( mofr_( 'Save Settings' ) ) . '">
                </div>

                <div class="h-max mofr-content-wrapper w-1/2 bg-yellow-50 flex-col rounded-smooth">
                <img class="w-[148px]" src=' . esc_url( MOFLR_FIREBASE_LOGO ) . '>
                    <div class="flex w-full gap-mofr-4">
                        <div class="mofr-step">1</div>
                        <p>Create/Open project on <u><b><a href="https://console.firebase.google.com/" target="blank" > firebase console</a></b></u></p>
                    </div>

                    <div class="flex w-full gap-mofr-4">
                        <div class="mofr-step">2</div>
                        <p>Go to project settings.</p>
                    </div>

                    <div class="flex w-full gap-mofr-4">
                        <div class="mofr-step">3</div>
                        <p>Scroll down on Project Settings page and add a Web App to your firebase.</p>
                    </div>

                    <div class="flex w-full gap-mofr-4">
                        <div class="mofr-step">4</div>
                        <p>Copy the configuration object to setup gateway.</p>
                    </div>

                    <div class="flex w-full gap-mofr-4">
                        <div class="mofr-step">5</div>
                        <p>Open the Authentication section from the side navigation bar.</p>
                    </div>

                    <div class="flex w-full gap-mofr-4">
                        <div class="mofr-step">6</div>
                        <p>Click on Sign-in Method tab & enable the Phone method</p>
                    </div>

                    <div class="flex w-full gap-mofr-4">
                        <div class="mofr-step">7</div>
                        <p>Ensure that your domain is listed in the Authorized Domains section</p>
                    </div>                  
                </div>
            </div>
        </form>
    </div>';
