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
class RealesWPTheme extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::REALESWP_REGISTER;
        $this->_typePhoneTag = "\x6d\x6f\x5f\x72\145\141\x6c\x65\x73\137\160\x68\x6f\x6e\145\137\x65\156\141\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\157\137\162\x65\x61\154\x65\163\x5f\x65\155\141\x69\x6c\x5f\x65\x6e\141\142\x6c\x65";
        $this->_phoneFormId = "\43\x70\x68\157\156\x65\123\151\147\156\165\x70";
        $this->_formKey = "\122\105\101\114\x45\123\137\x52\105\x47\x49\x53\x54\x45\x52";
        $this->_formName = mo_("\x52\145\141\x6c\145\163\40\x57\120\40\124\x68\145\x6d\145\40\x52\145\147\x69\x73\x74\x72\141\x74\x69\x6f\156\x20\106\157\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\162\x65\141\154\x65\x73\x5f\145\156\x61\142\154\x65");
        $this->_formDocuments = MoOTPDocs::REALES_THEME;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x72\x65\141\154\145\163\137\x65\156\x61\x62\x6c\x65\x5f\164\x79\160\x65");
        add_action("\167\x70\x5f\x65\x6e\x71\165\x65\x75\145\137\163\143\162\x69\160\164\x73", array($this, "\x65\x6e\x71\165\x65\x75\145\137\163\x63\162\x69\160\164\x5f\157\156\x5f\160\141\147\x65"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\164\x69\x6f\156", $_GET)) {
            goto Hn;
        }
        return;
        Hn:
        switch (trim($_GET["\x6f\x70\164\x69\157\x6e"])) {
            case "\155\x69\x6e\151\157\162\141\156\147\145\55\162\x65\141\154\x65\x73\x77\x70\55\x76\145\162\151\x66\x79":
                $this->_send_otp_realeswp_verify($_POST);
                goto vV;
            case "\x6d\x69\156\151\x6f\162\141\156\147\145\x2d\x76\141\154\x69\x64\141\x74\145\55\x72\x65\141\154\145\x73\167\160\x2d\x6f\x74\160":
                $this->_reales_validate_otp($_POST);
                goto vV;
        }
        Ou:
        vV:
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\x72\x65\141\154\x65\163\167\x70\123\143\162\x69\x70\164", MOV_URL . "\x69\156\x63\154\165\x64\x65\163\57\x6a\x73\57\x72\145\x61\154\145\x73\x77\160\56\155\151\x6e\x2e\152\163\x3f\x76\145\162\163\151\157\156\75" . MOV_VERSION, array("\x6a\x71\x75\x65\x72\171"));
        wp_localize_script("\162\145\141\154\x65\163\167\x70\x53\x63\162\x69\160\x74", "\155\157\x76\x61\x72\x73", array("\x69\x6d\x67\125\122\114" => MOV_URL . "\x69\x6e\143\154\x75\x64\x65\163\x2f\151\x6d\x61\x67\x65\x73\x2f\x6c\157\141\x64\145\162\56\147\x69\x66", "\x66\151\x65\x6c\x64\156\141\155\145" => $this->_otpType == $this->_typePhoneTag ? "\160\150\157\156\145\x20\x6e\x75\x6d\142\x65\x72" : "\145\x6d\x61\151\x6c", "\146\x69\145\154\x64" => $this->_otpType == $this->_typePhoneTag ? "\x70\x68\x6f\x6e\145\123\x69\147\156\165\x70" : "\145\155\x61\151\x6c\123\x69\147\x6e\165\x70", "\x73\x69\164\145\125\x52\x4c" => site_url(), "\151\156\163\145\162\164\x41\146\x74\145\162" => $this->_otpType == $this->_typePhoneTag ? "\43\160\150\157\156\x65\x53\x69\147\156\x75\160" : "\x23\145\155\141\x69\x6c\x53\x69\x67\156\165\160", "\x70\154\141\x63\x65\110\x6f\x6c\x64\145\x72" => mo_("\x4f\124\120\x20\x43\157\x64\145"), "\142\165\164\164\x6f\156\124\x65\170\164" => mo_("\126\141\154\x69\144\141\164\x65\40\x61\x6e\144\x20\x53\151\x67\156\x20\x55\x70"), "\141\x6a\x61\170\165\x72\154" => wp_ajax_url()));
        wp_enqueue_script("\162\x65\141\154\x65\163\167\x70\x53\143\x72\151\x70\x74");
    }
    function _send_otp_realeswp_verify($FA)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto zA;
        }
        $this->_send_otp_to_email($FA);
        goto pV;
        zA:
        $this->_send_otp_to_phone($FA);
        pV:
    }
    function _send_otp_to_phone($FA)
    {
        if (array_key_exists("\x75\163\x65\x72\x5f\x70\150\157\x6e\145", $FA) && !MoUtility::isBlank(sanitize_text_field($FA["\165\163\145\x72\x5f\x70\x68\157\x6e\145"]))) {
            goto ye;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto pn;
        ye:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($FA["\165\163\x65\162\x5f\x70\150\x6f\x6e\x65"]));
        $this->sendChallenge("\164\x65\163\x74", '', null, trim($FA["\x75\x73\x65\x72\x5f\x70\x68\157\x6e\145"]), VerificationType::PHONE);
        pn:
    }
    function _send_otp_to_email($FA)
    {
        if (array_key_exists("\165\163\x65\162\x5f\x65\x6d\141\151\154", $FA) && !MoUtility::isBlank(sanitize_email($FA["\165\163\145\x72\137\x65\155\141\151\154"]))) {
            goto VL;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto qi;
        VL:
        SessionUtils::addEmailVerified($this->_formSessionVar, $FA["\165\163\x65\162\137\x65\x6d\x61\151\154"]);
        $this->sendChallenge("\164\145\x73\x74", $FA["\x75\163\145\x72\137\x65\155\141\151\154"], null, $FA["\165\x73\x65\162\137\145\155\x61\x69\x6c"], VerificationType::EMAIL);
        qi:
    }
    function _reales_validate_otp($FA)
    {
        $Yy = !isset($FA["\x6f\164\x70"]) ? sanitize_text_field($FA["\x6f\164\x70"]) : '';
        $this->checkIfOTPVerificationHasStarted();
        $this->validateSubmittedFields($FA);
        $this->validateChallenge(NULL, $Yy);
    }
    function validateSubmittedFields($FA)
    {
        $Bs = $this->getVerificationType();
        if ($Bs === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email($FA["\x75\163\x65\162\137\x65\155\141\151\154"]))) {
            goto kw;
        }
        if ($Bs === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($FA["\165\x73\145\x72\137\x70\x68\x6f\156\145"]))) {
            goto FP;
        }
        goto xS;
        kw:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        die;
        goto xS;
        FP:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        die;
        xS:
    }
    function checkIfOTPVerificationHasStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto MX;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        die;
        MX:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
        die;
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(MoMessages::REG_SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
        die;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto aD;
        }
        array_push($kp, $this->_phoneFormId);
        aD:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto LX;
        }
        return;
        LX:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x72\x65\141\x6c\x65\163\x5f\145\x6e\141\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\162\145\x61\154\145\x73\137\145\x6e\141\142\x6c\x65\137\x74\171\160\145");
        update_mo_option("\162\x65\x61\154\x65\163\x5f\145\156\x61\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x72\x65\x61\x6c\x65\163\x5f\145\x6e\141\x62\154\x65\x5f\164\x79\x70\145", $this->_otpType);
    }
}
