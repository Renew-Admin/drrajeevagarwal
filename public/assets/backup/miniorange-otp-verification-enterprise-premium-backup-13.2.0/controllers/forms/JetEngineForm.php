<?php


use OTP\Handler\Forms\JetEngineForm;
$C3 = JetEngineForm::instance();
$pW = (bool) $C3->isFormEnabled() ? "\x63\150\x65\143\153\145\144" : '';
$z0 = $pW == "\143\x68\x65\x63\153\x65\144" ? '' : "\x68\151\x64\144\x65\156";
$tI = $C3->getOtpTypeEnabled();
$gQ = $C3->getFormDetails();
$l4 = admin_url() . "\x61\144\x6d\x69\x6e\56\x70\x68\160\x3f\x70\141\x67\145\x3d\167\160\x66\157\162\155\163\55\157\x76\145\x72\166\151\x65\167";
$jK = $C3->getButtonText();
$Ak = $C3->getPhoneHTMLTag();
$iQ = $C3->getEmailHTMLTag();
$kc = $C3->getBothHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\x69\x65\167\163\x2f\146\157\162\155\x73\x2f\x4a\145\164\105\x6e\x67\x69\156\145\x46\x6f\162\x6d\56\160\150\x70";
