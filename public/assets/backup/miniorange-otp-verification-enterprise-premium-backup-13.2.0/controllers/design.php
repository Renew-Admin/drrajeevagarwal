<?php


use OTP\Helper\Templates\DefaultPopup;
use OTP\Helper\Templates\ErrorPopup;
use OTP\Helper\Templates\ExternalPopup;
use OTP\Helper\Templates\UserChoicePopup;
use OTP\Objects\Template;
$UG = DefaultPopup::instance();
$Va = UserChoicePopup::instance();
$pm = ExternalPopup::instance();
$MW = ErrorPopup::instance();
$fQ = $UG->getNonceValue();
$Sd = $UG->getTemplateKey();
$Gj = $Va->getTemplateKey();
$MA = $pm->getTemplateKey();
$Tt = $MW->getTemplateKey();
$JS = maybe_unserialize(get_mo_option("\143\165\163\164\157\155\137\x70\x6f\160\165\160\x73"));
$ER = $JS[$UG->getTemplateKey()];
$Hx = $JS[$pm->getTemplateKey()];
$H_ = $JS[$Va->getTemplateKey()];
$lv = $JS[$MW->getTemplateKey()];
$MQ = Template::$templateEditor;
$qr = $UG->getTemplateEditorId();
$Qg = array_merge($MQ, ["\x74\145\170\x74\141\162\145\141\137\x6e\141\x6d\145" => $qr, "\x65\x64\x69\164\157\162\137\x68\x65\x69\147\x68\164" => 400]);
$D2 = $Va->getTemplateEditorId();
$aY = array_merge($MQ, ["\164\x65\x78\x74\x61\x72\x65\x61\x5f\x6e\141\x6d\145" => $D2, "\145\144\151\x74\157\x72\137\150\145\x69\x67\x68\164" => 400]);
$pw = $pm->getTemplateEditorId();
$N2 = array_merge($MQ, ["\164\145\x78\164\141\162\x65\x61\x5f\x6e\x61\155\145" => $pw, "\x65\x64\151\164\157\x72\x5f\x68\145\x69\x67\150\x74" => 400]);
$Yv = $MW->getTemplateEditorId();
$hu = array_merge($MQ, ["\164\x65\x78\x74\141\x72\145\x61\137\156\141\155\145" => $Yv, "\x65\x64\151\164\157\162\x5f\x68\145\x69\x67\x68\164" => 400]);
$eH = str_replace("\173\173\x43\117\x4e\x54\x45\x4e\x54\x7d\x7d", "\74\x69\x6d\x67\40\163\x72\143\75\x27" . MOV_LOADER_URL . "\x27\x3e", $UG->paneContent);
$fS = "\74\163\160\141\156\x20\163\164\x79\x6c\145\x3d\47\x66\157\x6e\x74\55\x73\x69\x7a\x65\x3a\x20\x31\x2e\x33\x65\155\73\x27\76" . "\x50\x52\x45\126\111\105\127\x20\120\101\x4e\105\74\x62\162\57\x3e\x3c\x62\162\57\x3e" . "\x3c\x2f\x73\160\141\156\76" . "\x3c\x73\160\141\156\76" . "\x43\x6c\x69\143\153\x20\x6f\x6e\x20\x74\150\x65\40\120\162\145\x76\151\x65\x77\x20\x62\165\164\x74\x6f\x6e\x20\141\x62\157\166\x65\x20\x74\x6f\40\143\150\145\143\x6b\40\150\157\x77\40\171\x6f\165\162\x20\x70\157\160\x75\x70\x20\x77\x6f\165\x6c\x64\x20\x6c\157\x6f\153\40\154\151\153\x65\x2e" . "\74\x2f\163\x70\x61\156\76";
$fS = str_replace("\173\173\115\105\x53\123\x41\107\x45\175\x7d", $fS, $UG->messageDiv);
$bC = str_replace("\173\x7b\x43\117\x4e\x54\105\116\124\x7d\x7d", $fS, $UG->paneContent);
include MOV_DIR . "\166\151\x65\x77\163\57\x64\x65\x73\151\147\156\x2e\x70\150\160";
