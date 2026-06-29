<?php


use OTP\Handler\Forms\WooCommerceCheckOutForm;
$C3 = WooCommerceCheckOutForm::instance();
$o4 = $C3->isFormEnabled() ? "\x63\150\145\143\x6b\145\144" : '';
$th = $o4 == "\x63\x68\145\x63\153\x65\144" ? '' : "\150\x69\144\x64\x65\x6e";
$yz = $C3->getOtpTypeEnabled();
$Yk = $C3->isGuestCheckoutOnlyEnabled() ? "\x63\150\145\143\x6b\x65\x64" : '';
$Zi = $C3->showButtonInstead() ? "\143\x68\145\x63\153\145\x64" : '';
$kj = $C3->isPopUpEnabled() ? "\x63\150\145\x63\x6b\x65\144" : '';
$FC = $C3->getPaymentMethods();
$uK = $C3->isSelectivePaymentEnabled() ? "\x63\150\145\x63\153\145\x64" : '';
$Cq = $uK == "\143\150\145\x63\x6b\145\144" ? '' : "\x68\x69\144\144\145\156";
$cD = $C3->getPhoneHTMLTag();
$DO = $C3->getEmailHTMLTag();
$jK = $C3->getButtonText();
$re = $C3->getFormName();
$Rj = $C3->isAutoLoginDisabled() ? "\143\x68\145\143\153\x65\x64" : '';
$Gw = $C3->restrictDuplicates() ? "\x63\150\x65\143\x6b\x65\x64" : '';
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\x73\x2f\x66\157\162\x6d\x73\x2f\127\157\157\x43\157\x6d\155\x65\x72\x63\x65\103\150\145\143\153\x4f\165\164\106\x6f\x72\x6d\x2e\x70\x68\160";
