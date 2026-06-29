<?php


use OTP\Handler\Forms\WPFormsPlugin;
$C3 = WPFormsPlugin::instance();
$In = (bool) $C3->isFormEnabled() ? "\x63\150\145\x63\153\145\x64" : '';
$bT = $In == "\x63\x68\145\x63\153\145\x64" ? '' : "\x68\151\144\144\145\x6e";
$CU = $C3->getOtpTypeEnabled();
$j8 = $C3->getFormDetails();
$YT = admin_url() . "\141\x64\x6d\x69\156\x2e\x70\x68\x70\x3f\160\x61\147\x65\75\167\x70\146\x6f\162\155\x73\55\157\x76\145\x72\166\x69\x65\x77";
$jK = $C3->getButtonText();
$fU = $C3->getPhoneHTMLTag();
$yG = $C3->getEmailHTMLTag();
$ne = $C3->getBothHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\163\x2f\146\x6f\162\x6d\163\x2f\127\120\106\157\x72\x6d\x73\x50\x6c\165\x67\x69\x6e\x2e\160\150\x70";
