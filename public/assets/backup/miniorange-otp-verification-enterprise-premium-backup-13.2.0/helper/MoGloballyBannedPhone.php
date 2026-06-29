<?php


namespace OTP\Helper;

use OTP\Traits\Instance;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
if (defined("\101\102\x53\x50\101\124\x48")) {
    goto MQW;
}
exit;
MQW:
class MoGloballyBannedPhone
{
    use Instance;
    function __construct()
    {
        add_filter("\155\x6f\x5f\147\x6c\157\142\141\154\x6c\171\137\x62\x61\156\156\145\144\x5f\160\150\x6f\156\145\x5f\166\x69\145\x77", [$this, "\x6d\x6f\107\x6c\157\x62\x61\154\x6c\171\x42\x61\156\x6e\x65\x64\120\x68\x6f\x6e\145\x56\151\x65\167"], 1, 1);
        add_action("\155\x6f\137\147\154\157\142\x61\x6c\x6c\x79\x5f\x62\141\156\x6e\145\144\x5f\x70\150\157\x6e\145\x5f\x63\150\x65\x63\153", [$this, "\x69\163\107\x6c\x6f\142\141\154\x6c\171\102\141\156\x6e\x65\x64\x50\x68\157\x6e\145"], 1, 2);
        add_filter("\x73\x65\x74\x5f\143\154\141\163\x73\x5f\x65\170\x69\163\x74\163\x5f\147\x6c\x6f\x62\x61\154\x6c\x79\142\x61\x6e\x6e\145\x64", [$this, "\x73\145\164\x5f\143\x6c\141\163\x73\x5f\145\170\x69\x73\164\163\137\147\154\157\x62\141\154\154\171\x62\141\156\156\x65\144"], 1, 1);
    }
    public function moGloballyBannedPhoneView($a1)
    {
        $hU = get_mo_option("\x67\154\x6f\142\141\154\x6c\171\x5f\142\x61\156\156\145\x64\x5f\160\150\157\x6e\x65") ? "\143\x68\x65\x63\153\145\144" : '';
        $a1 = "\x3c\x74\x72\x3e\15\12\x20\40\x20\40\40\40\40\x20\x20\40\x20\40\x20\x20\x20\40\x20\x20\40\40\x20\40\40\x20\40\40\x20\x20\74\164\144\x3e\15\xa\40\40\40\x20\x20\x20\x20\40\40\40\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\40\40\40\x20\40\40\x20\40\40\40\40\x20\x3c\151\156\x70\165\x74\40\x20\164\x79\160\x65\x3d\x22\x63\x68\145\x63\153\x62\x6f\x78\42\15\12\40\40\40\x20\x20\40\x20\40\x20\40\40\40\40\x20\x20\40\x20\40\x20\x20\40\x20\x20\40\40\40\x20\x20\x20\40\40\40\40\x20\x20\x20\x20\x20\40\40\x6e\141\155\145\75\x22\x6d\157\137\147\154\x6f\142\x61\x6c\x6c\171\x5f\x62\141\x6e\156\x65\x64\137\160\150\157\x6e\x65\42\xd\12\x20\40\x20\40\x20\40\x20\40\x20\x20\40\40\40\x20\x20\x20\40\40\40\40\x20\x20\40\40\40\x20\x20\40\x20\40\x20\40\x20\40\40\40\x20\40\40\x20\x69\x64\75\x22\147\154\x6f\x62\x61\154\154\x79\x42\141\x6e\x6e\x65\144\x50\150\157\x6e\145\x22\x20\xd\xa\40\x20\40\40\x20\40\40\40\40\x20\x20\40\40\40\x20\40\40\40\x20\x20\40\x20\40\x20\x20\40\40\40\x20\40\40\40\x20\x20\x20\x20\x20\x20\x20\x20\166\141\154\165\x65\x3d\x22\61\42\x20" . $hU . "\57\x3e\15\12\x20\x20\x20\40\40\x20\x20\x20\x20\x20\40\x20\x20\x20\40\x20\40\40\x20\x20\x20\40\x20\40\x20\x20\x20\40\x20\x20\x20\x20" . mo_("\103\154\x69\x63\x6b\40\x43\150\145\x63\153\x62\x6f\x78\x20\x54\x6f\40\105\x6e\141\x62\154\x65\40\107\x6c\157\x62\141\154\x6c\x79\40\102\x61\156\x6e\x65\x64\40\x50\x68\x6f\x6e\145\40\116\x75\x6d\x62\145\x72\x73\40\103\150\145\143\153") . "\40\15\12\x20\x20\x20\x20\x20\40\40\x20\40\40\x20\x20\40\x20\x20\x20\40\40\x20\x20\x20\40\40\40\x20\40\x20\x20\x20\x20\x20\40\74\x64\151\166\x20\143\154\141\x73\x73\x3d\42\x6d\x6f\x5f\x6f\164\160\x5f\x6e\157\x74\145\42\40\x73\x74\x79\x6c\145\75\42\x63\157\x6c\157\x72\72\x23\x39\64\62\x38\x32\70\73\42\x3e\15\12\40\40\x20\40\40\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\40\40\x20\x20\x20\x20\40\40\40\40\40\x20\74\x69\x3e\x46\157\x72\x20\105\x78\141\155\160\x6c\x65\72\x20\x2b\61\x31\x31\61\61\x31\x30\60\60\54\x2b\62\x32\62\62\62\x32\62\62\54\53\60\61\60\61\60\61\60\x31\60\x31\x30\x2c\40\x2b\65\x35\65\x35\x35\65\62\62\x32\62\62\54\40\53\61\62\x33\x34\x35\x36\67\x38\71\x3c\57\151\76\15\xa\40\x20\x20\x20\x20\40\x20\40\x20\40\x20\x20\x20\40\40\40\40\x20\x20\x20\x20\40\40\40\40\40\40\x20\40\40\x20\x20\x20\x20\40\x20\74\x2f\144\x69\x76\x3e\xd\xa\x20\x20\40\40\40\x20\x20\40\40\40\x20\x20\x20\40\x20\x20\40\x20\x20\x20\40\40\x20\x20\x20\40\40\x20\x3c\x2f\x74\x64\x3e\15\12\40\40\x20\x20\x20\40\40\x20\40\x20\40\x20\x20\40\x20\x20\40\x20\40\x20\40\x20\x20\x20\x3c\x2f\x74\x72\76";
        return $a1;
    }
    public function isGloballyBannedPhone($Dk, $S3)
    {
        if (!empty(get_mo_option("\x67\154\157\142\141\x6c\x6c\171\137\142\x61\156\x6e\x65\x64\x5f\160\x68\x6f\x6e\x65"))) {
            goto pGs;
        }
        return;
        pGs:
        if (!self::blockNumberOrNot($Dk)) {
            goto gsP;
        }
        $bC = str_replace("\x23\x23\160\150\x6f\x6e\x65\x23\x23", $Dk, $this->_get_is_globally_blocked_message());
        if ($S3) {
            goto FLb;
        }
        miniorange_site_otp_validation_form(null, null, null, $bC, $CD, $kt);
        goto kQq;
        FLb:
        wp_send_json(MoUtility::createJson($bC, MoConstants::ERROR_JSON_TYPE));
        kQq:
        gsP:
    }
    private function blockNumberOrNot($iM)
    {
        $Ha = 1;
        if (!(strlen($iM) > 15)) {
            goto iVr;
        }
        return true;
        iVr:
        $iM = substr($iM, 4);
        $Dk = str_split($iM);
        if (!(count(array_unique($Dk)) <= 2)) {
            goto I2n;
        }
        return true;
        I2n:
        sort($Dk, SORT_NUMERIC);
        $Dk = implode($Dk);
        if (!($iM === $Dk)) {
            goto YQw;
        }
        return true;
        YQw:
        $tt = 0;
        G1C:
        if (!($tt < strlen($Dk))) {
            goto dwg;
        }
        if (!($Dk[$tt] + 1 == $Dk[$tt + 1])) {
            goto zLF;
        }
        $Ha++;
        zLF:
        tzk:
        $tt++;
        goto G1C;
        dwg:
        if (!($Ha >= strlen($Dk) - 1)) {
            goto Hqf;
        }
        return true;
        Hqf:
        return false;
    }
    private function _get_is_globally_blocked_message()
    {
        $Hw = get_mo_option("\147\154\x6f\142\141\154\154\171\x5f\x62\141\156\x6e\x65\x64\137\x70\x68\x6f\156\145\x5f\x6d\x65\163\x73\x61\147\145", "\155\x6f\137\x6f\164\x70\x5f");
        return $Hw ? $Hw : MoMessages::showMessage(MoMessages::GLOBALLY_INVALID_PHONE_FORMAT);
    }
    public function set_class_exists_globallybanned($ai)
    {
        return TRUE;
    }
}
