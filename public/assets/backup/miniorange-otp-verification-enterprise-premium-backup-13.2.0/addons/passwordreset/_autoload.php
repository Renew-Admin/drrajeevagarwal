<?php


if (defined("\101\102\123\120\x41\124\110")) {
    goto N2;
}
exit;
N2:
define("\x55\x4d\x50\122\x5f\x44\x49\122", plugin_dir_path(__FILE__));
define("\125\x4d\x50\x52\x5f\125\x52\x4c", plugin_dir_url(__FILE__));
define("\125\115\x50\x52\x5f\x56\105\x52\x53\111\x4f\116", "\61\x2e\x30\56\x30");
define("\x55\115\120\122\x5f\x43\x53\x53\x5f\125\x52\114", UMPR_URL . "\x69\x6e\143\x6c\x75\x64\x65\163\x2f\x63\163\x73\x2f\x73\x65\164\x74\x69\x6e\147\163\x2e\x6d\x69\156\56\x63\163\163\77\166\145\162\163\x69\157\x6e\x3d" . UMPR_VERSION);
function get_umpr_option($Dy, $Bn = null)
{
    $Dy = ($Bn == null ? "\155\x6f\137\x75\155\137\160\x72\x5f" : $Bn) . $Dy;
    return get_mo_option($Dy, '');
}
function update_umpr_option($jE, $qL, $Bn = null)
{
    $jE = ($Bn === null ? "\155\157\x5f\165\x6d\x5f\160\162\137" : $Bn) . $jE;
    update_mo_option($jE, $qL, '');
}
