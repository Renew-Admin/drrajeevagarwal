<?php


use OTP\Handler\Forms\RealesWPTheme;
$C3 = RealesWPTheme::instance();
$W3 = $C3->isFormEnabled() ? "\143\150\x65\143\153\x65\x64" : '';
$MG = $W3 == "\x63\x68\x65\x63\153\x65\x64" ? '' : "\150\151\144\x64\x65\x6e";
$tz = $C3->getOtpTypeEnabled();
$UR = $C3->getPhoneHTMLTag();
$mN = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\x77\163\57\146\x6f\x72\155\163\x2f\x52\145\x61\154\x65\x73\x57\120\x54\x68\145\x6d\145\56\x70\150\x70";
