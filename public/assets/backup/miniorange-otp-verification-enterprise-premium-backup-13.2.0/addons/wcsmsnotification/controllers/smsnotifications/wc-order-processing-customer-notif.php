<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\x73\155\163"), $_SERVER["\x52\105\121\125\x45\x53\x54\x5f\125\x52\x49"]);
$wH = $Jc->getWcOrderProcessingNotif();
$en = $wH->page . "\x5f\x65\x6e\141\x62\154\145";
$Y2 = $wH->page . "\137\x73\x6d\163\142\157\x64\171";
$ZF = $wH->page . "\x5f\162\x65\x63\x69\x70\151\145\x6e\164";
$iw = $wH->page . "\x5f\x73\x65\x74\x74\151\156\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto jr;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getWcOrderProcessingNotif()->setIsEnabled($EW);
$Jc->getWcOrderProcessingNotif()->setSmsBody($M7);
update_wc_option("\156\157\164\x69\x66\151\x63\x61\164\151\x6f\x6e\x5f\163\145\164\x74\x69\156\147\163", $Jc);
$wH = $Jc->getWcOrderProcessingNotif();
jr:
$uF = $wH->recipient;
$yh = $wH->isEnabled ? "\x63\x68\x65\x63\153\145\144" : '';
include MSN_DIR . "\x2f\166\151\145\167\163\57\x73\155\x73\x6e\157\x74\151\146\151\x63\141\164\x69\x6f\156\163\x2f\167\x63\x2d\x63\165\163\x74\x6f\155\x65\x72\55\163\x6d\x73\55\164\x65\155\x70\x6c\x61\x74\145\x2e\x70\150\x70";
