<?php


use OTP\Handler\Forms\PieRegistrationForm;
$C3 = PieRegistrationForm::instance();
$NZ = $C3->isFormEnabled() ? "\143\x68\145\x63\153\x65\144" : '';
$eJ = $NZ == "\x63\x68\145\x63\x6b\145\144" ? '' : "\150\151\144\144\x65\x6e";
$YM = $C3->getOtpTypeEnabled();
$sK = $C3->getPhoneKeyDetails();
$TN = $C3->getPhoneHTMLTag();
$Q7 = $C3->getEmailHTMLTag();
$Mu = $C3->getBothHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\151\145\x77\x73\x2f\x66\157\162\155\x73\57\x50\151\x65\x52\x65\x67\151\x73\164\162\141\x74\x69\x6f\x6e\106\157\162\x6d\x2e\x70\x68\160";
