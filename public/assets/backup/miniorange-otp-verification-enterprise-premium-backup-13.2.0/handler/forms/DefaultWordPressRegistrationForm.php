<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class DefaultWordPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WP_DEFAULT_REG;
        $this->_phoneKey = "\164\145\x6c\x65\160\150\157\x6e\145";
        $this->_phoneFormId = "\x23\x70\150\157\x6e\x65\x5f\x6e\x75\x6d\142\x65\162\137\x6d\x6f";
        $this->_formKey = "\127\120\x5f\x44\105\106\101\125\114\x54";
        $this->_typePhoneTag = "\155\x6f\137\x77\160\x5f\144\x65\146\141\165\x6c\x74\137\160\x68\157\156\145\x5f\145\x6e\141\142\154\145";
        $this->_typeEmailTag = "\155\x6f\x5f\167\160\137\144\145\x66\141\165\154\x74\137\145\155\x61\x69\x6c\x5f\x65\156\141\142\154\145";
        $this->_typeBothTag = "\155\x6f\137\167\160\x5f\x64\145\146\141\x75\154\164\x5f\142\x6f\164\x68\137\145\x6e\x61\x62\154\x65";
        $this->_formName = mo_("\127\x6f\162\x64\x50\162\x65\163\163\x20\104\x65\x66\x61\x75\154\x74\x20\x2f\40\x54\115\114\40\122\145\x67\151\163\164\162\x61\164\x69\157\156\40\106\157\162\x6d");
        $this->_isFormEnabled = get_mo_option("\167\160\x5f\x64\x65\146\141\165\154\x74\137\145\156\141\x62\x6c\x65");
        $this->_formDocuments = MoOTPDocs::WP_DEFAULT_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\x70\137\x64\145\x66\x61\x75\x6c\164\137\x65\x6e\141\142\154\x65\137\164\x79\160\x65");
        $this->_disableAutoActivate = get_mo_option("\x77\x70\x5f\162\x65\147\x5f\141\165\x74\x6f\137\141\143\x74\x69\166\x61\164\145") ? FALSE : TRUE;
        $this->_restrictDuplicates = get_mo_option("\x77\x70\137\x72\145\147\x5f\x72\145\x73\164\x72\x69\143\164\137\144\x75\160\154\x69\143\141\x74\x65\163");
        add_action("\162\145\x67\151\x73\164\145\x72\x5f\146\x6f\x72\x6d", array($this, "\155\151\x6e\x69\x6f\x72\x61\x6e\147\145\137\x73\x69\x74\x65\137\162\x65\147\151\x73\x74\x65\162\x5f\x66\157\x72\155"));
        add_filter("\162\x65\147\151\x73\164\162\141\x74\151\x6f\x6e\x5f\145\x72\x72\157\162\x73", array($this, "\155\151\x6e\x69\x6f\x72\x61\156\147\145\x5f\163\151\164\x65\x5f\x72\145\x67\151\163\164\x72\141\164\151\157\156\137\145\162\162\x6f\162\163"), 99, 3);
        add_action("\141\144\155\x69\156\x5f\x70\x6f\163\164\137\156\x6f\160\x72\x69\166\137\166\141\154\x69\144\141\x74\151\x6f\156\x5f\x67\157\102\x61\143\x6b", array($this, "\x5f\150\141\x6e\144\154\145\137\x76\x61\154\151\144\x61\x74\x69\x6f\x6e\137\147\x6f\x42\x61\143\x6b\x5f\x61\143\x74\151\x6f\156"));
        add_action("\x75\163\x65\x72\137\x72\x65\x67\151\163\164\x65\162", array($this, "\155\151\x6e\151\157\x72\141\x6e\147\145\x5f\x72\145\x67\151\163\164\x72\x61\x74\151\x6f\x6e\137\163\141\166\x65"), 10, 1);
        add_filter("\x77\160\x5f\154\x6f\x67\x69\x6e\x5f\x65\162\162\157\162\163", array($this, "\x6d\151\x6e\151\x6f\x72\141\156\x67\x65\137\143\165\x73\x74\x6f\155\137\x72\x65\147\137\155\145\163\163\141\147\145"), 10, 2);
        if ($this->_disableAutoActivate) {
            goto q2;
        }
        remove_action("\162\x65\x67\151\163\164\x65\162\137\x6e\145\x77\137\165\163\x65\x72", "\x77\x70\137\x73\145\x6e\144\x5f\x6e\x65\x77\x5f\165\163\x65\x72\137\156\157\x74\x69\x66\x69\x63\141\x74\x69\157\156\163");
        q2:
    }
    function isPhoneVerificationEnabled()
    {
        $tA = $this->getVerificationType();
        return $tA === VerificationType::PHONE || $tA === VerificationType::BOTH;
    }
    function miniorange_custom_reg_message(WP_Error $errors, $My)
    {
        if ($this->_disableAutoActivate) {
            goto bR;
        }
        if (!in_array("\x72\x65\x67\151\163\164\x65\162\145\x64", $errors->get_error_codes())) {
            goto jt;
        }
        $errors->remove("\x72\x65\x67\x69\x73\x74\145\x72\145\x64");
        $errors->add("\162\145\147\151\x73\x74\x65\x72\145\x64", mo_("\122\145\x67\x69\163\x74\x72\141\164\x69\157\x6e\40\x43\x6f\x6d\160\x6c\x65\164\x65\x2e"), "\x6d\x65\x73\x73\141\147\145");
        jt:
        bR:
        return $errors;
    }
    function miniorange_site_register_form()
    {
        echo "\x3c\151\156\x70\x75\x74\40\x74\171\160\x65\75\42\150\151\x64\x64\x65\x6e\42\40\x6e\x61\x6d\145\75\42\x72\145\x67\151\163\x74\145\x72\x5f\x6e\157\x6e\143\x65\42\40\166\x61\154\x75\145\x3d\42\162\x65\147\x69\x73\164\145\x72\137\x6e\x6f\x6e\143\x65\42\x2f\x3e";
        if (!$this->isPhoneVerificationEnabled()) {
            goto qN;
        }
        echo "\74\154\141\142\145\x6c\40\146\157\x72\75\42\x70\x68\157\x6e\145\137\x6e\165\155\142\145\x72\137\x6d\x6f\42\76" . mo_("\x50\x68\157\x6e\145\x20\x4e\165\x6d\142\x65\162") . "\x3c\142\x72\40\x2f\76\xd\12\40\40\40\40\x20\40\x20\40\40\40\x20\x20\x20\40\40\x20\x3c\x69\156\160\165\164\x20\x74\x79\x70\145\x3d\x22\x74\x65\x78\164\42\x20\156\141\155\x65\75\x22\160\x68\157\x6e\x65\x5f\156\165\155\142\x65\x72\137\x6d\157\x22\x20\x69\144\x3d\42\x70\x68\x6f\x6e\x65\137\x6e\x75\x6d\x62\145\162\137\155\157\42\x20\x63\154\141\x73\x73\75\42\151\x6e\x70\x75\164\42\40\166\x61\x6c\x75\145\x3d\x22\x22\40\163\164\171\154\x65\x3d\42\x22\x2f\x3e\74\x2f\154\x61\x62\145\x6c\x3e";
        qN:
        if ($this->_disableAutoActivate) {
            goto vU;
        }
        echo "\74\x6c\x61\142\145\x6c\40\146\x6f\x72\x3d\42\x70\141\x73\x73\x77\157\x72\x64\x5f\155\x6f\42\x3e" . mo_("\x50\x61\163\x73\167\x6f\x72\x64") . "\74\142\x72\x20\57\76\xd\12\40\40\40\40\40\40\x20\40\x20\40\x20\40\x20\40\40\x20\x3c\x69\x6e\x70\165\x74\40\164\171\160\145\x3d\42\x70\x61\163\x73\x77\x6f\x72\144\x22\40\156\x61\155\145\75\42\x70\x61\x73\163\167\x6f\x72\144\x5f\x6d\x6f\x22\40\x69\x64\75\42\160\x61\x73\x73\167\157\x72\144\137\155\x6f\x22\40\143\x6c\141\163\x73\75\x22\151\x6e\x70\x75\164\42\40\x76\141\154\165\145\x3d\42\x22\40\163\164\171\x6c\145\x3d\42\x22\57\76\74\57\154\141\x62\145\x6c\76";
        echo "\74\x6c\141\x62\145\154\40\x66\157\x72\x3d\x22\x63\x6f\x6e\x66\151\162\155\x5f\160\x61\x73\163\x77\157\x72\144\137\x6d\x6f\x22\76" . mo_("\x43\157\x6e\x66\x69\x72\155\40\120\x61\x73\x73\x77\157\x72\144") . "\x3c\142\x72\40\x2f\76\xd\12\x20\x20\40\x20\x20\40\x20\x20\40\x20\x20\40\40\x20\x20\x20\74\151\156\160\165\164\x20\164\171\160\x65\75\x22\x70\141\163\x73\x77\157\162\144\x22\x20\x6e\141\155\145\75\42\x63\157\156\146\x69\162\155\x5f\x70\x61\x73\163\167\x6f\162\144\x5f\x6d\x6f\x22\x20\151\x64\x3d\x22\143\x6f\x6e\146\151\x72\155\137\x70\x61\x73\x73\x77\157\x72\144\x5f\x6d\x6f\42\x20\x63\x6c\141\163\163\x3d\x22\151\x6e\x70\x75\x74\42\40\x76\x61\x6c\165\x65\75\42\42\40\163\164\171\154\145\75\x22\42\57\x3e\x3c\x2f\x6c\x61\142\x65\x6c\x3e";
        echo "\74\x73\x63\162\151\160\164\x3e\167\x69\x6e\x64\157\167\x2e\157\156\x6c\x6f\x61\x64\x3d\146\x75\156\x63\164\151\x6f\x6e\50\51\173\40\144\157\143\165\x6d\145\156\164\x2e\147\145\x74\x45\x6c\145\x6d\x65\x6e\x74\x42\x79\x49\x64\50\x22\162\x65\x67\137\x70\x61\163\x73\x6d\141\151\x6c\x22\x29\x2e\x72\x65\155\157\166\145\x28\51\73\x20\x7d\74\x2f\163\x63\x72\151\160\x74\x3e";
        vU:
    }
    function miniorange_registration_save($nL)
    {
        $dI = MoPHPSessions::getSessionVar("\x70\150\157\156\145\137\156\165\x6d\142\x65\162\137\155\157");
        if (!$dI) {
            goto Hi;
        }
        add_user_meta($nL, $this->_phoneKey, $dI);
        Hi:
        if ($this->_disableAutoActivate) {
            goto dl;
        }
        wp_set_password(sanitize_text_field($_POST["\x70\141\163\x73\167\157\162\144\137\155\157"]), $nL);
        update_user_option($nL, "\144\145\146\141\165\154\x74\x5f\160\x61\163\163\167\157\162\144\x5f\x6e\x61\x67", false, true);
        dl:
    }
    function miniorange_site_registration_errors(WP_Error $errors, $rs, $p1)
    {
        $NN = isset($_POST["\x70\150\x6f\156\145\x5f\x6e\165\155\x62\x65\x72\x5f\155\157"]) ? sanitize_text_field($_POST["\x70\150\157\156\x65\137\x6e\x75\x6d\142\x65\x72\x5f\155\x6f"]) : null;
        $iK = isset($_POST["\x70\141\x73\x73\x77\157\162\x64\137\x6d\157"]) ? sanitize_text_field($_POST["\160\x61\x73\163\x77\157\162\x64\137\x6d\157"]) : null;
        $oc = isset($_POST["\x63\157\x6e\x66\x69\162\155\x5f\x70\141\x73\163\167\157\162\144\137\x6d\157"]) ? sanitize_text_field($_POST["\143\x6f\156\146\151\x72\155\137\x70\141\x73\163\x77\x6f\x72\144\137\x6d\x6f"]) : null;
        $this->checkIfPhoneNumberUnique($errors, $NN);
        $this->validatePasswords($errors, $iK, $oc);
        if (empty($errors->errors)) {
            goto OD;
        }
        return $errors;
        OD:
        if ($this->_otpType) {
            goto qT;
        }
        return $errors;
        qT:
        return $this->startOTPTransaction($rs, $p1, $errors, $NN);
    }
    private function validatePasswords(WP_Error &$uV, $iK, $oc)
    {
        if (!$this->_disableAutoActivate) {
            goto CF;
        }
        return;
        CF:
        if (!(strcasecmp($iK, $oc) !== 0)) {
            goto M7;
        }
        $uV->add("\x70\141\163\x73\167\x6f\x72\x64\x5f\155\151\163\x6d\141\x74\x63\x68", MoMessages::showMessage(MoMessages::PASS_MISMATCH));
        M7:
    }
    private function checkIfPhoneNumberUnique(WP_Error &$errors, $NN)
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto Mq;
        }
        return;
        Mq:
        if (MoUtility::isBlank($NN) || !MoUtility::validatePhoneNumber($NN)) {
            goto py;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse(trim($NN), $this->_phoneKey)) {
            goto NR;
        }
        goto QK;
        py:
        $errors->add("\x69\x6e\x76\141\x6c\151\144\137\160\x68\x6f\156\145", MoMessages::showMessage(MoMessages::ENTER_PHONE_DEFAULT));
        goto QK;
        NR:
        $errors->add("\x69\x6e\166\x61\x6c\151\144\x5f\x70\x68\x6f\156\x65", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        QK:
    }
    function startOTPTransaction($rs, $p1, $errors, $NN)
    {
        if (!(!MoUtility::isBlank(array_filter($errors->errors)) || !isset($_POST["\x72\145\147\151\x73\x74\145\x72\137\x6e\x6f\156\x63\x65"]))) {
            goto Nv;
        }
        return $errors;
        Nv:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto pb;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto ZS;
        }
        $this->sendChallenge($rs, $p1, $errors, $NN, VerificationType::EMAIL);
        goto UY;
        ZS:
        $this->sendChallenge($rs, $p1, $errors, $NN, VerificationType::BOTH);
        UY:
        goto p9;
        pb:
        $this->sendChallenge($rs, $p1, $errors, $NN, VerificationType::PHONE);
        p9:
        return $errors;
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        $Bs = $this->getVerificationType();
        $MZ = $Bs === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        $this->unsetOTPSessionVariables();
    }
    function isPhoneNumberAlreadyInUse($Dk, $j1)
    {
        global $wpdb;
        $Dk = MoUtility::processPhoneNumber($Dk);
        $le = $wpdb->get_row("\x53\105\x4c\105\x43\124\40\140\x75\x73\x65\x72\137\151\144\140\40\x46\122\117\115\x20\140{$wpdb->prefix}\165\x73\145\162\x6d\x65\164\x61\x60\x20\x57\110\x45\x52\x45\40\x60\x6d\145\x74\x61\137\153\145\171\x60\x20\75\x20\47{$j1}\x27\x20\x41\116\x44\40\140\155\x65\x74\x61\x5f\x76\141\154\x75\145\140\x20\75\40\x20\47{$Dk}\x27");
        return !MoUtility::isBlank($le);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto ET;
        }
        array_push($kp, $this->_phoneFormId);
        ET:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto bd;
        }
        return;
        bd:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\x70\137\144\145\146\x61\165\154\164\x5f\145\x6e\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x70\137\144\x65\x66\141\165\x6c\164\x5f\x65\156\x61\142\154\x65\137\164\171\x70\x65");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\167\x70\x5f\x72\x65\147\x5f\162\145\163\164\162\x69\143\164\x5f\144\x75\160\x6c\151\143\x61\164\x65\x73");
        $this->_disableAutoActivate = $this->sanitizeFormPOST("\167\160\x5f\162\x65\147\137\141\165\164\157\x5f\141\x63\164\x69\166\141\x74\x65") ? FALSE : TRUE;
        update_mo_option("\167\x70\x5f\144\x65\x66\141\x75\x6c\x74\x5f\145\156\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\160\137\144\145\x66\141\x75\154\164\137\x65\156\141\142\x6c\x65\137\x74\x79\160\145", $this->_otpType);
        update_mo_option("\x77\x70\x5f\x72\x65\x67\137\x72\145\x73\164\162\151\143\x74\137\x64\165\160\154\151\143\141\x74\x65\x73", $this->_restrictDuplicates);
        update_mo_option("\167\160\x5f\162\x65\x67\x5f\x61\165\x74\157\x5f\141\x63\164\151\x76\x61\164\x65", $this->_disableAutoActivate ? FALSE : TRUE);
    }
}
