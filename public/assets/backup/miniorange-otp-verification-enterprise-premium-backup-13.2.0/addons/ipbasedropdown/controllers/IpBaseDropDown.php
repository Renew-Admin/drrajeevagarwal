<?php

use OTP\Addons\ipbasedropdown\Handler\EnableIpBaseCountryCode;
use OTP\Handler\MoOTPActionHandlerHandler;


$handler                       = EnableIpBaseCountryCode::instance();

$adminHandler                  = MoOTPActionHandlerHandler::instance();
$ipbase_enabled 			   = $handler->getIsIpbaseAddonEnabled() ? "checked" : "";
// $sc_hidden 			           = $ipbase_enabled=="checked" ? "" : "hidden";
$nonce                         = $adminHandler->getNonceValue();
// $otp_selected_countries_list   = $handler->getIsCountryAllowed();
$nonce                         = $adminHandler->getNonceValue();


include IBC_DIR . 'views/IpBaseDropDown.php';