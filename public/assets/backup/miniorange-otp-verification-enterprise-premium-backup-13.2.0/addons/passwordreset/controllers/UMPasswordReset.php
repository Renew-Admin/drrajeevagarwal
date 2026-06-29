<?php


use OTP\Addons\PasswordReset\Handler\UMPasswordResetHandler;
use OTP\Handler\MoOTPActionHandlerHandler;
$C3 = UMPasswordResetHandler::instance();
$Zf = MoOTPActionHandlerHandler::instance();
$XV = $C3->isFormEnabled() ? "\x63\x68\x65\143\x6b\x65\144" : '';
$D_ = $XV == "\x63\x68\x65\143\153\145\x64" ? '' : "\150\151\x64\144\x65\x6e";
$Gc = $C3->getOtpTypeEnabled();
$Ic = $C3->getPhoneHTMLTag();
$uQ = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
$d4 = $C3->getButtonText();
$fQ = $Zf->getNonceValue();
$Dj = $C3->getFormOption();
$i0 = $C3->getPhoneKeyDetails();
$lq = $C3->getIsOnlyPhoneReset() ? "\x63\150\x65\x63\153\x65\144" : '';
include UMPR_DIR . "\x76\151\145\167\163\57\x55\x4d\120\x61\163\x73\167\x6f\x72\x64\122\x65\x73\145\164\x2e\x70\150\x70";
