<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\163\x6d\x73"), $_SERVER["\x52\x45\x51\x55\x45\x53\124\x5f\125\122\x49"]);
$wH = $Jc->getWcOrderCancelledNotif();
$en = $wH->page . "\x5f\x65\x6e\141\142\x6c\145";
$Y2 = $wH->page . "\x5f\163\155\x73\142\157\144\171";
$ZF = $wH->page . "\137\162\145\143\151\x70\151\x65\x6e\x74";
$iw = $wH->page . "\x5f\163\145\x74\x74\151\156\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto WG;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getWcOrderCancelledNotif()->setIsEnabled($EW);
$Jc->getWcOrderCancelledNotif()->setSmsBody($M7);
update_wc_option("\x6e\157\x74\x69\x66\151\143\x61\x74\x69\x6f\x6e\137\163\x65\x74\x74\x69\156\x67\163", $Jc);
$wH = $Jc->getWcOrderCancelledNotif();
WG:
$uF = $wH->recipient;
$yh = $wH->isEnabled ? "\143\x68\x65\x63\153\145\144" : '';
include MSN_DIR . "\x2f\x76\151\145\167\163\57\163\155\163\156\157\x74\x69\x66\x69\x63\x61\164\x69\x6f\x6e\163\x2f\167\x63\55\x63\165\163\x74\x6f\x6d\x65\162\x2d\163\155\163\55\x74\145\x6d\160\154\141\164\145\56\x70\150\160";
