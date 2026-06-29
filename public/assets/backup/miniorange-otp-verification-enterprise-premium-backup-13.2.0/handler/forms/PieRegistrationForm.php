<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class PieRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PIE_REG;
        $this->_typePhoneTag = "\x6d\x6f\137\x70\x69\x65\137\x70\150\157\156\x65\x5f\x65\x6e\x61\142\x6c\145";
        $this->_typeEmailTag = "\x6d\x6f\137\x70\151\x65\x5f\145\x6d\x61\151\154\x5f\x65\x6e\x61\142\x6c\x65";
        $this->_typeBothTag = "\x6d\x6f\137\160\151\145\x5f\142\x6f\x74\x68\x5f\x65\156\x61\142\x6c\145";
        $this->_formKey = "\120\x49\x45\x5f\106\x4f\122\x4d";
        $this->_formName = mo_("\120\111\105\40\x52\145\x67\x69\163\164\x72\141\x74\x69\157\x6e\40\x46\157\162\155");
        $this->_isFormEnabled = get_mo_option("\160\151\145\137\x64\x65\146\x61\165\x6c\164\137\x65\x6e\141\142\x6c\x65");
        $this->_formDocuments = MoOTPDocs::PIE_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x70\151\145\137\x65\156\141\142\x6c\x65\x5f\164\171\x70\x65");
        $this->_phoneKey = get_mo_option("\160\x69\145\x5f\160\150\x6f\156\145\137\153\x65\x79");
        $this->_phoneFormId = $this->getPhoneFieldKey();
        add_action("\x70\x69\x65\137\162\x65\x67\x69\163\164\145\x72\x5f\142\145\146\x6f\x72\x65\137\162\x65\x67\x69\163\164\x65\162\x5f\x76\141\x6c\151\x64\141\x74\145", array($this, "\x6d\151\x6e\151\x6f\x72\141\x6e\x67\145\137\160\151\x65\x5f\x75\x73\145\162\x5f\162\x65\147\x69\x73\164\162\x61\x74\x69\157\x6e"), 99, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $Bs = $this->getVerificationType();
        return $Bs === VerificationType::PHONE || $Bs === VerificationType::BOTH;
    }
    function miniorange_pie_user_registration()
    {
        global $errors;
        if (empty($errors->errors)) {
            goto D1;
        }
        return;
        D1:
        if (!$this->checkIfVerificationIsComplete()) {
            goto ba;
        }
        return;
        ba:
        if (!(empty($_POST[$this->_phoneFormId]) && $this->isPhoneVerificationEnabled())) {
            goto JF;
        }
        $errors->add("\155\157\x5f\157\x74\160\137\166\x65\162\x69\146\x79", MoMessages::showMessage(MoMessages::ENTER_PHONE_DEFAULT));
        return;
        JF:
        $this->startTheOTPVerificationProcess(sanitize_email($_POST["\145\x5f\x6d\x61\x69\x6c"]), sanitize_text_field($_POST[$this->_phoneFormId]));
        if ($this->checkIfVerificationIsComplete()) {
            goto v0;
        }
        $errors->add("\155\x6f\137\157\164\160\x5f\166\x65\x72\151\146\x79", MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
        v0:
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto UI;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        UI:
        return FALSE;
    }
    function startTheOTPVerificationProcess($BO, $Dk)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Df;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto rQ;
        }
        $this->sendChallenge('', $BO, null, $Dk, VerificationType::EMAIL);
        goto Xe;
        rQ:
        $this->sendChallenge('', $BO, null, $Dk, VerificationType::BOTH);
        Xe:
        goto No;
        Df:
        $this->sendChallenge('', $BO, null, $Dk, VerificationType::PHONE);
        No:
    }
    function getPhoneFieldKey()
    {
        $Zu = get_option("\160\151\x65\x5f\146\151\x65\x6c\144\x73");
        if (!empty($Zu)) {
            goto Ib;
        }
        return '';
        Ib:
        $Xw = maybe_unserialize($Zu);
        foreach ($Xw as $j1) {
            if (!(strcasecmp(trim($j1["\154\141\x62\x65\x6c"]), $this->_phoneKey) == 0)) {
                goto t9;
            }
            return str_replace("\x2d", "\x5f", sanitize_title($j1["\164\x79\160\x65"] . "\137" . (isset($j1["\151\144"]) ? $j1["\x69\x64"] : '')));
            t9:
            fj:
        }
        bu:
        return '';
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
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto KZ;
        }
        array_push($kp, "\151\x6e\x70\x75\164\x23" . $this->_phoneFormId);
        KZ:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto uV;
        }
        return;
        uV:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x70\x69\145\x5f\144\145\146\141\x75\154\x74\x5f\145\156\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x70\151\x65\x5f\145\x6e\141\x62\154\145\137\x74\171\x70\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x70\151\x65\x5f\160\x68\x6f\x6e\x65\x5f\x66\151\145\x6c\144\137\153\145\x79");
        update_mo_option("\160\x69\x65\x5f\x64\x65\146\141\x75\154\164\137\x65\x6e\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x70\x69\145\x5f\x65\x6e\141\x62\154\x65\x5f\x74\x79\160\145", $this->_otpType);
        update_mo_option("\160\151\145\137\160\150\157\156\145\137\153\x65\171", $this->_phoneKey);
    }
}
