<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class WPClientRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WP_CLIENT_REG;
        $this->_phoneKey = "\x77\x70\137\143\x6f\156\x74\141\x63\x74\x5f\x70\150\157\x6e\x65";
        $this->_phoneFormId = "\43\x77\x70\x63\137\x63\157\x6e\x74\x61\x63\164\x5f\x70\150\x6f\x6e\145";
        $this->_formKey = "\x57\x50\x5f\x43\114\111\x45\x4e\x54\137\x52\105\x47";
        $this->_typePhoneTag = "\155\157\137\167\x70\x5f\x63\154\x69\145\x6e\x74\137\160\150\x6f\156\145\137\145\x6e\x61\142\154\x65";
        $this->_typeEmailTag = "\155\x6f\x5f\167\x70\x5f\x63\x6c\151\145\156\164\137\145\x6d\x61\151\154\x5f\x65\156\x61\142\154\x65";
        $this->_typeBothTag = "\x6d\x6f\x5f\167\160\137\x63\154\x69\x65\156\164\137\142\157\x74\150\x5f\145\156\141\142\154\x65";
        $this->_formName = mo_("\x57\x50\40\103\154\151\145\156\164\x20\122\x65\147\151\x73\x74\162\141\x74\x69\x6f\x6e\40\x46\157\162\x6d");
        $this->_isFormEnabled = get_mo_option("\x77\160\137\143\x6c\x69\x65\x6e\x74\137\x65\156\x61\x62\x6c\x65");
        $this->_formDocuments = MoOTPDocs::WP_CLIENT_FORM;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\x70\137\x63\x6c\151\x65\x6e\x74\137\145\156\141\142\154\145\137\x74\171\x70\145");
        $this->_restrictDuplicates = get_mo_option("\167\160\137\143\154\x69\x65\x6e\x74\137\162\145\x73\164\162\x69\x63\164\137\144\x75\x70\x6c\151\x63\141\164\x65\x73");
        add_filter("\x77\160\x63\137\143\x6c\x69\145\156\164\137\x72\145\x67\x69\x73\x74\x72\x61\164\x69\157\x6e\x5f\x66\x6f\162\x6d\137\166\141\154\x69\x64\141\164\x69\157\156", [$this, "\x6d\151\x6e\151\157\x72\x61\x6e\147\145\x5f\143\154\151\x65\x6e\164\x5f\162\145\147\151\x73\x74\162\x61\164\x69\x6f\156\x5f\x76\145\162\151\x66\171"], 99, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $tA = $this->getVerificationType();
        return $tA === VerificationType::PHONE || $tA === VerificationType::BOTH;
    }
    function miniorange_client_registration_verify($errors)
    {
        $tA = $this->getVerificationType();
        $NN = MoUtility::sanitizeCheck("\x63\x6f\156\164\x61\143\x74\137\160\x68\157\x6e\145", $_POST);
        $p1 = MoUtility::sanitizeCheck("\x63\x6f\156\x74\141\143\164\x5f\x65\x6d\141\x69\x6c", $_POST);
        $rs = MoUtility::sanitizeCheck("\143\x6f\x6e\164\141\143\x74\x5f\165\163\145\x72\156\x61\155\x65", $_POST);
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($NN, $this->_phoneKey))) {
            goto mCb;
        }
        $errors .= mo_("\120\150\157\156\145\40\x6e\x75\155\142\145\162\x20\141\154\162\x65\x61\x64\x79\40\x69\x6e\40\165\x73\145\x2e\x20\120\154\145\141\163\145\40\105\x6e\164\145\162\x20\141\x20\x64\151\146\x66\145\x72\x65\x6e\x74\40\x50\150\157\x6e\145\40\156\165\155\x62\x65\x72\56");
        mCb:
        if (MoUtility::isBlank($errors)) {
            goto Xxq;
        }
        return $errors;
        Xxq:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto cMI;
        }
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $tA)) {
            goto xuo;
        }
        goto WnQ;
        cMI:
        MoUtility::initialize_transaction($this->_formSessionVar);
        goto WnQ;
        xuo:
        $this->unsetOTPSessionVariables();
        return $errors;
        WnQ:
        return $this->startOTPTransaction($rs, $p1, $errors, $NN);
    }
    function startOTPTransaction($rs, $p1, $errors, $NN)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto hY_;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto w2v;
        }
        $this->sendChallenge($rs, $p1, $errors, $NN, VerificationType::EMAIL);
        goto zp9;
        w2v:
        $this->sendChallenge($rs, $p1, $errors, $NN, VerificationType::BOTH);
        zp9:
        goto d3c;
        hY_:
        $this->sendChallenge($rs, $p1, $errors, $NN, VerificationType::PHONE);
        d3c:
        return $errors;
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        $Bs = $this->getVerificationType();
        $MZ = $Bs === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    function isPhoneNumberAlreadyInUse($Dk, $j1)
    {
        global $wpdb;
        $Dk = MoUtility::processPhoneNumber($Dk);
        $le = $wpdb->get_row("\x53\x45\114\x45\x43\x54\40\x60\165\x73\145\162\x5f\151\144\140\x20\x46\122\x4f\x4d\x20\x60{$wpdb->prefix}\x75\163\145\x72\155\x65\164\x61\x60\40\x57\x48\x45\x52\x45\40\x60\x6d\145\x74\141\137\153\x65\171\140\40\75\40\47{$j1}\x27\40\x41\116\x44\x20\140\x6d\x65\x74\141\137\x76\141\x6c\165\x65\x60\x20\75\x20\x20\47{$Dk}\x27");
        return !MoUtility::isBlank($le);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto jsg;
        }
        array_push($kp, $this->_phoneFormId);
        jsg:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto J0x;
        }
        return;
        J0x:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\160\x5f\x63\x6c\151\x65\156\x74\x5f\x65\156\141\x62\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\167\x70\x5f\143\x6c\x69\x65\156\164\137\145\x6e\x61\142\154\x65\137\x74\171\160\145");
        $this->_restrictDuplicates = $this->getVerificationType() === VerificationType::PHONE ? $this->sanitizeFormPOST("\167\160\x5f\143\154\151\145\x6e\x74\x5f\162\145\163\x74\x72\x69\143\x74\137\x64\165\x70\154\151\143\x61\164\x65\x73") : false;
        update_mo_option("\167\x70\137\x63\154\x69\145\x6e\164\137\x65\156\x61\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\x77\x70\137\143\x6c\x69\x65\156\x74\x5f\145\x6e\141\x62\x6c\145\137\x74\171\160\x65", $this->_otpType);
        update_mo_option("\x77\x70\x5f\143\x6c\x69\145\x6e\x74\x5f\x72\x65\x73\x74\x72\151\x63\164\137\144\x75\160\154\x69\x63\x61\164\x65\x73", $this->_restrictDuplicates);
    }
}
