<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class RealEstate7 extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formKey = "\122\x45\101\114\x5f\x45\x53\x54\x41\x54\x45\137\x37";
        $this->_formSessionVar = FormSessionVars::REALESTATE_7;
        $this->_isFormEnabled = get_mo_option("\x72\x65\141\x6c\145\x73\164\141\x74\145\x5f\145\x6e\141\x62\154\145");
        $this->_typePhoneTag = "\155\157\137\162\x65\x61\x6c\x65\x73\x74\x61\x74\x65\x5f\x63\x6f\x6e\x74\141\x63\x74\137\x70\150\157\156\x65\137\x65\x6e\141\x62\154\x65";
        $this->_typeEmailTag = "\155\157\x5f\162\x65\x61\154\x65\163\x74\141\164\145\x5f\x63\x6f\x6e\x74\x61\143\164\x5f\x65\155\x61\151\154\137\145\156\x61\142\x6c\x65";
        $this->_formName = mo_("\122\145\x61\154\x20\105\x73\164\x61\x74\x65\40\67\x20\120\x72\157\x20\124\150\145\155\x65");
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_phoneFormId = "\43\155\157\137\x63\164\137\165\x73\x65\x72\x5f\160\x68\x6f\156\145";
        $this->_generateOTPAction = "\x6d\x69\x6e\151\157\162\141\156\147\x65\x2d\162\x65\141\x6c\55\x65\x73\164\141\x74\x65\55\67\x2d\x73\x65\156\144\x2d\157\164\x70";
        $this->_validateOTPAction = "\155\151\x6e\x69\157\162\x61\156\x67\x65\55\162\x65\141\x6c\x2d\145\163\164\141\x74\145\55\67\55\166\x65\162\x69\146\x79\55\143\x6f\x64\x65";
        $this->_otpType = get_mo_option("\x72\x65\x61\x6c\x65\163\164\x61\164\145\x5f\157\164\x70\x5f\164\171\160\145");
        $this->_formDocuments = MoOTPDocs::REALESTATE7_THEME_LINK;
        $this->_buttonText = $this->setButtonText();
        add_action("\x77\x70\x5f\x65\x6e\x71\165\x65\165\145\137\163\143\x72\151\x70\164\x73", array($this, "\x61\x64\x64\120\x68\157\x6e\145\x46\x69\x65\x6c\144\x53\143\x72\151\x70\x74"));
        add_action("\x77\160\x5f\141\152\141\x78\x5f{$this->_generateOTPAction}", [$this, "\x5f\163\x65\156\144\x5f\x6f\x74\x70"]);
        add_action("\167\x70\x5f\x61\152\x61\170\x5f\x6e\x6f\160\x72\x69\166\x5f{$this->_generateOTPAction}", [$this, "\137\x73\145\156\144\137\x6f\164\x70"]);
        add_action("\167\x70\137\x61\x6a\x61\x78\x5f{$this->_validateOTPAction}", [$this, "\x70\x72\157\143\145\x73\x73\106\x6f\x72\155\x41\x6e\144\126\x61\x6c\x69\144\141\x74\145\117\x54\120"]);
        add_action("\x77\x70\x5f\141\152\x61\170\x5f\156\x6f\160\162\151\166\x5f{$this->_validateOTPAction}", [$this, "\x70\162\x6f\143\145\163\x73\106\157\162\155\101\x6e\144\x56\141\154\x69\144\141\164\x65\117\124\120"]);
        $this->_formDetails = ["\x63\x74\x5f\x72\x65\x67\x69\163\164\x72\x61\x74\151\x6f\x6e\x5f\x66\x6f\162\155" => ["\x70\150\x6f\x6e\145\153\145\x79" => "\155\x6f\137\143\164\137\x75\x73\x65\x72\x5f\x70\x68\x6f\x6e\x65", "\145\155\141\x69\154\153\x65\x79" => "\143\164\137\165\163\145\x72\x5f\x65\155\141\151\x6c"]];
        if (array_key_exists("\157\x70\x74\151\157\x6e", $_POST)) {
            goto H8;
        }
        return;
        H8:
        switch (trim($_POST["\x6f\x70\164\x69\x6f\x6e"])) {
            case "\x72\x65\x61\x6c\145\163\x74\x61\x74\x65\137\162\x65\x67\151\163\x74\145\x72":
                $this->_sanitizeAndRouteData($_POST);
                goto Qd;
        }
        po:
        Qd:
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto rr;
        }
        $this->unsetOTPSessionVariables();
        return;
        rr:
    }
    function setButtonText()
    {
        if (strcasecmp(get_mo_option("\162\145\x61\x6c\x65\x73\x74\141\164\x65\137\x6f\x74\x70\137\x74\171\x70\x65"), $this->_typePhoneTag) == 0) {
            goto sS;
        }
        return mo_("\x53\x65\x6e\x64\40\x4f\124\120\40\164\157\x20\105\155\x61\x69\x6c");
        goto GZ;
        sS:
        return mo_("\123\145\x6e\x64\40\x4f\124\x50\40\x74\157\40\120\x68\x6f\156\x65");
        GZ:
    }
    function _sanitizeAndRouteData($FA)
    {
        $j0 = key($this->_formDetails);
        if (array_key_exists($j0, $this->_formDetails)) {
            goto kX;
        }
        return;
        kX:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 || strcasecmp($this->_otpType, $this->_typeBothTag) == 0)) {
            goto MW;
        }
        $this->_processPhone(sanitize_text_field($FA["\155\x6f\137\143\x74\137\165\x73\145\162\137\160\150\x6f\x6e\x65"]));
        MW:
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0 || strcasecmp($this->_otpType, $this->_typeBothTag) == 0)) {
            goto ZW;
        }
        $this->_processEmail(sanitize_email($FA["\143\164\137\x75\163\x65\162\137\x65\x6d\141\x69\x6c"]));
        ZW:
    }
    function _send_otp()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto dV;
        }
        $this->_processEmailAndSendOTP($_POST);
        goto wo;
        dV:
        $this->_processPhoneAndSendOTP($_POST);
        wo:
    }
    private function _processEmailAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\x75\x73\145\x72\137\145\155\141\151\154", $FA)) {
            goto gE;
        }
        $p1 = sanitize_email($FA["\165\163\145\x72\x5f\x65\155\x61\x69\x6c"]);
        SessionUtils::addEmailVerified($this->_formSessionVar, $p1);
        $this->sendChallenge('', $p1, NULL, NULL, VerificationType::EMAIL);
        goto IG;
        gE:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        IG:
    }
    private function _processPhoneAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\163\145\162\x5f\x70\x68\157\x6e\x65", $FA)) {
            goto Y_;
        }
        $ue = sanitize_text_field($FA["\x75\x73\145\x72\x5f\x70\150\x6f\x6e\145"]);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $ue);
        $this->sendChallenge('', NULL, NULL, $ue, VerificationType::PHONE);
        goto vt;
        Y_:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        vt:
    }
    function processFormAndValidateOTP()
    {
        $this->validateAjaxRequest();
        $this->checkIfOTPSent();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfOTPSent()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto DB;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        DB:
    }
    private function checkIntegrityAndValidateOTP($FA)
    {
        $this->checkIntegrity($FA);
        $this->validateChallenge(sanitize_text_field($FA["\157\164\x70\124\171\160\145"]), NULL, sanitize_text_field($FA["\157\164\x70\137\x74\157\x6b\145\156"]));
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, sanitize_text_field($FA["\157\164\160\124\x79\160\x65"]))) {
            goto o_;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto Sl;
        o_:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        Sl:
    }
    private function checkIntegrity($FA)
    {
        if (sanitize_text_field($FA["\157\164\160\x54\171\x70\145"]) === "\x70\x68\x6f\x6e\145") {
            goto s7;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email(sanitize_email($FA["\165\x73\x65\162\x5f\145\155\x61\x69\x6c"])))) {
            goto nI;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        nI:
        goto Jz;
        s7:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field(sanitize_text_field($FA["\165\x73\145\162\137\x70\150\x6f\x6e\x65"])))) {
            goto Ho;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        Ho:
        Jz:
    }
    public function unsetOTPSessionVariables()
    {
        Sessionutils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    public function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
    }
    private function _processPhone($Dk)
    {
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)) {
            goto G7;
        }
        ct_errors()->add("\x50\x6c\x65\141\x73\145\x20\x56\141\154\x69\144\141\x74\x65", __(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), "\143\157\156\x74\x65\x6d\x70\157"));
        G7:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($Dk))) {
            goto Vd;
        }
        ct_errors()->add("\120\x6c\145\141\163\x65\x20\x56\141\154\x69\x64\141\164\x65", __(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), "\x63\x6f\x6e\164\x65\155\x70\x6f"));
        Vd:
    }
    private function _processEmail($mo)
    {
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL)) {
            goto yz;
        }
        ct_errors()->add("\x50\x6c\x65\141\163\x65\40\126\141\x6c\151\x64\141\x74\x65", __(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), "\x63\157\x6e\164\x65\x6d\x70\x6f"));
        yz:
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_text_field($mo))) {
            goto gW;
        }
        ct_errors()->add("\x50\154\145\141\x73\145\40\x56\x61\154\151\144\x61\x74\145", __(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), "\143\157\156\164\145\x6d\160\157"));
        gW:
    }
    public function addPhoneFieldScript()
    {
        wp_register_script("\162\145\x61\x6c\105\163\x74\141\164\x65\67\x53\x63\x72\151\160\x74", MOV_URL . "\151\156\x63\x6c\165\144\x65\163\x2f\x6a\163\57\162\x65\141\154\105\x73\164\x61\164\x65\x37\x53\143\162\x69\x70\164\x2e\155\x69\156\56\152\x73\77\166\145\x72\x73\151\x6f\156\75" . MOV_VERSION, array("\152\161\165\145\162\171"));
        wp_localize_script("\x72\145\x61\x6c\x45\163\164\x61\164\x65\67\123\x63\162\x69\x70\x74", "\162\145\x61\x6c\x45\163\164\x61\164\x65\x37\123\143\162\151\160\x74", array("\x73\151\x74\145\125\122\114" => wp_ajax_url(), "\157\164\160\x54\171\160\145" => $this->ajaxProcessingFields(), "\x66\x6f\x72\x6d\x44\x65\164\x61\x69\x6c\x73" => $this->_formDetails, "\142\x75\x74\x74\x6f\x6e\164\x65\x78\164" => $this->_buttonText, "\166\141\x6c\x69\144\141\x74\145\x64" => $this->getSessionDetails(), "\151\x6d\147\x55\122\114" => MOV_LOADER_URL, "\x66\x69\x65\154\144\x54\x65\170\x74" => mo_("\x45\x6e\x74\145\x72\40\117\124\120\40\x68\x65\162\145"), "\147\x6e\157\x6e\x63\x65" => wp_create_nonce($this->_nonce), "\x6e\x6f\156\143\x65\x4b\x65\171" => wp_create_nonce($this->_nonceKey), "\166\x6e\x6f\156\x63\x65" => wp_create_nonce($this->_nonce), "\x67\141\143\164\151\157\x6e" => $this->_generateOTPAction, "\166\141\143\164\x69\x6f\x6e" => $this->_validateOTPAction));
        wp_enqueue_script("\162\145\141\154\x45\163\164\141\164\x65\67\x53\x63\162\151\160\x74");
    }
    function getSessionDetails()
    {
        return [VerificationType::EMAIL => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL), VerificationType::PHONE => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)];
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!(self::isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto v7;
        }
        array_push($kp, $this->_phoneFormId);
        v7:
        return $kp;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto iG;
        }
        return;
        iG:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\162\x65\x61\154\145\163\164\x61\164\x65\137\x65\x6e\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x72\145\x61\154\145\163\164\x61\164\145\x5f\143\x6f\x6e\x74\141\143\164\137\164\x79\160\145");
        update_mo_option("\x72\145\141\154\x65\163\x74\141\x74\x65\x5f\x65\156\141\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\162\145\x61\x6c\x65\163\164\x61\164\145\137\157\164\x70\x5f\164\171\160\145", $this->_otpType);
    }
}
