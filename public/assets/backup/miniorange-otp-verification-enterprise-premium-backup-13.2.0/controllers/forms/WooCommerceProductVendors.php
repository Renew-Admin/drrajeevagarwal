<?php


use OTP\Handler\Forms\WooCommerceProductVendors;
$C3 = WooCommerceProductVendors::instance();
$ks = (bool) $C3->isFormEnabled() ? "\x63\x68\145\x63\x6b\x65\144" : '';
$UO = $ks == "\x63\x68\145\x63\x6b\x65\x64" ? '' : "\150\x69\144\144\x65\156";
$q7 = $C3->getOtpTypeEnabled();
$rc = (bool) $C3->restrictDuplicates() ? "\x63\150\145\x63\x6b\145\144" : '';
$x4 = $C3->getPhoneHTMLTag();
$hC = $C3->getEmailHTMLTag();
$xG = $C3->getBothHTMLTag();
$re = $C3->getFormName();
$Pg = $C3->isAjaxForm();
$Vg = $Pg ? "\x63\150\145\143\x6b\145\144" : '';
$YB = $C3->getButtonText();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\x73\57\x66\157\162\155\163\x2f\x57\157\157\103\157\155\x6d\145\162\x63\x65\120\162\157\x64\x75\143\x74\126\x65\x6e\x64\157\162\163\56\160\150\x70";
