<?php


use OTP\Handler\Forms\RegistrationMagicForm;
$C3 = RegistrationMagicForm::instance();
$c0 = $C3->isFormEnabled() ? "\x63\x68\145\x63\x6b\145\144" : '';
$j9 = $c0 == "\143\150\145\143\x6b\x65\144" ? '' : "\x68\151\x64\144\145\x6e";
$pX = $C3->getOtpTypeEnabled();
$zT = admin_url() . "\x61\144\x6d\x69\156\x2e\x70\150\x70\x3f\160\x61\x67\145\x3d\162\x6d\x5f\x66\x6f\162\155\137\155\x61\156\141\147\x65";
$II = $C3->getFormDetails();
$kA = $C3->getPhoneHTMLTag();
$Tu = $C3->getEmailHTMLTag();
$pY = $C3->getBothHTMLTag();
$re = $C3->getFormName();
$Gw = $C3->restrictDuplicates() ? "\x63\x68\x65\x63\153\x65\x64" : '';
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\151\x65\167\163\57\x66\157\x72\155\163\x2f\x52\x65\x67\x69\163\164\162\x61\164\x69\x6f\x6e\x4d\141\x67\x69\143\106\157\162\155\56\x70\x68\160";
