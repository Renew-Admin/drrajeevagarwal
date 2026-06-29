<?php


use OTP\Handler\Forms\ProfileBuilderRegistrationForm;
$C3 = ProfileBuilderRegistrationForm::instance();
$oH = $C3->isFormEnabled() ? "\x63\150\145\x63\x6b\145\x64" : '';
$TZ = $oH == "\x63\x68\145\x63\x6b\145\x64" ? '' : "\150\151\144\144\x65\156";
$Y7 = $C3->getOtpTypeEnabled();
$hA = $C3->getPhoneKeyDetails();
$eV = admin_url() . "\x61\144\x6d\151\156\56\160\150\x70\x3f\x70\x61\147\145\x3d\155\x61\156\x61\147\145\55\146\151\145\x6c\144\163";
$Z5 = $C3->getPhoneHTMLTag();
$Yr = $C3->getEmailHTMLTag();
$S6 = $C3->getBothHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\163\x2f\146\157\x72\155\163\57\120\x72\157\x66\151\x6c\145\x42\x75\151\x6c\x64\145\162\122\x65\147\151\x73\x74\162\141\164\x69\157\x6e\x46\x6f\162\155\x2e\160\x68\x70";
