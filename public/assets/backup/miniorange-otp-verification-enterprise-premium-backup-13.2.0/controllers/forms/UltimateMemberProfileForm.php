<?php


use OTP\Handler\Forms\UltimateMemberProfileForm;
$C3 = UltimateMemberProfileForm::instance();
$nM = $C3->isFormEnabled() ? "\143\150\145\x63\153\x65\144" : '';
$AU = $nM == "\x63\150\145\143\x6b\x65\x64" ? '' : "\x68\x69\x64\x64\145\x6e";
$NB = $C3->getOtpTypeEnabled();
$Jp = $C3->getPhoneKeyDetails();
$RK = admin_url() . "\x65\x64\x69\x74\x2e\x70\x68\160\x3f\160\157\163\164\137\164\171\160\x65\x3d\165\155\x5f\x66\x6f\162\x6d";
$Yi = $C3->getPhoneHTMLTag();
$nn = $C3->getEmailHTMLTag();
$Oy = $C3->getBothHTMLTag();
$vl = $C3->restrictDuplicates() ? "\143\150\145\x63\153\x65\144" : '';
$re = $C3->getFormName();
$Uz = $C3->getButtonText();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\167\x73\x2f\146\157\x72\155\163\x2f\x55\154\x74\x69\x6d\x61\x74\145\115\145\x6d\x62\x65\x72\x50\162\157\146\x69\154\145\x46\157\x72\155\56\x70\150\x70";
