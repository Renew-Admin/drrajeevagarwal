<?php


use OTP\Addons\CustomMessage\Handler\CustomMessages;
$C3 = CustomMessages::instance();
$l0 = $C3->moAddOnV();
$m5 = !$l0 ? "\144\151\163\x61\142\154\145\x64" : '';
$current_user = wp_get_current_user();
$eL = MCM_DIR . "\143\157\156\164\162\157\154\154\145\162\163\x2f";
$Wx = add_query_arg(array("\160\x61\147\x65" => "\141\144\144\x6f\156"), remove_query_arg("\x61\x64\144\157\x6e", $_SERVER["\122\105\121\x55\105\x53\x54\137\125\122\111"]));
if (!isset($_GET["\141\144\144\157\x6e"])) {
    goto Iq;
}
switch ($_GET["\141\144\x64\x6f\x6e"]) {
    case "\x63\165\x73\x74\x6f\x6d":
        include $eL . "\x63\x75\163\164\x6f\155\56\x70\150\x70";
        goto gb;
}
KO:
gb:
Iq:
