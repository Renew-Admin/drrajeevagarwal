<?php


namespace OTP\Handler;

if (defined("\x41\102\123\x50\101\124\x48")) {
    goto QJn;
}
exit;
QJn:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormSessionData;
use OTP\Objects\VerificationLogic;
use OTP\Traits\Instance;
final class PhoneVerificationLogic extends VerificationLogic
{
    use Instance;
    public function _handle_logic($iI, $p1, $NN, $CD, $kt)
    {
        $cv = MoUtility::validatePhoneNumber($NN);
        $XQ = MoUtility::checkForSelectedCountryAddon($NN);
        $bC = MoMessages::showMessage(MoMessages::BLOCKED_COUNTRY);
        if (!$XQ) {
            goto hAe;
        }
        if ($this->_is_ajax_form()) {
            goto FMn;
        }
        miniorange_site_otp_validation_form(null, null, null, $bC, $CD, $kt);
        goto xu2;
        FMn:
        wp_send_json(MoUtility::createJson($bC, MoConstants::COUNTRY_BLOCKED_ERROR));
        xu2:
        hAe:
        switch ($cv) {
            case 0:
                $this->_handle_not_matched($NN, $CD, $kt);
                goto XUw;
            case 1:
                $this->_handle_matched($iI, $p1, $NN, $CD, $kt);
                goto XUw;
        }
        DeT:
        XUw:
    }
    public function _handle_matched($iI, $p1, $NN, $CD, $kt)
    {
        $bC = str_replace("\43\x23\x70\150\x6f\156\145\x23\x23", $NN, $this->_get_is_blocked_message());
        if ($this->_is_blocked($p1, $NN)) {
            goto sWb;
        }
        do_action("\155\x6f\x5f\147\154\x6f\142\141\x6c\154\x79\137\142\141\x6e\x6e\x65\x64\137\x70\x68\x6f\156\x65\x5f\x63\x68\x65\x63\x6b", $NN, $this->_is_ajax_form());
        $this->_start_otp_verification($iI, $p1, $NN, $CD, $kt);
        goto Cit;
        sWb:
        if ($this->_is_ajax_form()) {
            goto TfV;
        }
        miniorange_site_otp_validation_form(null, null, null, $bC, $CD, $kt);
        goto JjL;
        TfV:
        wp_send_json(MoUtility::createJson($bC, MoConstants::ERROR_JSON_TYPE));
        JjL:
        Cit:
    }
    public function _start_otp_verification($iI, $p1, $NN, $CD, $kt)
    {
        $ig = GatewayFunctions::instance();
        $H2 = "\123\x4d\123";
        $H2 = apply_filters("\x6f\164\x70\137\x6f\x76\x65\x72\137\x63\x61\x6c\x6c\x5f\141\143\x74\151\x76\141\164\151\x6f\x6e", $H2);
        $zw = $ig->mo_send_otp_token($H2, '', $NN);
        switch ($zw["\163\164\x61\x74\x75\x73"]) {
            case "\123\x55\103\103\x45\123\123":
                $this->_handle_otp_sent($iI, $p1, $NN, $CD, $kt, $zw);
                goto DE4;
            default:
                $this->_handle_otp_sent_failed($iI, $p1, $NN, $CD, $kt, $zw);
                goto DE4;
        }
        jMs:
        DE4:
    }
    public function _handle_not_matched($NN, $CD, $kt)
    {
        $bC = str_replace("\43\x23\160\x68\x6f\156\x65\x23\x23", $NN, $this->_get_otp_invalid_format_message());
        if ($this->_is_ajax_form()) {
            goto NaO;
        }
        miniorange_site_otp_validation_form(null, null, null, $bC, $CD, $kt);
        goto KwY;
        NaO:
        wp_send_json(MoUtility::createJson($bC, MoConstants::ERROR_JSON_TYPE));
        KwY:
    }
    public function _handle_otp_sent_failed($iI, $p1, $NN, $CD, $kt, $zw)
    {
        $bC = str_replace("\43\43\160\150\x6f\156\x65\43\x23", $NN, $this->_get_otp_sent_failed_message());
        if ($this->_is_ajax_form()) {
            goto q8M;
        }
        miniorange_site_otp_validation_form(null, null, null, $bC, $CD, $kt);
        goto BZ6;
        q8M:
        wp_send_json(MoUtility::createJson($bC, MoConstants::ERROR_JSON_TYPE));
        BZ6:
    }
    public function _handle_otp_sent($iI, $p1, $NN, $CD, $kt, $zw)
    {
        SessionUtils::setPhoneTransactionID($zw["\x74\170\x49\144"]);
        if (!(MoUtility::micr() && MoUtility::isMG())) {
            goto BbA;
        }
        $zv = get_mo_option("\160\x68\157\156\x65\137\164\162\141\x6e\163\x61\143\164\x69\157\x6e\x73\x5f\162\145\155\x61\151\x6e\x69\x6e\147");
        if (!($zv > 0 && MO_TEST_MODE == false)) {
            goto rAk;
        }
        update_mo_option("\x70\x68\x6f\x6e\145\x5f\x74\x72\x61\156\x73\x61\143\x74\151\x6f\156\x73\137\162\145\155\141\151\x6e\x69\156\x67", $zv - 1);
        rAk:
        BbA:
        $bC = str_replace("\43\43\160\x68\x6f\156\145\43\x23", $NN, $this->_get_otp_sent_message());
        if ($this->_is_ajax_form()) {
            goto ivG;
        }
        miniorange_site_otp_validation_form($iI, $p1, $NN, $bC, $CD, $kt);
        goto iSb;
        ivG:
        wp_send_json(MoUtility::createJson($bC, MoConstants::SUCCESS_JSON_TYPE));
        iSb:
    }
    public function _get_otp_sent_message()
    {
        $Qj = get_mo_option("\163\x75\143\143\145\x73\163\137\160\150\157\x6e\x65\137\155\145\x73\x73\141\x67\145", "\155\157\137\157\164\160\x5f");
        return $Qj ? mo_($Qj) : MoMessages::showMessage(MoMessages::OTP_SENT_PHONE);
    }
    public function _get_otp_sent_failed_message()
    {
        $vN = get_mo_option("\x65\x72\162\x6f\x72\x5f\x70\150\x6f\x6e\x65\x5f\x6d\x65\163\163\141\147\145", "\155\x6f\x5f\157\164\160\137");
        $vN = $vN ? mo_($vN) : MoMessages::showMessage(MoMessages::ERROR_OTP_PHONE);
        $vN = apply_filters("\155\x6f\137\x67\145\164\137\x6f\164\x70\137\x73\145\156\164\x5f\x66\x61\x69\x6c\x65\144\137\155\x65\x73\163\141\147\145", $vN);
        return $vN;
    }
    public function _get_otp_invalid_format_message()
    {
        $o2 = get_mo_option("\x69\156\x76\141\154\x69\144\x5f\160\x68\x6f\x6e\x65\137\155\145\x73\x73\141\x67\145", "\x6d\x6f\137\x6f\x74\x70\137");
        return $o2 ? mo_($o2) : MoMessages::showMessage(MoMessages::ERROR_PHONE_FORMAT);
    }
    public function _is_blocked($p1, $NN)
    {
        $To = explode("\x3b", get_mo_option("\142\x6c\157\143\x6b\x65\x64\137\x70\150\x6f\156\x65\x5f\156\x75\x6d\x62\x65\x72\x73"));
        $To = apply_filters("\x6d\x6f\137\142\154\157\x63\153\145\144\x5f\160\x68\x6f\156\145\163", $To, $NN);
        return in_array($NN, $To);
    }
    public function _get_is_blocked_message()
    {
        $Hw = get_mo_option("\x62\x6c\x6f\x63\153\x65\144\137\160\x68\157\x6e\x65\x5f\x6d\145\163\163\141\147\145", "\x6d\x6f\137\157\164\160\137");
        return $Hw ? mo_($Hw) : MoMessages::showMessage(MoMessages::ERROR_PHONE_BLOCKED);
    }
}
