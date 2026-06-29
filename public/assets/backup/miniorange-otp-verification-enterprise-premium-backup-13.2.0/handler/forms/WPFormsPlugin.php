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
class WPFormsPlugin extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPFORM;
        $this->_phoneFormId = array();
        $this->_formKey = "\127\120\106\117\x52\x4d\x53";
        $this->_typePhoneTag = "\x6d\157\x5f\x77\x70\x66\x6f\x72\155\x5f\160\150\x6f\x6e\145\137\145\156\x61\x62\154\145";
        $this->_typeEmailTag = "\x6d\157\137\167\160\x66\157\162\x6d\x5f\145\155\x61\x69\x6c\137\x65\x6e\x61\142\154\x65";
        $this->_typeBothTag = "\155\x6f\x5f\x77\x70\146\x6f\162\155\137\142\x6f\x74\x68\137\145\x6e\x61\x62\154\x65";
        $this->_formName = mo_("\x57\x50\106\x6f\162\x6d\x73");
        $this->_isFormEnabled = get_mo_option("\x77\x70\146\x6f\162\x6d\137\145\156\x61\142\x6c\145");
        $this->_buttonText = get_mo_option("\167\x70\x66\157\x72\155\163\x5f\142\165\x74\x74\157\x6e\x5f\x74\x65\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\123\x65\156\x64\x20\117\x54\x50");
        $this->_generateOTPAction = "\x6d\x69\156\151\x6f\x72\141\156\147\145\x2d\x77\x70\x66\x6f\162\x6d\55\x73\145\x6e\x64\x2d\x6f\164\160";
        $this->_validateOTPAction = "\x6d\151\156\151\x6f\x72\x61\x6e\x67\145\x2d\167\x70\146\157\162\155\x2d\166\x65\162\151\x66\x79\x2d\143\x6f\x64\x65";
        $this->_formDocuments = MoOTPDocs::WP_FORMS_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\160\x66\x6f\x72\x6d\x5f\145\x6e\x61\142\x6c\145\x5f\164\x79\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\167\x70\146\x6f\162\155\137\146\x6f\162\155\x73"));
        if (!empty($this->_formDetails)) {
            goto tuP;
        }
        return;
        tuP:
        if (!($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag)) {
            goto n1I;
        }
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\43\167\160\146\157\162\x6d\x73\x2d" . $j1 . "\55\146\151\x65\x6c\x64\137" . $qL["\x70\150\157\156\x65\153\145\171"]);
            qK_:
        }
        Tqf:
        n1I:
        add_filter("\167\160\x66\x6f\x72\x6d\x73\x5f\x70\162\x6f\143\145\163\163\137\x69\x6e\x69\x74\151\x61\x6c\137\145\x72\162\157\x72\x73", array($this, "\x76\141\154\x69\144\x61\164\x65\x46\157\162\x6d"), 1, 2);
        add_action("\x77\160\x5f\145\x6e\x71\165\145\165\145\x5f\163\x63\162\x69\160\x74\x73", array($this, "\x6d\157\137\145\156\x71\165\145\x75\145\137\x77\160\x66\x6f\x72\x6d\x73"));
        add_action("\x77\160\x5f\141\152\x61\170\137{$this->_generateOTPAction}", [$this, "\x5f\x73\145\156\x64\137\157\164\160"]);
        add_action("\167\x70\137\x61\x6a\141\x78\x5f\x6e\x6f\160\162\151\x76\137{$this->_generateOTPAction}", [$this, "\137\163\x65\156\x64\137\x6f\164\x70"]);
        add_action("\x77\x70\137\141\x6a\141\170\x5f{$this->_validateOTPAction}", [$this, "\160\x72\x6f\x63\145\163\x73\x46\x6f\x72\155\x41\x6e\x64\x56\x61\x6c\x69\x64\141\x74\145\117\124\x50"]);
        add_action("\167\160\137\x61\152\x61\170\x5f\x6e\157\160\x72\x69\x76\x5f{$this->_validateOTPAction}", [$this, "\160\x72\x6f\x63\x65\x73\163\106\157\x72\x6d\x41\x6e\x64\126\x61\154\x69\144\141\x74\x65\117\x54\120"]);
    }
    function mo_enqueue_wpforms()
    {
        wp_register_script("\x6d\x6f\x77\160\x66\157\162\155\x73", MOV_URL . "\151\x6e\143\154\x75\x64\x65\163\x2f\152\x73\x2f\x6d\x6f\167\x70\146\157\x72\155\163\x2e\155\151\x6e\56\x6a\x73", array("\152\x71\x75\145\x72\171"));
        wp_localize_script("\155\x6f\x77\160\146\157\x72\155\163", "\x6d\157\x77\160\x66\x6f\162\x6d\163", array("\x73\x69\164\145\x55\x52\x4c" => wp_ajax_url(), "\157\x74\160\124\x79\x70\x65" => $this->ajaxProcessingFields(), "\x66\157\162\155\x44\145\164\141\151\154\x73" => $this->_formDetails, "\142\x75\x74\164\157\156\164\145\x78\164" => $this->_buttonText, "\166\141\154\151\144\x61\x74\x65\144" => $this->getSessionDetails(), "\x69\155\x67\125\x52\x4c" => MOV_LOADER_URL, "\x66\x69\x65\x6c\144\x54\x65\170\164" => mo_("\x45\x6e\x74\145\x72\x20\x4f\124\x50\x20\x68\145\162\145"), "\x67\156\157\x6e\x63\x65" => wp_create_nonce($this->_nonce), "\156\157\156\143\145\113\x65\171" => wp_create_nonce($this->_nonceKey), "\x76\156\x6f\156\143\x65" => wp_create_nonce($this->_nonce), "\x67\141\x63\x74\x69\x6f\x6e" => $this->_generateOTPAction, "\166\x61\143\x74\151\157\x6e" => $this->_validateOTPAction));
        wp_enqueue_script("\x6d\157\x77\x70\x66\157\162\155\163");
    }
    function getSessionDetails()
    {
        return [VerificationType::EMAIL => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL), VerificationType::PHONE => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)];
    }
    function _send_otp()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ("\155\x6f\x5f\x77\x70\146\157\x72\x6d\137" . sanitize_text_field($_POST["\x6f\x74\160\124\x79\x70\x65"]) . "\x5f\145\x6e\141\142\x6c\145" === $this->_typePhoneTag) {
            goto wRK;
        }
        $this->_processEmailAndSendOTP($_POST);
        goto qlI;
        wRK:
        $this->_processPhoneAndSendOTP($_POST);
        qlI:
    }
    private function _processEmailAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\145\162\x5f\145\155\x61\151\x6c", $FA)) {
            goto yca;
        }
        $p1 = sanitize_email($FA["\165\163\145\x72\137\x65\155\x61\x69\154"]);
        SessionUtils::addEmailVerified($this->_formSessionVar, $p1);
        $this->sendChallenge('', $p1, NULL, NULL, VerificationType::EMAIL);
        goto X9E;
        yca:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        X9E:
    }
    private function _processPhoneAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\163\x65\x72\137\x70\150\x6f\x6e\x65", $FA)) {
            goto dGQ;
        }
        $ue = sanitize_text_field($FA["\x75\163\x65\162\x5f\160\x68\157\x6e\145"]);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $ue);
        $this->sendChallenge('', NULL, NULL, $ue, VerificationType::PHONE);
        goto nyb;
        dGQ:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        nyb:
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
            goto sgZ;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        sgZ:
    }
    private function checkIntegrityAndValidateOTP($FA)
    {
        $this->checkIntegrity($FA);
        $this->validateChallenge(sanitize_text_field($FA["\157\164\x70\x54\171\x70\145"]), NULL, sanitize_text_field($FA["\x6f\164\x70\137\x74\x6f\153\145\156"]));
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, sanitize_text_field($FA["\157\x74\x70\124\x79\x70\x65"]))) {
            goto gow;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto sBo;
        gow:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        sBo:
    }
    private function checkIntegrity($FA)
    {
        if ($FA["\157\x74\160\124\171\x70\145"] === "\x70\150\157\x6e\145") {
            goto GIB;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email($FA["\x75\x73\145\162\137\x65\x6d\141\x69\x6c"]))) {
            goto V35;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        V35:
        goto PfZ;
        GIB:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($FA["\165\x73\x65\162\x5f\x70\150\x6f\x6e\145"]))) {
            goto guX;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        guX:
        PfZ:
    }
    public function validateForm($errors, $zA)
    {
        $j0 = $zA["\x69\x64"];
        if (array_key_exists($j0, $this->_formDetails)) {
            goto KAz;
        }
        return $errors;
        KAz:
        $zA = $this->_formDetails[$j0];
        if (empty($errors)) {
            goto o77;
        }
        return $errors;
        o77:
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto o5_;
        }
        $Fe = $this->_otpType === $this->_typeEmailTag ? $zA["\145\155\x61\151\154\153\x65\171"] : $zA["\x70\x68\157\156\x65\153\145\171"];
        $errors[$j0][$Fe] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        return $errors;
        o5_:
        if (!($this->_otpType === $this->_typeEmailTag || $this->_otpType === $this->_typeBothTag)) {
            goto hEJ;
        }
        $errors = $this->processEmail($zA, $errors, $j0);
        hEJ:
        if (!($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag)) {
            goto XW3;
        }
        $errors = $this->processPhone($zA, $errors, $j0);
        XW3:
        if (!empty($errors)) {
            goto VHC;
        }
        $this->unsetOTPSessionVariables();
        VHC:
        return $errors;
    }
    function processEmail($zA, $errors, $j0)
    {
        $Fe = $zA["\x65\x6d\141\151\154\x6b\145\x79"];
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL)) {
            goto EHK;
        }
        $errors[$j0][$Fe] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        EHK:
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_text_field($_POST["\167\160\146\x6f\162\155\163"]["\146\x69\145\154\x64\x73"][$Fe]))) {
            goto YaE;
        }
        $errors[$j0][$Fe] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        YaE:
        return $errors;
    }
    function processPhone($zA, $errors, $j0)
    {
        $Fe = $zA["\160\150\x6f\156\145\x6b\x65\x79"];
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)) {
            goto kjE;
        }
        $errors[$j0][$Fe] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        kjE:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($_POST["\x77\x70\x66\x6f\x72\x6d\x73"]["\146\x69\145\x6c\x64\163"][$Fe]))) {
            goto Ojh;
        }
        $errors[$j0][$Fe] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        Ojh:
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
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->_isFormEnabled && ($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag))) {
            goto xOQ;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        xOQ:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Tgt;
        }
        return;
        Tgt:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\160\146\157\162\155\137\x65\156\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x77\160\146\x6f\162\155\137\145\156\x61\x62\154\x65\137\x74\x79\160\145");
        $this->_buttonText = $this->sanitizeFormPOST("\167\160\146\157\162\155\x73\137\142\165\164\x74\157\x6e\137\x74\145\x78\x74");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\x77\160\146\157\162\155\x5f\145\156\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x77\160\x66\157\162\155\137\145\x6e\141\142\x6c\145\x5f\x74\171\x70\x65", $this->_otpType);
        update_mo_option("\x77\160\x66\157\162\x6d\163\137\142\165\x74\x74\x6f\x6e\137\164\x65\170\164", $this->_buttonText);
        update_mo_option("\x77\160\146\x6f\162\155\137\146\x6f\x72\155\163", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = [];
        if (array_key_exists("\x77\x70\x66\x6f\x72\155\137\146\157\x72\x6d", $_POST)) {
            goto E39;
        }
        return $form;
        E39:
        foreach (array_filter($_POST["\x77\x70\x66\x6f\x72\155\x5f\146\157\162\155"]["\146\x6f\162\155"]) as $j1 => $qL) {
            $zA = $this->getFormDataFromID($qL);
            if (!MoUtility::isBlank($zA)) {
                goto Dcx;
            }
            goto GEU;
            Dcx:
            $LO = $this->getFieldIDs($_POST, $j1, $zA);
            $form[sanitize_text_field($qL)] = array("\x65\x6d\141\x69\x6c\x6b\145\171" => $LO["\145\155\141\x69\154\113\145\171"], "\160\150\x6f\x6e\x65\153\145\171" => $LO["\x70\150\x6f\x6e\145\x4b\x65\x79"], "\160\x68\157\x6e\x65\x5f\163\150\157\167" => sanitize_text_field($_POST["\x77\x70\x66\157\x72\x6d\137\x66\x6f\162\x6d"]["\x70\150\157\156\145\x6b\x65\171"][$j1]), "\x65\155\141\151\x6c\x5f\x73\x68\x6f\167" => sanitize_text_field($_POST["\167\160\146\x6f\162\155\137\146\157\162\x6d"]["\145\155\x61\x69\x6c\153\145\171"][$j1]));
            GEU:
        }
        LTs:
        return $form;
    }
    private function getFormDataFromID($j0)
    {
        if (!Moutility::isBlank($j0)) {
            goto bCb;
        }
        return '';
        bCb:
        $form = get_post(absint($j0));
        if (!MoUtility::isBlank($j0)) {
            goto ZqX;
        }
        return '';
        ZqX:
        return wp_unslash(json_decode($form->post_content));
    }
    private function getFieldIDs($FA, $j1, $zA)
    {
        $LO = array("\x65\155\x61\151\154\113\x65\x79" => '', "\x70\x68\157\156\145\113\x65\x79" => '');
        if (!empty($FA)) {
            goto X5j;
        }
        return $LO;
        X5j:
        foreach ($zA->fields as $QO) {
            if (property_exists($QO, "\154\141\x62\145\x6c")) {
                goto iJd;
            }
            goto Gse;
            iJd:
            if (!(strcasecmp($QO->label, $FA["\167\x70\146\157\x72\x6d\x5f\x66\x6f\x72\x6d"]["\145\x6d\141\x69\x6c\153\x65\x79"][$j1]) === 0)) {
                goto rTW;
            }
            $LO["\x65\x6d\141\x69\x6c\x4b\x65\171"] = $QO->id;
            rTW:
            if (!(strcasecmp($QO->label, $FA["\167\160\x66\157\162\155\x5f\146\x6f\x72\155"]["\160\150\157\156\145\x6b\x65\171"][$j1]) === 0)) {
                goto XWN;
            }
            $LO["\x70\150\157\x6e\145\x4b\145\171"] = $QO->id;
            XWN:
            Gse:
        }
        oJN:
        return $LO;
    }
}
