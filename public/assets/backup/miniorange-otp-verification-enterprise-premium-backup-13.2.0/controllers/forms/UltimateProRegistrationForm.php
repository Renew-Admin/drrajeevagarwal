<?php


use OTP\Handler\Forms\UltimateProRegistrationForm;
$C3 = UltimateProRegistrationForm::instance();
$nm = (bool) $C3->isFormEnabled() ? "\x63\x68\145\x63\153\145\x64" : '';
$jV = $nm == "\x63\150\145\143\x6b\x65\x64" ? '' : "\x68\x69\144\144\145\156";
$Nv = $C3->getOtpTypeEnabled();
$lI = admin_url() . "\x61\x64\155\151\156\x2e\x70\x68\x70\x3f\x70\x61\x67\145\75\151\150\x63\137\155\141\156\141\147\145\x26\x74\141\x62\x3d\162\145\147\151\x73\x74\145\x72\x26\x73\x75\142\x74\x61\142\75\x63\x75\163\164\157\x6d\x5f\146\151\x65\154\144\x73";
$ag = $C3->getPhoneHTMLTag();
$l1 = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\151\x65\x77\163\x2f\x66\157\162\155\x73\x2f\125\x6c\164\151\x6d\141\x74\x65\x50\x72\157\x52\x65\147\151\x73\164\x72\x61\x74\x69\x6f\156\x46\x6f\162\x6d\56\160\x68\160";
