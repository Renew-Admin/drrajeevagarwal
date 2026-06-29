<?php


use OTP\Handler\Forms\MemberPressRegistrationForm;
$C3 = MemberPressRegistrationForm::instance();
$Uy = $C3->isFormEnabled() ? "\143\150\x65\x63\x6b\x65\x64" : '';
$N7 = $Uy == "\143\x68\145\143\x6b\145\144" ? '' : "\150\151\144\x64\145\x6e";
$e9 = $C3->getOtpTypeEnabled();
$UT = $C3->getPhoneKeyDetails();
$uq = admin_url() . "\x61\x64\155\x69\156\56\160\150\160\x3f\160\141\147\145\75\155\x65\x6d\x62\x65\162\x70\162\145\163\x73\x2d\x6f\160\x74\151\x6f\156\x73\x23\x6d\145\160\162\55\146\151\x65\154\144\163";
$tL = $C3->getPhoneHTMLTag();
$ep = $C3->getEmailHTMLTag();
$aR = $C3->getBothHTMLTag();
$re = $C3->getFormName();
$QP = $C3->bypassForLoggedInUsers() ? "\x63\150\x65\x63\153\x65\144" : '';
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\151\x65\x77\x73\x2f\146\157\162\155\x73\57\115\145\x6d\x62\145\162\x50\x72\145\x73\163\x52\x65\147\x69\163\x74\162\141\164\x69\157\x6e\x46\x6f\162\155\56\x70\150\x70";
