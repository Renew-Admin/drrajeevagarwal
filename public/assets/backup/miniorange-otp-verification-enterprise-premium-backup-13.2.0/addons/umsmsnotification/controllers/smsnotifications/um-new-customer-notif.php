<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\163\x6d\x73"), $_SERVER["\122\x45\x51\125\x45\123\x54\x5f\125\122\x49"]);
$wH = $Jc->getUmNewCustomerNotif();
$en = $wH->page . "\x5f\x65\x6e\x61\142\x6c\x65";
$Y2 = $wH->page . "\x5f\x73\155\x73\x62\157\x64\171";
$ZF = $wH->page . "\137\x72\145\x63\151\160\x69\x65\x6e\x74";
$iw = $wH->page . "\137\x73\x65\x74\x74\x69\156\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto hB;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$uF = MoUtility::sanitizeCheck($ZF, $_POST);
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getUmNewCustomerNotif()->setIsEnabled($EW);
$Jc->getUmNewCustomerNotif()->setRecipient($uF);
$Jc->getUmNewCustomerNotif()->setSmsBody($M7);
update_umsn_option("\x6e\x6f\164\151\x66\x69\x63\141\x74\151\157\x6e\137\163\145\164\164\151\156\x67\x73", $Jc);
$wH = $Jc->getUmNewCustomerNotif();
hB:
$uF = maybe_unserialize($wH->recipient);
$uF = MoUtility::isBlank($uF) ? "\x6d\x6f\x62\151\154\x65\x5f\x6e\165\155\142\x65\x72" : $uF;
$yh = $wH->isEnabled ? "\143\150\145\x63\x6b\x65\x64" : '';
include UMSN_DIR . "\x2f\x76\151\x65\x77\x73\57\163\x6d\x73\156\x6f\164\151\x66\x69\143\141\x74\x69\157\x6e\163\x2f\165\155\x2d\143\165\163\164\157\155\x65\162\55\163\x6d\x73\55\x74\145\x6d\160\x6c\x61\164\x65\56\160\150\160";
