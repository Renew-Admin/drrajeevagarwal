<?php

use OTP\Addons\PasscodeOverCalltwilio\Helper\MoOtpOverCall;

echo'	<div class="mo_registration_divided_layout mo-otp-full">
				<div class="mo_registration_table_layout mo-otp-center">';

					MoOtpOverCall::is_addon_activated();

	echo'			<table style="width:100%">
						<form name="f" method="post" action="" id="mo_passcode_over_voice_settings">
							<input type="hidden" name="option" value="mo_passcode_over_voice_settings" />
							<tr>
								<td>
									<h2>'.mo_("miniOrange OTP Over Call").'
                                        <span style="float:right;margin-top:-10px;">
                                            <a href="'.$addon.'" id="goBack" class="button button-primary button-large">'.mo_("Go Back").'</a>
                                            <input  type="submit" 
                                                    name="save" 
                                                    id="save" '.$disabled.' 
                                                    class="button button-primary button-large" 
                                                    value="'.mo_('Save Settings').'">
                                        </span>
									</h2>
									
								</td>
								<td>
							</tr>
							<tr>
								<td>'.mo_("OTP Over Call can be activated after checking below option. Click on it to configure it.").'</td>
							</tr>
							<tr>
								<table class="moc-table-list" cellspacing="0">
								<hr><br>
									<tbody>
									<div class="mo_otp_over_call_form" style="text-align: left;">
                                                <input  type="checkbox" '.$disabled.' 
                                                        id="mo_otp_over_call_enable" 
                                                        value="1"
                                                        class="app_enable" '.$otp_over_call_enable.' 
                                                        name="mo_customer_validation_otp_over_call" />
                                                <strong>'.mo_("Enable OTP over Call Verification").'</strong>
                                                <br><br>
                                                </div>
									';


	echo '							</tbody>
								</table>
							</tr>
						</form>	
					</table>
				</div>
			</div>';