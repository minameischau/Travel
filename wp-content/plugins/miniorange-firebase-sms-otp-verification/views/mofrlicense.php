<?php
/**
 * Load admin view for liscensing tab.
 *
 * @package minorange-firebase-sms-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use MoOTP\Helper\MoMessages;

echo '<div id="licensing" class="bg-slate-50 box tabcontent h-full" >
    <div class="h-68px p-top px-mofr-4 border-b" >
        <p class="flex"><strong style="font-size: 1rem;gap: 0.5rem;    display: inline-flex;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <g id="d4a43e0162b45f718f49244b403ea8f4">
                                        <g id="4ea4c3dca364b4cff4fba75ac98abb38">
                                            <g id="2413972edc07f152c2356073861cb269">
                                                <path id="2deabe5f8681ff270d3f37797985a977" d="M20.8007 20.5644H3.19925C2.94954 20.5644 2.73449 20.3887 2.68487 20.144L0.194867 7.94109C0.153118 7.73681 0.236091 7.52728 0.406503 7.40702C0.576651 7.28649 0.801941 7.27862 0.980492 7.38627L7.69847 11.4354L11.5297 3.72677C11.6177 3.54979 11.7978 3.43688 11.9955 3.43531C12.1817 3.43452 12.3749 3.54323 12.466 3.71889L16.4244 11.3598L23.0197 7.38654C23.1985 7.27888 23.4233 7.28702 23.5937 7.40728C23.7641 7.52754 23.8471 7.73707 23.8056 7.94136L21.3156 20.1443C21.2652 20.3887 21.0501 20.5644 20.8007 20.5644Z" fill="black"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>Features & Pricing</strong></p>
    </div>    
  <div class="p-4">
    <div class="flex flex-wrap">
      <div class="w-1/2">
        <div class="h-max mofr-content-wrapper flex-col rounded-smooth">
          <h3 class="mb-0.5 font-heading font-bold text-ex-lg justify-center text-gray-900">Free</h3>
          <div class="p-4 text-xs font-normal rounded-smooth bg-blue-50 border-b py-mofr-4 px-mofr-4" role="alert">
            To utilize the free plugin, simply click here to access the Firebase console where you can configure your Firebase app: 
              <i><u><a target="_blank" href="https://console.firebase.google.com/" class="text-xs font-bold bg-blue-50 text-green-800" > Firebase console</a></u></i>
          </div>
          <ul>                         
            <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <g id="121bb4fcd7d9ecd609461239dd2e48b4">
                    <path id="0561649782827908dc63f2bd29021113" d="M5 13L8.52642 15.8211C9.35374 16.483 10.5536 16.3848 11.2624 15.5973L19 7" stroke="#00CDA8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <p>OTP Verification on MiniOrange Login/Registration Form</p>
            </li>

            <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <g id="121bb4fcd7d9ecd609461239dd2e48b4">
                    <path id="0561649782827908dc63f2bd29021113" d="M5 13L8.52642 15.8211C9.35374 16.483 10.5536 16.3848 11.2624 15.5973L19 7" stroke="#00CDA8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <p>Country Code Dropdown</p>
            </li>

            <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <g id="45b801790239018d0b79ae1c7cb28ffc">
                    <path id="0433d8134fba447a7695df8550801262" d="M16.9999 7.00006L7 17M16.9999 16.9999L7 7" stroke="#FF6E6E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </g>
                </svg>
                <p>Allow admin to decide role of the user.</p>
            </li>

            <li class="flex flex-row gap-mofr-2 items-center py-mofr-4py-mofr-2 text-sm">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <g id="45b801790239018d0b79ae1c7cb28ffc">
                    <path id="0433d8134fba447a7695df8550801262" d="M16.9999 7.00006L7 17M16.9999 16.9999L7 7" stroke="#FF6E6E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </g>
                </svg>
                <p>Allow admin to set up custom redirection after login/ Registration.</p>
            </li>

            <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <g id="45b801790239018d0b79ae1c7cb28ffc">
                    <path id="0433d8134fba447a7695df8550801262" d="M16.9999 7.00006L7 17M16.9999 16.9999L7 7" stroke="#FF6E6E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </g>
                </svg>
                <p>OTP Verification on the default WooCommerce Login/Registration Form.</p>
            </li>

            <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <g id="45b801790239018d0b79ae1c7cb28ffc">
                    <path id="0433d8134fba447a7695df8550801262" d="M16.9999 7.00006L7 17M16.9999 16.9999L7 7" stroke="#FF6E6E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </g>
                </svg>
                  <p>OTP Verification on the WooCommerce Checkout Form.</p>
                </li>

                <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <g id="45b801790239018d0b79ae1c7cb28ffc">
                    <path id="0433d8134fba447a7695df8550801262" d="M16.9999 7.00006L7 17M16.9999 16.9999L7 7" stroke="#FF6E6E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </g>
                </svg>
                  <p>OTP Verification on the Gravity Form.</p>
                </li>

              <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <g id="45b801790239018d0b79ae1c7cb28ffc">
                    <path id="0433d8134fba447a7695df8550801262" d="M16.9999 7.00006L7 17M16.9999 16.9999L7 7" stroke="#FF6E6E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </g>
                </svg>
              <p>OTP Verification on the Ultimate Member Registration Form.</p>
            </li>

            <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <g id="45b801790239018d0b79ae1c7cb28ffc">
                    <path id="0433d8134fba447a7695df8550801262" d="M16.9999 7.00006L7 17M16.9999 16.9999L7 7" stroke="#FF6E6E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </g>
                </svg>
                <p>Replace the default WooCommerce Login/Registration Form with the MiniOrange Login/Registration Form.</p>
            </li>
                    
          </ul>
        </div>
      </div>


      <div class="h-max mofr-content-wrapper w-1/2 bg-black text-white flex-col rounded-smooth">    
          <h3 class="mb-0.5 font-heading font-bold text-ex-lg justify-center text-white">Premium Plan ($49)</h3>
          <div class="flex flex-wrap gap-mofr-4">
              <div class="w-1/2 flex-col rounded-smooth">
                <a target="_blank" href="https://dev-miniorange-firebase.pantheonsite.io/my-account/" class="flex flex-row items-center justify-center gap-mofr-3 h-[50px] px-mofr-6 rounded-md font-bold text-center bg-indigo-500 hover:bg-indigo-600 text-white text-l">Free Demo</a>
              </div>
              <div class="w-1/2 flex-col rounded-smooth">
                <a target="_blank" href="https://login.xecurify.com/moas/login?redirectUrl=https://login.xecurify.com/moas/initializepayment&requestOrigin=wp_email_verification_intranet_firebase_otp_plan" class="flex flex-row items-center justify-center gap-mofr-3 h-[50px] px-mofr-6 rounded-md font-bold text-center bg-indigo-500 hover:bg-indigo-600 text-white text-l">Upgrade Now</a>
              </div>
          </div>
            <ul>
                <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <g id="121bb4fcd7d9ecd609461239dd2e48b4">
                        <path id="0561649782827908dc63f2bd29021113" d="M5 13L8.52642 15.8211C9.35374 16.483 10.5536 16.3848 11.2624 15.5973L19 7" stroke="#00CDA8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      </g>
                    </svg>
                    <p>OTP Verification on MiniOrange Login/Registration Form</p>
                </li>

                <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <g id="121bb4fcd7d9ecd609461239dd2e48b4">
                    <path id="0561649782827908dc63f2bd29021113" d="M5 13L8.52642 15.8211C9.35374 16.483 10.5536 16.3848 11.2624 15.5973L19 7" stroke="#00CDA8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <p>Country Code Dropdown</p>
                </li>

                <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <g id="121bb4fcd7d9ecd609461239dd2e48b4">
                        <path id="0561649782827908dc63f2bd29021113" d="M5 13L8.52642 15.8211C9.35374 16.483 10.5536 16.3848 11.2624 15.5973L19 7" stroke="#00CDA8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      </g>
                    </svg>
                  <p>Allow admin to decide role of the user.</p>
                </li>

                <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <g id="121bb4fcd7d9ecd609461239dd2e48b4">
                        <path id="0561649782827908dc63f2bd29021113" d="M5 13L8.52642 15.8211C9.35374 16.483 10.5536 16.3848 11.2624 15.5973L19 7" stroke="#00CDA8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      </g>
                    </svg>
                  <p>Allow admin to set up custom redirection after login/ Registration.</p>
                </li>

                <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <g id="121bb4fcd7d9ecd609461239dd2e48b4">
                        <path id="0561649782827908dc63f2bd29021113" d="M5 13L8.52642 15.8211C9.35374 16.483 10.5536 16.3848 11.2624 15.5973L19 7" stroke="#00CDA8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      </g>
                    </svg>
                  <p>OTP Verification on the default WooCommerce Login/Registration Form.</p>
                </li>

                <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <g id="121bb4fcd7d9ecd609461239dd2e48b4">
                        <path id="0561649782827908dc63f2bd29021113" d="M5 13L8.52642 15.8211C9.35374 16.483 10.5536 16.3848 11.2624 15.5973L19 7" stroke="#00CDA8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      </g>
                    </svg>
                  <p>OTP Verification on the WooCommerce Checkout Form.</p>
                </li>

                <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <g id="121bb4fcd7d9ecd609461239dd2e48b4">
                        <path id="0561649782827908dc63f2bd29021113" d="M5 13L8.52642 15.8211C9.35374 16.483 10.5536 16.3848 11.2624 15.5973L19 7" stroke="#00CDA8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      </g>
                    </svg>
                  <p>OTP Verification on the Gravity Form.</p>
                </li>

                <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <g id="121bb4fcd7d9ecd609461239dd2e48b4">
                        <path id="0561649782827908dc63f2bd29021113" d="M5 13L8.52642 15.8211C9.35374 16.483 10.5536 16.3848 11.2624 15.5973L19 7" stroke="#00CDA8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      </g>
                    </svg>
                  <p>OTP Verification on the Ultimate Member Registration Form.</p>
                </li>

                <li class="flex flex-row gap-mofr-2 items-center py-mofr-2 text-sm">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <g id="121bb4fcd7d9ecd609461239dd2e48b4">
                        <path id="0561649782827908dc63f2bd29021113" d="M5 13L8.52642 15.8211C9.35374 16.483 10.5536 16.3848 11.2624 15.5973L19 7" stroke="#00CDA8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      </g>
                    </svg>
                <p>Replace the default WooCommerce Login/Registration Form with the MiniOrange Login/Registration Form.</p>
                </li>
            </ul>
      </div>
    </div>
  </div></div>';
