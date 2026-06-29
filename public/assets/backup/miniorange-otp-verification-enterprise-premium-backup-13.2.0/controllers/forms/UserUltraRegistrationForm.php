<?php


use OTP\Handler\Forms\UserUltraRegistrationForm;
$C3 = UserUltraRegistrationForm::instance();
$Jt = $C3->isFormEnabled() ? "\143\x68\x65\143\x6b\x65\144" : '';
$wi = $Jt == "\143\x68\145\143\x6b\x65\x64" ? '' : "\x68\151\x64\144\145\x6e";
$as = $C3->getOtpTypeEnabled();
$VE = admin_url() . "\x61\144\155\151\156\x2e\160\x68\x70\77\x70\x61\x67\145\75\x75\163\x65\x72\x75\x6c\164\162\x61\x26\x74\x61\x62\75\x66\151\x65\x6c\x64\x73";
$g0 = $C3->getPhoneKeyDetails();
$A3 = $C3->getPhoneHTMLTag();
$ye = $C3->getEmailHTMLTag();
$qo = $C3->getBothHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\x69\x65\x77\x73\57\146\x6f\162\155\x73\57\x55\x73\x65\162\125\x6c\164\x72\x61\x52\x65\x67\x69\163\x74\x72\x61\x74\151\157\156\106\x6f\162\x6d\56\160\x68\160";
