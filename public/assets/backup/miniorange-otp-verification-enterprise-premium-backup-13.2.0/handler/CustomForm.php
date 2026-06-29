<?php


namespace OTP\Handler;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class CustomForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_isAddOnForm = TRUE;
        $this->isEnabled = get_mo_option("\x63\146\x5f\x73\x75\x62\x6d\151\x74\137\x69\144", "\x6d\157\137\157\164\x70\137") ? true : false;
        $this->_formSessionVar = FormSessionVars::CUSTOMFORM;
        $this->_typePhoneTag = "\155\157\137\143\x75\163\164\x6f\x6d\x46\157\x72\155\137\x70\x68\157\156\x65\x5f\x65\x6e\x61\142\x6c\x65";
        $this->_typeEmailTag = "\155\x6f\x5f\143\x75\163\x74\157\155\106\157\162\155\x5f\x65\155\x61\151\x6c\137\x65\x6e\x61\142\x6c\x65";
        $this->_isFormEnabled = $this->isEnabled;
        $this->_phoneFormId = stripslashes(get_mo_option("\x63\x66\137\x66\x69\x65\154\144\x5f\x69\144", "\155\x6f\x5f\x6f\x74\160\x5f"));
        $this->_generateOTPAction = "\x6d\x69\156\151\157\x72\x61\x6e\x67\x65\55\143\165\163\x74\x6f\x6d\x46\x6f\162\x6d\x2d\x73\x65\x6e\144\x2d\x6f\164\x70";
        $this->_validateOTPAction = "\x6d\151\156\151\157\162\x61\x6e\147\x65\55\x63\x75\x73\x74\x6f\155\106\157\162\x6d\55\166\145\162\151\x66\171\x2d\143\157\x64\145";
        $this->_checkValidatedOnSubmit = "\x6d\x69\x6e\x69\157\162\x61\156\x67\145\55\143\x75\x73\x74\157\x6d\x46\157\x72\155\55\166\x65\x72\151\146\x79\55\163\x75\x62\155\151\x74";
        $this->_otpType = get_mo_option("\143\146\x5f\x65\x6e\141\x62\154\145\137\164\x79\160\145", "\x6d\x6f\137\157\x74\x70\x5f");
        $this->_buttonText = get_mo_option("\x63\146\137\x62\x75\x74\x74\157\x6e\x5f\x74\145\170\164", "\x6d\157\137\157\x74\x70\x5f");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\151\143\x6b\40\110\145\x72\x65\40\164\157\40\163\145\x6e\x64\x20\x4f\x54\120");
        $this->validated = FALSE;
        parent::__construct();
        $this->handleForm();
    }
    function handleForm()
    {
        MoPHPSessions::checkSession();
        if ($this->isEnabled) {
            goto y8;
        }
        return;
        y8:
        add_action("\167\160\137\145\156\x71\165\145\x75\145\137\163\143\x72\151\x70\x74\x73", array($this, "\155\157\x5f\145\x6e\161\165\x65\165\x65\x5f\x66\x6f\162\x6d\x5f\x73\143\162\x69\x70\x74"));
        add_action("\x6c\x6f\x67\151\156\137\x65\x6e\161\x75\145\x75\x65\137\x73\x63\162\151\x70\x74\163", array($this, "\155\157\x5f\x65\156\161\165\x65\165\145\x5f\146\157\162\x6d\x5f\x73\x63\162\x69\x70\164"));
        add_action("\167\160\137\x61\152\x61\x78\x5f{$this->_generateOTPAction}", [$this, "\137\163\145\156\x64\x5f\157\164\160"]);
        add_action("\x77\160\137\141\152\x61\170\137\156\157\x70\x72\151\166\137{$this->_generateOTPAction}", [$this, "\x5f\x73\x65\156\x64\137\x6f\x74\160"]);
        add_action("\167\x70\137\141\152\141\x78\137{$this->_validateOTPAction}", [$this, "\x70\x72\x6f\x63\x65\163\x73\x46\x6f\162\155\101\x6e\x64\126\x61\x6c\151\x64\x61\x74\x65\x4f\124\x50"]);
        add_action("\x77\160\137\141\x6a\141\170\137\156\x6f\x70\x72\151\166\x5f{$this->_validateOTPAction}", [$this, "\160\x72\x6f\x63\x65\x73\x73\x46\x6f\162\x6d\101\156\x64\126\x61\x6c\151\x64\x61\164\x65\117\x54\x50"]);
        add_action("\167\160\x5f\x61\x6a\x61\170\x5f{$this->_checkValidatedOnSubmit}", [$this, "\137\x63\150\145\x63\153\x56\x61\x6c\x69\x64\x61\164\145\144\117\x6e\x53\x75\142\x6d\x69\164"]);
        add_action("\x77\x70\x5f\x61\152\141\170\137\156\157\x70\162\x69\x76\x5f{$this->_checkValidatedOnSubmit}", [$this, "\137\143\x68\x65\x63\x6b\x56\x61\x6c\x69\x64\141\x74\145\x64\x4f\x6e\123\x75\x62\x6d\151\164"]);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto bb;
        }
        $this->validated = TRUE;
        $this->unsetOTPSessionVariables();
        return;
        bb:
    }
    function mo_enqueue_form_script()
    {
        wp_register_script($this->_formSessionVar, MOV_URL . "\x69\156\143\x6c\165\x64\145\x73\57\152\x73\57" . $this->_formSessionVar . "\x2e\152\x73", array("\152\161\165\x65\162\x79"));
        wp_localize_script($this->_formSessionVar, $this->_formSessionVar, array("\163\151\x74\145\x55\122\x4c" => wp_ajax_url(), "\x6f\x74\160\x54\x79\x70\x65" => $this->getVerificationType(), "\x66\157\x72\x6d\104\x65\164\141\x69\154\x73" => $this->_formDetails, "\x62\x75\x74\164\157\x6e\164\x65\170\x74" => $this->_buttonText, "\151\x6d\x67\125\122\x4c" => MOV_LOADER_URL, "\146\x69\x65\x6c\144\124\x65\x78\x74" => mo_("\x45\156\164\x65\162\40\117\x54\120\40\x68\x65\162\x65"), "\x67\156\157\156\143\145" => wp_create_nonce($this->_nonce), "\x6e\x6f\156\143\x65\113\x65\171" => wp_create_nonce($this->_nonceKey), "\166\156\157\156\143\x65" => wp_create_nonce($this->_nonce), "\x67\141\x63\164\151\157\156" => $this->_generateOTPAction, "\166\x61\x63\164\151\x6f\x6e" => $this->_validateOTPAction, "\146\151\x65\x6c\x64\123\x65\154\145\143\164\157\x72" => stripcslashes(get_mo_option("\x63\146\137\146\151\x65\x6c\144\x5f\x69\x64", "\155\157\x5f\x6f\x74\x70\x5f")), "\163\x75\x62\x6d\151\164\x53\145\x6c\x65\x63\x74\157\162" => stripcslashes(get_mo_option("\x63\146\137\163\x75\142\x6d\151\164\137\151\144", "\155\157\x5f\x6f\x74\160\137")), "\x73\x69\x74\145\x55\122\114" => wp_ajax_url(), "\x73\141\x63\x74\151\157\156" => $this->_checkValidatedOnSubmit));
        wp_enqueue_script($this->_formSessionVar);
        wp_enqueue_style("\x6d\x6f\137\146\x6f\x72\155\x73\x5f\143\163\163", MOV_FORM_CSS);
    }
    function _send_otp()
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Kf;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        Kf:
        if (!(MoUtility::sanitizeCheck("\x6f\x74\x70\x54\x79\160\145", $_POST) === VerificationType::PHONE)) {
            goto j1;
        }
        $this->_processPhoneAndSendOTP($_POST);
        j1:
        if (!(MoUtility::sanitizeCheck("\157\164\x70\x54\171\160\x65", $_POST) === VerificationType::EMAIL)) {
            goto PU;
        }
        $this->_processEmailAndSendOTP($_POST);
        PU:
    }
    public function _checkValidatedOnSubmit()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar) || $this->validated) {
            goto qj;
        }
        if (!(!SessionUtils::isOTPInitialized($this->_formSessionVar) && !$this->validated)) {
            goto i_;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        i_:
        goto Rr;
        qj:
        wp_send_json(MoUtility::createJson(self::VALIDATED, MoConstants::SUCCESS_JSON_TYPE));
        Rr:
    }
    private function _processEmailAndSendOTP($FA)
    {
        MoPHPSessions::checkSession();
        if (!MoUtility::sanitizeCheck("\165\x73\145\x72\137\145\155\141\x69\x6c", $FA)) {
            goto qe;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, sanitize_email($FA["\165\163\145\162\137\x65\x6d\x61\x69\154"]));
        $this->sendChallenge('', sanitize_email($FA["\x75\x73\x65\162\137\x65\x6d\x61\151\154"]), NULL, NULL, VerificationType::EMAIL);
        goto rF;
        qe:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        rF:
    }
    private function _processPhoneAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\145\x72\137\160\x68\157\x6e\145", $FA)) {
            goto WV;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, sanitize_text_field($FA["\165\x73\145\162\137\160\150\x6f\156\145"]));
        $this->sendChallenge('', NULL, NULL, sanitize_text_field($FA["\165\x73\x65\162\137\x70\x68\157\156\145"]), VerificationType::PHONE);
        goto cj;
        WV:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        cj:
    }
    function processFormAndValidateOTP()
    {
        MoPHPSessions::checkSession();
        $this->checkIfOTPSent();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfOTPSent()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto zC;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        zC:
    }
    private function checkIntegrityAndValidateOTP($FA)
    {
        MoPHPSessions::checkSession();
        $this->checkIntegrity($FA);
        $this->validateChallenge(sanitize_text_field($FA["\x6f\x74\160\x54\x79\x70\x65"]), NULL, sanitize_text_field($FA["\x6f\164\160\x5f\x74\x6f\x6b\x65\x6e"]));
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, sanitize_text_field($FA["\x6f\164\x70\124\171\x70\145"]))) {
            goto jY;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::CUSTOM_FORM_MESSAGE), MoConstants::ERROR_JSON_TYPE));
        goto sJ;
        jY:
        if (!($FA["\157\x74\160\x54\x79\160\145"] === VerificationType::PHONE)) {
            goto hT;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, sanitize_text_field($FA["\x75\163\x65\x72\137\x70\150\157\156\x65"]));
        hT:
        if (!($FA["\157\x74\x70\x54\x79\x70\x65"] === VerificationType::EMAIL)) {
            goto k2;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, sanitize_email($FA["\165\x73\x65\162\137\x65\155\141\151\154"]));
        k2:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::CUSTOM_FORM_MESSAGE), MoConstants::ERROR_JSON_TYPE));
        sJ:
    }
    private function checkIntegrity($FA)
    {
        if (!($FA["\x6f\164\x70\x54\x79\160\x65"] === VerificationType::PHONE)) {
            goto C7;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($FA["\165\x73\145\x72\137\160\x68\157\x6e\145"]))) {
            goto Iv;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        Iv:
        C7:
        if (!($FA["\x6f\164\160\124\171\x70\145"] === VerificationType::EMAIL)) {
            goto P8;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email($FA["\x75\x73\145\162\x5f\x65\155\141\151\154"]))) {
            goto jk;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        jk:
        P8:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Zj;
        }
        return;
        Zj:
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto op;
        }
        return;
        op:
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    public function unsetOTPSessionVariables()
    {
        MoPHPSessions::checkSession();
        SessionUtils::unsetSession([$this->_formSessionVar, $this->_txSessionId]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->isPhoneEnabled())) {
            goto S1;
        }
        array_push($kp, $this->_phoneFormId);
        S1:
        return $kp;
    }
    function isPhoneEnabled()
    {
        return $this->getVerificationType() == VerificationType::PHONE ? TRUE : FALSE;
    }
    function handleFormOptions()
    {
    }
    function getSubmitKeyDetails()
    {
        return stripcslashes(get_mo_option("\x63\x66\x5f\x73\x75\142\x6d\x69\x74\137\151\x64", "\x6d\x6f\137\x6f\164\x70\x5f"));
    }
    function getFieldKeyDetails()
    {
        return stripcslashes(get_mo_option("\143\x66\137\x66\151\x65\154\144\137\x69\144", "\x6d\157\137\157\x74\160\x5f"));
    }
}
