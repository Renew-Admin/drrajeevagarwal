<?php


if (defined("\101\102\x53\x50\x41\124\x48")) {
    goto kc;
}
exit;
kc:
define("\115\123\116\x5f\104\x49\122", plugin_dir_path(__FILE__));
define("\x4d\x53\x4e\x5f\125\122\x4c", plugin_dir_url(__FILE__));
define("\115\123\x4e\x5f\126\x45\x52\123\x49\x4f\x4e", "\61\x2e\60\x2e\60");
define("\x4d\123\x4e\137\x43\x53\123\137\125\x52\x4c", MSN_URL . "\151\156\x63\x6c\165\x64\x65\163\57\143\163\x73\57\163\145\x74\x74\x69\156\147\163\56\x6d\151\x6e\56\143\163\x73\77\166\145\162\163\x69\x6f\156\75" . MSN_VERSION);
define("\115\123\116\x5f\x4a\123\x5f\125\x52\x4c", MSN_URL . "\x69\x6e\143\x6c\165\144\x65\x73\x2f\152\163\57\163\145\164\x74\151\156\147\x73\x2e\155\151\x6e\x2e\152\163\77\166\x65\162\x73\151\157\x6e\75" . MSN_VERSION);
function get_wc_option($Dy, $Bn = null)
{
    $Dy = ($Bn === null ? "\x6d\157\137\x77\x63\137\x73\x6d\163\x5f" : $Bn) . $Dy;
    return get_mo_option($Dy, '');
}
function update_wc_option($jE, $qL, $Bn = null)
{
    $jE = ($Bn === null ? "\155\157\137\167\143\137\163\155\163\x5f" : $Bn) . $jE;
    update_mo_option($jE, $qL, '');
}
