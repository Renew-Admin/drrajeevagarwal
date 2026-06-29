<?php


use OTP\Handler\Forms\ElementorPro;
$C3 = ElementorPro::instance();
$q2 = (bool) $C3->isFormEnabled() ? "\x63\x68\145\x63\x6b\x65\x64" : '';
$ek = $q2 == "\x63\150\x65\143\x6b\x65\144" ? '' : "\150\151\144\144\x65\156";
$m_ = $C3->getOtpTypeEnabled();
$gi = $C3->getFormDetails();
$zQ = admin_url() . "\x61\x64\155\151\x6e\56\160\x68\x70\77\x70\x61\147\x65\x3d\x77\160\146\x6f\x72\x6d\x73\x2d\157\x76\145\162\166\x69\145\167";
$jK = $C3->getButtonText();
$qH = $C3->getPhoneHTMLTag();
$ls = $C3->getEmailHTMLTag();
$Tm = $C3->getBothHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\x69\145\x77\x73\x2f\x66\157\162\155\163\57\105\154\x65\155\x65\156\x74\x6f\x72\120\x72\157\x2e\160\x68\x70";
