<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class MemberPressSingleCheckoutForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::MEMBERPRESS_SINGLE_REG;
        $this->_typePhoneTag = "\155\157\137\x6d\162\x70\137\163\151\x6e\147\154\x65\x5f\160\150\157\156\145\x5f\145\x6e\x61\142\x6c\145";
        $this->_typeEmailTag = "\155\157\137\x6d\x72\160\x5f\x73\151\156\147\x6c\x65\x5f\x65\x6d\x61\151\154\137\x65\156\141\142\x6c\145";
        $this->_typeBothTag = "\155\x6f\137\155\162\160\137\x73\151\156\x67\x6c\x65\137\x62\157\164\150\137\145\156\141\x62\154\x65";
        $this->_formName = mo_("\x4d\x65\x6d\x62\145\162\120\x72\145\163\x73\x20\123\151\x6e\x67\154\145\x20\x43\x68\145\143\x6b\x6f\x75\164\40\122\x65\x67\x69\x73\164\x72\141\164\151\157\156\40\x46\157\x72\155");
        $this->_formKey = "\115\105\x4d\x42\x45\x52\x50\122\x45\123\x53\x53\x49\116\107\114\105\x43\110\x45\x43\x4b\x4f\125\124";
        $this->_isFormEnabled = get_mo_option("\x6d\162\160\x5f\x73\x69\x6e\147\154\145\137\x64\145\x66\141\165\154\x74\137\x65\156\141\x62\154\x65");
        $this->_formDocuments = MoOTPDocs::MRP_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $user = wp_get_current_user();
        if($user->exists()){
          return;  
        }
        $this->_byPassLogin = get_mo_option("\x6d\162\160\137\163\x69\x6e\147\154\145\x5f\x61\156\x6f\x6e\137\157\156\x6c\171");
        $this->_phoneKey = get_mo_option("\x6d\162\x70\137\163\151\156\147\x6c\x65\x5f\160\150\157\x6e\x65\137\153\145\171");
        $this->_otpType = get_mo_option("\x6d\x72\x70\x5f\163\x69\156\x67\154\145\137\145\156\x61\x62\154\145\137\x74\x79\x70\145");
        $this->_phoneFormId = "\151\x6e\x70\165\164\133\156\141\155\x65\x3d" . $this->_phoneKey . "\x5d";
        add_action("\167\x70\x5f\x61\x6a\141\170\137\155\157\x6d\x72\160\137\x73\x69\156\x67\154\x65\137\163\x65\156\x64\x5f\x6f\x74\x70", [$this, "\137\x73\145\156\144\137\157\x74\x70"]);
        add_action("\x77\x70\137\141\x6a\141\170\x5f\x6e\x6f\x70\x72\x69\166\137\x6d\157\155\162\160\x5f\x73\151\156\x67\154\x65\137\x73\x65\x6e\x64\x5f\x6f\x74\x70", [$this, "\x5f\x73\x65\156\144\137\157\x74\x70"]);
        add_filter("\x6d\145\x70\162\55\x76\141\154\151\x64\141\164\x65\55\163\x69\x67\156\x75\160", array($this, "\155\151\156\151\157\162\141\156\x67\145\x5f\163\x69\x74\145\137\162\145\147\151\x73\x74\x65\x72\x5f\146\157\x72\x6d"), 99, 1);
        add_action("\x77\x70\137\145\156\161\x75\x65\x75\145\x5f\163\x63\x72\151\160\x74\x73", array($this, "\x6d\151\x6e\151\157\x72\x61\x6e\x67\145\137\163\151\x6e\147\x6c\145\x5f\x63\150\145\143\153\x6f\165\x74\137\162\x65\147\151\x73\x74\145\162\x5f\x73\x63\162\151\x70\x74"));
        add_action("\165\163\145\162\137\x72\x65\x67\151\163\x74\145\162", array($this, "\x75\156\163\x65\164\155\x65\x70\x72\x73\x69\156\147\154\x65\143\x68\145\143\153\157\165\x74\x53\145\163\163\151\157\156\126\141\x72\x69\x61\x62\x6c\x65\x73"), 99, 2);
    }
    function _send_otp()
    {
        $FA = $_POST;
        $this->validateAjaxRequest();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType == $this->_typePhoneTag) {
            goto Jy;
        }
        $this->_processEmailAndStartOTPVerificationProcess($FA);
        goto ua;
        Jy:
        $this->_processPhoneAndStartOTPVerificationProcess($FA);
        ua:
    }
    private function _processPhoneAndStartOTPVerificationProcess($FA)
    {
        if (!MoUtility::sanitizeCheck("\x75\x73\145\162\x5f\x70\x68\157\x6e\x65", $FA)) {
            goto aR;
        }
        $this->setSessionAndStartOTPVerification(trim($FA["\165\x73\145\x72\x5f\x70\x68\157\156\145"]), NULL, trim($FA["\x75\x73\145\162\x5f\x70\150\157\x6e\145"]), VerificationType::PHONE);
        goto xt;
        aR:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        xt:
    }
    private function _processEmailAndStartOTPVerificationProcess($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\145\162\137\145\x6d\141\151\154", $FA)) {
            goto NN;
        }
        $this->setSessionAndStartOTPVerification($FA["\165\x73\x65\162\x5f\x65\x6d\x61\151\154"], $FA["\x75\163\145\x72\137\x65\x6d\x61\x69\x6c"], NULL, VerificationType::EMAIL);
        goto kn;
        NN:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        kn:
    }
    private function setSessionAndStartOTPVerification($WH, $BO, $dI, $ml)
    {
        SessionUtils::addEmailOrPhoneVerified($this->_formSessionVar, $WH, $ml);
        $this->sendChallenge('', $BO, NULL, $dI, $ml);
    }
    function miniorange_single_checkout_register_script()
    {
        wp_register_script("\x6d\157\155\x72\x70\163\x69\x6e\147\154\145", MOV_URL . "\151\x6e\143\x6c\x75\144\x65\x73\x2f\152\x73\57\155\157\155\x72\160\163\151\156\x67\x6c\x65\56\155\151\156\56\152\163", array("\152\x71\x75\x65\162\171"));
        wp_localize_script("\155\157\155\x72\x70\163\x69\156\x67\x6c\x65", "\155\x6f\155\x72\160\x73\151\156\x67\x6c\x65", array("\x73\151\164\145\x55\x52\114" => wp_ajax_url(), "\157\164\x70\x54\171\x70\145" => $this->_otpType, "\x66\x6f\162\155\x6b\x65\171" => strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? $this->_phoneKey : "\x75\x73\x65\162\x5f\145\x6d\x61\x69\x6c", "\156\x6f\x6e\143\145" => wp_create_nonce($this->_nonce), "\142\165\x74\164\157\156\164\x65\170\x74" => mo_("\103\154\x69\x63\x6b\x20\x48\145\x72\145\x20\164\157\40\163\145\x6e\144\40\x4f\x54\120"), "\151\155\x67\x55\x52\114" => MOV_LOADER_URL));
        wp_enqueue_script("\155\x6f\x6d\x72\160\163\151\x6e\147\154\145");
    }
    function miniorange_site_register_form($errors)
    {
        if (!$errors) {
            goto Kk;
        }
        return $errors;
        Kk:
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto kE;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto qQ;
        }
        $errors["\165\163\145\162\137\145\x6d\x61\x69\154"] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        goto mW;
        qQ:
        $errors[$this->_phoneKey] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        mW:
        kE:
        if (!$errors) {
            goto xU;
        }
        return $errors;
        xU:
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto pq;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email($_POST["\x75\x73\145\x72\137\145\x6d\x61\151\154"]))) {
            goto i6;
        }
        $errors["\x75\x73\145\162\x5f\x65\x6d\141\x69\x6c"] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        i6:
        goto uy;
        pq:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($_POST[$this->_phoneKey]))) {
            goto Ir;
        }
        $errors[$this->_phoneKey] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        Ir:
        uy:
        if (!$errors) {
            goto sc;
        }
        return $errors;
        sc:
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto PT;
        }
        $bD = "\145\x6d\x61\x69\x6c";
        goto Ly;
        PT:
        $bD = "\160\x68\x6f\x6e\x65";
        Ly:
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, sanitize_text_field($_POST["\155\x6f\137\x76\145\164\151\x66\171\137\x6f\x74\160\137\146\x69\145\x6c\144"]))) {
            goto Rk;
        }
        $this->validateChallenge($bD, NULL, sanitize_text_field($_POST["\x6d\x6f\137\166\x65\164\151\x66\x79\x5f\157\164\x70\x5f\146\x69\x65\154\144"]));
        Rk:
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $bD)) {
            goto fa;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto t1;
        }
        $errors["\x75\163\x65\x72\x5f\145\155\x61\x69\x6c"] = MoMessages::showMessage(MoMessages::INVALID_OTP);
        goto tL;
        t1:
        $errors[$this->_phoneKey] = MoMessages::showMessage(MoMessages::INVALID_OTP);
        tL:
        fa:
        return $errors;
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!(self::isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto S7;
        }
        array_push($kp, $this->_phoneFormId);
        S7:
        return $kp;
    }
    function isPhoneVerificationEnabled()
    {
        $tA = $this->getVerificationType();
        return $tA === VerificationType::PHONE || $tA === VerificationType::BOTH;
    }
    function unsetmeprsinglecheckoutSessionVariables($nL, $Y_)
    {
        $this->unsetOTPSessionVariables();
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto UT;
        }
        return;
        UT:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x6d\162\x70\137\163\x69\x6e\147\154\x65\137\144\145\146\x61\x75\x6c\164\137\x65\156\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x6d\x72\x70\x5f\163\151\156\147\x6c\145\137\145\156\141\x62\154\x65\x5f\164\171\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\155\162\160\x5f\x73\x69\x6e\x67\154\145\137\160\x68\x6f\156\145\137\146\x69\x65\154\x64\137\x6b\x65\x79");
        $this->_byPassLogin = $this->sanitizeFormPOST("\x6d\x70\162\137\x73\151\156\x67\154\x65\x5f\x61\156\x6f\156\x5f\157\x6e\154\x79");
        if (!$this->basicValidationCheck(BaseMessages::MEMBERPRESS_CHOOSE)) {
            goto oM;
        }
        update_mo_option("\x6d\x72\x70\137\x73\151\156\147\x6c\x65\137\144\145\x66\141\x75\154\164\x5f\x65\156\x61\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\155\162\x70\x5f\163\x69\156\147\154\x65\137\145\x6e\x61\142\x6c\x65\x5f\164\171\160\x65", $this->_otpType);
        update_mo_option("\155\x72\x70\137\x73\151\x6e\147\154\145\x5f\160\x68\x6f\156\145\137\153\x65\171", $this->_phoneKey);
        update_mo_option("\155\162\x70\x5f\163\x69\x6e\147\154\x65\137\x61\x6e\x6f\156\137\157\156\x6c\171", $this->_byPassLogin);
        oM:
    }
}
