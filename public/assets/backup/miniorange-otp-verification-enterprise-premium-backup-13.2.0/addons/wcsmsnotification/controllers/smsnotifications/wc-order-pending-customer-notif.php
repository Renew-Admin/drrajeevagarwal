<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\163\155\x73"), $_SERVER["\122\105\x51\125\105\x53\x54\x5f\x55\122\x49"]);
$wH = $Jc->getWcOrderPendingNotif();
$en = $wH->page . "\137\145\x6e\x61\142\x6c\145";
$Y2 = $wH->page . "\137\x73\155\x73\142\157\144\171";
$ZF = $wH->page . "\x5f\162\145\143\151\x70\x69\145\156\x74";
$iw = $wH->page . "\137\x73\x65\x74\x74\x69\156\x67\x73";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto tg;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getWcOrderPendingNotif()->setIsEnabled($EW);
$Jc->getWcOrderPendingNotif()->setSmsBody($M7);
update_wc_option("\156\x6f\164\151\146\x69\143\x61\164\x69\x6f\x6e\137\163\145\x74\164\x69\156\x67\163", $Jc);
$wH = $Jc->getWcOrderPendingNotif();
tg:
$uF = $wH->recipient;
$yh = $wH->isEnabled ? "\143\x68\x65\x63\x6b\145\x64" : '';
include MSN_DIR . "\x2f\166\151\145\167\x73\x2f\x73\x6d\x73\x6e\157\x74\151\x66\151\143\x61\164\151\157\x6e\163\x2f\x77\x63\55\x63\x75\x73\x74\x6f\x6d\x65\162\x2d\163\155\x73\x2d\164\145\155\160\154\x61\x74\145\x2e\x70\x68\160";
