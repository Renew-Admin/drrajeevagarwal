<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\x73\x6d\163"), $_SERVER["\x52\x45\x51\x55\105\123\124\x5f\125\122\x49"]);
$wH = $Jc->getWcOrderCompletedNotif();
$en = $wH->page . "\137\145\x6e\x61\142\154\145";
$Y2 = $wH->page . "\137\x73\155\x73\x62\157\144\x79";
$ZF = $wH->page . "\137\162\145\143\x69\160\x69\x65\x6e\164";
$iw = $wH->page . "\x5f\x73\x65\x74\x74\151\156\147\163";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto ot;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getWcOrderCompletedNotif()->setIsEnabled($EW);
$Jc->getWcOrderCompletedNotif()->setSmsBody($M7);
update_wc_option("\156\157\164\151\x66\x69\x63\141\x74\151\x6f\x6e\137\163\145\x74\x74\x69\x6e\147\x73", $Jc);
$wH = $Jc->getWcOrderCompletedNotif();
ot:
$uF = $wH->recipient;
$yh = $wH->isEnabled ? "\143\150\x65\143\153\145\144" : '';
include MSN_DIR . "\57\x76\151\x65\x77\x73\57\163\x6d\163\156\x6f\164\151\146\151\x63\x61\x74\151\x6f\x6e\x73\x2f\x77\x63\x2d\143\165\163\x74\157\x6d\145\x72\55\163\x6d\163\x2d\x74\145\x6d\160\154\x61\x74\145\x2e\x70\150\160";
