<?php


use OTP\Handler\Forms\ContactForm7;
$C3 = ContactForm7::instance();
$Zs = (bool) $C3->isFormEnabled() ? "\143\150\x65\x63\x6b\x65\144" : '';
$X_ = $Zs == "\x63\150\x65\x63\153\145\x64" ? '' : "\150\x69\x64\x64\x65\156";
$fo = $C3->getOtpTypeEnabled();
$DG = admin_url() . "\x61\144\155\x69\156\x2e\160\150\160\x3f\x70\x61\147\x65\75\167\x70\x63\146\67";
$fa = $C3->getEmailKeyDetails();
$P5 = $C3->getPhoneHTMLTag();
$uW = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\167\x73\57\x66\157\162\x6d\163\x2f\103\x6f\156\164\x61\x63\x74\x46\x6f\x72\x6d\x37\x2e\x70\150\x70";
