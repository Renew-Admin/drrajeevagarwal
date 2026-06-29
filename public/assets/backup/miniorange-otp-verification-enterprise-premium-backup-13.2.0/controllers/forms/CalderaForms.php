<?php


use OTP\Handler\Forms\CalderaForms;
$C3 = CalderaForms::instance();
$wx = (bool) $C3->isFormEnabled() ? "\x63\x68\x65\143\x6b\x65\144" : '';
$pr = $wx == "\143\150\145\143\153\x65\x64" ? '' : "\150\x69\144\144\145\156";
$I6 = $C3->getOtpTypeEnabled();
$Sc = $C3->getFormDetails();
$E4 = admin_url() . "\x61\x64\155\151\156\56\x70\150\x70\77\x70\x61\x67\x65\x3d\143\141\154\x64\x65\162\x61\x2d\x66\x6f\162\x6d\163";
$jK = $C3->getButtonText();
$pH = $C3->getPhoneHTMLTag();
$Z8 = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\x69\x65\167\x73\57\x66\x6f\162\x6d\x73\57\x43\141\154\144\145\x72\x61\106\x6f\x72\x6d\x73\56\x70\150\x70";
