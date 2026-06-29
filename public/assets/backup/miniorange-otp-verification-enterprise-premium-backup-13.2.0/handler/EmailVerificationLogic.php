<?php


namespace OTP\Handler;

if (defined("\x41\x42\123\120\101\124\110")) {
    goto TH;
}
exit;
TH:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\VerificationLogic;
use OTP\Traits\Instance;
final class EmailVerificationLogic extends VerificationLogic
{
    use Instance;
    public function _handle_logic($iI, $p1, $NN, $CD, $kt)
    {
        if (is_email($p1)) {
            goto Yn;
        }
        $this->_handle_not_matched($p1, $CD, $kt);
        goto C_;
        Yn:
        $this->_handle_matched($iI, $p1, $NN, $CD, $kt);
        C_:
    }
    public function _handle_matched($iI, $p1, $NN, $CD, $kt)
    {
        $bC = str_replace("\43\43\x65\x6d\141\x69\154\x23\43", $p1, $this->_get_is_blocked_message());
        if ($this->_is_blocked($p1, $NN)) {
            goto FL;
        }
        $this->_start_otp_verification($iI, $p1, $NN, $CD, $kt);
        goto DJ;
        FL:
        if ($this->_is_ajax_form()) {
            goto Ha;
        }
        miniorange_site_otp_validation_form(null, null, null, $bC, $CD, $kt);
        goto tb;
        Ha:
        wp_send_json(MoUtility::createJson($bC, MoConstants::ERROR_JSON_TYPE));
        tb:
        DJ:
    }
    public function _handle_not_matched($p1, $CD, $kt)
    {
        $bC = str_replace("\43\43\x65\155\141\151\x6c\43\x23", $p1, $this->_get_otp_invalid_format_message());
        if ($this->_is_ajax_form()) {
            goto xc;
        }
        miniorange_site_otp_validation_form(null, null, null, $bC, $CD, $kt);
        goto zH;
        xc:
        wp_send_json(MoUtility::createJson($bC, MoConstants::ERROR_JSON_TYPE));
        zH:
    }
    public function _start_otp_verification($iI, $p1, $NN, $CD, $kt)
    {
        $ig = GatewayFunctions::instance();
        $zw = $ig->mo_send_otp_token("\105\115\101\111\114", $p1, '');
        switch ($zw["\163\x74\x61\x74\x75\x73"]) {
            case "\123\125\103\x43\105\123\x53":
                $this->_handle_otp_sent($iI, $p1, $NN, $CD, $kt, $zw);
                goto hH;
            default:
                $this->_handle_otp_sent_failed($iI, $p1, $NN, $CD, $kt, $zw);
                goto hH;
        }
        y3:
        hH:
    }
    public function _handle_otp_sent($iI, $p1, $NN, $CD, $kt, $zw)
    {
        SessionUtils::setEmailTransactionID($zw["\164\170\111\144"]);
        if (!(MoUtility::micr() && MoUtility::isMG())) {
            goto DN;
        }
        $VR = get_mo_option("\145\x6d\141\151\x6c\137\164\x72\x61\x6e\x73\141\x63\164\151\x6f\156\163\x5f\162\145\155\x61\x69\x6e\151\156\x67");
        if (!($VR > 0 && MO_TEST_MODE == false)) {
            goto To;
        }
        update_mo_option("\145\x6d\x61\151\154\137\164\162\x61\156\163\x61\143\x74\151\157\156\x73\137\x72\x65\x6d\x61\x69\156\x69\x6e\x67", $VR - 1);
        To:
        DN:
        $bC = str_replace("\43\x23\145\155\141\151\x6c\x23\x23", $p1, $this->_get_otp_sent_message());
        if ($this->_is_ajax_form()) {
            goto wY;
        }
        miniorange_site_otp_validation_form($iI, $p1, $NN, $bC, $CD, $kt);
        goto Ub;
        wY:
        wp_send_json(MoUtility::createJson($bC, MoConstants::SUCCESS_JSON_TYPE));
        Ub:
    }
    public function _handle_otp_sent_failed($iI, $p1, $NN, $CD, $kt, $zw)
    {
        $bC = str_replace("\x23\x23\x65\x6d\141\151\154\x23\x23", $p1, $this->_get_otp_sent_failed_message());
        if ($this->_is_ajax_form()) {
            goto TL;
        }
        miniorange_site_otp_validation_form(null, null, null, $bC, $CD, $kt);
        goto Ys;
        TL:
        wp_send_json(MoUtility::createJson($bC, MoConstants::ERROR_JSON_TYPE));
        Ys:
    }
    public function _get_otp_sent_message()
    {
        $Bk = get_mo_option("\x73\165\143\x63\145\163\x73\x5f\145\x6d\141\151\x6c\x5f\155\145\163\x73\141\147\145", "\x6d\x6f\137\157\x74\160\x5f");
        return $Bk ? mo_($Bk) : MoMessages::showMessage(MoMessages::OTP_SENT_EMAIL);
    }
    public function _get_otp_sent_failed_message()
    {
        $vN = get_mo_option("\x65\162\x72\157\x72\137\x65\155\x61\x69\x6c\137\155\145\x73\x73\141\147\x65", "\x6d\x6f\137\157\x74\160\137");
        return $vN ? mo_($vN) : MoMessages::showMessage(MoMessages::ERROR_OTP_EMAIL);
    }
    public function _is_blocked($p1, $NN)
    {
        $Qf = explode("\73", get_mo_option("\x62\x6c\x6f\x63\x6b\145\144\137\x64\157\x6d\x61\x69\x6e\x73"));
        $Qf = apply_filters("\x6d\157\x5f\142\x6c\157\x63\153\x65\144\x5f\x65\155\x61\x69\154\137\144\157\x6d\x61\x69\156\x73", $Qf);
        return in_array(MoUtility::getDomain($p1), $Qf);
    }
    public function _get_is_blocked_message()
    {
        $FM = get_mo_option("\x62\154\x6f\x63\153\x65\x64\137\x65\155\141\151\x6c\137\x6d\x65\x73\163\x61\x67\x65", "\x6d\157\137\157\x74\160\137");
        return $FM ? mo_($FM) : MoMessages::showMessage(MoMessages::ERROR_EMAIL_BLOCKED);
    }
    public function _get_otp_invalid_format_message()
    {
        $bC = get_mo_option("\x69\156\166\141\154\151\x64\x5f\x65\x6d\141\151\x6c\x5f\155\145\x73\163\x61\x67\x65", "\155\157\137\157\x74\160\x5f");
        return $bC ? mo_($bC) : MoMessages::showMessage(MoMessages::ERROR_EMAIL_FORMAT);
    }
}
