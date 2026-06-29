<?php


use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Handler\Forms\YourOwnForm;
$C3 = YourOwnForm::instance();
$WA = (bool) $C3->isFormEnabled() ? "\143\x68\145\x63\x6b\145\x64" : '';
$tw = $WA == "\x63\150\x65\143\153\145\144" ? '' : "\x68\x69\144\144\x65\156";
$g4 = $C3->getOtpTypeEnabled();
$EA = admin_url() . "\141\144\x6d\x69\156\56\160\150\160\x3f\x70\x61\x67\x65\x3d\143\x75\x73\164\x6f\155\137\146\x6f\x72\x6d";
$TH = $C3->getEmailKeyDetails();
$Nk = $C3->getPhoneHTMLTag();
$M5 = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
$jK = $C3->getButtonText();
$o8 = $C3->getSubmitKeyDetails();
$Kg = $C3->getFieldKeyDetails();
include MOV_DIR . "\166\x69\145\x77\x73\x2f\146\157\x72\x6d\163\x2f\131\157\165\x72\x4f\x77\156\106\157\162\155\56\160\150\160";
