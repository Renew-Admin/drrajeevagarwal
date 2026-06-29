<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\163\155\x73"), $_SERVER["\122\105\121\x55\x45\x53\x54\x5f\x55\122\111"]);
$wH = $Jc->getWcNewCustomerNotif();
$en = $wH->page . "\137\145\x6e\141\142\154\x65";
$Y2 = $wH->page . "\x5f\163\x6d\163\142\157\144\171";
$ZF = $wH->page . "\137\x72\145\143\x69\160\x69\x65\x6e\x74";
$iw = $wH->page . "\137\163\x65\x74\x74\x69\156\147\163";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto NA;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getWcNewCustomerNotif()->setIsEnabled($EW);
$Jc->getWcNewCustomerNotif()->setSmsBody($M7);
update_wc_option("\156\x6f\164\x69\146\x69\143\x61\x74\x69\157\156\137\x73\145\x74\x74\151\156\147\163", $Jc);
$wH = $Jc->getWcNewCustomerNotif();
NA:
$uF = $wH->recipient;
$yh = $wH->isEnabled ? "\143\x68\145\143\153\x65\144" : '';
include MSN_DIR . "\57\166\x69\145\x77\x73\57\163\x6d\x73\156\157\164\x69\x66\x69\143\x61\164\x69\157\156\163\x2f\167\x63\x2d\x63\x75\163\164\157\155\145\x72\55\x73\x6d\163\x2d\x74\145\x6d\x70\154\x61\164\x65\x2e\x70\150\160";
