<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\x73\x6d\x73"), $_SERVER["\122\x45\121\125\105\x53\124\137\x55\x52\111"]);
$wH = $Jc->getWcOrderFailedNotif();
$en = $wH->page . "\x5f\145\156\x61\142\154\x65";
$Y2 = $wH->page . "\137\163\x6d\x73\x62\x6f\x64\x79";
$ZF = $wH->page . "\137\162\145\143\x69\x70\151\145\156\x74";
$iw = $wH->page . "\x5f\x73\x65\164\164\x69\x6e\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto qJ;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getWcOrderFailedNotif()->setIsEnabled($EW);
$Jc->getWcOrderFailedNotif()->setSmsBody($M7);
update_wc_option("\x6e\x6f\164\x69\146\x69\143\x61\164\x69\x6f\156\137\x73\x65\x74\164\151\156\x67\163", $Jc);
$wH = $Jc->getWcOrderFailedNotif();
qJ:
$uF = $wH->recipient;
$yh = $wH->isEnabled ? "\143\150\145\x63\153\x65\x64" : '';
include MSN_DIR . "\57\166\x69\145\x77\x73\57\163\155\163\156\157\164\x69\x66\x69\x63\x61\164\151\x6f\x6e\163\x2f\167\143\x2d\143\165\163\164\157\x6d\x65\162\x2d\163\x6d\x73\55\x74\145\x6d\x70\154\x61\x74\x65\x2e\x70\x68\x70";
