<?php


use OTP\Handler\Forms\Edumareg;
$C3 = Edumareg::instance();
$um = $C3->isFormEnabled() ? "\x63\150\145\143\153\x65\144" : '';
$vx = $um == "\x63\x68\x65\x63\153\x65\x64" ? '' : "\150\151\144\x64\145\156";
$pg = $C3->getOtpTypeEnabled();
$Ea = $C3->getPhoneHTMLTag();
$lP = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\151\x65\x77\163\x2f\x66\157\162\155\163\57\105\144\165\155\141\162\145\x67\x2e\160\x68\160";
