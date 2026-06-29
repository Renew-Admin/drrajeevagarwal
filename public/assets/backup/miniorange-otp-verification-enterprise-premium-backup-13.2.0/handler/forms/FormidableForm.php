<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class FormidableForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMIDABLE_FORM;
        $this->_typePhoneTag = "\155\157\x5f\146\162\155\x5f\146\x6f\162\155\137\160\x68\x6f\156\145\x5f\145\x6e\141\x62\154\145";
        $this->_typeEmailTag = "\x6d\157\137\x66\x72\155\x5f\x66\157\x72\155\137\145\x6d\x61\x69\x6c\x5f\145\156\141\142\154\145";
        $this->_formKey = "\x46\117\122\x4d\x49\x44\x41\x42\x4c\x45\137\106\x4f\122\115";
        $this->_formName = mo_("\x46\157\x72\155\151\144\141\142\x6c\145\40\106\x6f\x72\155\x73");
        $this->_isFormEnabled = get_mo_option("\x66\x72\155\137\146\x6f\162\x6d\x5f\x65\x6e\141\142\x6c\145");
        $this->_buttonText = get_mo_option("\x66\x72\x6d\137\x62\x75\164\164\x6f\x6e\x5f\x74\145\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\151\x63\153\x20\x48\145\x72\145\40\164\157\x20\x73\145\x6e\144\40\x4f\x54\120");
        $this->_generateOTPAction = "\155\x69\156\151\157\x72\141\156\x67\145\x5f\x66\162\x6d\x5f\147\x65\156\x65\x72\x61\164\145\137\x6f\164\160";
        $this->_formDocuments = MoOTPDocs::FORMIDABLE_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x66\x72\x6d\137\146\x6f\162\x6d\x5f\145\x6e\x61\x62\154\x65\x5f\x74\171\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\146\162\155\137\x66\x6f\162\x6d\137\x6f\164\160\x5f\145\x6e\x61\x62\x6c\x65\x64"));
        $this->_phoneFormId = array();
        if (!(empty($this->_formDetails) || !$this->_isFormEnabled)) {
            goto du;
        }
        return;
        du:
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\43" . $qL["\x70\x68\x6f\156\145\153\x65\171"] . "\40\x69\x6e\x70\165\x74");
            iy:
        }
        yL:
        add_filter("\x66\162\x6d\137\166\141\x6c\151\x64\141\164\145\x5f\146\x69\x65\x6c\144\x5f\145\156\x74\x72\171", [$this, "\x6d\x69\156\x69\157\162\x61\156\147\x65\137\x6f\x74\160\x5f\x76\x61\x6c\x69\x64\x61\164\x69\157\x6e"], 11, 4);
        add_action("\x77\160\137\141\152\x61\170\x5f{$this->_generateOTPAction}", [$this, "\137\163\x65\x6e\x64\x5f\x6f\164\x70\137\146\162\x6d\137\x61\x6a\141\170"]);
        add_action("\167\160\137\141\x6a\x61\170\x5f\156\157\160\162\151\x76\x5f{$this->_generateOTPAction}", [$this, "\x5f\x73\145\156\144\137\157\x74\160\x5f\x66\162\155\137\x61\x6a\x61\170"]);
        add_action("\x77\160\x5f\145\x6e\x71\x75\145\165\145\x5f\x73\143\162\x69\x70\164\x73", array($this, "\x6d\x69\x6e\151\x6f\162\x61\156\147\x65\x5f\x72\145\147\x69\163\x74\x65\162\x5f\146\157\162\155\151\x64\141\142\154\x65\137\x73\x63\162\151\x70\x74"));
    }
    function miniorange_register_formidable_script()
    {
        wp_register_script("\155\157\146\x6f\x72\x6d\151\144\141\x62\x6c\x65", MOV_URL . "\151\x6e\143\154\165\144\x65\163\x2f\152\x73\x2f\146\x6f\162\155\x69\144\141\142\154\145\x2e\155\151\156\56\152\x73", array("\x6a\161\165\145\x72\x79"));
        wp_localize_script("\x6d\x6f\x66\157\162\155\x69\x64\141\142\154\x65", "\x6d\x6f\146\x6f\x72\x6d\x69\x64\x61\x62\154\x65", array("\163\151\164\x65\125\x52\x4c" => wp_ajax_url(), "\x6f\164\160\124\x79\160\145" => $this->_otpType, "\146\x6f\x72\x6d\153\x65\171" => strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? "\x70\150\x6f\156\145\153\145\x79" : "\x65\155\141\x69\x6c\153\145\x79", "\156\157\156\x63\x65" => wp_create_nonce($this->_nonce), "\142\165\x74\x74\157\x6e\x74\x65\x78\x74" => mo_($this->_buttonText), "\151\x6d\147\x55\x52\114" => MOV_LOADER_URL, "\146\x6f\x72\x6d\163" => $this->_formDetails, "\x67\x65\x6e\x65\162\141\x74\x65\125\x52\x4c" => $this->_generateOTPAction));
        wp_enqueue_script("\155\x6f\x66\x6f\162\x6d\x69\144\141\142\x6c\145");
    }
    function _send_otp_frm_ajax()
    {
        $this->validateAjaxRequest();
        if ($this->_otpType == $this->_typePhoneTag) {
            goto Bo;
        }
        $this->_send_frm_otp_to_email($_POST);
        goto jQ;
        Bo:
        $this->_send_frm_otp_to_phone($_POST);
        jQ:
    }
    function _send_frm_otp_to_phone($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\163\x65\x72\x5f\160\150\x6f\156\x65", $FA)) {
            goto PB;
        }
        $this->sendOTP(trim($FA["\165\163\x65\162\x5f\x70\x68\157\x6e\145"]), NULL, trim($FA["\165\x73\x65\x72\x5f\160\x68\x6f\x6e\x65"]), VerificationType::PHONE);
        goto Fp;
        PB:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        Fp:
    }
    function _send_frm_otp_to_email($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\145\x72\137\x65\155\x61\x69\154", $FA)) {
            goto iB;
        }
        $this->sendOTP(sanitize_email($FA["\x75\x73\x65\162\137\145\x6d\141\151\154"]), sanitize_email($FA["\x75\163\145\x72\137\x65\155\141\151\x6c"]), NULL, VerificationType::EMAIL);
        goto ue;
        iB:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        ue:
    }
    private function sendOTP($WH, $BO, $dI, $tA)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($tA === VerificationType::PHONE) {
            goto up;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $WH);
        goto pP;
        up:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $WH);
        pP:
        $this->sendChallenge('', $BO, NULL, $dI, $tA);
    }
    function miniorange_otp_validation($errors, $QO, $qL, $Tw)
    {
        if (!($this->getFieldId("\x76\x65\x72\151\146\x79\137\x73\x68\x6f\x77", $QO) !== $QO->id)) {
            goto LG;
        }
        return $errors;
        LG:
        if (MoUtility::isBlank($errors)) {
            goto Z8;
        }
        return $errors;
        Z8:
        if ($this->hasOTPBeenSent($errors, $QO)) {
            goto F7;
        }
        return $errors;
        F7:
        if (!$this->isMisMatchEmailOrPhone($errors, $QO)) {
            goto Zs;
        }
        return $errors;
        Zs:
        if ($this->isValidOTP($qL, $QO, $errors)) {
            goto Fz;
        }
        return $errors;
        Fz:
        return $errors;
    }
    private function hasOTPBeenSent(&$errors, $QO)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto U5;
        }
        $bC = MoMessages::showMessage(BaseMessages::ENTER_VERIFY_CODE);
        if ($this->isPhoneVerificationEnabled()) {
            goto oo;
        }
        $errors["\146\151\x65\154\144" . $this->getFieldId("\x65\x6d\x61\x69\154\137\163\150\x6f\x77", $QO)] = $bC;
        goto Ss;
        oo:
        $errors["\x66\x69\x65\154\144" . $this->getFieldId("\x70\150\x6f\156\145\x5f\x73\x68\x6f\x77", $QO)] = $bC;
        Ss:
        return false;
        U5:
        return true;
    }
    private function isMisMatchEmailOrPhone(&$errors, $QO)
    {
        $oF = $this->getFieldId($this->isPhoneVerificationEnabled() ? "\160\x68\x6f\x6e\145\x5f\x73\150\157\167" : "\145\155\x61\151\154\x5f\163\x68\x6f\167", $QO);
        $us = sanitize_text_field($_POST["\x69\x74\145\155\137\x6d\x65\164\x61"][$oF]);
        if ($this->checkPhoneOrEmailIntegrity($us)) {
            goto V2;
        }
        if ($this->isPhoneVerificationEnabled()) {
            goto X8;
        }
        $errors["\146\151\x65\x6c\x64" . $this->getFieldId("\x65\x6d\x61\151\154\137\163\150\x6f\x77", $QO)] = MoMessages::showMessage(BaseMessages::EMAIL_MISMATCH);
        goto Uk;
        X8:
        $errors["\146\151\145\x6c\144" . $this->getFieldId("\x70\x68\x6f\x6e\x65\x5f\x73\x68\x6f\x77", $QO)] = MoMessages::showMessage(BaseMessages::PHONE_MISMATCH);
        Uk:
        return true;
        V2:
        return false;
    }
    private function isValidOTP($qL, $QO, &$errors)
    {
        $tA = $this->getVerificationType();
        $this->validateChallenge($tA, NULL, $qL);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $tA)) {
            goto QI;
        }
        $errors["\x66\151\145\x6c\144" . $this->getFieldId("\166\145\x72\x69\146\171\x5f\x73\150\x6f\x77", $QO)] = MoUtility::_get_invalid_otp_method();
        return false;
        goto Ob;
        QI:
        $this->unsetOTPSessionVariables();
        return true;
        Ob:
    }
    private function checkPhoneOrEmailIntegrity($us)
    {
        if ($this->isPhoneVerificationEnabled()) {
            goto Ch;
        }
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $us);
        goto la;
        Ch:
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $us);
        la:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->_isFormEnabled && $this->isPhoneVerificationEnabled())) {
            goto J_;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        J_:
        return $kp;
    }
    function isPhoneVerificationEnabled()
    {
        return $this->getVerificationType() === VerificationType::PHONE;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Fc;
        }
        return;
        Fc:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x66\x72\x6d\137\x66\157\162\x6d\137\145\156\x61\x62\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x66\x72\x6d\137\146\157\162\x6d\137\x65\x6e\141\x62\x6c\x65\137\x74\x79\x70\x65");
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_buttonText = $this->sanitizeFormPOST("\x66\162\155\x5f\x62\x75\x74\164\157\156\x5f\164\x65\x78\x74");
        if (!$this->basicValidationCheck(BaseMessages::FORMIDABLE_CHOOSE)) {
            goto RX;
        }
        update_mo_option("\146\x72\155\x5f\x62\x75\x74\x74\x6f\156\x5f\x74\145\x78\x74", $this->_buttonText);
        update_mo_option("\146\162\x6d\x5f\146\x6f\x72\x6d\x5f\x65\156\x61\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\146\x72\155\137\x66\x6f\162\x6d\x5f\x65\x6e\141\x62\154\x65\137\x74\171\x70\x65", $this->_otpType);
        update_mo_option("\x66\x72\x6d\137\x66\x6f\162\155\x5f\x6f\x74\x70\137\145\x6e\141\142\x6c\x65\x64", maybe_serialize($this->_formDetails));
        RX:
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\x66\x72\155\x5f\x66\x6f\x72\155", $_POST)) {
            goto cZ;
        }
        return array();
        cZ:
        foreach (array_filter($_POST["\146\162\155\137\146\x6f\x72\x6d"]["\146\x6f\162\155"]) as $j1 => $qL) {
            $j1 = sanitize_text_field($j1);
            $form[sanitize_text_field($qL)] = array("\x65\155\x61\x69\154\x6b\145\x79" => "\x66\162\155\x5f\x66\x69\145\x6c\x64\x5f" . sanitize_text_field($_POST["\146\x72\155\137\146\157\x72\155"]["\x65\155\141\151\154\153\x65\x79"][$j1]) . "\137\x63\x6f\x6e\164\x61\x69\156\x65\162", "\160\x68\x6f\156\x65\153\145\x79" => "\146\162\x6d\x5f\146\x69\x65\x6c\144\x5f" . sanitize_text_field($_POST["\146\162\155\x5f\146\x6f\x72\155"]["\160\x68\x6f\x6e\x65\153\x65\x79"][$j1]) . "\x5f\x63\x6f\156\164\x61\151\156\x65\162", "\x76\x65\x72\151\146\171\113\x65\171" => "\x66\x72\155\137\146\x69\145\x6c\144\137" . sanitize_text_field($_POST["\146\162\155\x5f\x66\x6f\162\155"]["\x76\145\x72\x69\x66\171\x4b\x65\171"][$j1]) . "\x5f\143\157\x6e\x74\141\151\156\x65\x72", "\160\150\x6f\156\x65\x5f\163\x68\x6f\x77" => sanitize_text_field($_POST["\146\162\155\137\x66\157\x72\x6d"]["\x70\150\157\156\x65\153\x65\171"][$j1]), "\x65\x6d\141\151\154\x5f\x73\x68\157\x77" => sanitize_text_field($_POST["\x66\x72\x6d\x5f\x66\157\x72\155"]["\145\x6d\141\151\x6c\x6b\x65\x79"][$j1]), "\x76\x65\x72\x69\x66\x79\x5f\163\150\x6f\x77" => sanitize_text_field($_POST["\x66\x72\x6d\137\x66\x6f\x72\x6d"]["\x76\145\162\151\146\x79\113\145\x79"][$j1]));
            nJ:
        }
        vq:
        return $form;
    }
    function getFieldId($j1, $QO)
    {
        return $this->_formDetails[$QO->form_id][$j1];
    }
}
