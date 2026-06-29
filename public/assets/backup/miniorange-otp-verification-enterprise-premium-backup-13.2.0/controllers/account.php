<?php


use OTP\Handler\MoRegistrationHandler;
use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
$P9 = MoConstants::HOSTNAME . "\57\155\157\141\x73\57\154\x6f\x67\151\x6e" . "\77\162\145\x64\x69\x72\x65\x63\x74\125\162\x6c\75" . MoConstants::HOSTNAME . "\x2f\155\157\141\163\57\x76\x69\145\x77\x6c\151\143\145\156\x73\145\x6b\145\x79\163";
$C3 = MoRegistrationHandler::instance();
if (get_mo_option("\x72\x65\147\151\163\x74\x72\141\164\x69\x6f\x6e\137\x73\164\141\x74\x75\163") === "\115\x4f\x5f\x4f\x54\120\137\104\105\x4c\111\126\105\x52\105\104\x5f\x53\x55\103\x43\105\x53\x53" || get_mo_option("\162\x65\x67\x69\x73\164\162\141\164\151\157\156\x5f\x73\164\x61\x74\x75\x73") === "\x4d\x4f\137\x4f\x54\x50\137\126\x41\114\111\x44\x41\x54\x49\x4f\x4e\137\106\101\111\114\125\122\105" || get_mo_option("\162\145\147\x69\163\164\162\141\x74\151\157\x6e\137\x73\164\141\164\165\x73") === "\x4d\117\137\117\124\120\x5f\x44\x45\114\111\x56\x45\122\x45\x44\137\x46\x41\111\114\x55\x52\105") {
    goto Y8;
}
if (get_mo_option("\x76\145\162\151\x66\171\x5f\x63\165\x73\164\x6f\x6d\x65\x72")) {
    goto Cg;
}
if (!MoUtility::micr()) {
    goto ys;
}
if (MoUtility::micr() && !MoUtility::mclv()) {
    goto tN;
}
$RQ = get_mo_option("\141\x64\155\151\156\x5f\x63\x75\x73\x74\x6f\x6d\x65\162\137\153\145\171");
$nG = get_mo_option("\x61\144\155\151\x6e\137\141\x70\x69\x5f\x6b\145\171");
$ry = get_mo_option("\143\x75\x73\164\x6f\x6d\145\162\137\x74\x6f\153\x65\156");
$pM = MoUtility::mclv() && !MoUtility::isMG();
$fQ = $Zf->getNonceValue();
$Yx = $C3->getNonceValue();
include MOV_DIR . "\166\x69\x65\167\x73\57\141\143\143\x6f\x75\x6e\164\57\x70\162\157\146\151\154\x65\56\x70\x68\x70";
goto t4;
tN:
$fQ = $C3->getNonceValue();
include MOV_DIR . "\166\x69\x65\x77\x73\x2f\x61\143\x63\157\165\x6e\x74\x2f\166\145\x72\151\146\x79\x2d\x6c\153\56\160\x68\160";
t4:
goto RF;
ys:
$current_user = wp_get_current_user();
$dL = get_mo_option("\141\144\155\151\x6e\x5f\x70\150\157\x6e\x65") ? get_mo_option("\141\144\155\151\x6e\x5f\x70\x68\157\x6e\145") : '';
$fQ = $C3->getNonceValue();
delete_site_option("\x70\141\x73\163\167\x6f\162\x64\x5f\155\x69\x73\155\141\164\143\150");
update_mo_option("\156\x65\167\x5f\162\x65\x67\x69\x73\x74\x72\x61\x74\151\157\x6e", "\x74\162\165\x65");
include MOV_DIR . "\166\x69\x65\x77\163\57\x61\143\143\x6f\165\x6e\164\x2f\162\x65\x67\x69\163\x74\145\x72\56\x70\x68\160";
RF:
goto pG;
Cg:
$p4 = get_mo_option("\x61\144\x6d\x69\x6e\x5f\x65\155\141\x69\x6c") ? get_mo_option("\x61\x64\x6d\151\x6e\137\x65\155\141\151\x6c") : '';
$fQ = $C3->getNonceValue();
include MOV_DIR . "\166\151\x65\x77\x73\57\141\143\143\x6f\x75\156\164\x2f\x6c\157\147\151\x6e\x2e\160\x68\x70";
pG:
goto dz;
Y8:
$dL = get_mo_option("\141\x64\x6d\x69\156\137\x70\x68\x6f\x6e\145") ? get_mo_option("\141\x64\155\x69\156\137\x70\150\157\x6e\145") : '';
$fQ = $C3->getNonceValue();
include MOV_DIR . "\x76\x69\x65\167\x73\x2f\x61\143\143\x6f\x75\156\x74\x2f\x76\x65\162\151\x66\171\56\160\150\160";
dz:
