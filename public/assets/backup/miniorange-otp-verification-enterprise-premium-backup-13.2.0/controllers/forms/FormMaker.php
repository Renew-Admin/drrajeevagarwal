<?php


use OTP\Handler\Forms\FormMaker;
$C3 = FormMaker::instance();
$dC = (bool) $C3->isFormEnabled() ? "\143\150\x65\x63\153\145\144" : '';
$Mq = $dC == "\x63\x68\x65\143\x6b\x65\x64" ? '' : "\x68\151\x64\x64\x65\156";
$OD = admin_url() . "\x61\144\x6d\x69\156\56\x70\150\x70\x3f\160\x61\x67\x65\75\155\141\156\141\147\145\x5f\x66\x6d";
$rk = $C3->getOtpTypeEnabled();
$a3 = $C3->getEmailHTMLTag();
$dK = $C3->getPhoneHTMLTag();
$Jg = $C3->getFormDetails();
$re = $C3->getFormName();
$jK = $C3->getButtonText();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\x73\x2f\146\x6f\162\x6d\x73\57\106\157\162\155\115\141\x6b\145\x72\x2e\160\150\x70";
