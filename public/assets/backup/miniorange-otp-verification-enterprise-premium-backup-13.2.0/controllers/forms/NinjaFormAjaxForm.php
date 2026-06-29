<?php


use OTP\Handler\Forms\NinjaFormAjaxForm;
$C3 = NinjaFormAjaxForm::instance();
$kF = $C3->isFormEnabled() ? "\143\x68\145\143\x6b\145\144" : '';
$Ph = $kF == "\143\150\145\x63\153\x65\144" ? '' : "\150\151\x64\144\145\x6e";
$s3 = $C3->getOtpTypeEnabled();
$IL = admin_url() . "\141\144\155\x69\156\x2e\x70\150\160\77\x70\141\147\x65\x3d\x6e\151\156\152\x61\x2d\x66\157\x72\x6d\x73";
$YJ = $C3->getFormDetails();
$mR = $C3->getPhoneHTMLTag();
$vP = $C3->getEmailHTMLTag();
$jK = $C3->getButtonText();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\167\x73\57\x66\157\162\155\163\x2f\x4e\x69\x6e\x6a\141\x46\x6f\162\x6d\x41\152\141\x78\106\x6f\162\x6d\x2e\160\x68\160";
