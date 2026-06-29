<?php


use OTP\Addons\UmSMSNotification\Handler\UltimateMemberSMSNotificationsHandler;
$C3 = UltimateMemberSMSNotificationsHandler::instance();
$l0 = $C3->moAddOnV();
$m5 = !$l0 ? "\x64\151\x73\141\x62\x6c\145\144" : '';
$current_user = wp_get_current_user();
$eL = UMSN_DIR . "\143\x6f\156\164\162\157\154\154\145\162\x73\x2f";
$Wx = add_query_arg(array("\160\141\x67\145" => "\x61\x64\144\157\156"), remove_query_arg("\141\144\144\x6f\x6e", $_SERVER["\122\105\121\125\105\x53\x54\137\x55\x52\x49"]));
if (!isset($_GET["\x61\144\x64\157\156"])) {
    goto RW;
}
switch ($_GET["\141\144\x64\157\156"]) {
    case "\x75\x6d\137\156\x6f\x74\x69\x66":
        include $eL . "\x75\x6d\55\x73\x6d\x73\55\156\157\164\151\x66\x69\x63\141\x74\x69\157\x6e\56\x70\x68\160";
        goto L2;
}
Rz:
L2:
RW:
