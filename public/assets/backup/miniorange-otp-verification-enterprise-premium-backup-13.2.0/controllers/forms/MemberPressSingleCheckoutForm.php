<?php


use OTP\Handler\Forms\MemberPressSingleCheckoutForm;
$C3 = MemberPressSingleCheckoutForm::instance();
$p3 = $C3->isFormEnabled() ? "\143\150\145\143\153\145\144" : '';
$Ee = $p3 == "\x63\150\145\x63\153\x65\144" ? '' : "\x68\151\x64\144\145\156";
$D8 = $C3->getOtpTypeEnabled();
$NG = $C3->getPhoneKeyDetails();
$md = admin_url() . "\141\144\x6d\151\156\x2e\160\150\x70\77\160\x61\147\x65\75\155\x65\155\x62\x65\x72\x70\162\145\163\x73\x2d\157\160\164\151\x6f\156\x73\43\155\x65\x70\x72\55\146\151\x65\154\x64\163";
$Yg = $C3->getPhoneHTMLTag();
$OF = $C3->getEmailHTMLTag();
$qh = $C3->getBothHTMLTag();
$re = $C3->getFormName();
$By = $C3->bypassForLoggedInUsers() ? "\143\150\x65\143\x6b\145\x64" : '';
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\x69\145\x77\x73\57\146\157\162\x6d\x73\57\x4d\x65\x6d\142\145\x72\120\x72\145\163\x73\x53\x69\156\x67\154\145\103\x68\x65\143\x6b\x6f\x75\164\x46\x6f\162\x6d\56\160\150\160";
