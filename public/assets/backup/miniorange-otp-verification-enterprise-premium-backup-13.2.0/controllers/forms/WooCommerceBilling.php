<?php


use OTP\Handler\Forms\WooCommerceBilling;
$C3 = WooCommerceBilling::instance();
$h0 = (bool) $C3->isFormEnabled() ? "\143\x68\x65\143\153\145\x64" : '';
$zV = $h0 == "\143\x68\145\143\153\145\144" ? '' : "\150\x69\x64\144\x65\x6e";
$pI = $C3->getOtpTypeEnabled();
$mW = $C3->getPhoneHTMLTag();
$X0 = $C3->getEmailHTMLTag();
$DX = (bool) $C3->restrictDuplicates() ? "\143\150\x65\143\153\x65\x64" : '';
$jK = $C3->getButtonText();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\151\x65\167\163\57\x66\157\x72\155\163\x2f\x57\157\x6f\x43\x6f\155\155\x65\x72\x63\x65\102\151\154\x6c\151\x6e\x67\x2e\x70\150\160";
