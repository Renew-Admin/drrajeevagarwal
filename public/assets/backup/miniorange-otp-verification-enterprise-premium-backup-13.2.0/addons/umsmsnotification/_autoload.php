<?php


if (defined("\x41\102\123\120\x41\124\110")) {
    goto Bk;
}
exit;
Bk:
define("\x55\115\123\116\137\x44\x49\x52", plugin_dir_path(__FILE__));
define("\x55\115\x53\x4e\137\x55\122\x4c", plugin_dir_url(__FILE__));
define("\125\x4d\x53\x4e\x5f\x56\105\122\123\111\117\116", "\x31\x2e\60\x2e\x30");
define("\125\x4d\123\x4e\137\x43\123\x53\x5f\x55\x52\114", UMSN_URL . "\151\x6e\143\154\165\x64\x65\x73\57\x63\163\163\57\163\x65\164\x74\x69\x6e\147\163\x2e\155\x69\x6e\56\143\x73\163\x3f\166\145\x72\x73\x69\157\156\x3d" . UMSN_VERSION);
function get_umsn_option($Dy, $Bn = null)
{
    $Dy = ($Bn == null ? "\x6d\157\137\165\x6d\x5f\x73\155\x73\137" : $Bn) . $Dy;
    return get_mo_option($Dy, '');
}
function update_umsn_option($jE, $qL, $Bn = null)
{
    $jE = ($Bn === null ? "\155\157\137\x75\x6d\137\x73\155\163\x5f" : $Bn) . $jE;
    update_mo_option($jE, $qL, '');
}
