<?php


use OTP\Handler\Forms\WooCommerceFrontendManagerForm;
$C3 = WooCommerceFrontendManagerForm::instance();
$AN = (bool) $C3->isFormEnabled() ? "\143\150\145\x63\x6b\145\x64" : '';
$tU = $AN == "\x63\x68\x65\x63\x6b\x65\144" ? '' : "\x68\x69\144\x64\145\x6e";
$RD = $C3->getOtpTypeEnabled();
$Uk = $C3->getFormDetails();
$jK = $C3->getButtonText();
$TF = $C3->getPhoneHTMLTag();
$YH = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
$Gw = $C3->restrictDuplicates() ? "\143\150\x65\x63\x6b\145\144" : '';
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\x69\145\x77\163\x2f\x66\x6f\162\155\x73\57\127\x6f\x6f\x43\157\155\x6d\145\x72\x63\x65\x46\x72\x6f\x6e\x74\x65\156\144\x4d\x61\156\141\x67\x65\162\x46\x6f\162\x6d\x2e\160\x68\160";
