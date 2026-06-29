<?php


use OTP\Handler\Forms\PaidMembershipForm;
$C3 = PaidMembershipForm::instance();
$zg = $C3->isFormEnabled() ? "\143\150\145\143\x6b\x65\x64" : '';
$nz = $zg == "\143\x68\x65\x63\x6b\x65\144" ? '' : "\150\151\x64\x64\145\x6e";
$PE = $C3->getOtpTypeEnabled();
$IT = $C3->getPhoneHTMLTag();
$Gu = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\x77\163\57\x66\x6f\x72\x6d\x73\57\120\141\x69\x64\115\145\155\142\145\162\x73\150\151\x70\x46\157\x72\155\56\x70\150\160";
