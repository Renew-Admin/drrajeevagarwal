<?php


use OTP\Handler\Forms\Edumalog;
$C3 = Edumalog::instance();
$C2 = $C3->isFormEnabled() ? "\x63\x68\x65\143\153\x65\x64" : '';
$Xq = $C2 == "\x63\x68\145\143\153\145\x64" ? '' : "\x68\151\144\x64\145\156";
$H1 = $C3->getOtpTypeEnabled();
$ZS = $C3->getPhoneHTMLTag();
$H0 = $C3->getEmailHTMLTag();
$MH = $C3->getPhoneKeyDetails();
$re = $C3->getFormName();
$Eo = $C3->byPassCheckForAdmins() ? "\143\x68\x65\143\x6b\x65\144" : '';
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\151\x65\x77\163\57\x66\x6f\162\155\x73\x2f\x45\144\165\x6d\141\154\157\147\x2e\160\x68\160";
