<?php


echo'   <div class="mo_registration_divided_layout mo-otp-full">
            <div class="mo_registration_table_layout mo-otp-center">';


echo'           <table style="width:100%">
                    <form name="f" method="post" action="" id="ipbase_countries_settings">
                        <input type="hidden" id="error_message" name="error_message" value="">
                        <input type="hidden" name ="option" value="mo_ipbase_countrycode_value" />';

                        wp_nonce_field($nonce);

echo'                       <tr>
                                <td>
                                    <h2>'.mo_("IP BASED COUNTRY CODE SETTINGS").'
                                        <span style="float:right;margin-top:-10px;">
                                            <a  href="'.esc_attr($addon).'" 
                                                id="goBack" 
                                                class="button button-primary button-large">
                                                '.mo_("Go Back").'
                                            </a>
                                            <input  type="submit" 
                                                    name="save" 
                                                    id="save" '.esc_attr($disabled).' 
                                                    class="button button-primary button-large" 
                                                    value="'.mo_('Save Settings').'">
                                        </span>
                                    </h2>
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td>'.mo_("Enable Ip Based Country Code Addon.").'</td>
                            </tr>
                             <tr>
                                <table cellspacing="0" style="width:100%">
                                    <tr>
                                        <td>
                                            <div class="mo_otp_form" style="text-align: left;">
                                                <input  type="checkbox" '.esc_attr($disabled).' 
                                                        id="ipbase_country_code" 
                                                        value="1"
                                                        data-toggle="blocked_country_settings" 
                                                        class="app_enable" '.esc_attr($ipbase_enabled).' 
                                                        name="mo_customer_validation_ipbase_enable" />
                                                <strong>'.mo_("Enable this checkbox to show Geolocation/Ip Based Country Code dropdown.").'</strong>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </tr>    
                        </form> 
                    </table>
                </div>
            </div>';