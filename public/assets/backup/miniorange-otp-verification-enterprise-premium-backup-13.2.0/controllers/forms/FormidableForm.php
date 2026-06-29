<?php


use OTP\Handler\Forms\FormidableForm;
$C3 = FormidableForm::instance();
$T8 = $C3->isFormEnabled() ? "\x63\x68\145\143\x6b\145\x64" : '';
$X5 = $T8 == "\143\150\145\143\153\145\x64" ? '' : "\x68\x69\144\x64\x65\156";
$X9 = $C3->getOtpTypeEnabled();
$I2 = admin_url() . "\141\x64\x6d\x69\156\x2e\160\150\x70\77\160\141\x67\145\x3d\146\157\162\x6d\x69\x64\141\x62\154\x65";
$s4 = $C3->getFormDetails();
$ox = $C3->getPhoneHTMLTag();
$Ui = $C3->getEmailHTMLTag();
$jK = $C3->getButtonText();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\x69\145\x77\x73\x2f\x66\x6f\x72\155\163\x2f\106\157\162\x6d\151\144\x61\x62\154\145\106\157\x72\155\x2e\160\x68\160";
