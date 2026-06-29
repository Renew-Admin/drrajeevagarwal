<?php


use OTP\Handler\Forms\WooCommerceRegistrationForm;
use OTP\Helper\MoUtility;
$C3 = WooCommerceRegistrationForm::instance();
$Gx = (bool) $C3->isFormEnabled() ? "\143\150\145\x63\153\145\144" : '';
$ZY = $Gx == "\x63\x68\x65\x63\153\x65\144" ? '' : "\150\x69\x64\x64\145\156";
$K6 = $C3->getOtpTypeEnabled();
$DX = (bool) $C3->restrictDuplicates() ? "\x63\150\145\x63\x6b\145\144" : '';
$VO = $C3->getPhoneHTMLTag();
$aX = $C3->getEmailHTMLTag();
$Wt = $C3->getBothHTMLTag();
$re = $C3->getFormName();
$Km = $C3->redirectToPage();
$uj = MoUtility::isBlank($Km) ? '' : get_page_by_title($Km)->ID;
$Pg = $C3->isAjaxForm();
$Vg = $Pg ? "\143\150\145\x63\x6b\x65\x64" : '';
$l6 = $C3->getButtonText();
$ss = $C3->isredirectToPageEnabled() ? "\143\150\x65\143\153\145\x64" : '';
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\163\x2f\x66\157\162\x6d\163\57\x57\x6f\157\x43\157\x6d\155\145\162\143\x65\x52\x65\147\151\x73\164\x72\x61\164\151\x6f\x6e\106\x6f\162\155\x2e\160\x68\x70";
