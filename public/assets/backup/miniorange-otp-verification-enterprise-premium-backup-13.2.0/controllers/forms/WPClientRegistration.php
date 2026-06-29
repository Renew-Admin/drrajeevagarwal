<?php


use OTP\Handler\Forms\WPClientRegistration;
$C3 = WPClientRegistration::instance();
$WG = $C3->isFormEnabled() ? "\x63\150\x65\x63\153\x65\144" : '';
$qM = $WG == "\143\150\145\143\153\145\x64" ? '' : "\x68\x69\144\144\145\156";
$Nw = $C3->getOtpTypeEnabled();
$oG = $C3->getPhoneHTMLTag();
$u6 = $C3->getEmailHTMLTag();
$NV = $C3->getBothHTMLTag();
$re = $C3->getFormName();
$Gw = $C3->restrictDuplicates() ? "\143\150\x65\x63\153\x65\144" : '';
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\x69\x65\167\x73\x2f\146\x6f\x72\x6d\163\57\127\120\103\x6c\x69\145\156\164\122\x65\x67\151\x73\164\x72\x61\x74\x69\157\156\56\160\150\160";
