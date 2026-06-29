<?php


use OTP\Handler\Forms\WordPressComments;
$C3 = WordPressComments::instance();
$QF = (bool) $C3->isFormEnabled() ? "\x63\150\145\x63\x6b\145\144" : '';
$i1 = $QF == "\x63\x68\x65\143\153\x65\144" ? '' : "\x68\x69\x64\144\145\x6e";
$IK = $C3->getOtpTypeEnabled();
$q_ = $C3->bypassForLoggedInUsers() ? "\143\150\145\143\x6b\x65\144" : '';
$AX = $C3->getPhoneHTMLTag();
$oK = $C3->getEmailHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\151\x65\167\x73\x2f\x66\x6f\x72\x6d\163\57\127\x6f\x72\144\120\162\145\163\x73\x43\157\x6d\x6d\x65\x6e\164\163\56\x70\x68\160";
