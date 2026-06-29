<?php


use OTP\Handler\Forms\SimplrRegistrationForm;
$C3 = SimplrRegistrationForm::instance();
$wX = $C3->isFormEnabled() ? "\143\150\x65\143\x6b\145\144" : '';
$Z2 = $wX == "\143\x68\145\143\153\145\144" ? '' : "\150\x69\x64\x64\x65\156";
$ki = $C3->getOtpTypeEnabled();
$kI = admin_url() . "\157\x70\x74\x69\157\156\x73\55\x67\145\x6e\145\x72\x61\154\x2e\160\x68\160\x3f\x70\141\x67\145\x3d\163\x69\155\x70\x6c\x72\x5f\162\x65\x67\137\x73\145\x74\46\x72\145\x67\166\151\x65\167\x3d\x66\151\145\x6c\144\x73\x26\x6f\162\x64\x65\x72\142\171\x3d\156\x61\155\x65\x26\x6f\x72\144\145\162\75\144\145\163\x63";
$VB = $C3->getPhoneKeyDetails();
$FK = $C3->getPhoneHTMLTag();
$Sq = $C3->getEmailHTMLTag();
$qs = $C3->getBothHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\x69\145\167\x73\x2f\x66\x6f\162\155\163\x2f\123\151\155\x70\154\x72\122\145\x67\x69\x73\x74\162\x61\164\151\157\x6e\x46\x6f\162\x6d\56\160\150\160";
