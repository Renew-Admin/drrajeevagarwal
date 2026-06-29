<?php


echo'	<div class="mo_registration_divided_layout mo-otp-full">
            <div class="mo_registration_table_layout mo-otp-center">';


echo'		    <table style="width:100%">
                    <form name="f" method="post" action="" id="selected_countries_settings">
                        <input type="hidden" id="error_message" name="error_message" value="">
                        <input type="hidden" name ="option" value="mo_selected_countrycode_value" />';

                        wp_nonce_field($nonce);

echo'			            <tr>
                                <td>
                                    <h2>'.mo_("SELECTED COUNTRIES SETTINGS").'
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
                                <td>'.mo_("Enable or Disable Options for the Selected Countries Addon.").'</td>
                            </tr>
                             <tr>
                                <table cellspacing="0" style="width:100%">
                                    <tr>
                                        <td>
                                            <div class="mo_otp_form" style="text-align: left;">
                                                <input  type="radio" '.esc_attr($disabled).' 
                                                        id="selected_country_code" 
                                                        value="'.esc_attr($sc_enabled).'" '.( esc_attr($sc_type) == esc_attr($sc_enabled) ? "checked" : "").'
                                                        data-toggle="blocked_country_settings" 
                                                        class="app_enable" 
                                                        name="mo_customer_validation_sc_type" />
                                                <strong>'.mo_("Enable this radio to send OTPs to mentioned countries below.").'</strong>
                                                    <div class="mo_registration_help_desc"  '.( esc_attr($sc_type) !=  esc_attr($sc_enabled) ? "hidden" :"").'
                                                        id="blocked_country_settings">
                                                        <table style="width:100%">
                                                           <tr>
                                                             <td>';


                                                         $_all_country_list=get_sc_option('allcountrywithcountrycode');
                                                      echo     '
                                                         
                                                                     <select name="mo_country_dropdown" class="country_dropdown" id = "country_dropdown" >
                                                                      <option value="">----Select Your Country----</option> ';
                                                                     
                                                        foreach ($_all_country_list as $key => $value) {
                                                                echo '<option value='.esc_attr($value['countryCode']).'>'.esc_attr($value['name']).'</option>';
                                                                } 
                                                               echo ' </select> 

                                                           </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <textarea   name="mo_selected_country_numbers" id="mo_selected_country_numbers"
                                                                    rows="5" 
                                                                    placeholder="'.mo_("Select countries you want to show.").'">'.
                                                                    esc_attr($otp_selected_countries_list).
                                                                    '</textarea>
                                                                </td>
                                                            </tr>   
                                                        </table>
                                                     </div>


                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </tr>    
                            <tr>
                                <table cellspacing="0" style="width:100%">
                                    <tr>
                                        <td>
                                            <div class="mo_otp_form" style="text-align: left;">
                                                <input  type="radio" '.esc_attr($disabled).' 
                                                        id="block_selected_country_code" 
                                                            value="'.esc_attr($sc_block).'" '.( esc_attr($sc_type) == esc_attr($sc_block) ? "checked" : "").'
                                                        data-toggle="block_blocked_country_settings" 
                                                        class="app_enable"  
                                                        name="mo_customer_validation_sc_type" />
                                                <strong>'.mo_("Enable this radio to block OTPs to mentioned countries below.").'</strong>
                                                    <div class="mo_registration_help_desc"  '.(esc_attr($sc_type) != esc_attr($sc_block) ? "hidden" :"").' 
                                                        id="block_blocked_country_settings">
                                                        <table style="width:100%">
                                                             <tr>
                                                             <td>';


                                                         $_all_country_list=get_sc_option('allcountrywithcountrycode');
                                                      echo     '
                                                         
                                                                     <select name="mo_country_block_dropdown" class="country_block_dropdown" id = "country_block_dropdown" >
                                                                      <option value="">----Select Your Country----</option> ';
                                                                     
                                                        foreach ($_all_country_list as $key => $value) {
                                                                echo '<option value='.esc_attr($value['countryCode']).'>'.esc_attr($value['name']).'</option>';
                                                                } 
                                                               echo ' </select> 

                                                           </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <textarea   name="mo_block_selected_country_numbers" 
                                                                     id="mo_block_selected_country_numbers"
                                                                    rows="5" 
                                                                    placeholder="'.mo_("Select countries you want to block
                                                                        .").'">'.
                                                                    esc_attr($otp_block_selected_countries_list).
                                                                    '</textarea>
                                                                </td>
                                                            </tr>   
                                                        </table>
                                                     </div>

                                                     
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                            </tr>  
                            
                                
                        </form> 
                    </table>
                                
                </div>
            </div>

';