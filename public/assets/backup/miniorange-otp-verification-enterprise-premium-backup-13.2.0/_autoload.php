<?php


use OTP\Helper\FormList;
use OTP\Helper\FormSessionData;
use OTP\Helper\MoUtility;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\SplClassLoader;
if (defined("\x41\102\x53\x50\x41\124\x48")) {
    goto vgu;
}
exit;
vgu:
define("\x4d\117\126\x5f\x44\111\122", plugin_dir_path(__FILE__));
define("\x4d\117\126\137\x55\122\x4c", plugin_dir_url(__FILE__));
$aU = wp_remote_retrieve_body(wp_remote_get(MOV_URL . "\160\x61\x63\x6b\141\x67\145\x2e\152\163\x6f\156", ["\x73\163\154\166\145\162\x69\x66\171" => false]));
$Js = json_decode($aU);
if (!(json_last_error() !== 0)) {
    goto RNP;
}
$Js = json_decode(initializePackageJson());
RNP:
define("\x4d\117\126\137\126\x45\x52\123\111\x4f\x4e", $Js->version);
define("\x4d\117\x56\137\124\131\x50\x45", $Js->type);
define("\x4d\x4f\x56\x5f\x48\x4f\123\x54", $Js->hostname);
define("\115\x4f\x56\x5f\104\x45\x46\x41\125\x4c\x54\x5f\103\x55\x53\x54\117\115\x45\x52\113\105\x59", $Js->dCustomerKey);
define("\115\117\126\137\104\x45\106\101\x55\114\x54\137\101\x50\x49\113\105\x59", $Js->dApiKey);
define("\x4d\x4f\126\x5f\123\x53\x4c\x5f\126\x45\122\x49\106\x59", $Js->sslVerify);
define("\115\x4f\x56\x5f\103\x53\123\x5f\125\122\x4c", MOV_URL . "\151\x6e\x63\x6c\165\x64\x65\163\x2f\x63\x73\x73\x2f\155\x6f\137\x63\x75\163\164\157\155\145\x72\137\x76\x61\x6c\151\144\x61\x74\x69\157\156\137\x73\x74\171\154\x65\x2e\x6d\151\x6e\x2e\143\x73\163\77\166\x65\x72\x73\x69\x6f\156\75" . MOV_VERSION);
define("\x4d\x4f\126\137\106\117\x52\x4d\137\103\123\x53", MOV_URL . "\151\x6e\143\x6c\165\144\145\x73\57\x63\163\x73\x2f\155\x6f\137\146\x6f\162\155\x73\x5f\x63\163\x73\x2e\x6d\151\156\x2e\x63\x73\163\77\x76\145\x72\x73\x69\x6f\156\x3d" . MOV_VERSION);
define("\x4d\x4f\137\111\x4e\124\124\105\114\x49\116\x50\x55\124\x5f\x43\123\x53", MOV_URL . "\151\x6e\x63\x6c\165\x64\x65\x73\57\143\163\x73\x2f\151\x6e\164\x6c\124\145\x6c\x49\x6e\160\165\164\56\x6d\x69\x6e\56\x63\x73\x73\77\x76\x65\162\x73\x69\157\x6e\x3d" . MOV_VERSION);
define("\x4d\117\126\x5f\x4a\123\x5f\x55\122\114", MOV_URL . "\x69\156\143\154\x75\x64\145\163\57\x6a\163\57\x73\145\164\x74\x69\156\x67\x73\56\x6d\x69\x6e\56\152\163\x3f\166\145\162\x73\x69\157\156\x3d" . MOV_VERSION);
define("\126\x41\x4c\111\104\x41\124\111\x4f\x4e\x5f\112\x53\137\x55\x52\114", MOV_URL . "\151\156\x63\x6c\x75\144\145\163\x2f\x6a\163\57\146\157\x72\155\x56\x61\154\151\144\141\x74\x69\157\156\x2e\x6d\151\x6e\x2e\x6a\x73\x3f\166\145\162\163\x69\x6f\x6e\75" . MOV_VERSION);
define("\x4d\117\x5f\111\x4e\x54\x54\x45\x4c\x49\x4e\120\x55\124\x5f\x4a\123", MOV_URL . "\x69\156\143\x6c\165\x64\145\x73\x2f\x6a\x73\57\151\x6e\164\x6c\124\x65\x6c\111\x6e\x70\165\164\x2e\155\151\156\56\x6a\x73\x3f\x76\145\x72\x73\151\x6f\156\75" . MOV_VERSION);
define("\x4d\x4f\137\104\x52\x4f\x50\x44\117\x57\116\x5f\112\123", MOV_URL . "\151\x6e\x63\154\x75\144\145\x73\57\x6a\x73\57\144\x72\x6f\x70\x64\x6f\167\156\x2e\155\151\156\x2e\x6a\163\77\x76\145\162\x73\151\157\156\75" . MOV_VERSION);
define("\x4d\117\x56\137\x4c\x4f\101\104\105\122\x5f\125\122\x4c", MOV_URL . "\151\156\143\x6c\165\144\x65\163\57\151\x6d\x61\147\x65\163\x2f\x6c\x6f\x61\144\145\x72\56\147\x69\146");
define("\x4d\x4f\x56\x5f\104\117\x4e\x41\x54\105", MOV_URL . "\151\156\x63\154\165\x64\145\x73\57\x69\155\x61\x67\x65\x73\x2f\x64\x6f\x6e\141\164\x65\56\x70\156\147");
define("\115\x4f\126\137\x50\x41\131\x50\x41\114", MOV_URL . "\151\156\x63\x6c\x75\144\145\163\57\x69\155\x61\147\145\x73\57\160\141\171\160\x61\x6c\56\160\x6e\x67");
define("\x4d\117\126\137\116\x45\124\x42\x41\116\113", MOV_URL . "\151\156\x63\154\165\x64\x65\x73\x2f\x69\155\141\147\145\163\x2f\156\145\x74\x62\x61\x6e\x6b\151\156\x67\56\x70\156\x67");
define("\x4d\x4f\x56\x5f\103\x41\x52\x44", MOV_URL . "\x69\x6e\x63\x6c\165\x64\145\163\x2f\x69\x6d\141\x67\x65\163\x2f\143\141\x72\x64\56\160\156\x67");
define("\115\117\x56\x5f\x4c\117\x47\x4f\x5f\125\122\114", MOV_URL . "\151\156\x63\154\165\144\145\x73\x2f\151\x6d\x61\147\145\163\57\154\x6f\147\157\56\x70\156\147");
define("\115\x4f\126\x5f\111\x43\x4f\x4e", MOV_URL . "\x69\x6e\143\x6c\x75\x64\145\x73\x2f\151\x6d\141\x67\145\x73\x2f\x6d\x69\x6e\151\x6f\162\141\x6e\147\145\137\151\143\157\x6e\x2e\160\156\147");
define("\x4d\x4f\x56\137\x49\x43\117\x4e\137\x47\x49\106", MOV_URL . "\x69\156\143\154\x75\x64\145\163\57\151\155\141\x67\145\x73\x2f\155\157\137\151\143\157\x6e\x2e\147\x69\x66");
define("\115\x4f\137\x43\125\123\124\117\x4d\137\106\x4f\122\x4d", MOV_URL . "\151\156\x63\x6c\x75\144\145\x73\57\152\x73\57\x63\x75\x73\x74\157\155\x46\x6f\162\x6d\x2e\x6a\x73\x3f\166\145\162\x73\151\x6f\x6e\x3d" . MOV_VERSION);
define("\x4d\117\x56\x5f\x41\x44\104\117\x4e\x5f\x44\x49\122", MOV_DIR . "\141\x64\x64\x6f\156\163\57");
define("\x4d\x4f\126\137\x55\x53\x45\x5f\120\x4f\x4c\x59\114\x41\116\x47", TRUE);
define("\x4d\x4f\137\x54\105\x53\124\x5f\x4d\x4f\104\105", $Js->testMode);
define("\x4d\x4f\137\x46\101\111\x4c\137\115\x4f\x44\x45", $Js->failMode);
define("\x4d\x4f\126\x5f\x53\105\x53\x53\111\117\x4e\137\124\x59\x50\105", $Js->session);
define("\x4d\x4f\126\137\x4d\x41\111\114\x5f\114\117\107\117", MOV_URL . "\151\x6e\143\x6c\165\144\145\163\x2f\151\x6d\x61\x67\x65\163\x2f\x6d\x6f\x5f\163\165\160\160\x6f\x72\164\137\151\x63\x6f\x6e\x2e\x70\156\x67");
define("\115\117\126\x5f\117\x46\x46\105\122\x53\137\114\117\107\x4f", MOV_URL . "\151\156\x63\x6c\x75\144\145\x73\x2f\x69\x6d\141\147\145\163\57\155\x6f\x5f\163\141\x6c\x65\x5f\151\x63\x6f\156\56\160\156\x67");
define("\115\x4f\x56\137\106\105\101\x54\125\x52\105\x53\137\107\x52\x41\x50\110\x49\x43", MOV_URL . "\x69\156\143\154\165\x64\145\163\x2f\x69\x6d\141\147\145\x73\x2f\155\x6f\137\x66\145\141\164\x75\x72\x65\x73\137\x67\x72\x61\160\x68\151\x63\x2e\160\156\x67");
define("\115\x4f\126\137\124\131\120\x45\x5f\120\114\x41\x4e", $Js->typePlan);
define("\115\117\126\137\x4c\x49\103\105\x4e\x53\105\137\x4e\x41\x4d\x45", $Js->licenseName);
include "\x53\x70\x6c\x43\154\141\x73\x73\114\157\x61\144\145\x72\x2e\x70\150\160";
$IA = new SplClassLoader("\x4f\x54\x50", realpath(__DIR__ . DIRECTORY_SEPARATOR . "\56\x2e"));
$IA->register();
require_once "\x76\151\x65\x77\163\57\143\157\155\155\x6f\156\x2d\145\154\x65\155\145\156\x74\163\x2e\x70\x68\x70";
initializeForms();
function initializeForms()
{
    $HC = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(MOV_DIR . "\150\x61\x6e\x64\x6c\x65\x72\57\146\x6f\162\155\163", RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($HC as $J3) {
        $xI = $J3->getFilename();
        $XN = "\x4f\x54\120\x5c\110\x61\x6e\x64\x6c\x65\162\134\x46\x6f\x72\155\163\134" . str_replace("\x2e\x70\x68\x70", '', $xI);
        $ou = FormList::instance();
        $PN = $XN::instance();
        $ou->add($PN->getFormKey(), $PN);
        af4:
    }
    o1N:
}
function admin_post_url()
{
    return admin_url("\141\144\x6d\151\156\x2d\160\x6f\163\x74\x2e\160\150\160");
}
function wp_ajax_url()
{
    return admin_url("\141\144\x6d\x69\156\55\141\152\x61\x78\56\160\x68\160");
}
function mo_($Dy)
{
    $Op = "\155\151\x6e\151\x6f\162\x61\x6e\147\145\55\x6f\x74\160\55\x76\x65\x72\151\x66\151\x63\141\x74\151\x6f\x6e";
    $Dy = preg_replace("\x2f\x5c\163\x2b\x2f\123", "\x20", $Dy);
    return is_scalar($Dy) ? MoUtility::_is_polylang_installed() && MOV_USE_POLYLANG ? pll__($Dy) : __($Dy, $Op) : $Dy;
}
function get_mo_option($Dy, $Bn = null)
{
    $Dy = ($Bn === null ? "\x6d\157\x5f\x63\x75\x73\x74\157\155\x65\162\137\x76\141\154\x69\144\x61\164\x69\157\156\137" : $Bn) . $Dy;
    return apply_filters("\x67\145\164\137\155\x6f\x5f\157\x70\164\x69\157\156", get_site_option($Dy));
}
function update_mo_option($Dy, $qL, $Bn = null)
{
    $Dy = ($Bn === null ? "\x6d\157\x5f\x63\x75\x73\x74\157\x6d\145\162\x5f\166\141\x6c\x69\x64\141\x74\x69\157\156\x5f" : $Bn) . $Dy;
    update_site_option($Dy, apply_filters("\x75\x70\144\x61\164\145\137\x6d\157\137\x6f\160\x74\x69\157\x6e", $qL, $Dy));
}
function delete_mo_option($Dy, $Bn = null)
{
    $Dy = ($Bn === null ? "\x6d\x6f\x5f\143\x75\163\x74\157\155\145\162\137\x76\x61\x6c\x69\x64\141\164\x69\x6f\x6e\x5f" : $Bn) . $Dy;
    delete_site_option($Dy);
}
function get_mo_class($r0)
{
    $u5 = get_class($r0);
    return substr($u5, strrpos($u5, "\x5c") + 1);
}
function initializePackageJson()
{
    $st = json_encode(["\156\141\155\x65" => "\x6d\151\x6e\x69\157\x72\141\x6e\147\145\x2d\x6f\x74\x70\x2d\x76\x65\162\x69\146\x69\143\141\164\151\x6f\x6e\55\145\x6e\164\145\x72\160\x72\x69\163\145", "\166\145\x72\163\151\157\x6e" => "13.2.0", "\164\x79\x70\x65" => "\105\x6e\x74\x65\x72\160\x72\x69\163\145\107\x61\164\x65\167\141\x79\127\x69\164\x68\101\x64\x64\x6f\x6e\x73", "\164\145\x73\x74\x4d\157\x64\145" => false, "\x66\141\151\x6c\x4d\x6f\x64\x65" => false, "\x68\157\x73\164\156\x61\155\145" => "https://login.xecurify.com", "\x64\x43\x75\163\164\x6f\x6d\145\x72\x4b\x65\x79" => "\x31\66\65\65\x35", "\x64\101\x70\x69\113\x65\171" => "\x66\x46\144\x32\130\x63\x76\x54\107\104\x65\155\132\166\142\167\x31\x62\x63\x55\x65\x73\x4e\x4a\127\105\161\113\x62\x62\x55\x71", "\163\163\x6c\126\145\x72\x69\146\171" => false, "\x73\x65\x73\163\151\157\x6e" => "\124\x52\x41\x4e\x53\x49\105\x4e\x54", "\x74\171\x70\x65\x50\x6c\x61\x6e" => "\x77\x70\137\145\155\141\151\154\137\x76\145\x72\x69\146\151\143\141\164\x69\157\156\x5f\x69\x6e\164\x72\141\x6e\x65\x74\x5f\145\x6e\164\x65\162\160\162\151\x73\145\137\x70\x6c\x61\156", "\154\151\143\x65\x6e\x73\x65\x4e\141\x6d\145" => "\x57\x50\137\105\115\101\x49\114\137\x56\105\122\111\106\111\x43\x41\x54\x49\x4f\x4e\137\x49\116\124\x52\x41\x4e\105\x54\x5f\105\x4e\x54\105\x52\x50\x52\111\x53\105\x5f\x50\114\101\x4e"]);
    return $st;
}
