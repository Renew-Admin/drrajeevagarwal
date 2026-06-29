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
use WP_Error;
class EverestContactForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::EVEREST_CONTACT;
        $this->_typePhoneTag = "\x6d\157\x5f\145\x76\x65\x72\x65\x73\164\x5f\143\x6f\156\164\141\143\x74\x5f\160\x68\x6f\156\145\x5f\x65\156\x61\142\x6c\145";
        $this->_typeEmailTag = "\x6d\x6f\137\145\166\145\x72\x65\163\164\137\x63\157\x6e\x74\141\x63\164\137\x65\x6d\x61\x69\154\137\145\x6e\141\142\154\x65";
        $this->_formKey = "\105\x56\105\x52\105\123\124\137\103\117\116\x54\x41\x43\x54";
        $this->_formName = mo_("\x45\x76\x65\x72\x65\163\x74\x20\103\157\156\164\x61\143\x74\x20\x46\157\162\155");
        $this->_isFormEnabled = get_mo_option("\145\166\145\x72\x65\x73\x74\137\143\157\x6e\164\141\143\x74\137\145\x6e\141\142\154\x65");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::EVEREST_CONTACT_FORM_LINK;
        $this->_generateOTPAction = "\x6d\151\156\151\157\162\x61\x6e\147\x65\x5f\145\x76\145\x72\145\163\164\x5f\x63\x6f\156\x74\x61\x63\x74\137\x67\145\156\145\x72\141\164\145\137\x6f\x74\x70";
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\151\x63\153\x20\x48\x65\162\x65\40\x74\x6f\x20\x73\x65\x6e\144\x20\x4f\x54\120");
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x65\166\145\x72\x65\x73\x74\137\143\157\x6e\x74\141\x63\x74\137\x65\x6e\141\x62\x6c\x65\x5f\164\171\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x65\166\145\x72\x65\163\x74\x5f\143\x6f\x6e\x74\x61\x63\164\x5f\x66\x6f\162\155\x73"));
        $this->_buttonText = get_mo_option("\x65\x76\145\x72\x65\163\x74\x5f\143\157\x6e\164\141\x63\164\137\x62\165\164\164\157\156\137\164\x65\170\x74");
        if (!empty($this->_formDetails)) {
            goto rE;
        }
        return;
        rE:
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\x23\x65\x76\x66\x2d" . $j1 . "\x2d\x66\x69\x65\x6c\x64\137" . $qL["\160\150\x6f\x6e\x65\x6b\x65\171"]);
            fX:
        }
        J2:
        add_filter("\x65\166\145\162\145\x73\x74\x5f\x66\157\162\155\163\137\x70\x72\x6f\143\145\x73\163\137\151\156\151\x74\151\x61\x6c\137\x65\162\x72\157\162\x73", [$this, "\x76\141\x6c\151\144\x61\x74\145\106\157\162\155"], 99, 2);
        add_filter("\145\x76\145\162\x65\163\x74\x5f\x66\x6f\162\x6d\163\x5f\160\162\x6f\x63\x65\x73\x73\137\x61\x66\164\x65\x72\137\146\151\154\x74\x65\162", [$this, "\x75\x6e\163\x65\x74\x53\x65\163\163\151\157\156\x56\x61\162\x69\141\142\154\145"], 99, 3);
        add_action("\x77\160\x5f\141\152\141\170\x5f{$this->_generateOTPAction}", [$this, "\137\x73\145\x6e\144\137\157\x74\x70"]);
        add_action("\167\160\x5f\x61\x6a\x61\170\137\x6e\157\x70\162\x69\x76\137{$this->_generateOTPAction}", [$this, "\x5f\x73\x65\156\144\137\x6f\x74\x70"]);
        add_action("\167\160\137\145\x6e\161\x75\145\165\145\137\163\x63\162\151\x70\x74\x73", array($this, "\x6d\151\x6e\151\157\x72\x61\156\147\x65\x5f\162\x65\147\151\x73\164\145\x72\x5f\145\166\x65\x72\x65\163\x74\137\x63\x6f\156\164\x61\143\164\137\163\x63\162\x69\x70\164"));
    }
    function unsetSessionVariable($sg, $wn, $fw)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto Vf;
        }
        $this->unsetOTPSessionVariables();
        Vf:
        return $sg;
    }
    function miniorange_register_everest_contact_script()
    {
        wp_register_script("\x6d\157\145\x76\x65\162\145\163\164\x63\157\156\164\141\x63\x74", MOV_URL . "\151\x6e\x63\x6c\x75\144\x65\x73\x2f\x6a\x73\x2f\155\x6f\145\x76\x65\162\x65\x73\164\x63\x6f\x6e\164\x61\143\x74\56\x6d\x69\156\x2e\152\163", array("\152\x71\165\x65\x72\x79"));
        wp_localize_script("\155\157\145\x76\145\162\145\x73\x74\143\x6f\156\x74\x61\143\x74", "\x6d\157\145\166\x65\162\145\163\164\143\x6f\156\x74\141\x63\164", array("\x73\x69\x74\145\x55\x52\114" => wp_ajax_url(), "\157\164\160\124\171\160\x65" => $this->_otpType, "\x66\157\x72\155\x6b\x65\x79" => strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? "\x70\150\157\x6e\145\153\x65\171" : "\x65\155\141\151\154\x6b\x65\171", "\156\x6f\x6e\143\x65" => wp_create_nonce($this->_nonce), "\x62\165\164\x74\157\156\164\145\x78\x74" => mo_($this->_buttonText), "\151\x6d\147\125\122\114" => MOV_LOADER_URL, "\x66\157\162\x6d\x73" => $this->_formDetails, "\x67\x65\x6e\x65\162\x61\x74\145\125\122\114" => $this->_generateOTPAction));
        wp_enqueue_script("\x6d\x6f\x65\166\145\x72\145\x73\x74\x63\x6f\x6e\164\x61\x63\164");
    }
    function _send_otp()
    {
        $FA = $_POST;
        $this->validateAjaxRequest();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType == $this->_typePhoneTag) {
            goto uS;
        }
        $this->_processEmailAndStartOTPVerificationProcess($FA);
        goto VC;
        uS:
        $this->_processPhoneAndStartOTPVerificationProcess($FA);
        VC:
    }
    private function _processEmailAndStartOTPVerificationProcess($FA)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\145\162\x5f\145\155\x61\x69\154", $FA)) {
            goto Ia;
        }
        $this->setSessionAndStartOTPVerification(sanitize_email($FA["\x75\163\x65\x72\x5f\x65\x6d\x61\x69\x6c"]), sanitize_email($FA["\x75\163\x65\162\137\145\155\x61\151\154"]), NULL, VerificationType::EMAIL);
        goto XM;
        Ia:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        XM:
    }
    private function _processPhoneAndStartOTPVerificationProcess($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\x65\162\x5f\160\150\x6f\x6e\145", $FA)) {
            goto Pk;
        }
        $this->setSessionAndStartOTPVerification(trim(sanitize_text_field($FA["\165\x73\x65\x72\x5f\x70\150\157\156\145"])), NULL, trim(sanitize_text_field($FA["\165\x73\145\x72\x5f\160\x68\x6f\156\x65"])), VerificationType::PHONE);
        goto lo;
        Pk:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        lo:
    }
    private function setSessionAndStartOTPVerification($WH, $BO, $dI, $ml)
    {
        SessionUtils::addEmailOrPhoneVerified($this->_formSessionVar, $WH, $ml);
        $this->sendChallenge('', $BO, NULL, $dI, $ml);
    }
    public function validateForm($errors, $fw)
    {
        $j0 = $fw["\x69\x64"];
        if (empty($errors[$j0]["\x68\145\x61\x64\x65\x72"])) {
            goto EP;
        }
        return $errors;
        EP:
        if (array_key_exists($j0, $this->_formDetails)) {
            goto iK;
        }
        return $errors;
        iK:
        $zA = $this->_formDetails[$j0];
        $FA = $_POST;
        $errors = $this->checkIfOtpVerificationStarted($errors, $FA);
        if (empty($errors[$j0]["\150\145\x61\144\145\x72"])) {
            goto wx;
        }
        return $errors;
        wx:
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0 && strcasecmp($fw["\146\157\x72\155\137\x66\x69\x65\154\x64\163"][$zA["\145\x6d\x61\x69\x6c\x6b\x65\x79"]]["\x69\x64"], $zA["\x65\155\x61\x69\x6c\153\x65\171"]) == 0) {
            goto mI;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && strcasecmp($fw["\x66\x6f\x72\155\137\146\x69\145\154\x64\x73"][$zA["\x70\150\157\156\145\x6b\x65\171"]]["\151\144"], $zA["\160\150\x6f\x6e\145\153\145\171"]) == 0) {
            goto og;
        }
        goto HD;
        mI:
        $errors = $this->processEmail($FA, $errors, $zA);
        goto HD;
        og:
        $errors = $this->processPhone($FA, $errors, $zA);
        HD:
        if (!is_wp_error($errors)) {
            goto DG;
        }
        return $errors;
        DG:
        if (!(empty($errors) && strcasecmp($fw["\146\x6f\x72\155\137\x66\151\145\154\144\163"][$zA["\x76\145\x72\151\146\x79\x4b\145\171"]]["\x69\144"], $zA["\166\x65\162\151\146\x79\x4b\x65\171"]) == 0)) {
            goto kD;
        }
        $errors = $this->processOTPEntered($FA, $errors, $zA);
        kD:
        return $errors;
    }
    function processOTPEntered($FA, $errors, $zA)
    {
        $j0 = $FA["\145\166\145\162\x65\x73\164\137\146\x6f\162\x6d\163"]["\151\x64"];
        $Bs = $this->getVerificationType();
        $this->validateChallenge($Bs, NULL, $FA["\145\166\145\162\x65\x73\x74\x5f\x66\157\162\x6d\163"]["\146\x6f\x72\x6d\x5f\146\151\x65\x6c\144\x73"][$zA["\166\x65\x72\151\146\x79\113\x65\171"]]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs)) {
            goto fQ;
        }
        $errors[$j0]["\150\145\141\x64\x65\162"] = MoUtility::_get_invalid_otp_method();
        fQ:
        return $errors;
    }
    function checkIfOtpVerificationStarted($errors, $FA)
    {
        $j0 = $FA["\145\166\x65\162\145\163\x74\137\x66\157\162\155\163"]["\151\144"];
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto EO;
        }
        $errors[$j0]["\150\145\141\144\145\x72"] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        EO:
        return $errors;
    }
    function processEmail($FA, $errors, $zA)
    {
        $j0 = sanitize_text_field($FA["\145\166\145\x72\145\163\164\137\146\157\x72\155\163"]["\x69\144"]);
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $FA["\145\x76\145\x72\x65\x73\x74\137\x66\x6f\x72\155\163"]["\x66\157\162\x6d\x5f\146\x69\x65\x6c\x64\x73"][$zA["\x65\x6d\141\x69\154\x6b\x65\171"]])) {
            goto da;
        }
        $errors[$fk]["\x68\x65\x61\144\x65\x72"] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        da:
        return $errors;
    }
    function processPhone($FA, $errors, $zA)
    {
        $j0 = sanitize_text_field($FA["\145\x76\x65\x72\145\x73\164\137\146\x6f\162\x6d\163"]["\151\x64"]);
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $FA["\145\166\145\x72\x65\x73\164\x5f\146\157\162\x6d\163"]["\x66\x6f\x72\x6d\137\146\151\145\x6c\x64\163"][$zA["\160\x68\157\x6e\x65\x6b\x65\x79"]])) {
            goto iT;
        }
        $errors[$j0]["\x68\x65\141\x64\145\162"] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        iT:
        return $errors;
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
        SessionUtils::unsetSession([$this->_formSessionVar, $this->_txSessionId]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto IK;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        IK:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto ea;
        }
        return;
        ea:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x65\x76\x65\x72\145\x73\164\x5f\143\x6f\x6e\x74\x61\143\x74\137\x65\x6e\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\145\x76\x65\x72\145\163\164\x5f\x63\157\x6e\x74\x61\x63\x74\x5f\x65\156\141\142\x6c\145\x5f\164\x79\x70\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\x65\166\x65\162\x65\163\164\137\x63\x6f\x6e\x74\141\143\164\137\x62\x75\x74\164\x6f\156\x5f\x74\145\x78\x74");
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\145\x76\145\x72\x65\163\x74\x5f\x63\x6f\156\164\x61\x63\x74\x5f\145\x6e\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x65\166\x65\x72\x65\163\164\137\x63\157\x6e\x74\x61\x63\x74\137\145\156\x61\142\x6c\145\137\x74\171\160\145", $this->_otpType);
        update_mo_option("\x65\166\x65\x72\x65\x73\164\137\143\157\x6e\164\x61\143\x74\x5f\x62\x75\x74\164\x6f\156\137\x74\145\x78\x74", $this->_buttonText);
        update_mo_option("\145\166\145\162\145\x73\164\x5f\x63\157\156\164\x61\143\164\137\x66\x6f\x72\155\163", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = [];
        if (!(!array_key_exists("\x65\x76\145\x72\145\x73\164\x5f\143\157\x6e\x74\141\x63\x74\137\146\x6f\x72\x6d", $_POST) || !$this->_isFormEnabled)) {
            goto zv;
        }
        return $form;
        zv:
        foreach (array_filter($_POST["\145\166\145\x72\145\x73\164\137\143\x6f\156\164\141\x63\x74\x5f\x66\157\162\155"]["\x66\x6f\162\x6d"]) as $j1 => $qL) {
            $form[$qL] = array("\145\x6d\x61\151\x6c\x6b\x65\x79" => sanitize_text_field($_POST["\145\x76\145\162\145\x73\164\137\143\157\156\164\x61\x63\x74\x5f\x66\x6f\162\x6d"]["\145\x6d\141\x69\154\153\x65\171"][$j1]), "\160\150\157\x6e\x65\153\145\x79" => sanitize_text_field($_POST["\x65\x76\x65\x72\145\x73\164\137\x63\157\x6e\x74\x61\x63\x74\137\x66\157\162\155"]["\x70\x68\157\x6e\x65\153\145\171"][$j1]), "\x76\x65\x72\x69\146\171\113\145\171" => sanitize_text_field($_POST["\x65\166\145\x72\x65\163\x74\137\x63\x6f\156\x74\x61\x63\164\137\146\x6f\x72\x6d"]["\166\x65\x72\151\x66\x79\113\145\171"][$j1]), "\x70\150\157\x6e\x65\137\163\150\x6f\167" => sanitize_text_field($_POST["\145\166\145\x72\145\163\164\x5f\x63\157\156\164\141\143\164\x5f\x66\157\x72\x6d"]["\x70\150\x6f\x6e\145\153\x65\171"][$j1]), "\145\155\x61\151\154\137\x73\150\x6f\x77" => sanitize_text_field($_POST["\145\x76\145\x72\x65\163\164\x5f\143\x6f\x6e\x74\141\x63\164\137\x66\157\x72\155"]["\145\x6d\141\151\154\153\x65\x79"][$j1]), "\166\145\x72\x69\146\171\x5f\163\x68\x6f\x77" => sanitize_text_field($_POST["\x65\166\145\162\x65\163\164\137\x63\x6f\156\x74\141\143\x74\x5f\x66\157\162\155"]["\x76\x65\162\151\x66\171\x4b\x65\171"][$j1]));
            u8:
        }
        xr:
        return $form;
    }
}
