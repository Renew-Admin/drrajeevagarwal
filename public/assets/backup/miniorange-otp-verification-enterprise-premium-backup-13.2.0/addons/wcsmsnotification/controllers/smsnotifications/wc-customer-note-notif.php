<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\163\155\x73"), $_SERVER["\x52\105\x51\x55\105\123\124\x5f\x55\122\111"]);
$wH = $Jc->getWcCustomerNoteNotif();
$en = $wH->page . "\137\x65\x6e\141\x62\x6c\x65";
$Y2 = $wH->page . "\x5f\163\155\x73\x62\x6f\x64\171";
$ZF = $wH->page . "\137\162\x65\x63\151\160\x69\145\x6e\x74";
$iw = $wH->page . "\x5f\163\x65\164\x74\x69\x6e\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto RQ;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getWcCustomerNoteNotif()->setIsEnabled($EW);
$Jc->getWcCustomerNoteNotif()->setSmsBody($M7);
update_wc_option("\156\157\x74\x69\x66\151\143\141\x74\x69\157\156\137\163\145\x74\x74\x69\156\x67\163", $Jc);
$wH = $Jc->getWcCustomerNoteNotif();
RQ:
$uF = $wH->recipient;
$yh = $wH->isEnabled ? "\143\150\x65\x63\153\x65\144" : '';
include MSN_DIR . "\57\x76\151\145\x77\163\x2f\163\x6d\x73\156\157\164\x69\146\151\x63\x61\x74\151\157\156\x73\x2f\167\x63\x2d\x63\165\x73\164\157\x6d\145\162\55\163\155\163\x2d\164\145\155\160\x6c\x61\164\145\56\160\150\160";
