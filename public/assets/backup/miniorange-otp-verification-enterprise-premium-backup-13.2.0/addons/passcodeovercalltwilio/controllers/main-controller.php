<?php

use OTP\Addons\PasscodeOverCalltwilio\Handler\OTPOverVoice;

$registerd 		= OTPOverVoice::instance()->moAddOnV();
	$disabled  	 	= !$registerd ? "disabled" : "";
	$controller 	= MOC_DIR . 'controllers/';
    $addon          = add_query_arg( array('page' => 'addon'), remove_query_arg('addon',$_SERVER['REQUEST_URI']));

	if(isset( $_GET[ 'addon' ]))
	{
		switch($_GET['addon'])
		{
			case 'mo_otp_over_call':
				include $controller . 'otp-over-voice.php'; break;
		}
	}