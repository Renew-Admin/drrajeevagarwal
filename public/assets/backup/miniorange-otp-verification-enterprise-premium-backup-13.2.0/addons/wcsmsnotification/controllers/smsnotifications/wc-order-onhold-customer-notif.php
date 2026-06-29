<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\163\x6d\x73"), $_SERVER["\122\x45\121\x55\105\123\x54\x5f\125\122\x49"]);
$wH = $Jc->getWcOrderOnHoldNotif();
$en = $wH->page . "\137\145\156\x61\x62\154\145";
$Y2 = $wH->page . "\137\x73\x6d\x73\x62\157\144\x79";
$ZF = $wH->page . "\x5f\x72\145\x63\151\x70\151\x65\x6e\x74";
$iw = $wH->page . "\137\x73\145\164\164\x69\x6e\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto sF;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getWcOrderOnHoldNotif()->setIsEnabled($EW);
$Jc->getWcOrderOnHoldNotif()->setSmsBody($M7);
update_wc_option("\156\x6f\x74\151\146\151\143\141\164\151\157\156\x5f\163\x65\164\164\x69\156\147\x73", $Jc);
$wH = $Jc->getWcOrderOnHoldNotif();
sF:
$uF = $wH->recipient;
$yh = $wH->isEnabled ? "\x63\x68\x65\x63\x6b\145\x64" : '';
include MSN_DIR . "\x2f\166\x69\145\167\163\x2f\163\x6d\163\156\157\164\x69\x66\x69\x63\x61\x74\151\x6f\x6e\163\57\167\x63\55\143\x75\163\x74\157\x6d\145\162\x2d\x73\155\163\55\x74\145\155\x70\154\x61\x74\145\x2e\160\150\x70";
