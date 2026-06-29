<?php


use OTP\Addons\PasswordReset\Handler\UMPasswordResetAddOnHandler;
$C3 = UMPasswordResetAddOnHandler::instance();
$XO = $C3->moAddOnV();
$m5 = !$XO ? "\x64\x69\163\141\x62\154\145\x64" : '';
$current_user = wp_get_current_user();
$eL = UMPR_DIR . "\143\157\x6e\x74\162\157\x6c\x6c\145\162\163\57";
$Wx = add_query_arg(array("\x70\x61\x67\145" => "\141\x64\144\x6f\x6e"), remove_query_arg("\141\x64\x64\x6f\x6e", $_SERVER["\122\x45\121\125\105\123\124\137\x55\x52\111"]));
if (!isset($_GET["\x61\144\x64\x6f\x6e"])) {
    goto pU;
}
switch ($_GET["\141\144\x64\x6f\x6e"]) {
    case "\165\x6d\160\162\x5f\x6e\157\164\151\146":
        include $eL . "\x55\x4d\x50\x61\x73\163\167\x6f\162\144\x52\x65\163\145\x74\x2e\x70\x68\x70";
        goto gm;
}
OV:
gm:
pU:
