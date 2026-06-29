<?php


namespace OTP\Handler\Forms;

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
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class YourOwnForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formKey = "\x59\117\x55\x52\137\x4f\127\116\137\x46\117\122\x4d";
        $this->_formName = mo_("\x3c\163\x70\141\x6e\x20\x73\x74\x79\154\145\75\x27\143\157\x6c\x6f\x72\72\x67\x72\x65\145\156\x27\40\x3e\74\142\76\103\141\156\47\164\x20\x46\x69\156\x64\40\x79\157\165\x72\x20\106\157\x72\155\77\x20\124\162\x79\40\x6d\145\x21\74\x2f\x62\x3e\x3c\x2f\x73\x70\x61\x6e\x3e");
        $this->_formSessionVar = FormSessionVars::CUSTOMFORM;
        $this->_formDetails = maybe_unserialize(get_mo_option("\x63\x75\x73\x74\157\x6d\x5f\146\157\x72\155\137\157\x74\160\x5f\x65\x6e\x61\x62\154\x65\x64"));
        $this->_typePhoneTag = "\155\x6f\137\x63\165\x73\x74\x6f\155\106\x6f\x72\155\137\160\x68\157\156\145\x5f\145\x6e\x61\142\x6c\145";
        $this->_typeEmailTag = "\x6d\157\137\x63\165\163\x74\x6f\x6d\x46\x6f\x72\x6d\x5f\x65\155\141\x69\154\137\x65\156\x61\142\x6c\145";
        $this->_isFormEnabled = get_mo_option("\x63\165\163\x74\x6f\155\137\x66\x6f\162\155\x5f\x63\157\156\x74\141\x63\164\137\x65\x6e\141\x62\154\145");
        $this->_generateOTPAction = "\x6d\151\x6e\x69\157\x72\x61\156\x67\145\x2d\143\165\x73\164\157\x6d\106\157\162\x6d\55\x73\145\x6e\x64\x2d\157\164\x70";
        $this->_validateOTPAction = "\155\151\156\x69\157\162\x61\156\147\x65\55\143\165\x73\x74\157\155\x46\x6f\x72\x6d\x2d\x76\x65\162\151\x66\x79\55\143\x6f\144\x65";
        $this->_checkValidatedOnSubmit = "\x6d\151\156\x69\x6f\162\141\x6e\147\x65\x2d\143\x75\x73\x74\157\155\x46\x6f\162\x6d\x2d\166\145\162\151\146\171\x2d\163\165\142\x6d\151\164";
        $this->_otpType = get_mo_option("\x63\x75\x73\164\157\155\x5f\146\157\x72\155\137\x65\x6e\141\x62\154\145\x5f\x74\x79\x70\x65");
        $this->_buttonText = get_mo_option("\x63\165\163\x74\157\x6d\137\146\157\x72\x6d\137\x62\165\x74\x74\x6f\156\137\164\145\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\151\x63\153\x20\x48\x65\162\x65\40\164\157\x20\163\x65\x6e\144\40\x4f\124\x50");
        $this->validated = FALSE;
        parent::__construct();
        $this->handleForm();
    }
    function handleForm()
    {
        MoPHPSessions::checkSession();
        if ($this->_isFormEnabled) {
            goto XJF;
        }
        return;
        XJF:
        $this->_formFieldId = $this->getFieldKeyDetails();
        $this->_formSubmitId = $this->getSubmitKeyDetails();
        add_action("\167\x70\137\x65\156\161\165\145\x75\x65\x5f\163\143\162\151\x70\164\163", array($this, "\155\x6f\x5f\x65\x6e\161\x75\x65\165\145\137\x66\157\162\155\137\x73\x63\162\151\160\x74"));
        add_action("\x6c\157\147\151\156\x5f\145\156\161\165\x65\165\x65\x5f\x73\x63\x72\151\160\x74\x73", array($this, "\x6d\x6f\x5f\145\156\161\165\x65\165\145\x5f\146\x6f\162\155\137\x73\143\x72\x69\160\164"));
        add_action("\167\160\137\141\152\141\x78\137{$this->_generateOTPAction}", [$this, "\137\x73\145\x6e\144\x5f\157\x74\160"]);
        add_action("\167\160\137\x61\x6a\x61\x78\x5f\156\157\160\162\x69\166\137{$this->_generateOTPAction}", [$this, "\x5f\x73\145\156\144\x5f\157\x74\x70"]);
        add_action("\167\160\137\141\x6a\x61\x78\x5f{$this->_validateOTPAction}", [$this, "\x70\x72\x6f\143\x65\163\163\x46\x6f\162\x6d\101\x6e\144\126\x61\x6c\151\x64\x61\x74\x65\117\x54\x50"]);
        add_action("\x77\160\x5f\141\x6a\x61\170\x5f\156\157\x70\162\151\x76\x5f{$this->_validateOTPAction}", [$this, "\x70\x72\157\x63\145\x73\163\x46\157\162\155\x41\156\x64\126\141\x6c\x69\144\141\x74\145\x4f\x54\x50"]);
        add_action("\x77\160\137\x61\x6a\x61\170\x5f{$this->_checkValidatedOnSubmit}", [$this, "\x5f\x63\150\x65\143\x6b\126\141\154\x69\x64\x61\x74\x65\144\117\156\x53\165\142\x6d\x69\x74"]);
        add_action("\x77\160\x5f\141\152\x61\170\137\156\157\x70\162\x69\x76\x5f{$this->_checkValidatedOnSubmit}", [$this, "\x5f\x63\150\145\x63\x6b\126\x61\x6c\151\144\141\x74\145\144\117\x6e\123\x75\142\x6d\x69\164"]);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto rzH;
        }
        $this->validated = TRUE;
        $this->unsetOTPSessionVariables();
        return;
        rzH:
    }
    function mo_enqueue_form_script()
    {
        wp_register_script($this->_formSessionVar, MOV_URL . "\151\156\143\154\x75\x64\x65\163\57\x6a\163\57" . $this->_formSessionVar . "\x2e\152\163", array("\152\161\x75\x65\162\x79"));
        wp_localize_script($this->_formSessionVar, $this->_formSessionVar, array("\163\x69\x74\145\125\122\114" => wp_ajax_url(), "\x6f\x74\x70\124\171\160\145" => $this->getVerificationType(), "\x66\157\162\x6d\104\145\x74\x61\x69\x6c\163" => $this->_formDetails, "\142\x75\164\x74\157\x6e\164\x65\x78\164" => $this->_buttonText, "\x69\155\147\125\122\114" => MOV_LOADER_URL, "\146\x69\x65\154\x64\x54\x65\170\x74" => mo_("\105\156\164\x65\x72\40\117\x54\x50\40\150\145\x72\145"), "\147\156\x6f\x6e\143\x65" => wp_create_nonce($this->_nonce), "\x6e\x6f\x6e\x63\x65\x4b\145\171" => wp_create_nonce($this->_nonceKey), "\x76\x6e\x6f\x6e\x63\x65" => wp_create_nonce($this->_nonce), "\147\x61\143\164\151\157\156" => $this->_generateOTPAction, "\x76\141\143\164\151\x6f\156" => $this->_validateOTPAction, "\x73\x61\143\164\151\157\156" => $this->_checkValidatedOnSubmit, "\146\x69\145\154\x64\123\x65\x6c\145\143\x74\157\162" => $this->_formFieldId, "\163\165\142\x6d\x69\164\123\x65\154\x65\x63\164\x6f\x72" => $this->_formSubmitId));
        wp_enqueue_script($this->_formSessionVar);
        wp_enqueue_style("\x6d\x6f\137\x66\x6f\162\x6d\163\137\x63\163\163", MOV_FORM_CSS);
    }
    function _send_otp()
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto aN1;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        aN1:
        if (!(MoUtility::sanitizeCheck("\157\x74\x70\x54\x79\x70\145", $_POST) === VerificationType::PHONE)) {
            goto Ivw;
        }
        $this->_processPhoneAndSendOTP($_POST);
        Ivw:
        if (!(MoUtility::sanitizeCheck("\157\164\160\124\171\x70\145", $_POST) === VerificationType::EMAIL)) {
            goto mCR;
        }
        $this->_processEmailAndSendOTP($_POST);
        mCR:
    }
    public function _checkValidatedOnSubmit()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar) || $this->validated) {
            goto yRR;
        }
        if (!(!SessionUtils::isOTPInitialized($this->_formSessionVar) && !$this->validated)) {
            goto uXS;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        uXS:
        goto sa_;
        yRR:
        wp_send_json(MoUtility::createJson(self::VALIDATED, MoConstants::SUCCESS_JSON_TYPE));
        sa_:
    }
    private function _processEmailAndSendOTP($FA)
    {
        MoPHPSessions::checkSession();
        if (!MoUtility::sanitizeCheck("\x75\x73\x65\162\137\x65\155\141\151\x6c", $FA)) {
            goto pIp;
        }
        $p1 = sanitize_email($FA["\x75\x73\145\x72\x5f\145\155\141\x69\x6c"]);
        SessionUtils::addEmailVerified($this->_formSessionVar, $p1);
        $this->sendChallenge('', $p1, NULL, NULL, VerificationType::EMAIL);
        goto k6l;
        pIp:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        k6l:
    }
    private function _processPhoneAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\163\x65\x72\x5f\x70\x68\x6f\156\145", $FA)) {
            goto xWn;
        }
        $ue = sanitize_text_field($FA["\165\x73\x65\162\137\x70\150\157\156\145"]);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $ue);
        $this->sendChallenge('', NULL, NULL, $ue, VerificationType::PHONE);
        goto Q1g;
        xWn:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        Q1g:
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
            goto MnE;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        MnE:
    }
    private function checkIntegrityAndValidateOTP($FA)
    {
        MoPHPSessions::checkSession();
        $this->checkIntegrity($FA);
        $this->validateChallenge(sanitize_text_field($FA["\x6f\x74\160\124\171\x70\145"]), NULL, sanitize_text_field($FA["\x6f\164\x70\137\x74\157\x6b\145\x6e"]));
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $FA["\x6f\164\160\124\x79\x70\145"])) {
            goto tiY;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::CUSTOM_FORM_MESSAGE), MoConstants::ERROR_JSON_TYPE));
        goto AXA;
        tiY:
        if (!($FA["\x6f\164\x70\124\x79\160\x65"] === VerificationType::PHONE)) {
            goto HeL;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, sanitize_text_field($FA["\165\163\x65\162\x5f\x70\150\x6f\156\x65"]));
        HeL:
        if (!($FA["\x6f\164\160\x54\171\x70\x65"] === VerificationType::EMAIL)) {
            goto mHv;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, sanitize_email($FA["\165\x73\145\x72\x5f\145\155\x61\x69\154"]));
        mHv:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::CUSTOM_FORM_MESSAGE), MoConstants::ERROR_JSON_TYPE));
        AXA:
    }
    private function checkIntegrity($FA)
    {
        if (!($FA["\157\164\160\x54\x79\x70\145"] === VerificationType::PHONE)) {
            goto s9v;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($FA["\165\x73\x65\x72\137\160\x68\157\156\145"]))) {
            goto D5a;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        D5a:
        s9v:
        if (!($FA["\157\x74\x70\124\171\160\x65"] === VerificationType::EMAIL)) {
            goto jyF;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email($FA["\x75\163\145\x72\137\x65\155\141\x69\154"]))) {
            goto WsD;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        WsD:
        jyF:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto M9N;
        }
        return;
        M9N:
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto OB6;
        }
        return;
        OB6:
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
            goto Pz0;
        }
        array_push($kp, $this->_formFieldId);
        Pz0:
        return $kp;
    }
    function isPhoneEnabled()
    {
        return $this->getVerificationType() == VerificationType::PHONE ? TRUE : FALSE;
    }
    private function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\x63\165\163\164\157\155\137\x66\x6f\x72\x6d", $_POST)) {
            goto D_Z;
        }
        return array();
        D_Z:
        $tA = sanitize_text_field($_POST["\x6d\x6f\x5f\143\165\x73\164\157\x6d\145\x72\137\x76\141\x6c\151\144\x61\x74\x69\157\x6e\x5f\x63\x75\163\164\x6f\x6d\137\146\157\x72\155\137\x65\x6e\141\142\x6c\x65\x5f\x74\x79\x70\x65"]) == $this->_typePhoneTag ? "\160\150\157\156\x65" : "\x65\x6d\x61\x69\154";
        foreach (array_filter($_POST["\x63\165\163\x74\x6f\155\137\146\x6f\162\x6d"]["\146\x6f\x72\155"]) as $j1 => $qL) {
            $form[$qL] = array("\x73\165\x62\x6d\x69\x74\x5f\151\x64" => sanitize_text_field($_POST["\143\165\163\164\x6f\x6d\x5f\x66\157\162\x6d"][$tA]["\163\x75\142\155\x69\x74\x5f\151\144"]), "\146\x69\x65\154\x64\137\151\x64" => sanitize_text_field($_POST["\143\165\x73\164\x6f\155\x5f\146\157\x72\x6d"][$tA]["\x66\151\x65\x6c\144\137\x69\x64"]));
            rmR:
        }
        Mmd:
        return $form;
    }
    function handleFormOptions()
    {
        $form = $this->parseFormDetails();
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto sE1;
        }
        return;
        sE1:
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x63\x75\163\x74\157\155\137\146\157\x72\155\x5f\143\157\x6e\164\141\143\x74\137\145\x6e\x61\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\143\x75\163\164\x6f\x6d\137\146\x6f\x72\155\137\145\156\x61\x62\x6c\x65\x5f\164\x79\x70\145");
        $this->_buttonText = $this->sanitizeFormPOST("\143\165\163\164\157\155\137\146\x6f\162\155\x5f\x62\x75\164\x74\x6f\x6e\137\x74\145\x78\x74");
        if (!$this->basicValidationCheck(BaseMessages::CUSTOM_CHOOSE)) {
            goto u4K;
        }
        update_mo_option("\143\x75\x73\x74\x6f\x6d\x5f\146\157\x72\155\137\x6f\x74\160\x5f\145\156\141\142\x6c\145\x64", maybe_serialize($this->_formDetails));
        update_mo_option("\143\165\163\164\157\x6d\x5f\x66\157\162\x6d\x5f\x63\x6f\156\x74\x61\x63\164\137\145\156\141\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x63\x75\x73\164\157\155\x5f\x66\157\162\x6d\x5f\145\156\x61\142\154\x65\x5f\x74\x79\x70\x65", $this->_otpType);
        update_mo_option("\143\165\163\x74\157\x6d\137\x66\157\x72\155\x5f\x62\x75\164\x74\x6f\156\x5f\x74\145\170\x74", $this->_buttonText);
        u4K:
    }
    function getSubmitKeyDetails()
    {
        if (!empty($this->_formDetails)) {
            goto SXm;
        }
        return;
        SXm:
        return stripcslashes($this->_formDetails[1]["\163\x75\x62\155\x69\x74\x5f\151\x64"]);
    }
    function getFieldKeyDetails()
    {
        if (!empty($this->_formDetails)) {
            goto KeD;
        }
        return;
        KeD:
        return stripcslashes($this->_formDetails[1]["\x66\x69\145\x6c\144\137\151\144"]);
    }
}
