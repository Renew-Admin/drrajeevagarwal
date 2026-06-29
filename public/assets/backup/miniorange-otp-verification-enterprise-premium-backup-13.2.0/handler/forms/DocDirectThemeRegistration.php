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
class DocDirectThemeRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::DOCDIRECT_REG;
        $this->_typePhoneTag = "\x6d\157\x5f\x64\x6f\143\144\x69\162\145\x63\164\x5f\x70\150\157\x6e\x65\137\145\156\x61\142\x6c\145";
        $this->_typeEmailTag = "\155\157\x5f\x64\x6f\143\144\x69\x72\145\143\164\137\x65\x6d\141\151\x6c\137\145\156\141\x62\154\x65";
        $this->_formKey = "\104\x4f\x43\x44\111\122\105\103\124\137\x54\110\x45\x4d\x45";
        $this->_formName = mo_("\104\157\x63\x20\104\x69\162\145\x63\164\40\124\x68\x65\x6d\x65\40\x62\x79\40\124\x68\145\x6d\157\x47\x72\141\x70\x68\151\x63\x73");
        $this->_isFormEnabled = get_mo_option("\x64\x6f\143\144\151\x72\145\x63\164\x5f\145\156\x61\142\154\x65");
        $this->_phoneFormId = "\x69\156\160\x75\x74\133\156\141\155\145\x3d\160\x68\157\x6e\x65\137\x6e\165\155\142\145\162\x5d";
        $this->_formDocuments = MoOTPDocs::DOCDIRECT_THEME;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x64\157\143\x64\x69\x72\x65\143\x74\x5f\x65\x6e\x61\x62\x6c\x65\x5f\x74\171\x70\x65");
        add_action("\167\160\137\x65\x6e\x71\165\145\x75\x65\137\x73\x63\x72\151\160\164\x73", array($this, "\x61\144\144\123\143\x72\x69\160\164\x54\157\122\x65\x67\151\163\x74\162\x61\164\x69\x6f\x6e\x50\x61\x67\x65"));
        add_action("\167\x70\x5f\141\x6a\x61\170\x5f\144\157\x63\x64\x69\x72\145\x63\164\x5f\x75\x73\x65\162\x5f\x72\145\147\151\x73\164\x72\141\164\151\157\156", array($this, "\x6d\x6f\x5f\166\x61\154\151\x64\141\164\145\137\x64\x6f\143\144\x69\x72\145\143\164\x5f\x75\163\x65\162\137\162\145\147\x69\163\164\x72\x61\164\151\157\156"), 1);
        add_action("\x77\x70\x5f\141\x6a\141\170\x5f\x6e\x6f\x70\x72\x69\x76\x5f\144\x6f\x63\144\151\x72\145\143\164\x5f\165\163\x65\162\x5f\162\x65\x67\x69\163\164\x72\141\x74\x69\157\x6e", array($this, "\155\x6f\x5f\166\x61\x6c\151\144\141\164\x65\137\x64\157\143\144\x69\162\x65\143\x74\137\x75\x73\145\x72\x5f\162\145\147\151\163\164\162\141\x74\x69\x6f\x6e"), 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\x70\164\151\157\156", $_GET)) {
            goto EF;
        }
        return;
        EF:
        switch (trim($_GET["\157\160\x74\x69\157\x6e"])) {
            case "\x6d\x69\x6e\x69\x6f\162\x61\156\x67\x65\55\x64\157\143\x64\x69\x72\x65\x63\164\55\x76\145\162\151\146\171":
                $this->startOTPVerificationProcess($_POST);
                goto cv;
        }
        bv:
        cv:
    }
    function addScriptToRegistrationPage()
    {
        wp_register_script("\x64\x6f\x63\144\x69\162\145\x63\164", MOV_URL . "\151\x6e\143\154\165\x64\x65\x73\57\152\x73\x2f\x64\157\x63\144\x69\162\145\143\x74\x2e\x6d\151\x6e\x2e\x6a\x73\77\166\x65\162\163\x69\157\156\x3d" . MOV_VERSION, array("\x6a\161\165\x65\162\x79"), MOV_VERSION, true);
        wp_localize_script("\x64\157\143\144\151\162\x65\143\x74", "\155\x6f\144\x6f\143\x64\151\162\x65\x63\x74", array("\x69\x6d\x67\125\122\114" => MOV_URL . "\151\x6e\x63\x6c\x75\144\145\x73\x2f\x69\155\141\x67\145\163\57\154\157\141\144\x65\x72\56\x67\x69\146", "\x62\x75\x74\x74\157\156\124\x65\170\164" => mo_("\103\x6c\x69\x63\153\40\x48\145\162\145\40\164\157\x20\126\145\x72\x69\146\171\40\x59\157\x75\x72\163\x65\x6c\x66"), "\x69\x6e\163\145\x72\164\101\x66\164\x65\x72" => strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\x69\156\160\x75\164\x5b\x6e\141\x6d\145\x3d\x70\x68\157\x6e\x65\x5f\156\165\x6d\142\145\x72\x5d" : "\151\156\x70\165\x74\x5b\x6e\x61\155\145\x3d\145\x6d\141\151\154\x5d", "\160\154\x61\143\145\110\x6f\x6c\144\x65\x72" => mo_("\x4f\124\x50\x20\x43\x6f\x64\145"), "\x73\x69\x74\x65\125\122\x4c" => site_url()));
        wp_enqueue_script("\144\157\143\144\x69\x72\145\x63\164");
    }
    function startOtpVerificationProcess($FA)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto Ze;
        }
        $this->_send_otp_to_email($FA);
        goto sz;
        Ze:
        $this->_send_otp_to_phone($FA);
        sz:
    }
    function _send_otp_to_phone($FA)
    {
        if (array_key_exists("\165\x73\145\x72\x5f\x70\x68\x6f\x6e\x65", $FA) && !MoUtility::isBlank($FA["\165\x73\x65\x72\x5f\x70\150\157\156\x65"])) {
            goto OA;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto b8;
        OA:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($FA["\x75\x73\145\x72\137\x70\x68\x6f\156\x65"]));
        $this->sendChallenge("\x74\x65\x73\164", '', null, trim($FA["\x75\x73\x65\162\x5f\x70\150\x6f\x6e\145"]), VerificationType::PHONE);
        b8:
    }
    function _send_otp_to_email($FA)
    {
        if (array_key_exists("\165\x73\145\x72\x5f\x65\155\141\151\154", $FA) && !MoUtility::isBlank($FA["\x75\163\x65\x72\x5f\145\155\x61\x69\154"])) {
            goto bH;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto Lo;
        bH:
        SessionUtils::addEmailVerified($this->_formSessionVar, $FA["\x75\163\x65\x72\137\x65\x6d\x61\x69\154"]);
        $this->sendChallenge("\x74\x65\163\x74", $FA["\x75\163\145\162\137\x65\x6d\x61\x69\154"], null, $FA["\x75\163\145\162\137\x65\155\x61\x69\x6c"], VerificationType::EMAIL);
        Lo:
    }
    function mo_validate_docdirect_user_registration()
    {
        $this->checkIfVerificationNotStarted();
        $this->checkIfVerificationCodeNotEntered();
        $this->handle_otp_token_submitted();
    }
    function checkIfVerificationNotStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Ci;
        }
        echo json_encode(array("\x74\x79\x70\145" => "\x65\x72\162\x6f\162", "\x6d\145\163\x73\141\x67\145" => MoMessages::showMessage(MoMessages::DOC_DIRECT_VERIFY)));
        die;
        Ci:
    }
    function checkIfVerificationCodeNotEntered()
    {
        if (!(!array_key_exists("\155\x6f\x5f\166\145\162\x69\146\171", $_POST) || MoUtility::isBlank(sanitize_text_field($_POST["\155\x6f\x5f\x76\145\162\151\x66\171"])))) {
            goto Xz;
        }
        echo json_encode(array("\x74\171\x70\x65" => "\145\162\162\157\162", "\x6d\x65\x73\163\141\147\145" => MoMessages::showMessage(MoMessages::DCD_ENTER_VERIFY_CODE)));
        die;
        Xz:
    }
    function handle_otp_token_submitted()
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto h2;
        }
        $this->processEmail();
        goto na;
        h2:
        $this->processPhoneNumber();
        na:
        $this->validateChallenge($this->getVerificationType(), "\155\x6f\x5f\166\145\162\151\146\x79", NULL);
    }
    function processPhoneNumber()
    {
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\160\150\x6f\156\x65\x5f\x6e\x75\x6d\x62\x65\x72"])) {
            goto WX;
        }
        echo json_encode(array("\164\171\x70\145" => "\145\162\x72\157\162", "\x6d\x65\x73\x73\141\x67\x65" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH)));
        die;
        WX:
    }
    function processEmail()
    {
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\145\x6d\x61\151\x6c"])) {
            goto Kn;
        }
        echo json_encode(array("\x74\x79\x70\145" => "\145\162\162\157\162", "\x6d\x65\163\x73\141\147\x65" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH)));
        die;
        Kn:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto xW;
        }
        return;
        xW:
        echo json_encode(array("\164\171\160\x65" => "\145\162\x72\157\x72", "\x6d\145\x73\x73\141\147\x65" => MoUtility::_get_invalid_otp_method()));
        die;
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        $this->unsetOTPSessionVariables();
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto Z7;
        }
        array_push($kp, $this->_phoneFormId);
        Z7:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto AP;
        }
        return;
        AP:
        $this->_otpType = $this->sanitizeFormPOST("\x64\157\x63\x64\x69\x72\145\143\x74\137\145\x6e\141\142\x6c\x65\137\x74\x79\160\145");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x64\x6f\x63\x64\x69\162\x65\x63\x74\137\145\156\x61\x62\x6c\145");
        update_mo_option("\144\x6f\x63\x64\151\162\x65\143\x74\137\145\156\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\144\x6f\143\144\151\x72\x65\143\x74\x5f\145\x6e\x61\x62\154\145\137\164\171\x70\x65", $this->_otpType);
    }
}
