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
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class WooCommerceProductVendors extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_PRODUCT_VENDOR;
        $this->_isAjaxForm = TRUE;
        $this->_typePhoneTag = "\x6d\157\137\167\x63\137\160\x76\x5f\160\x68\157\x6e\x65\x5f\145\x6e\x61\x62\154\145";
        $this->_typeEmailTag = "\x6d\157\137\x77\143\x5f\160\166\x5f\145\x6d\x61\151\x6c\x5f\145\x6e\141\142\154\145";
        $this->_phoneFormId = "\x23\x72\145\147\x5f\142\x69\154\154\151\x6e\x67\137\160\x68\x6f\x6e\145";
        $this->_formKey = "\x57\x43\137\x50\126\137\x52\105\107\137\x46\x4f\122\x4d";
        $this->_formName = mo_("\127\157\x6f\x63\157\155\x6d\x65\162\x63\x65\40\120\162\x6f\144\165\x63\164\x20\x56\145\156\144\x6f\x72\40\x52\x65\x67\x69\x73\164\x72\141\x74\151\157\156\x20\x46\157\162\x6d");
        $this->_isFormEnabled = get_mo_option("\x77\x63\137\160\166\x5f\144\145\146\x61\165\x6c\x74\x5f\145\x6e\x61\142\x6c\145");
        $this->_buttonText = get_mo_option("\x77\x63\x5f\x70\166\137\x62\x75\164\x74\157\x6e\137\164\x65\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\x69\x63\153\40\x48\x65\x72\x65\x20\x74\157\x20\x73\145\156\x64\40\x4f\x54\x50");
        $this->_formDocuments = MoOTPDocs::WC_PRODUCT_VENDOR;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\167\x63\137\x70\x76\x5f\x65\156\141\x62\154\145\137\x74\x79\x70\x65");
        $this->_restrictDuplicates = get_mo_option("\x77\143\137\x70\x76\x5f\162\145\x73\164\x72\151\x63\164\x5f\144\x75\x70\154\x69\143\x61\164\145\x73");
        add_action("\167\x63\x70\x76\x5f\162\x65\147\x69\163\164\x72\141\164\151\x6f\156\x5f\x66\x6f\162\x6d", array($this, "\155\157\137\x61\144\144\137\160\150\157\x6e\145\137\x66\151\x65\x6c\144"), 1);
        add_action("\x77\x70\x5f\x61\152\141\170\137\156\x6f\160\162\x69\x76\x5f\x6d\x69\156\x69\x6f\162\x61\x6e\x67\x65\x5f\x77\143\x5f\x76\x70\x5f\162\145\147\137\166\145\x72\x69\x66\x79", array($this, "\163\145\x6e\144\x41\x6a\x61\x78\x4f\124\120\122\145\x71\165\145\163\x74"));
        add_filter("\x77\143\x70\166\137\163\150\157\162\164\143\157\144\145\137\162\145\147\x69\x73\x74\x72\141\164\x69\x6f\156\x5f\x66\157\162\155\x5f\x76\141\x6c\x69\x64\x61\x74\151\157\x6e\137\x65\162\162\157\x72\x73", array($this, "\x72\x65\147\x5f\146\151\145\x6c\x64\163\x5f\145\162\162\157\x72\163"), 1, 2);
        add_action("\x77\x70\137\145\156\x71\165\x65\x75\145\137\x73\143\162\x69\160\164\163", array($this, "\x6d\x69\x6e\x69\x6f\162\141\x6e\x67\x65\x5f\162\145\147\x69\163\x74\145\162\137\167\143\x5f\163\x63\162\x69\x70\164"));
    }
    public function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $wI = MoUtility::sanitizeCheck("\165\163\145\162\137\160\x68\x6f\x6e\x65", $_POST);
        $p1 = MoUtility::sanitizeCheck("\165\163\x65\162\x5f\145\x6d\x61\151\x6c", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto kT;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $p1);
        goto Ge;
        kT:
        SessionUtils::addPhoneVerified($this->_formSessionVar, MoUtility::processPhoneNumber($wI));
        Ge:
        $uV = $this->processFormFields(null, $p1, new WP_Error(), null, $wI);
        if (!$uV->get_error_code()) {
            goto eB;
        }
        wp_send_json(MoUtility::createJson($uV->get_error_message(), MoConstants::ERROR_JSON_TYPE));
        eB:
    }
    public function reg_fields_errors($errors, $OA)
    {
        if (empty($errors)) {
            goto QC;
        }
        return $errors;
        QC:
        $this->assertOTPField($errors, $OA);
        $this->checkIfOTPWasSent($errors);
        return $this->checkIntegrityAndValidateOTP($OA, $errors);
    }
    private function assertOTPField(&$errors, $OA)
    {
        if (MoUtility::sanitizeCheck("\155\157\166\x65\162\x69\146\x79", $OA)) {
            goto Vh;
        }
        $errors[] = MoMessages::showMessage(MoMessages::REQUIRED_OTP);
        Vh:
    }
    private function checkIfOTPWasSent(&$errors)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto tn;
        }
        $errors[] = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        tn:
    }
    private function checkIntegrityAndValidateOTP($FA, array $errors)
    {
        if (empty($errors)) {
            goto d4;
        }
        return $errors;
        d4:
        $FA["\x62\x69\x6c\154\x69\x6e\x67\x5f\160\150\x6f\x6e\145"] = MoUtility::processPhoneNumber($FA["\x62\151\154\154\x69\x6e\147\x5f\160\150\x6f\x6e\145"]);
        $errors = $this->checkIntegrity($FA, $errors);
        if (empty($errors->errors)) {
            goto Pt;
        }
        return $errors;
        Pt:
        $Bs = $this->getVerificationType();
        $this->validateChallenge($Bs, NULL, sanitize_text_field($FA["\155\157\x76\x65\x72\x69\x66\x79"]));
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs)) {
            goto d3;
        }
        $this->unsetOTPSessionVariables();
        goto pW;
        d3:
        $errors[] = MoUtility::_get_invalid_otp_method();
        pW:
        return $errors;
    }
    private function checkIntegrity($FA, array $errors)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Wp;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto f2;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email($FA["\x65\x6d\x61\151\x6c"]))) {
            goto xH;
        }
        $errors[] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        xH:
        f2:
        goto Ev;
        Wp:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, MoUtility::processPhoneNumber($FA["\142\151\x6c\154\x69\x6e\147\x5f\x70\x68\x6f\x6e\x65"]))) {
            goto W2;
        }
        $errors[] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        W2:
        Ev:
        return $errors;
    }
    function processFormFields($zC, $mo, $errors, $iK, $Dk)
    {
        global $phoneLogic;
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto W3;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto SY;
        }
        $Dk = isset($Dk) ? $Dk : '';
        $this->sendChallenge($zC, $mo, $errors, $Dk, VerificationType::EMAIL, $iK);
        SY:
        goto KS;
        W3:
        if (!isset($Dk) || !MoUtility::validatePhoneNumber($Dk)) {
            goto CM;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($Dk, "\x62\x69\x6c\x6c\151\156\x67\137\160\150\x6f\x6e\145")) {
            goto kj;
        }
        goto qy;
        CM:
        return new WP_Error("\142\x69\x6c\x6c\x69\x6e\x67\x5f\160\x68\157\x6e\145\137\x65\x72\x72\x6f\162", str_replace("\43\x23\x70\x68\x6f\156\145\x23\43", $Dk, $phoneLogic->_get_otp_invalid_format_message()));
        goto qy;
        kj:
        return new WP_Error("\142\x69\x6c\x6c\x69\156\147\137\160\150\x6f\x6e\x65\x5f\145\x72\x72\157\x72", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        qy:
        $this->sendChallenge($zC, $mo, $errors, $Dk, VerificationType::PHONE, $iK);
        KS:
        return $errors;
    }
    function isPhoneNumberAlreadyInUse($Dk, $j1)
    {
        global $wpdb;
        $Dk = MoUtility::processPhoneNumber($Dk);
        $le = $wpdb->get_row("\x53\105\x4c\x45\103\x54\40\140\x75\x73\x65\162\137\x69\144\x60\x20\x46\x52\x4f\115\x20\x60{$wpdb->prefix}\165\163\145\162\x6d\145\164\x61\x60\x20\127\x48\x45\x52\x45\40\140\x6d\145\164\141\137\x6b\x65\x79\x60\x20\x3d\40\x27{$j1}\x27\40\x41\116\104\40\140\155\145\x74\x61\137\x76\x61\x6c\x75\x65\140\x20\75\40\40\x27{$Dk}\x27");
        return !MoUtility::isBlank($le);
    }
    function miniorange_register_wc_script()
    {
        wp_register_script("\x6d\157\x77\143\160\166\162\145\x67", MOV_URL . "\x69\156\143\x6c\165\144\145\x73\57\x6a\163\57\167\143\160\x76\162\x65\x67\56\155\x69\156\56\x6a\163", array("\x6a\x71\x75\145\x72\171"));
        wp_localize_script("\155\x6f\x77\x63\160\x76\162\x65\x67", "\155\157\167\x63\x70\166\162\145\147", array("\x73\151\x74\145\125\x52\x4c" => wp_ajax_url(), "\x6f\164\x70\x54\171\x70\145" => $this->_otpType, "\156\x6f\x6e\143\145" => wp_create_nonce($this->_nonce), "\x62\x75\164\x74\157\156\x74\145\x78\x74" => mo_($this->_buttonText), "\146\x69\145\154\144" => $this->_otpType === $this->_typePhoneTag ? "\162\145\x67\137\x76\160\137\x62\151\x6c\x6c\x69\x6e\x67\137\160\x68\x6f\156\145" : "\167\143\160\166\55\x63\157\156\146\x69\162\155\55\x65\x6d\x61\x69\154", "\151\155\x67\125\x52\114" => MOV_LOADER_URL, "\143\x6f\x64\145\114\141\x62\x65\154" => mo_("\105\x6e\x74\145\x72\40\x56\x65\x72\x69\146\151\x63\141\164\151\157\x6e\40\103\157\144\x65")));
        wp_enqueue_script("\155\x6f\x77\143\x70\166\x72\x65\x67");
    }
    public function mo_add_phone_field()
    {
        echo "\74\160\x20\x63\154\141\163\x73\x3d\42\x66\x6f\162\x6d\55\x72\x6f\x77\x20\x66\x6f\x72\155\x2d\x72\157\167\x2d\x77\x69\x64\145\42\x3e\xd\12\x9\x9\11\x9\11\x3c\x6c\141\142\145\x6c\x20\146\x6f\x72\x3d\42\162\145\147\x5f\166\160\137\x62\151\x6c\154\151\156\x67\x5f\160\x68\x6f\x6e\145\x22\x3e\xd\12\11\11\11\x9\x9\x20\x20\40\40" . mo_("\x50\150\x6f\x6e\x65") . "\xd\12\x9\11\11\11\11\x20\40\x20\x20\x3c\x73\160\141\x6e\x20\x63\x6c\x61\x73\x73\x3d\42\x72\145\x71\165\151\x72\145\x64\x22\76\x2a\74\57\163\160\141\x6e\76\15\12\x20\40\x20\x20\40\x20\40\x20\40\40\40\40\x20\40\40\40\40\x20\x20\40\74\x2f\154\x61\142\x65\x6c\x3e\xd\xa\x9\11\11\x9\11\x3c\151\x6e\160\x75\164\x20\164\171\160\145\75\x22\x74\x65\x78\164\x22\40\x63\x6c\141\163\x73\x3d\42\x69\x6e\x70\x75\x74\x2d\164\x65\170\x74\x22\40\15\12\11\11\11\x9\x9\40\x20\40\40\40\x20\x20\x20\156\x61\x6d\145\x3d\42\142\151\x6c\x6c\x69\x6e\x67\137\x70\150\x6f\156\x65\42\40\x69\x64\75\42\x72\145\x67\137\166\x70\x5f\x62\151\x6c\154\151\156\147\x5f\160\x68\x6f\x6e\x65\x22\40\xd\12\x9\x9\x9\x9\x9\40\40\x20\x20\x20\40\x20\x20\166\141\154\165\x65\75\42" . (!empty($_POST["\142\151\154\154\x69\156\147\x5f\160\x68\157\156\x65"]) ? $_POST["\142\x69\x6c\154\151\x6e\147\137\x70\150\x6f\x6e\x65"] : '') . "\x22\40\x2f\76\xd\12\x9\x9\11\x20\x20\11\x20\40\74\x2f\x70\x3e";
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
        if (!$this->isFormEnabled()) {
            goto A1;
        }
        array_push($kp, $this->_phoneFormId);
        A1:
        return $kp;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto wR;
        }
        return;
        wR:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\x63\137\160\166\137\x64\145\x66\141\x75\154\x74\x5f\145\x6e\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\167\x63\x5f\x70\x76\137\x65\x6e\x61\142\x6c\145\137\x74\x79\x70\x65");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\167\143\137\x70\166\x5f\x72\x65\x73\164\162\x69\x63\x74\x5f\144\165\x70\x6c\x69\x63\x61\164\145\x73");
        $this->_buttonText = $this->sanitizeFormPOST("\167\143\137\160\166\x5f\x62\x75\x74\164\157\156\x5f\164\x65\x78\x74");
        update_mo_option("\167\143\x5f\160\166\x5f\144\x65\146\x61\x75\154\164\137\145\x6e\141\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x77\x63\137\160\166\x5f\145\156\141\142\154\145\x5f\164\171\x70\x65", $this->_otpType);
        update_mo_option("\167\x63\137\160\x76\x5f\x72\145\163\164\162\151\x63\164\x5f\x64\x75\160\x6c\151\x63\141\164\145\163", $this->_restrictDuplicates);
        update_mo_option("\167\x63\x5f\x70\166\137\142\165\164\164\x6f\156\137\x74\145\170\164", $this->_buttonText);
    }
}
