<?php


use OTP\Handler\Forms\UserProRegistrationForm;
$C3 = UserProRegistrationForm::instance();
$QL = $C3->isFormEnabled() ? "\x63\150\145\143\153\145\144" : '';
$VF = $QL == "\x63\150\x65\143\x6b\x65\x64" ? '' : "\150\151\144\144\x65\x6e";
$Qh = $C3->getOtpTypeEnabled();
$RW = admin_url() . "\x61\x64\155\151\x6e\56\160\150\x70\77\x70\141\147\145\75\x75\x73\145\162\x70\162\x6f\46\x74\x61\142\x3d\146\151\145\x6c\144\x73";
$CI = $C3->disableAutoActivation() ? "\143\x68\x65\x63\153\145\x64" : '';
$cU = $C3->getPhoneHTMLTag();
$N9 = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\x73\x2f\146\x6f\162\x6d\x73\57\x55\x73\x65\x72\120\162\x6f\x52\145\147\151\163\x74\x72\x61\x74\x69\157\156\106\x6f\162\x6d\56\x70\150\x70";
