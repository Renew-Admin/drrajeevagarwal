<?php


use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\Tabs;
$Mx = admin_url() . "\x65\144\x69\x74\x2e\160\x68\x70\x3f\x70\x6f\163\x74\137\164\x79\x70\x65\x3d\160\141\147\x65";
$q8 = MoUtility::micv() ? "\167\x70\x5f\x6f\164\x70\x5f\x76\145\x72\x69\146\151\x63\x61\164\151\x6f\156\x5f\x75\160\x67\162\x61\144\145\137\x70\x6c\141\156" : "\167\x70\x5f\157\164\x70\x5f\x76\145\x72\x69\x66\151\143\141\x74\x69\157\156\x5f\x62\x61\x73\151\x63\137\x70\154\x61\156";
$fQ = $Zf->getNonceValue();
$V_ = add_query_arg(["\x70\x61\x67\x65" => $ve->_tabDetails[Tabs::FORMS]->_menuSlug, "\146\x6f\162\155" => "\x63\157\156\x66\151\x67\x75\162\145\x64\137\146\157\162\155\163\43\x63\x6f\x6e\x66\x69\147\x75\x72\x65\x64\x5f\146\157\x72\155\163"]);
$Oi = add_query_arg("\x70\141\147\145", $ve->_tabDetails[Tabs::FORMS]->_menuSlug . "\x23\146\x6f\x72\155\x5f\x73\145\141\162\x63\x68", remove_query_arg(["\x66\157\162\x6d"]));
$Jy = isset($_GET["\146\157\162\x6d"]) ? sanitize_text_field($_GET["\x66\157\162\x6d"]) : false;
$io = $Jy == "\x63\x6f\156\x66\x69\147\165\162\x65\144\x5f\146\157\x72\x6d\x73";
$tH = $ve->_tabDetails[Tabs::OTP_SETTINGS];
$Ov = $tH->_url;
$GV = $ve->_tabDetails[Tabs::SMS_EMAIL_CONFIG];
$UM = $GV->_url;
$XP = $ve->_tabDetails[Tabs::DESIGN];
$Ze = $XP->_url;
$ib = $ve->_tabDetails[Tabs::ADD_ONS];
$Wx = $ib->_url;
$TU = $ve->_tabDetails[Tabs::CONTACT_US];
$wV = $TU->_url;
$kZ = MoConstants::FEEDBACK_EMAIL;
include MOV_DIR . "\166\x69\145\x77\x73\x2f\163\x65\164\x74\x69\x6e\147\x73\x2e\160\x68\x70";
include MOV_DIR . "\166\x69\145\167\x73\x2f\x69\x6e\163\164\162\165\143\164\151\157\x6e\163\x2e\x70\150\x70";
