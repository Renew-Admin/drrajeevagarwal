<?php


use OTP\Handler\Forms\UltimateMemberRegistrationForm;
$C3 = UltimateMemberRegistrationForm::instance();
$Pa = $C3->isFormEnabled() ? "\143\150\x65\143\x6b\145\x64" : '';
$yk = $Pa == "\x63\x68\145\x63\153\145\x64" ? '' : "\150\151\x64\144\x65\x6e";
$I9 = $C3->getOtpTypeEnabled();
$TD = admin_url() . "\145\144\x69\x74\x2e\x70\150\160\77\160\x6f\x73\x74\x5f\164\x79\x70\145\x3d\165\x6d\x5f\146\157\162\155";
$Ys = $C3->getPhoneHTMLTag();
$Rh = $C3->getEmailHTMLTag();
$OT = $C3->getBothHTMLTag();
$PC = $C3->restrictDuplicates() ? "\143\x68\145\x63\153\145\144" : '';
$re = $C3->getFormName();
$Ur = $C3->getButtonText();
$Pg = $C3->isAjaxForm();
$Vg = $Pg ? "\143\x68\x65\143\x6b\145\144" : '';
$d7 = $C3->getFormKey();
$aO = $C3->getPhoneKeyDetails();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\151\145\167\x73\x2f\x66\x6f\x72\x6d\163\57\x55\154\164\151\155\x61\164\x65\115\x65\155\142\x65\x72\122\145\x67\x69\x73\x74\x72\141\164\x69\x6f\156\x46\157\162\155\56\x70\x68\160";
