<?php


use OTP\Handler\Forms\DefaultWordPressRegistrationForm;
$C3 = DefaultWordPressRegistrationForm::instance();
$HT = (bool) $C3->isFormEnabled() ? "\143\150\x65\x63\153\145\x64" : '';
$Kt = $HT == "\143\x68\x65\143\x6b\145\144" ? '' : "\x68\x69\144\144\145\156";
$o5 = $C3->getOtpTypeEnabled();
$ya = (bool) $C3->restrictDuplicates() ? "\x63\x68\145\x63\x6b\145\x64" : '';
$KK = $C3->getPhoneHTMLTag();
$yl = $C3->getEmailHTMLTag();
$Mj = $C3->getBothHTMLTag();
$re = $C3->getFormName();
$nZ = $C3->disableAutoActivation() ? '' : "\x63\x68\145\143\153\145\144";
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\x77\163\x2f\x66\157\x72\x6d\163\57\104\x65\146\x61\165\x6c\164\x57\157\x72\144\120\162\145\x73\163\122\145\147\x69\x73\164\162\x61\x74\151\x6f\156\106\x6f\162\155\x2e\160\150\x70";
