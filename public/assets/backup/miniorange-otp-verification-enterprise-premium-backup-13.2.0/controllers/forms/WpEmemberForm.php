<?php


use OTP\Handler\Forms\WpEmemberForm;
$C3 = WpEmemberForm::instance();
$Q8 = $C3->isFormEnabled() ? "\143\x68\x65\x63\x6b\x65\144" : '';
$vo = $Q8 == "\x63\150\145\143\153\145\144" ? '' : "\x68\151\x64\144\x65\x6e";
$WZ = $C3->getOtpTypeEnabled();
$RJ = admin_url() . "\141\144\x6d\151\156\56\160\150\160\x3f\x70\x61\x67\145\75\145\115\x65\155\142\145\x72\137\163\x65\x74\164\x69\156\147\x73\137\155\x65\156\x75\46\164\x61\x62\x3d\64";
$GY = $C3->getPhoneHTMLTag();
$AD = $C3->getEmailHTMLTag();
$Cy = $C3->getBothHTMLTag();
$re = $C3->getFormName();
get_plugin_form_link($C3->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\163\x2f\146\157\162\155\163\57\x57\x70\105\155\x65\x6d\x62\145\162\106\157\162\155\x2e\160\x68\160";
