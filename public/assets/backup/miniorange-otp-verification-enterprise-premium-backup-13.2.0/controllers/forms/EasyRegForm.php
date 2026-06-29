<?php


use OTP\Handler\Forms\EasyRegForm;
$C3 = EasyRegForm::instance();
$Hh = (bool) $C3->isFormEnabled() ? "\143\x68\x65\143\x6b\x65\144" : '';
$S_ = $Hh == "\143\x68\x65\143\153\145\144" ? '' : "\x68\151\x64\x64\x65\x6e";
$k7 = $C3->getOtpTypeEnabled();
$d2 = $C3->getFormDetails();
$fl = admin_url() . "\141\144\155\151\156\56\x70\150\x70\77\x70\141\x67\x65\x3d\x65\x72\x66\x6f\162\x6d\x73\55\157\166\x65\x72\x76\x69\x65\167";
$jK = $C3->getButtonText();
$yv = $C3->getPhoneHTMLTag();
$Ca = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\163\x2f\x66\157\162\x6d\x73\57\x45\141\163\171\122\145\x67\x46\157\162\155\x2e\x70\150\160";
