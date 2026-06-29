<?php


use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Objects\Tabs;
use OTP\Helper\MoUtility;
$VI = remove_query_arg(["\141\144\x64\157\x6e", "\x66\x6f\x72\x6d", "\x73\165\142\x70\x61\147\x65"], $_SERVER["\122\x45\121\125\x45\123\x54\137\125\122\x49"]);
$lD = add_query_arg(array("\160\x61\147\145" => $ve->_tabDetails[Tabs::ACCOUNT]->_menuSlug), $VI);
$lW = MoConstants::FAQ_URL;
$D1 = MoMessages::showMessage(MoMessages::REGISTER_WITH_US, ["\x75\x72\154" => $lD]);
$iL = MoMessages::showMessage(MoMessages::ACTIVATE_PLUGIN, ["\x75\x72\x6c" => $lD]);
$j_ = add_query_arg(array("\160\141\x67\145" => $ve->_tabDetails[Tabs::SMS_EMAIL_CONFIG]->_menuSlug), $VI);
$gJ = MoMessages::showMessage(MoMessages::CONFIG_GATEWAY, ["\165\x72\154" => $j_]);
$J9 = sanitize_text_field($_GET["\160\x61\x67\145"]);
$WO = add_query_arg(array("\x70\x61\147\x65" => $ve->_tabDetails[Tabs::PRICING]->_menuSlug), $VI);
$fQ = $Zf->getNonceValue();
$R0 = MoUtility::micr();
$TO = strcmp(MOV_TYPE, "\x4d\151\156\151\117\x72\141\x6e\x67\145\107\141\x74\x65\167\141\x79") === 0;
include MOV_DIR . "\x76\x69\145\x77\x73\57\156\141\166\142\141\x72\x2e\160\150\160";
