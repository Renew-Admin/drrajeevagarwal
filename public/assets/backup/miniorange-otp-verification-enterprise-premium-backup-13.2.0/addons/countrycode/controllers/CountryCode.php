<?php

use OTP\Addons\CountryCode\Handler\SelectedCountryCode;
use OTP\Handler\MoOTPActionHandlerHandler;

$handler                       = SelectedCountryCode::instance();
$adminHandler                  = MoOTPActionHandlerHandler::instance();
$sc_type                       = $handler->getScType();
$sc_enabled 			       = $handler->getIsEnabled();
$sc_block                      = $handler->getIsBlockCountryEnabled();
$nonce                         = $adminHandler->getNonceValue();
$otp_selected_countries_list   = $handler->getIsCountryAllowed();
$otp_block_selected_countries_list   = $handler->getIsCountryblocked();
$nonce                         = $adminHandler->getNonceValue();

include SC_DIR . 'views/CountryCode.php';