<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\163\155\163"), $_SERVER["\x52\105\x51\x55\x45\x53\124\137\x55\122\x49"]);
$wH = $Jc->getWcOrderRefundedNotif();
$en = $wH->page . "\x5f\x65\156\x61\x62\154\x65";
$Y2 = $wH->page . "\x5f\163\155\163\x62\157\x64\171";
$ZF = $wH->page . "\x5f\162\145\x63\x69\x70\x69\145\156\x74";
$iw = $wH->page . "\x5f\163\145\164\164\151\156\x67\x73";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto Bt;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getWcOrderRefundedNotif()->setIsEnabled($EW);
$Jc->getWcOrderRefundedNotif()->setSmsBody($M7);
update_wc_option("\x6e\x6f\x74\x69\x66\x69\x63\x61\x74\x69\x6f\156\137\163\x65\x74\x74\151\156\147\163", $Jc);
$wH = $Jc->getWcOrderRefundedNotif();
Bt:
$uF = $wH->recipient;
$yh = $wH->isEnabled ? "\x63\150\x65\x63\153\x65\x64" : '';
include MSN_DIR . "\x2f\x76\x69\145\x77\x73\57\x73\155\x73\x6e\x6f\164\151\146\151\x63\x61\164\151\x6f\156\163\57\x77\x63\55\143\165\x73\164\x6f\155\x65\x72\55\x73\x6d\163\55\x74\x65\155\x70\154\x61\164\x65\56\x70\150\x70";
