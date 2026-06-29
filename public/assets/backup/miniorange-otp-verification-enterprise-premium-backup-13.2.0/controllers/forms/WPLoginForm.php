<?php


use OTP\Handler\Forms\WPLoginForm;
$C3 = WPLoginForm::instance();
$JN = (bool) $C3->isFormEnabled() ? "\143\x68\145\143\153\145\x64" : '';
$P2 = $JN == "\x63\x68\145\143\x6b\145\x64" ? '' : "\150\x69\x64\x64\145\156";
$bq = (bool) $C3->savePhoneNumbers() ? "\x63\150\145\x63\153\145\x64" : '';
$KX = $C3->getPhoneKeyDetails();
$JK = (bool) $C3->byPassCheckForAdmins() ? "\143\150\145\143\x6b\x65\x64" : '';
$Rf = (bool) $C3->allowLoginThroughPhone() ? "\143\150\x65\143\x6b\x65\x64" : '';
$Eu = (bool) $C3->restrictDuplicates() ? "\x63\x68\145\x63\153\x65\144" : '';
$pp = $C3->getOtpTypeEnabled();
$Ml = $C3->getPhoneHTMLTag();
$HX = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
$vn = $C3->getSkipPasswordCheck() ? "\x63\150\145\x63\x6b\145\x64" : '';
$wN = $C3->getSkipPasswordCheck() ? "\x62\154\157\x63\x6b" : "\x68\151\x64\x64\145\x6e";
$WE = $C3->getSkipPasswordCheckFallback() ? "\143\x68\145\x63\x6b\x65\x64" : '';
$Mo = $C3->getUserLabel();
$ua = $C3->isDelayOtp() ? "\x63\x68\145\143\x6b\x65\144" : '';
$td = $C3->isDelayOtp() ? "\142\x6c\157\143\153" : "\150\x69\144\144\145\156";
$G1 = $C3->getDelayOtpInterval();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\151\145\167\x73\57\x66\x6f\x72\x6d\x73\x2f\127\x50\x4c\157\x67\x69\156\106\x6f\162\x6d\56\x70\x68\160";
