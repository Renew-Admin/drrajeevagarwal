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
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class WcProfileForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_verifyFieldKey;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WC_PROFILE_UPDATE;
        $this->_typePhoneTag = "\x6d\x6f\x5f\167\x63\137\x70\x72\x6f\146\x69\154\x65\x5f\160\150\x6f\x6e\x65\137\145\x6e\141\x62\x6c\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\x77\x63\x5f\160\162\x6f\x66\x69\154\x65\x5f\x65\155\141\x69\154\137\x65\x6e\141\x62\154\x65";
        $this->_formKey = "\x57\103\x5f\x41\103\x5f\x46\x4f\122\x4d";
        $this->_verifyFieldKey = "\x76\x65\162\x69\146\x79\x5f\x66\151\x65\x6c\144";
        $this->_formName = mo_("\x57\x6f\x6f\x43\x6f\x6d\155\x65\x72\x63\x65\40\x41\143\x63\x6f\165\156\164\40\x44\x65\164\141\151\x6c\163\x20\106\157\x72\155");
        $this->_isFormEnabled = get_mo_option("\x77\143\x5f\160\x72\x6f\x66\x69\x6c\145\137\145\x6e\x61\142\x6c\x65");
        $this->_restrictDuplicates = get_mo_option("\x77\143\x5f\x70\x72\157\x66\x69\154\145\137\x72\x65\x73\164\x72\151\143\x74\137\144\x75\160\x6c\151\143\x61\164\x65\163");
        $this->_buttonText = get_mo_option("\x77\x63\137\160\x72\x6f\x66\x69\x6c\x65\x5f\x62\165\164\x74\157\x6e\137\164\145\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\154\151\143\x6b\40\110\145\162\145\40\164\157\x20\163\x65\x6e\x64\x20\x4f\x54\120");
        $this->_phoneKey = get_mo_option("\x77\143\x5f\x70\162\157\x66\151\x6c\145\137\160\150\157\x6e\x65\137\x6b\145\x79");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\x62\x69\x6c\154\x69\156\147\137\160\x68\x6f\x6e\145";
        $this->_phoneFormId = "\43\x62\151\154\154\151\156\x67\137\160\150\x6f\156\145";
        $this->_generateOTPAction = "\x6d\151\x6e\x69\x6f\x72\x61\156\147\145\137\167\x63\137\x61\x63\137\157\164\160";
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\167\x63\x5f\160\x72\x6f\x66\151\154\145\x5f\x65\x6e\x61\142\x6c\145\137\164\171\160\145");
        add_action("\167\157\157\x63\157\155\x6d\145\x72\143\145\137\x65\144\151\164\137\x61\143\143\157\165\x6e\164\137\x66\157\x72\x6d", array($this, "\155\157\x5f\141\x64\x64\x5f\160\x68\157\x6e\145\x5f\x66\x69\x65\x6c\144\x5f\x61\143\143\157\x75\x6e\164\x5f\146\157\x72\x6d"));
        add_action("\167\x70\x5f\141\152\x61\x78\137{$this->_generateOTPAction}", [$this, "\163\x74\141\162\x74\x4f\x74\160\x56\145\162\151\146\151\143\141\x74\x69\157\x6e\120\162\x6f\143\145\163\x73"]);
        add_action("\167\160\x5f\141\x6a\141\x78\137\x6e\157\x70\162\x69\166\137{$this->_generateOTPAction}", [$this, "\163\164\x61\162\164\117\x74\x70\126\145\x72\x69\146\x69\x63\x61\164\x69\x6f\156\x50\x72\x6f\x63\145\x73\163"]);
        add_action("\167\157\x6f\143\x6f\155\155\145\162\x63\145\137\x73\x61\166\x65\x5f\141\x63\x63\x6f\165\156\x74\x5f\144\145\164\x61\151\x6c\163\x5f\x65\162\162\157\x72\x73", [$this, "\166\x65\162\151\x66\171\x4f\x74\160\105\x6e\164\145\x72\x65\x64"], 10, 1);
        add_action("\x77\x70\137\145\156\161\165\145\165\x65\137\163\x63\162\151\x70\x74\163", array($this, "\155\x69\156\x69\x6f\x72\141\156\x67\145\137\167\x63\137\x61\143\137\163\143\162\151\160\164"));
    }
    function verifyOtpEntered($errors)
    {
        $vu = strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? "\142\151\x6c\x6c\151\x6e\147\137\x70\x68\157\x6e\145" : "\x61\x63\x63\157\x75\x6e\164\137\145\x6d\x61\x69\x6c";
        if ($this->getUserData($this->_phoneKey) !== sanitize_text_field($_POST[$vu])) {
            goto Xj;
        }
        return;
        goto mR;
        Xj:
        $this->checkIfOTPSent($errors);
        if (empty($errors->errors)) {
            goto w0;
        }
        return $errors;
        w0:
        $this->checkIntegrityAndValidateOTP($errors);
        mR:
    }
    function checkIfOTPSent($errors)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto fe;
        }
        $errors->add("\x62\x69\154\154\x69\156\x67\137\165\x73\x65\162\137\x6e\x65\x65\144\x5f\164\157\137\166\145\162\151\x66\171\x5f\x65\x72\x72\157\162", MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        return $errors;
        fe:
    }
    function checkIntegrityAndValidateOTP($errors)
    {
        $this->checkIntegrity($errors);
        $this->validateChallenge($this->getVerificationType(), NULL, sanitize_text_field($_POST["\145\156\164\x65\x72\137\157\x74\x70"]));
        if (empty($errors->errors)) {
            goto QV;
        }
        return $errors;
        QV:
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto DW;
        }
        $errors->add("\x62\151\154\154\x69\156\x67\x5f\151\x6e\x76\141\154\x69\x64\x5f\157\164\160\x5f\145\x72\x72\x6f\x72", MoMessages::showMessage(MoMessages::INVALID_OTP));
        return $errors;
        goto wW;
        DW:
        if (!($this->getVerificationType() === VerificationType::PHONE)) {
            goto ai;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, sanitize_text_field($_POST["\142\x69\154\x6c\x69\x6e\x67\x5f\160\150\157\x6e\145"]));
        $nL = get_current_user_id();
        update_user_meta($nL, "\x62\x69\154\154\x69\156\147\x5f\x70\150\157\x6e\145", sanitize_text_field($_POST["\142\x69\x6c\x6c\x69\156\x67\137\160\150\x6f\156\145"]));
        $this->unsetOTPSessionVariables();
        ai:
        if (!($this->getVerificationType() === VerificationType::EMAIL)) {
            goto pa;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, sanitize_email($_POST["\141\x63\x63\157\165\156\x74\x5f\145\155\x61\151\154"]));
        $nL = get_current_user_id();
        $yj = array("\x49\x44" => $nL, "\x75\163\145\162\137\145\155\141\x69\x6c" => sanitize_email($_POST["\141\143\x63\157\x75\156\164\137\x65\155\x61\151\x6c"]));
        wp_update_user($yj);
        $this->unsetOTPSessionVariables();
        pa:
        wW:
    }
    function checkIntegrity($errors)
    {
        if (!($this->getVerificationType() === VerificationType::PHONE)) {
            goto tJ;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($_POST["\142\151\154\154\151\x6e\x67\x5f\160\150\157\x6e\145"]))) {
            goto sg;
        }
        $errors->add("\x62\151\154\x6c\x69\156\147\137\x70\150\157\156\145\137\x6d\x69\x73\155\x61\164\x63\150\137\145\162\x72\x6f\162", MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        return $errors;
        sg:
        tJ:
        if (!($this->getVerificationType() === VerificationType::EMAIL)) {
            goto oi;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email($_POST["\x61\143\x63\x6f\x75\x6e\164\137\x65\155\141\151\x6c"]))) {
            goto CG;
        }
        $errors->add("\142\151\154\154\151\156\147\137\145\x6d\141\x69\x6c\x5f\155\151\x73\x6d\x61\164\x63\150\137\145\x72\162\157\162", MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        return $errors;
        CG:
        oi:
    }
    function miniorange_wc_ac_script()
    {
        wp_register_script("\x6d\x6f\x77\x63\x61\x63", MOV_URL . "\x69\x6e\143\154\165\x64\145\x73\57\x6a\163\57\155\x6f\x77\143\x61\143\56\x6d\x69\x6e\56\152\163", array("\152\x71\165\145\162\x79"));
        wp_localize_script("\x6d\157\167\143\x61\x63", "\x6d\157\x77\143\141\143", array("\x73\x69\164\x65\125\x52\114" => wp_ajax_url(), "\x6f\164\x70\x54\171\x70\x65" => $this->_otpType == $this->_typePhoneTag ? "\160\150\x6f\156\x65" : "\x65\x6d\141\151\154", "\x6e\x6f\x6e\x63\x65" => wp_create_nonce($this->_nonce), "\142\x75\x74\164\x6f\x6e\164\x65\170\x74" => mo_($this->_buttonText), "\151\155\147\x55\x52\114" => MOV_LOADER_URL, "\x67\145\x6e\x65\x72\x61\x74\145\125\122\114" => $this->_generateOTPAction, "\x66\151\x65\x6c\144\x56\141\154\165\145" => $this->getUserData($this->_phoneKey), "\160\x68\157\156\145\113\x65\x79" => $this->_phoneKey));
        wp_enqueue_script("\155\157\x77\143\141\x63");
    }
    private function getUserData($j1)
    {
        $current_user = wp_get_current_user();
        if ($this->_otpType == $this->_typePhoneTag) {
            goto ly;
        }
        return $current_user->user_email;
        goto ao;
        ly:
        global $wpdb;
        $bX = "\123\105\114\105\103\124\40\x6d\x65\164\x61\137\166\141\154\165\x65\40\106\122\x4f\x4d\40\x60{$wpdb->prefix}\165\x73\x65\x72\x6d\145\164\141\x60\40\x57\x48\105\122\105\x20\x60\155\x65\164\141\137\x6b\x65\x79\x60\40\75\40\47{$j1}\x27\x20\x41\116\104\x20\x60\165\163\x65\162\x5f\x69\144\x60\40\75\x20{$current_user->ID}";
        $le = $wpdb->get_row($bX);
        return isset($le) ? $le->meta_value : '';
        ao:
    }
    function startOtpVerificationProcess()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType == $this->_typePhoneTag) {
            goto C3;
        }
        $this->_processEmailAndSendOTP($_POST);
        goto Ju;
        C3:
        $this->_processPhoneAndSendOTP($_POST);
        Ju:
    }
    function _processPhoneAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\x65\162\x5f\x69\x6e\160\x75\x74", $FA)) {
            goto u2;
        }
        $this->checkDuplicates(sanitize_text_field($FA["\165\x73\x65\162\137\x69\x6e\x70\165\164"]), $this->_phoneKey);
        SessionUtils::addPhoneVerified($this->_formSessionVar, sanitize_text_field($FA["\x75\163\x65\x72\x5f\x69\156\x70\x75\x74"]));
        $this->sendChallenge('', NULL, NULL, sanitize_text_field($FA["\165\163\x65\162\137\151\156\160\165\x74"]), VerificationType::PHONE);
        goto N4;
        u2:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        N4:
    }
    function _processEmailAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\163\x65\x72\x5f\x69\x6e\160\x75\x74", $FA)) {
            goto EL;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, sanitize_email($FA["\165\163\145\162\137\x69\x6e\x70\165\x74"]));
        $this->sendChallenge('', sanitize_text_field($FA["\165\x73\145\x72\137\151\x6e\x70\165\x74"]), NULL, NULL, VerificationType::EMAIL);
        goto yO;
        EL:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        yO:
    }
    private function checkDuplicates($qL, $j1)
    {
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($qL, $j1))) {
            goto el;
        }
        $bC = MoMessages::showMessage(MoMessages::PHONE_EXISTS);
        wp_send_json(MoUtility::createJson($bC, MoConstants::ERROR_JSON_TYPE));
        el:
    }
    function isPhoneNumberAlreadyInUse($Dk, $j1)
    {
        global $wpdb;
        MoUtility::processPhoneNumber($Dk);
        $OY = "\x53\105\x4c\105\103\124\40\x60\x75\163\145\x72\x5f\151\144\x60\40\x46\122\x4f\x4d\40\x60{$wpdb->prefix}\x75\x73\145\162\155\x65\164\141\x60\x20\127\x48\x45\122\x45\x20\140\x6d\145\164\141\x5f\153\145\x79\140\x20\75\x20\47{$j1}\x27\x20\x41\x4e\104\40\x60\x6d\x65\164\141\x5f\166\141\x6c\x75\x65\140\40\75\x20\40\47{$Dk}\x27";
        $le = $wpdb->get_row($OY);
        return !MoUtility::isBlank($le);
    }
    function mo_add_phone_field_account_form()
    {
        woocommerce_form_field("\x62\x69\x6c\154\151\156\147\x5f\x70\x68\157\x6e\145", array("\164\x79\x70\145" => "\164\x65\x78\164", "\162\x65\161\165\x69\x72\145\x64" => true, "\154\141\x62\145\x6c" => "\120\150\157\156\x65\40\x4e\x75\155\x62\145\x72"), get_user_meta(get_current_user_id(), "\142\151\x6c\154\151\x6e\x67\x5f\x70\x68\157\x6e\145", true));
        woocommerce_form_field("\145\156\x74\145\x72\137\x6f\164\x70", array("\x74\171\x70\x65" => "\x74\145\170\164", "\162\145\x71\x75\151\x72\x65\x64" => false, "\x6c\141\142\x65\154" => "\105\x6e\164\145\162\40\x4f\124\x50"), get_user_meta(get_current_user_id(), "\145\156\x74\145\162\x5f\x6f\x74\x70", true));
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    public function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto B6;
        }
        array_push($kp, $this->_phoneFormId);
        B6:
        return $kp;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto ad;
        }
        return;
        ad:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x63\x5f\160\162\x6f\x66\x69\x6c\145\137\x65\x6e\x61\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\167\143\137\x70\162\x6f\146\151\154\x65\137\x65\156\141\142\x6c\x65\x5f\x74\171\x70\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\167\143\137\160\x72\157\146\151\154\x65\x5f\142\x75\164\164\x6f\156\x5f\164\145\170\164");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\167\143\x5f\x70\x72\157\x66\x69\x6c\145\137\x72\x65\x73\164\x72\x69\143\x74\137\144\x75\160\x6c\x69\x63\141\164\x65\x73");
        $this->_phoneKey = $this->sanitizeFormPOST("\167\143\x5f\160\162\157\x66\x69\x6c\x65\x5f\x70\150\157\x6e\x65\137\153\145\171");
        update_mo_option("\x77\x63\137\x70\162\x6f\146\x69\154\145\x5f\x65\156\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\x63\137\x70\162\x6f\x66\x69\154\145\x5f\145\x6e\x61\x62\x6c\145\137\x74\x79\x70\x65", $this->_otpType);
        update_mo_option("\x77\x63\x5f\x70\162\157\146\151\154\145\137\x62\x75\164\164\157\156\x5f\x74\x65\x78\x74", $this->_buttonText);
        update_mo_option("\x77\143\x5f\160\x72\157\146\151\154\145\137\162\x65\163\x74\162\x69\x63\x74\137\144\165\x70\154\151\x63\x61\164\x65\x73", $this->_restrictDuplicates);
        update_mo_option("\167\x63\137\160\162\157\146\151\x6c\x65\x5f\160\x68\x6f\x6e\145\137\x6b\x65\171", $this->_phoneKey);
    }
}
