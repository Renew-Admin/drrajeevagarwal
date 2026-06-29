<?php


use OTP\Handler\Forms\EverestContactForm;
$C3 = EverestContactForm::instance();
$Pv = (bool) $C3->isFormEnabled() ? "\x63\150\145\x63\153\x65\144" : '';
$PD = $Pv == "\143\x68\x65\x63\153\x65\144" ? '' : "\x68\151\x64\x64\x65\x6e";
$of = $C3->getOtpTypeEnabled();
$zI = $C3->getFormDetails();
$H3 = admin_url() . "\141\144\x6d\151\x6e\56\x70\150\160\77\160\x61\147\145\x3d\x65\x76\x66\x2d\x62\x75\151\154\144\145\x72";
$jK = $C3->getButtonText();
$F4 = $C3->getPhoneHTMLTag();
$hR = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\x69\x65\167\163\x2f\x66\157\162\155\x73\x2f\105\x76\x65\x72\x65\163\164\103\157\x6e\x74\x61\x63\164\106\x6f\162\x6d\56\x70\x68\x70";
