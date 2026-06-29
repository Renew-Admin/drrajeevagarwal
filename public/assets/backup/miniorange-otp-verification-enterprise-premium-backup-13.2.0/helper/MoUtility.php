<?php


namespace OTP\Helper;

use OTP\Objects\NotificationSettings;
use OTP\Objects\TabDetails;
use OTP\Helper\CountryList;
use OTP\Objects\Tabs;
use ReflectionClass;
use ReflectionException;
use stdClass;
if (defined("\x41\x42\x53\x50\101\x54\x48")) {
    goto UtP;
}
exit;
UtP:
class MoUtility
{
    public static function checkForScriptTags($Yc)
    {
        return preg_match("\74\163\x63\x72\x69\x70\164\x3e", $Yc, $cv);
    }
    public static function moGetCountryNameFromIP()
    {
        if (!empty($_SERVER["\110\x54\x54\x50\137\103\114\111\105\x4e\124\x5f\x49\120"])) {
            goto z3A;
        }
        if (!empty($_SERVER["\x48\x54\124\x50\x5f\130\x5f\x46\117\x52\x57\x41\122\104\x45\x44\x5f\x46\117\x52"])) {
            goto Jta;
        }
        $LZ = $_SERVER["\x52\x45\x4d\x4f\124\105\137\101\104\x44\122"];
        goto n73;
        Jta:
        $LZ = $_SERVER["\x48\x54\x54\120\x5f\130\137\x46\x4f\x52\x57\101\122\104\x45\104\x5f\106\117\x52"];
        n73:
        goto pMy;
        z3A:
        $LZ = $_SERVER["\x48\124\x54\x50\x5f\103\114\x49\x45\116\124\x5f\111\120"];
        pMy:
        $Oz = MoConstants::MOCOUNTRY;
        return $Oz;
    }
    public static function get_hidden_phone($Dk)
    {
        return "\170\170\x78\x78\x78\x78\x78" . substr($Dk, strlen($Dk) - 3);
    }
    public static function isBlank($qL)
    {
        return !isset($qL) || empty($qL);
    }
    public static function createJson($bC, $uO)
    {
        return array("\x6d\x65\163\x73\141\147\x65" => $bC, "\162\145\x73\x75\154\x74" => $uO);
    }
    public static function mo_is_curl_installed()
    {
        return in_array("\x63\x75\x72\x6c", get_loaded_extensions());
    }
    public static function currentPageUrl()
    {
        $J5 = "\x68\164\164\x70";
        if (!(isset($_SERVER["\110\124\124\120\123"]) && $_SERVER["\110\124\124\120\123"] == "\x6f\156")) {
            goto Wsc;
        }
        $J5 .= "\x73";
        Wsc:
        $J5 .= "\72\x2f\x2f";
        if ($_SERVER["\123\105\x52\126\x45\x52\x5f\x50\117\122\x54"] != "\70\60") {
            goto g2w;
        }
        $J5 .= $_SERVER["\x53\x45\x52\126\x45\122\x5f\x4e\101\115\105"] . $_SERVER["\x52\x45\121\125\x45\x53\124\x5f\x55\122\111"];
        goto h5A;
        g2w:
        $J5 .= $_SERVER["\123\105\x52\126\x45\122\137\x4e\101\x4d\x45"] . "\x3a" . $_SERVER["\x53\105\122\x56\x45\122\x5f\x50\117\x52\124"] . $_SERVER["\x52\x45\x51\125\x45\x53\124\137\x55\122\x49"];
        h5A:
        if (!function_exists("\141\160\x70\x6c\171\x5f\x66\x69\x6c\x74\x65\162\163")) {
            goto L5h;
        }
        apply_filters("\x6d\x6f\x5f\143\x75\162\154\x5f\160\141\x67\145\137\165\162\154", $J5);
        L5h:
        return $J5;
    }
    public static function getDomain($mo)
    {
        return $vd = substr(strrchr($mo, "\100"), 1);
    }
    public static function validatePhoneNumber($Dk)
    {
        return preg_match(MoConstants::PATTERN_PHONE, MoUtility::processPhoneNumber($Dk), $W0);
    }
    public static function checkForSelectedCountryAddon($Dk)
    {
        $D6 = CountryList::getCountryCodeList();
        $D6 = apply_filters("\x73\145\154\x65\143\164\145\144\x5f\x63\x6f\x75\x6e\x74\162\x69\x65\163", $D6);
        foreach ($D6 as $j1 => $qL) {
            if (!(strpos($Dk, $qL["\x63\157\165\x6e\x74\162\x79\103\157\144\145"]) !== false)) {
                goto x5t;
            }
            return false;
            x5t:
            HYy:
        }
        ArS:
        return true;
    }
    public static function isCountryCodeAppended($Dk)
    {
        return preg_match(MoConstants::PATTERN_COUNTRY_CODE, $Dk, $W0) ? true : false;
    }
    public static function processPhoneNumber($Dk)
    {
        $Dk = preg_replace(MoConstants::PATTERN_SPACES_HYPEN, '', ltrim(trim($Dk), "\60"));
        $B1 = CountryList::getDefaultCountryCode();
        $Dk = !isset($B1) || MoUtility::isCountryCodeAppended($Dk) ? $Dk : $B1 . $Dk;
        return apply_filters("\155\x6f\x5f\x70\x72\157\x63\x65\x73\x73\137\160\150\157\156\145", $Dk);
    }
    public static function micr()
    {
        $mo = get_mo_option("\x61\144\155\151\156\137\145\155\x61\151\x6c");
        $Yw = get_mo_option("\x61\x64\x6d\x69\156\137\143\x75\163\x74\x6f\x6d\x65\x72\x5f\x6b\x65\x79");
        if (!$mo || !$Yw || !is_numeric(trim($Yw))) {
            goto PWu;
        }
        return 1;
        goto OUE;
        PWu:
        return 0;
        OUE:
    }
    public static function rand()
    {
        $Ho = wp_rand(0, 15);
        $pJ = "\x30\x31\62\x33\64\x35\66\67\70\71\x61\142\x63\144\145\146\x67\x68\151\x6a\153\154\155\x6e\x6f\x70\x71\x72\163\164\165\166\167\170\x79\172\101\x42\x43\x44\x45\x46\x47\110\x49\x4a\113\114\115\116\x4f\120\121\x52\x53\124\125\126\127\x58\x59\x5a";
        $dU = '';
        $tt = 0;
        yP6:
        if (!($tt < $Ho)) {
            goto NDD;
        }
        $dU .= $pJ[wp_rand(0, strlen($pJ) - 1)];
        ltF:
        $tt++;
        goto yP6;
        NDD:
        return $dU;
    }
    public static function micv()
    {
        $mo = get_mo_option("\x61\x64\x6d\x69\156\x5f\145\155\x61\151\154");
        $Yw = get_mo_option("\x61\x64\x6d\151\x6e\x5f\x63\x75\x73\164\x6f\x6d\x65\162\137\x6b\145\x79");
        $xc = get_mo_option("\143\x68\145\x63\153\137\x6c\156");
        if (!$mo || !$Yw || !is_numeric(trim($Yw))) {
            goto MDd;
        }
        return $xc ? $xc : 0;
        goto Uqv;
        MDd:
        return 0;
        Uqv:
    }
    public static function _handle_mo_check_ln($WN, $Yw, $B2)
    {
        $xM = MoMessages::FREE_PLAN_MSG;
        $K9 = array();
        $ig = GatewayFunctions::instance();
        $zw = json_decode(MocURLOTP::check_customer_ln($Yw, $B2, $ig->getApplicationName()), true);
        if (strcasecmp($zw["\x73\164\x61\x74\x75\x73"], "\x53\125\103\103\105\x53\123") == 0) {
            goto phC;
        }
        $zw = json_decode(MocURLOTP::check_customer_ln($Yw, $B2, "\x77\160\x5f\145\x6d\x61\x69\154\137\166\x65\x72\151\x66\x69\x63\141\x74\151\x6f\156\x5f\151\156\164\162\141\x6e\145\x74"), true);
        if (!MoUtility::sanitizeCheck("\154\x69\x63\x65\156\163\x65\120\x6c\x61\x6e", $zw)) {
            goto gN0;
        }
        $xM = MoMessages::INSTALL_PREMIUM_PLUGIN;
        gN0:
        goto kfS;
        phC:
        $m9 = isset($zw["\145\x6d\141\151\154\122\145\x6d\141\x69\x6e\151\156\147"]) ? $zw["\145\x6d\x61\151\154\x52\145\x6d\141\151\156\x69\x6e\147"] : 0;
        $fE = isset($zw["\163\155\x73\x52\x65\x6d\141\x69\x6e\x69\156\147"]) ? $zw["\x73\x6d\163\122\145\155\x61\151\156\151\x6e\147"] : 0;
        if (!MoUtility::sanitizeCheck("\154\151\143\x65\x6e\163\145\x50\154\141\x6e", $zw)) {
            goto N8j;
        }
        if (strcmp(MOV_TYPE, "\x4d\151\x6e\151\117\162\141\156\x67\145\x47\x61\164\145\x77\x61\x79") === 0 || strcmp(MOV_TYPE, "\105\156\164\145\x72\160\162\x69\163\x65\107\x61\164\x65\x77\x61\x79\x57\151\x74\150\x41\x64\144\x6f\x6e\x73") === 0) {
            goto CWI;
        }
        $xM = MoMessages::UPGRADE_MSG;
        $K9 = array("\160\x6c\141\156" => $zw["\x6c\x69\x63\145\156\163\x65\120\154\x61\156"]);
        goto Sth;
        CWI:
        $xM = MoMessages::REMAINING_TRANSACTION_MSG;
        $K9 = array("\160\x6c\141\x6e" => $zw["\x6c\151\x63\x65\156\x73\145\x50\x6c\141\156"], "\163\155\x73" => $fE, "\145\x6d\x61\151\154" => $m9);
        Sth:
        update_mo_option("\x63\x68\145\143\x6b\137\154\156", base64_encode($zw["\x6c\x69\143\145\x6e\x73\145\120\154\x61\x6e"]));
        N8j:
        update_mo_option("\145\x6d\x61\x69\154\137\164\162\141\x6e\163\141\x63\164\x69\157\x6e\x73\137\x72\x65\155\x61\151\156\151\156\x67", $m9);
        update_mo_option("\160\x68\x6f\156\145\137\164\x72\141\x6e\x73\x61\143\x74\x69\x6f\x6e\x73\137\162\145\155\x61\151\156\151\x6e\x67", $fE);
        kfS:
        if (!$WN) {
            goto uve;
        }
        do_action("\155\157\x5f\x72\x65\147\151\x73\164\x72\x61\164\151\x6f\x6e\137\x73\150\x6f\x77\x5f\x6d\x65\163\x73\x61\147\x65", MoMessages::showMessage($xM, $K9), "\x53\125\x43\x43\x45\x53\x53");
        uve:
    }
    public static function initialize_transaction($form)
    {
        $tP = new ReflectionClass(FormSessionVars::class);
        foreach ($tP->getConstants() as $j1 => $qL) {
            MoPHPSessions::unsetSession($qL);
            lEq:
        }
        jLE:
        SessionUtils::initializeForm($form);
    }
    public static function _get_invalid_otp_method()
    {
        return get_mo_option("\151\x6e\166\141\x6c\151\x64\137\x6d\145\x73\163\x61\x67\145", "\x6d\157\x5f\x6f\x74\160\x5f") ? mo_(get_mo_option("\x69\156\x76\141\154\x69\x64\x5f\155\145\x73\163\x61\x67\x65", "\x6d\157\x5f\x6f\164\160\137")) : MoMessages::showMessage(MoMessages::INVALID_OTP);
    }
    public static function _is_polylang_installed()
    {
        return function_exists("\x70\154\x6c\x5f\137") && function_exists("\x70\x6c\154\x5f\162\145\147\x69\163\x74\145\x72\137\163\x74\162\151\156\147");
    }
    public static function replaceString(array $Xc, $Dy)
    {
        foreach ($Xc as $j1 => $qL) {
            $Dy = str_replace("\173" . $j1 . "\175", $qL, $Dy);
            VCG:
        }
        tTN:
        return $Dy;
    }
    private static function testResult()
    {
        $OB = new stdClass();
        $OB->status = MO_FAIL_MODE ? "\x45\122\122\117\x52" : "\x53\125\x43\103\x45\123\123";
        return $OB;
    }
    public static function send_phone_notif($fh, $xM)
    {
        $KT = function ($fh, $xM) {
            return json_decode(MocURLOTP::send_notif(new NotificationSettings($fh, $xM)));
        };
        $fh = MoUtility::processPhoneNumber($fh);
        $xM = self::replaceString(["\160\x68\157\x6e\x65" => str_replace("\53", '', "\x25\x32\x42" . $fh)], $xM);
        $zw = MO_TEST_MODE ? self::testResult() : $KT($fh, $xM);
        return strcasecmp($zw->status, "\x53\x55\103\103\105\x53\x53") == 0 ? true : false;
    }
    public static function send_email_notif($G_, $U7, $jz, $kV, $bC)
    {
        $KT = function ($G_, $U7, $jz, $kV, $bC) {
            $lH = new NotificationSettings($G_, $U7, $jz, $kV, $bC);
            return json_decode(MocURLOTP::send_notif($lH));
        };
        $zw = MO_TEST_MODE ? self::testResult() : $KT($G_, $U7, $jz, $kV, $bC);
        return strcasecmp($zw->status, "\123\125\x43\103\x45\123\x53") == 0 ? true : false;
    }
    public static function sanitizeCheck($j1, $jl)
    {
        if (is_array($jl)) {
            goto If8;
        }
        return $jl;
        If8:
        $qL = !array_key_exists($j1, $jl) || self::isBlank($jl[$j1]) ? false : $jl[$j1];
        return is_array($qL) ? $qL : sanitize_text_field($qL);
    }
    public static function mclv()
    {
        $ig = GatewayFunctions::instance();
        return $ig->mclv();
    }
    public static function isGatewayConfig()
    {
        $ig = GatewayFunctions::instance();
        return $ig->isGatewayConfig();
    }
    public static function isMG()
    {
        $ig = GatewayFunctions::instance();
        return $ig->isMG();
    }
    public static function areFormOptionsBeingSaved($EC)
    {
        return current_user_can("\x6d\141\x6e\x61\147\x65\x5f\x6f\160\164\151\x6f\156\163") && self::micr() && self::mclv() && isset($_POST["\157\x70\x74\x69\x6f\156"]) && $EC == $_POST["\157\x70\x74\x69\x6f\156"];
    }
    public static function is_addon_activated()
    {
        if (!(self::micr() && self::mclv())) {
            goto c05;
        }
        return;
        c05:
        $ve = TabDetails::instance();
        $lO = add_query_arg(array("\x70\141\x67\x65" => $ve->_tabDetails[Tabs::ACCOUNT]->_menuSlug), remove_query_arg("\x61\x64\x64\x6f\156", $_SERVER["\x52\105\121\x55\105\x53\124\137\125\x52\x49"]));
        echo "\74\144\151\166\x20\x73\x74\x79\154\145\x3d\x22\144\151\163\160\154\x61\171\72\x62\154\157\x63\x6b\x3b\x6d\141\162\147\x69\156\55\164\x6f\x70\x3a\x31\x30\160\170\73\x63\157\154\157\162\72\x72\x65\x64\x3b\142\x61\143\x6b\x67\x72\x6f\x75\x6e\144\x2d\x63\x6f\x6c\x6f\162\72\x72\x67\142\x61\x28\x32\x35\61\x2c\x20\62\63\62\x2c\x20\60\x2c\x20\x30\x2e\x31\x35\51\73\15\xa\x9\11\x9\x9\x9\x9\11\x9\x70\141\144\x64\x69\x6e\147\72\x35\160\170\73\142\x6f\x72\x64\145\x72\72\163\157\154\151\x64\40\61\x70\170\x20\162\147\x62\141\50\62\65\65\x2c\x20\x30\54\x20\71\x2c\x20\60\x2e\x33\66\x29\x3b\x22\76\15\xa\x9\x9\11\40\11\11\74\141\x20\x68\162\x65\x66\75\42" . $lO . "\42\x3e" . mo_("\x56\x61\154\151\x64\x61\x74\x65\40\x79\x6f\165\x72\40\x70\165\162\x63\150\x61\163\x65") . "\74\x2f\x61\76\x20\xd\xa\x9\11\x9\x20\x9\x9\11\x9" . mo_("\40\x74\x6f\40\x65\x6e\141\142\154\145\40\164\x68\x65\40\101\x64\144\x20\117\156") . "\74\57\144\x69\166\x3e";
    }
    public static function getActivePluginVersion($RF, $k0 = 0)
    {
        if (!function_exists("\x67\x65\x74\x5f\x70\x6c\165\147\x69\156\163")) {
            require_once ABSPATH . "\167\160\x2d\141\x64\x6d\151\x6e\57\151\156\143\x6c\x75\144\145\x73\57\160\x6c\x75\x67\151\x6e\x2e\x70\x68\x70";
        }
        $rA = get_plugins();
        $RA = get_option("\141\143\164\x69\x76\x65\137\x70\x6c\x75\x67\x69\x6e\x73");
        foreach ($rA as $j1 => $qL) {
            if (!(strcasecmp($qL["\x4e\141\155\x65"], $RF) == 0)) {
                goto Oxm;
            }
            if (!in_array($j1, $RA)) {
                goto Ncs;
            }
            return (int) $qL["\126\x65\x72\163\x69\157\x6e"][$k0];
            Ncs:
            Oxm:
            JB4:
        }
        bHr:
        return null;
    }
}
