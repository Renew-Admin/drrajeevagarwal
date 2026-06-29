<?php


use OTP\Handler\Forms\VisualFormBuilder;
$C3 = VisualFormBuilder::instance();
$rL = $C3->isFormEnabled() ? "\x63\150\145\x63\153\x65\x64" : '';
$mK = $rL == "\143\150\x65\x63\x6b\x65\144" ? '' : "\x68\151\x64\x64\145\156";
$dQ = $C3->getOtpTypeEnabled();
$Ay = admin_url() . "\141\144\x6d\x69\156\56\x70\x68\160\x3f\x70\x61\x67\145\x3d\166\151\163\165\x61\154\x2d\x66\x6f\162\x6d\x2d\142\165\x69\154\x64\145\162";
$Jd = $C3->getFormDetails();
$W1 = $C3->getPhoneHTMLTag();
$k4 = $C3->getEmailHTMLTag();
$jK = $C3->getButtonText();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\x73\x2f\x66\157\162\x6d\x73\x2f\126\x69\x73\x75\141\x6c\x46\157\162\x6d\102\165\x69\x6c\x64\145\x72\56\x70\150\160";
