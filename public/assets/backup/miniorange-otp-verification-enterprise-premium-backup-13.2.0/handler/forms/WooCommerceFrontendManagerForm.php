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
class WooCommerceFrontendManagerForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WCFM;
        $this->_phoneFormId = "\x23\160\150\157\x6e\x65";
        $this->_formKey = "\127\x43\x46\x4d";
        $this->_typePhoneTag = "\155\157\x5f\x77\143\146\155\x66\x6f\x72\155\x5f\x70\150\157\156\145\x5f\145\x6e\141\142\154\145";
        $this->_typeEmailTag = "\155\157\x5f\167\143\146\x6d\x66\157\x72\155\x5f\x65\155\141\151\154\137\145\156\141\x62\154\145";
        $this->_formName = mo_("\x57\x6f\157\x43\157\x6d\x6d\x65\x72\143\x65\40\x46\x72\x6f\x6e\164\145\156\144\x20\115\141\x6e\141\x67\x65\x72\x20\106\157\162\x6d\40\x28\127\103\106\115\51");
        $this->_isFormEnabled = get_mo_option("\x77\x63\x66\x6d\146\157\162\x6d\137\x65\x6e\141\x62\154\x65");
        $this->_buttonText = get_mo_option("\167\x63\146\x6d\146\x6f\162\155\x73\137\x62\x75\x74\164\x6f\x6e\x5f\x74\145\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\123\145\x6e\x64\x20\117\x54\120");
        $this->_generateOTPAction = "\x6d\151\156\x69\157\x72\x61\156\147\145\55\167\x63\x66\155\146\x6f\x72\155\55\163\x65\156\x64\x2d\157\164\x70";
        $this->_validateOTPAction = "\155\x69\156\x69\157\x72\141\x6e\147\145\55\x77\x63\146\155\146\x6f\x72\x6d\x2d\166\x65\162\151\x66\171\55\x63\x6f\x64\145";
        $this->_formDocuments = MoOTPDocs::WCFM_FORM;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\143\x66\x6d\146\x6f\x72\x6d\x5f\145\156\141\142\154\x65\137\x74\171\160\145");
        $this->_restrictDuplicates = get_mo_option("\x77\143\x66\155\146\157\x72\x6d\x5f\162\145\x73\164\162\x69\143\x74\x5f\x64\165\x70\x6c\x69\143\x61\x74\x65\x73");
        add_filter("\167\143\146\155\137\x66\157\162\x6d\137\143\x75\x73\x74\157\x6d\x5f\x76\141\154\151\144\141\164\x69\x6f\156", [$this, "\x76\x61\154\151\144\141\164\x65\106\157\x72\155"], 99, 1);
        add_action("\x77\160\137\145\x6e\161\x75\145\165\x65\x5f\x73\143\162\151\160\x74\163", array($this, "\155\x6f\137\x65\156\x71\x75\x65\165\x65\x5f\x77\143\146\x6d\x66\x6f\162\x6d\163"));
        add_action("\x77\143\x66\155\x6d\160\137\156\145\167\137\x73\x74\157\162\145\137\x63\162\x65\141\164\145\x64", [$this, "\165\156\x73\x65\164\x5f\x73\145\x73\x73\x69\157\x6e"], 99, 2);
        add_action("\167\160\x5f\x61\x6a\x61\170\x5f{$this->_generateOTPAction}", [$this, "\x5f\x73\x65\x6e\x64\137\157\x74\x70"]);
        add_action("\x77\x70\x5f\141\152\x61\170\x5f\156\157\160\162\x69\166\137{$this->_generateOTPAction}", [$this, "\x5f\163\145\156\144\x5f\x6f\x74\x70"]);
        add_action("\x77\160\x5f\x61\152\141\x78\137{$this->_validateOTPAction}", [$this, "\160\x72\157\x63\x65\x73\x73\106\157\x72\155\x41\156\144\126\141\x6c\x69\x64\141\164\145\x4f\124\120"]);
        add_action("\x77\160\137\x61\x6a\141\x78\137\x6e\157\160\x72\151\166\x5f{$this->_validateOTPAction}", [$this, "\160\x72\x6f\143\x65\163\x73\106\157\x72\x6d\101\156\x64\x56\x61\x6c\151\144\x61\x74\x65\117\x54\x50"]);
    }
    function unset_session($sr, $Eh)
    {
        $this->unsetOTPSessionVariables();
    }
    function mo_enqueue_wcfmforms()
    {
        wp_register_script("\155\x6f\137\167\143\146\x6d", MOV_URL . "\151\x6e\x63\154\x75\x64\145\x73\57\x6a\x73\57\x6d\157\137\x77\x63\146\x6d\x2e\155\151\x6e\56\152\163", array("\x6a\x71\165\145\162\x79"));
        wp_localize_script("\x6d\x6f\x5f\167\143\x66\x6d", "\x6d\x6f\x5f\x77\x63\146\155", array("\x73\x69\164\145\x55\122\x4c" => wp_ajax_url(), "\157\x74\160\124\171\160\x65" => $this->_otpType, "\146\x69\145\154\144" => $this->_otpType === $this->_typePhoneTag ? "\x70\x68\157\x6e\x65" : "\165\163\x65\x72\x5f\145\x6d\x61\x69\154", "\x62\x75\x74\164\157\156\x74\145\x78\x74" => $this->_buttonText, "\x76\x61\154\151\144\x61\x74\145\144" => $this->getSessionDetails(), "\x69\155\x67\x55\122\114" => MOV_LOADER_URL, "\146\x69\145\x6c\144\124\x65\x78\164" => mo_("\105\156\x74\x65\x72\x20\117\124\120"), "\147\156\157\156\143\145" => wp_create_nonce($this->_nonce), "\156\157\x6e\x63\145\x4b\145\x79" => wp_create_nonce($this->_nonceKey), "\166\x6e\157\x6e\x63\145" => wp_create_nonce($this->_nonce), "\147\x61\143\164\x69\x6f\x6e" => $this->_generateOTPAction, "\166\141\x63\164\x69\x6f\x6e" => $this->_validateOTPAction));
        wp_enqueue_script("\x6d\x6f\137\x77\x63\x66\155");
    }
    function getSessionDetails()
    {
        return [VerificationType::EMAIL => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL), VerificationType::PHONE => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)];
    }
    function _send_otp()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ("\x6d\x6f\137\x77\143\x66\155\146\x6f\x72\155\x5f" . $_POST["\157\x74\x70\124\171\x70\145"] . "\x5f\145\156\x61\x62\x6c\x65" === $this->_typePhoneTag) {
            goto Gr;
        }
        $this->_processEmailAndSendOTP($_POST);
        goto Og;
        Gr:
        $this->_processPhoneAndSendOTP($_POST);
        Og:
    }
    private function _processEmailAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\145\x72\x5f\x65\155\141\x69\x6c", $FA)) {
            goto M8;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $FA["\x75\x73\x65\x72\137\145\155\x61\151\154"]);
        $this->sendChallenge('', $FA["\165\163\x65\x72\137\x65\155\141\x69\x6c"], NULL, NULL, VerificationType::EMAIL);
        goto ZM;
        M8:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        ZM:
    }
    private function _processPhoneAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\x65\x72\137\160\150\x6f\156\x65", $FA)) {
            goto CN;
        }
        if ($this->isPhoneNumberAlreadyInUse($FA["\x75\x73\145\162\x5f\160\x68\157\x6e\x65"]) && $this->_restrictDuplicates) {
            goto gN;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, $FA["\165\163\x65\162\137\160\x68\157\156\x65"]);
        $this->sendChallenge('', NULL, NULL, $FA["\x75\163\145\162\137\160\150\157\x6e\145"], VerificationType::PHONE);
        goto dS;
        gN:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_EXISTS), MoConstants::ERROR_JSON_TYPE));
        dS:
        goto Ad;
        CN:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        Ad:
    }
    function isPhoneNumberAlreadyInUse($Dk)
    {
        global $wpdb;
        $Dk = MoUtility::processPhoneNumber($Dk);
        $j1 = "\x62\x69\154\154\151\156\x67\x5f\160\150\x6f\156\x65";
        $uU = wp_get_current_user()->ID;
        $le = $wpdb->get_row("\123\105\x4c\x45\x43\x54\x20\140\165\x73\x65\x72\x5f\151\144\x60\x20\106\x52\117\x4d\40\x60{$wpdb->prefix}\165\x73\145\x72\x6d\x65\164\141\140\40\127\x48\105\x52\105\40\140\x6d\145\x74\x61\137\153\145\x79\x60\40\x3d\40\x27{$j1}\47\40\x41\116\104\x20\140\155\145\x74\141\137\166\x61\154\165\x65\x60\40\x3d\x20\40\x27{$Dk}\x27");
        return MoUtility::isBlank($le) ? FALSE : $le->user_id != $uU;
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
            goto My;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        My:
    }
    private function checkIntegrityAndValidateOTP($FA)
    {
        $this->checkIntegrity($FA);
        $this->validateChallenge($FA["\x6f\164\x70\x54\x79\160\x65"], NULL, $FA["\157\x74\160\137\164\x6f\x6b\x65\156"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $FA["\157\164\x70\124\x79\x70\145"])) {
            goto pi;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto ZY;
        pi:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        ZY:
    }
    private function checkIntegrity($FA)
    {
        if ($FA["\157\164\x70\124\x79\160\145"] === "\160\x68\x6f\x6e\145") {
            goto Bj;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $FA["\165\x73\x65\162\137\x65\155\x61\x69\x6c"])) {
            goto NX;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        NX:
        goto f1;
        Bj:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $FA["\165\163\145\162\x5f\x70\x68\x6f\x6e\x65"])) {
            goto uP;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        uP:
        f1:
    }
    public function validateForm($zA)
    {
        if (!empty($zA)) {
            goto Cx;
        }
        return $zA;
        Cx:
        if (!(isset($_POST["\167\143\x66\155\137\155\145\155\x62\145\x72\x73\150\151\x70\137\162\x65\147\x69\163\x74\x72\141\164\151\x6f\156\x5f\146\x6f\162\x6d"]) && !isset($zA["\x6d\x65\x6d\142\x65\162\x5f\151\144"]))) {
            goto M5;
        }
        if (!($this->_otpType === $this->_typeEmailTag)) {
            goto IH;
        }
        $zA = $this->processEmail($zA);
        IH:
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto Xk;
        }
        $zA = $this->processPhone($zA);
        Xk:
        return $zA;
        M5:
    }
    function processEmail($zA)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL)) {
            goto P1;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $zA["\x75\163\x65\x72\x5f\145\x6d\x61\x69\154"])) {
            goto PF;
        }
        $zA["\x68\x61\163\137\145\x72\x72\x6f\162"] = true;
        $zA["\155\x65\x73\x73\141\x67\x65"] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        PF:
        goto Aa;
        P1:
        $zA["\x68\x61\163\x5f\145\x72\162\x6f\x72"] = true;
        $zA["\x6d\145\163\163\x61\147\x65"] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        Aa:
        return $zA;
    }
    function processPhone($zA)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)) {
            goto rg;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $zA["\167\x63\x66\x6d\166\x6d\x5f\x73\x74\x61\164\151\x63\x5f\151\156\146\x6f\163"]["\x70\150\x6f\x6e\x65"])) {
            goto wF;
        }
        $zA["\x68\x61\163\x5f\x65\x72\162\157\162"] = true;
        $zA["\x6d\145\163\x73\141\147\145"] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        wF:
        goto uO;
        rg:
        $zA["\x68\x61\163\x5f\145\162\x72\157\x72"] = true;
        $zA["\155\145\x73\x73\141\x67\x65"] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        uO:
        return $zA;
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
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->_isFormEnabled && ($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag))) {
            goto T2;
        }
        $kp = array_merge($kp, array($this->_phoneFormId));
        T2:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto pZ;
        }
        return;
        pZ:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x63\146\155\x66\x6f\x72\x6d\137\x65\x6e\x61\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x63\x66\x6d\x66\157\x72\155\137\x65\156\141\142\154\x65\137\164\171\160\145");
        $this->_buttonText = $this->sanitizeFormPOST("\x77\143\x66\155\x66\x6f\x72\155\x73\x5f\x62\165\164\x74\x6f\x6e\x5f\164\x65\170\164");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x77\x63\x66\155\146\157\x72\x6d\137\162\x65\x73\x74\162\151\x63\164\137\x64\165\160\x6c\x69\143\141\164\145\163");
        update_mo_option("\x77\143\x66\x6d\x66\x6f\162\155\137\162\145\163\x74\162\x69\143\164\x5f\144\165\160\x6c\x69\143\x61\164\145\163", $this->_restrictDuplicates);
        update_mo_option("\167\143\146\x6d\146\157\162\155\x5f\x65\x6e\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x77\143\146\x6d\146\x6f\162\155\137\145\x6e\141\x62\x6c\145\x5f\x74\x79\x70\145", $this->_otpType);
        update_mo_option("\167\x63\x66\x6d\146\157\x72\155\163\x5f\x62\165\x74\x74\157\156\137\x74\145\x78\164", $this->_buttonText);
    }
}
