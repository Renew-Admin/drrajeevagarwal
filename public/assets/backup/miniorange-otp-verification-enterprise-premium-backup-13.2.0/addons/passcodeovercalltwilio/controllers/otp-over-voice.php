<?php

use \OTP\Addons\CustomMessage\Handler\CustomMessages;

$otp_over_call_enable = get_moc_option("moc_enabled") ? "checked" : ""; 
include MOC_DIR . 'views/mo-otp-over-voice.php';