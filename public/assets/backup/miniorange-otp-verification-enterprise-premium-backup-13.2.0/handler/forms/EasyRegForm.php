<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class EasyRegForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::EASY_REG_FORM;
        $this->_typePhoneTag = "\155\x6f\137\145\x61\x73\x79\162\145\x67\137\x70\150\x6f\156\x65\x5f\x65\156\141\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\157\x5f\145\141\163\x79\x72\x65\x67\137\x65\155\141\x69\x6c\x5f\145\156\x61\x62\154\145";
        $this->_formKey = "\145\141\x73\x79\x72\145\x67";
        $this->_formName = mo_("\105\141\x73\x79\x20\122\x65\147\151\x73\164\162\141\164\151\157\156\40\106\157\162\x6d\163");
        $this->_isFormEnabled = get_mo_option("\x65\141\x73\171\x72\145\147\137\x65\156\x61\x62\154\x65");
        $this->_buttonText = get_mo_option("\145\x61\x73\171\x72\x65\x67\x5f\142\x75\164\x74\x6f\156\x5f\164\x65\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\151\x63\x6b\x20\x48\145\x72\145\x20\164\157\40\x73\145\156\144\x20\x4f\124\x50");
        $this->_phoneFormId = array();
        $this->_generateOTPAction = "\155\x69\156\x69\157\x72\141\x6e\147\145\x5f\145\x61\163\x79\x72\145\147\x5f\147\x65\x6e\145\x72\x61\164\145\x5f\157\x74\160";
        $this->_validateOTPAction = "\x6d\x69\x6e\x69\x6f\x72\x61\156\x67\x65\x5f\145\141\163\x79\x72\145\x67\x5f\x76\x65\x72\x69\146\x79\x5f\x6f\164\160";
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\145\x61\163\x79\162\x65\147\x5f\x65\156\x61\x62\154\x65\137\164\x79\x70\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x65\141\x73\x79\x72\x65\147\x5f\x66\x6f\x72\155\163"));
        if (!empty($this->_formDetails)) {
            goto c9;
        }
        return;
        c9:
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\x2e\166\145\162\151\x66\171\x5f\x70\150\x6f\156\x65");
            Hr:
        }
        H0:
        add_action("\x77\160\137\x61\152\x61\x78\x5f{$this->_generateOTPAction}", [$this, "\x73\x74\x61\x72\164\117\164\x70\126\145\162\x69\x66\x69\143\141\164\x69\x6f\156\x50\162\157\143\x65\x73\x73"]);
        add_action("\167\x70\x5f\x61\x6a\141\x78\137\156\157\160\162\x69\x76\137{$this->_generateOTPAction}", [$this, "\163\164\x61\x72\x74\x4f\x74\x70\x56\145\162\151\146\151\x63\141\164\x69\157\x6e\120\x72\x6f\x63\145\163\x73"]);
        add_action("\x65\x72\146\x5f\162\x65\x67\151\163\164\145\162\x5f\x66\x72\x6f\156\164\x5f\163\x63\x72\151\160\x74\163", [$this, "\x6d\x69\156\x69\x6f\x72\x61\156\x67\145\x5f\162\145\147\151\x73\164\145\162\x5f\x65\x61\163\x79\x72\x65\147\x5f\x73\x63\162\151\x70\164"]);
        if (!(isset($_POST["\141\143\164\x69\x6f\x6e"]) && $_POST["\x61\143\164\151\x6f\156"] === "\x65\162\x66\137\163\165\142\155\151\x74\137\146\157\x72\x6d")) {
            goto ZV;
        }
        if (!empty($this->errors)) {
            goto Fs;
        }
        $this->unsetOTPSessionVariables();
        return false;
        goto GB;
        Fs:
        return true;
        GB:
        ZV:
        add_action("\x77\160\x5f\141\152\x61\170\137{$this->_validateOTPAction}", [$this, "\160\x72\157\x63\145\x73\x73\x46\157\x72\155\x41\x6e\144\126\141\154\151\x64\x61\164\x65\x4f\x54\120"]);
        add_action("\167\160\x5f\141\152\141\x78\x5f\x6e\x6f\x70\x72\151\x76\137{$this->_validateOTPAction}", [$this, "\160\162\157\x63\x65\163\x73\106\157\x72\x6d\x41\156\144\x56\141\x6c\151\x64\x61\164\x65\x4f\x54\x50"]);
    }
    function processFormAndValidateOTP()
    {
        $this->checkIfOTPSent();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfOTPSent()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto gs;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        gs:
    }
    function checkIntegrityAndValidateOTP()
    {
        $this->checkIntegrity($_POST);
        $this->validateChallenge($this->getVerificationType(), NULL, $_POST["\x6f\164\160\137\164\x6f\x6b\x65\x6e"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto M6;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto Rt;
        M6:
        if (!($this->getVerificationType() === VerificationType::PHONE)) {
            goto uj;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, $_POST["\165\163\145\162\137\160\x68\157\156\145"]);
        uj:
        if (!($this->getVerificationType() === VerificationType::EMAIL)) {
            goto Fb;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, $_POST["\x75\163\145\x72\137\145\155\141\151\x6c"]);
        Fb:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, "\x73\x75\143\143\145\x73\163\61"));
        Rt:
    }
    function checkIntegrity()
    {
        if (!($this->getVerificationType() === VerificationType::PHONE)) {
            goto cp;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\x75\163\145\162\137\x70\150\x6f\156\x65"])) {
            goto cD;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        cD:
        cp:
        if (!($this->getVerificationType() === VerificationType::EMAIL)) {
            goto Ov;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\165\163\x65\162\x5f\145\x6d\x61\151\x6c"])) {
            goto ty;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        ty:
        Ov:
    }
    function unsetSessionVariable($I5)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto g5;
        }
        $this->unsetOTPSessionVariables();
        g5:
        return $I5;
    }
    function miniorange_register_easyreg_script()
    {
        wp_register_script("\155\x6f\145\x61\x73\171\162\x65\x67", MOV_URL . "\x69\156\x63\154\x75\x64\x65\163\57\x6a\x73\57\x6d\x6f\145\x61\163\171\162\145\147\56\x6d\151\156\56\x6a\163", array("\152\161\x75\x65\x72\x79"));
        wp_localize_script("\x6d\157\145\141\163\171\162\145\147", "\155\x6f\145\x61\163\171\162\145\147", array("\x73\151\164\x65\125\122\x4c" => wp_ajax_url(), "\157\164\x70\x54\x79\160\x65" => $this->_otpType, "\x66\x6f\x72\155\153\x65\x79" => strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? "\160\x68\x6f\156\x65\x6b\145\x79" : "\x65\155\x61\151\154\153\x65\x79", "\x6e\157\x6e\x63\145" => wp_create_nonce($this->_nonce), "\142\165\164\164\157\156\x74\145\170\164" => mo_($this->_buttonText), "\x66\151\145\x6c\x64\111\104" => $this->_otpType === $this->_typePhoneTag ? "\166\x65\x72\151\146\171\x5f\160\x68\157\156\145" : "\x76\145\x72\x69\x66\171\137\145\x6d\141\x69\x6c", "\151\x6d\x67\x55\x52\114" => MOV_LOADER_URL, "\146\157\x72\x6d\x73" => $this->_formDetails, "\x67\145\156\x65\x72\141\164\x65\125\x52\x4c" => $this->_generateOTPAction, "\x76\x61\x63\x74\151\x6f\156" => $this->_validateOTPAction));
        wp_enqueue_script("\x6d\x6f\x65\141\x73\x79\x72\x65\x67");
    }
    function startOtpVerificationProcess()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto G5;
        }
        $this->_processEmailAndSendOTP($_POST);
        goto Yl;
        G5:
        $this->_processPhoneAndSendOTP($_POST);
        Yl:
    }
    function _processEmailAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\x65\x72\x5f\145\155\141\151\x6c", $FA)) {
            goto Cs;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $FA["\165\163\145\162\x5f\145\155\141\x69\154"]);
        $this->sendChallenge('', $FA["\165\163\x65\162\137\145\155\141\x69\154"], NULL, NULL, VerificationType::EMAIL);
        goto ch;
        Cs:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        ch:
    }
    function _processPhoneAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\x65\162\137\x70\150\157\156\x65", $FA)) {
            goto GJ;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, $FA["\165\163\145\162\x5f\160\150\x6f\156\x65"]);
        $this->sendChallenge('', NULL, NULL, $FA["\165\x73\x65\x72\137\160\x68\157\x6e\145"], VerificationType::PHONE);
        goto w8;
        GJ:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        w8:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_formSessionVar, $this->_txSessionId]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto NY;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        NY:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto AU;
        }
        return;
        AU:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x65\141\x73\x79\x72\x65\147\x5f\145\156\x61\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\145\141\x73\171\162\145\x67\x5f\x65\156\141\142\x6c\145\x5f\x74\171\x70\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\145\x61\163\171\162\145\x67\137\142\x75\164\x74\x6f\x6e\x5f\164\145\170\x74");
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\x65\x61\x73\171\x72\x65\147\x5f\x65\156\141\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\145\141\x73\171\162\x65\147\x5f\x65\x6e\141\x62\154\x65\x5f\164\x79\x70\x65", $this->_otpType);
        update_mo_option("\x65\x61\x73\x79\162\x65\147\137\142\x75\164\164\157\156\137\x74\145\170\x74", $this->_buttonText);
        update_mo_option("\145\x61\163\x79\162\x65\x67\137\x66\x6f\x72\155\163", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = [];
        if (!(!array_key_exists("\x65\x61\163\x79\162\145\x67\x5f\146\x6f\162\x6d", $_POST) || !$this->_isFormEnabled)) {
            goto sA;
        }
        return $form;
        sA:
        foreach (array_filter($_POST["\x65\x61\x73\171\x72\x65\147\137\x66\x6f\x72\x6d"]["\x66\x6f\x72\x6d"]) as $j1 => $qL) {
            $form[$qL] = array("\x65\x6d\141\151\154\x6b\x65\171" => $_POST["\145\141\x73\x79\162\x65\x67\x5f\x66\x6f\x72\155"]["\145\155\141\151\154\x6b\x65\171"][$j1], "\x70\x68\x6f\x6e\145\x6b\x65\171" => $_POST["\x65\x61\x73\x79\162\x65\x67\137\x66\157\162\155"]["\160\x68\157\156\x65\x6b\145\171"][$j1], "\x76\x65\162\151\x66\x79\113\x65\171" => $_POST["\145\x61\163\x79\x72\x65\147\x5f\x66\157\162\x6d"]["\166\x65\162\x69\146\x79\113\x65\171"][$j1], "\x70\150\x6f\x6e\145\x5f\163\150\157\167" => $_POST["\x65\x61\x73\x79\162\x65\147\137\x66\157\x72\x6d"]["\x70\x68\157\156\145\x6b\145\171"][$j1], "\x65\155\x61\x69\154\x5f\163\x68\157\x77" => $_POST["\x65\141\163\x79\162\145\147\137\146\x6f\162\x6d"]["\145\x6d\141\151\x6c\153\x65\x79"][$j1], "\166\x65\x72\x69\x66\x79\x5f\163\150\157\x77" => $_POST["\145\141\163\x79\x72\145\147\x5f\146\x6f\162\x6d"]["\166\x65\x72\151\146\171\113\x65\x79"][$j1]);
            K1:
        }
        qY:
        return $form;
    }
}
