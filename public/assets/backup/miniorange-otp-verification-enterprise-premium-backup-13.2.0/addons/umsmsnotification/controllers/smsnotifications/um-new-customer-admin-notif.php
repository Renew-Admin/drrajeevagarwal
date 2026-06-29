<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\163\155\x73"), $_SERVER["\122\x45\121\x55\x45\123\x54\x5f\125\122\111"]);
$wH = $Jc->getUmNewUserAdminNotif();
$en = $wH->page . "\137\x65\x6e\x61\142\x6c\x65";
$Y2 = $wH->page . "\137\x73\x6d\x73\x62\157\144\x79";
$ZF = $wH->page . "\137\x72\145\x63\151\160\x69\x65\156\164";
$iw = $wH->page . "\x5f\x73\x65\x74\164\151\156\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto X3;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$uF = serialize(explode("\73", MoUtility::sanitizeCheck($ZF, $_POST)));
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getUmNewUserAdminNotif()->setIsEnabled($EW);
$Jc->getUmNewUserAdminNotif()->setRecipient($uF);
$Jc->getUmNewUserAdminNotif()->setSmsBody($M7);
update_umsn_option("\156\x6f\164\151\x66\151\x63\x61\164\151\x6f\156\137\163\x65\164\x74\x69\156\147\x73", $Jc);
$wH = $Jc->getUmNewUserAdminNotif();
X3:
$uF = maybe_unserialize($wH->recipient);
$uF = is_array($uF) ? implode("\x3b", $uF) : $uF;
$yh = $wH->isEnabled ? "\143\150\145\x63\153\x65\x64" : '';
include UMSN_DIR . "\57\166\151\x65\167\163\x2f\163\155\x73\x6e\157\x74\x69\146\x69\x63\x61\x74\151\157\x6e\x73\x2f\x75\155\x2d\141\x64\x6d\151\156\55\x73\155\163\55\164\145\x6d\160\x6c\141\x74\x65\x2e\160\150\160";
