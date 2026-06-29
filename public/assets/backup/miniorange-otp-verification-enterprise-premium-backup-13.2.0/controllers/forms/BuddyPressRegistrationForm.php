<?php


use OTP\Handler\Forms\BuddyPressRegistrationForm;
$C3 = BuddyPressRegistrationForm::instance();
$sz = $C3->isFormEnabled() ? "\x63\x68\x65\x63\x6b\145\x64" : '';
$jG = $sz == "\x63\150\145\143\x6b\x65\144" ? '' : "\150\151\x64\144\145\x6e";
$MX = $C3->getOtpTypeEnabled();
$C_ = admin_url() . "\165\x73\x65\162\163\x2e\160\x68\160\x3f\160\141\147\145\x3d\x62\160\55\x70\x72\157\146\x69\154\145\x2d\x73\x65\x74\x75\160";
$pz = $C3->getPhoneKeyDetails();
$sp = $C3->disableAutoActivation() ? "\143\150\x65\x63\x6b\x65\x64" : '';
$qQ = $C3->getPhoneHTMLTag();
$cR = $C3->getEmailHTMLTag();
$MN = $C3->getBothHTMLTag();
$re = $C3->getFormName();
$Gw = $C3->restrictDuplicates() ? "\x63\x68\145\143\x6b\145\x64" : '';
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\x69\x65\x77\x73\57\x66\x6f\162\x6d\x73\x2f\102\165\144\x64\171\x50\x72\145\163\163\x52\x65\147\151\163\x74\x72\141\x74\x69\x6f\156\106\157\x72\155\x2e\x70\150\160";
