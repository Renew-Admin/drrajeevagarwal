<?php


use OTP\Handler\Forms\WpMemberForm;
$C3 = WpMemberForm::instance();
$yK = (bool) $C3->isFormEnabled() ? "\143\150\145\x63\x6b\145\x64" : '';
$Ot = $yK == "\x63\x68\145\143\x6b\145\x64" ? '' : "\150\151\x64\x64\x65\x6e";
$jf = $C3->getOtpTypeEnabled();
$Ht = admin_url() . "\141\144\155\151\x6e\56\x70\x68\x70\x3f\x70\x61\147\145\75\167\160\x6d\145\155\x2d\x73\x65\164\x74\x69\156\x67\163\46\x74\x61\142\x3d\x66\151\x65\154\144\163";
$gT = $C3->getPhoneHTMLTag();
$LI = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
$T1 = $C3->getPhoneKeyDetails();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\x73\x2f\x66\x6f\x72\155\x73\57\x57\160\115\x65\x6d\142\x65\x72\x46\x6f\x72\x6d\x2e\160\150\x70";
