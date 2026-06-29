<?php

use OTP\Addons\passwordresetwc\Handler\WCPasswordResetHandler;
use OTP\Handler\MoOTPActionHandlerHandler;

// WooCommerce registration form
/** @var WCPasswordResetHandler $handler */
$handler                    = WCPasswordResetHandler::instance();
/** @var MoOTPActionHandlerHandler $adminHandler */
$adminHandler               = MoOTPActionHandlerHandler::instance();
$wcpr_enabled 			    = $handler->isFormEnabled() ? "checked" : "";
$wcpr_hidden 			    = $wcpr_enabled=="checked" ? "" : "hidden";
$wcpr_enabled_type		    = $handler->getOtpTypeEnabled();
$wcpr_type_phone	 	    = $handler->getPhoneHTMLTag();
$wcpr_type_email	 		= $handler->getEmailHTMLTag();
$form_name                  = $handler->getFormName();
$wcpr_button_text           = $handler->getButtonText();
$nonce                      = $adminHandler->getNonceValue();
$formOption                 = $handler->getFormOption();
$wcpr_field_key             = $handler->getPhoneKeyDetails();
$wcpr_only_phone            = $handler->getIsOnlyPhoneReset() ? "checked" : "";

if ($wcpr_enabled_type==$wcpr_type_email) {
	$wcpr_only_phone="";
	update_wcpr_option('only_phone_reset',$wcpr_only_phone);
}

include WCPR_DIR . 'views/WCPasswordReset.php';