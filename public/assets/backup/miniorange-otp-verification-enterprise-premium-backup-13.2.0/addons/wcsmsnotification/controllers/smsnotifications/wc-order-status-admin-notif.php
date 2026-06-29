<?php


use OTP\Helper\MoUtility;
$n6 = remove_query_arg(array("\163\155\163"), $_SERVER["\x52\x45\x51\125\105\123\x54\137\125\x52\111"]);
$wH = $Jc->getWcAdminOrderStatusNotif();
$en = $wH->page . "\x5f\145\156\x61\x62\154\x65";
$Y2 = $wH->page . "\x5f\163\x6d\163\142\x6f\144\x79";
$ZF = $wH->page . "\x5f\162\x65\x63\151\x70\151\x65\156\164";
$iw = $wH->page . "\137\x73\145\164\164\x69\156\147\163";
if (!MoUtility::areFormOptionsBeingSaved($iw)) {
    goto sd;
}
$EW = array_key_exists($en, $_POST) ? TRUE : FALSE;
$uF = serialize(explode("\73", MoUtility::sanitizeCheck($ZF, $_POST)));
$M7 = MoUtility::isBlank($_POST[$Y2]) ? $wH->defaultSmsBody : MoUtility::sanitizeCheck($Y2, $_POST);
$Jc->getWcAdminOrderStatusNotif()->setIsEnabled($EW);
$Jc->getWcAdminOrderStatusNotif()->setRecipient($uF);
$Jc->getWcAdminOrderStatusNotif()->setSmsBody($M7);
update_wc_option("\156\x6f\x74\151\x66\x69\143\x61\x74\x69\157\x6e\137\x73\145\164\x74\x69\x6e\x67\x73", $Jc);
$wH = $Jc->getWcAdminOrderStatusNotif();
sd:
$uF = maybe_unserialize($wH->recipient);
$uF = is_array($uF) ? implode("\x3b", $uF) : $uF;
$yh = $wH->isEnabled ? "\x63\x68\x65\x63\x6b\145\144" : '';
include MSN_DIR . "\x2f\x76\151\x65\167\x73\x2f\163\x6d\163\156\157\164\151\146\x69\143\141\x74\x69\157\x6e\163\x2f\167\x63\x2d\141\x64\155\151\156\55\163\x6d\x73\x2d\164\x65\x6d\x70\x6c\x61\164\x65\x2e\160\x68\160";
