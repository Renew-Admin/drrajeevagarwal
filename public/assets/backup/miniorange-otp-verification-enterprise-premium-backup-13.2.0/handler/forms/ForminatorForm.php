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
class ForminatorForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMINATOR;
        $this->_typePhoneTag = "\x6d\157\x5f\x66\157\x72\155\151\156\141\164\157\x72\x5f\x70\x68\x6f\x6e\x65\137\145\156\x61\142\x6c\x65";
        $this->_typeEmailTag = "\x6d\157\x5f\146\157\162\155\x69\156\141\164\x6f\162\137\145\x6d\x61\151\154\x5f\x65\x6e\x61\142\154\145";
        $this->_formKey = "\106\x4f\122\x4d\111\116\x41\124\117\122";
        $this->_formName = mo_("\x46\x6f\162\155\x69\156\141\164\x6f\x72\40\x46\x6f\162\155\x73");
        $this->_isFormEnabled = get_mo_option("\x66\x6f\x72\155\151\x6e\x61\164\x6f\162\137\x65\x6e\x61\142\154\x65");
        $this->_buttonText = get_mo_option("\146\157\162\155\x69\x6e\141\x74\x6f\x72\x5f\142\x75\x74\x74\x6f\156\137\x74\145\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\154\151\143\x6b\40\x48\x65\x72\145\40\x74\x6f\x20\163\x65\x6e\x64\40\117\x54\120");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::CALDERA_FORMS_LINK;
        $this->_generateOTPAction = "\155\x69\156\151\x6f\x72\141\x6e\x67\x65\137\146\157\162\155\x69\x6e\141\164\157\162\137\x67\x65\x6e\x65\x72\141\x74\145\137\x6f\x74\x70";
        $this->_validateOTPAction = "\155\x69\x6e\x69\x6f\x72\x61\x6e\x67\145\x5f\146\x6f\x72\x6d\151\156\141\164\x6f\162\137\x76\141\x6c\x69\x64\141\x74\145\x5f\x6f\x74\160";
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x66\157\x72\155\x69\156\141\x74\x6f\x72\x5f\145\x6e\x61\x62\154\x65\x5f\x74\171\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\146\x6f\x72\155\151\156\141\x74\157\x72\137\x66\157\x72\x6d\163"));
        if (!empty($this->_formDetails)) {
            goto ry;
        }
        return;
        ry:
        add_action("\167\160\137\x61\x6a\x61\170\x5f{$this->_generateOTPAction}", [$this, "\x5f\x73\145\156\x64\x5f\x6f\x74\160"]);
        add_action("\x77\x70\137\141\152\141\x78\137\156\157\x70\162\151\x76\x5f{$this->_generateOTPAction}", [$this, "\137\163\x65\156\144\137\157\164\160"]);
        add_action("\x77\160\x5f\x65\x6e\161\x75\x65\x75\x65\x5f\x73\x63\162\x69\x70\x74\163", array($this, "\x6d\151\156\151\x6f\162\141\156\x67\x65\137\162\145\147\x69\163\164\x65\162\137\146\x6f\162\155\151\x6e\x61\x74\157\162\137\x73\x63\x72\151\x70\164"));
        add_action("\167\160\137\141\x6a\x61\x78\137{$this->_validateOTPAction}", [$this, "\160\x72\x6f\x63\x65\163\163\x46\x6f\162\x6d\x41\156\144\126\x61\x6c\x69\x64\x61\x74\145\x4f\124\x50"]);
        add_action("\x77\160\137\141\x6a\x61\x78\x5f\156\x6f\160\162\x69\166\137{$this->_validateOTPAction}", [$this, "\x70\x72\157\143\x65\x73\x73\106\x6f\x72\x6d\x41\156\144\126\x61\x6c\x69\144\x61\164\145\x4f\124\120"]);
        add_filter("\146\x6f\x72\155\151\156\141\164\x6f\162\x5f\143\165\163\164\x6f\x6d\x5f\x66\x6f\x72\x6d\x5f\x73\165\142\155\151\164\137\145\162\162\x6f\x72\x73", [$this, "\x66\157\162\155\x69\156\x61\164\157\162\x5f\x63\x75\163\164\x6f\155\137\x66\x6f\x72\x6d\137\x73\165\x62\x6d\x69\164\137\145\x72\x72\x6f\162\163"], 1, 3);
        add_filter("\146\157\162\155\x69\156\141\x74\157\x72\137\146\x6f\162\155\x5f\141\x6a\141\x78\x5f\x73\165\142\x6d\x69\x74\137\162\x65\x73\x70\157\x6e\163\145", [$this, "\x66\157\162\x6d\151\x6e\141\x74\157\x72\x5f\x66\x6f\162\155\x5f\x61\x6a\141\170\137\x73\x75\x62\155\151\164\x5f\x72\x65\163\x70\157\156\x73\x65"], 1, 2);
    }
    public function forminator_form_ajax_submit_response($aU, $fk)
    {
        if (!(!$aU["\163\x75\x63\x63\x65\x73\x73"] && array_key_exists($fk, $this->_formDetails))) {
            goto jm;
        }
        $aU["\155\x65\163\163\141\147\145"] = $aU["\x65\x72\162\x6f\162\x73"][0];
        jm:
        if (!$aU["\x73\x75\x63\143\x65\x73\x73"]) {
            goto Ag;
        }
        $this->unsetOTPSessionVariables();
        Ag:
        return $aU;
    }
    public function forminator_custom_form_submit_errors($SB, $fk, $I_)
    {
        $Kp = $this->moValidationChecks($SB, $fk, $I_);
        if (!$Kp) {
            goto Wb;
        }
        array_push($SB, $Kp);
        Wb:
        return $SB;
    }
    public function moValidationChecks($SB, $fk, $I_ = '')
    {
        $Kp = '';
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Rg;
        }
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto ny;
        }
        $Fe = $this->_formDetails[$fk][$this->getVerificationType() . "\153\x65\171"];
        $ro = '';
        foreach ($I_ as $j1 => $qL) {
            if (!($qL["\156\141\x6d\x65"] == $Fe)) {
                goto Jb;
            }
            $ro = $qL["\166\141\154\165\x65"];
            Jb:
            ft:
        }
        dQ:
        if (array_key_exists($fk, $this->_formDetails) && $this->getVerificationType() === "\160\x68\157\x6e\x65") {
            goto os;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email($ro))) {
            goto IM;
        }
        $Kp = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        IM:
        goto vv;
        os:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($ro))) {
            goto gx;
        }
        $Kp = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        gx:
        vv:
        goto cY;
        Rg:
        $Kp = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        goto cY;
        ny:
        $Kp = MoMessages::showMessage(MoMessages::INVALID_OTP);
        cY:
        return $Kp;
    }
    function unsetSessionVariable($I5)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto RI;
        }
        $this->unsetOTPSessionVariables();
        RI:
        return $I5;
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
            goto sD;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        sD:
    }
    private function checkIntegrityAndValidateOTP($FA)
    {
        $this->checkIntegrity($FA);
        $this->validateChallenge(sanitize_text_field($FA["\x6f\164\160\x54\x79\x70\145"]), NULL, sanitize_text_field($FA["\x6f\164\160\137\164\x6f\x6b\145\x6e"]));
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, sanitize_text_field($FA["\x6f\164\160\x54\171\x70\145"]))) {
            goto RL;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto iE;
        RL:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        iE:
    }
    private function checkIntegrity($FA)
    {
        if ($FA["\x6f\x74\160\x54\171\x70\x65"] === "\x70\x68\x6f\156\145") {
            goto Sc;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email($FA["\165\x73\x65\x72\137\x65\155\x61\x69\x6c"]))) {
            goto T4;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        T4:
        goto zt;
        Sc:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($FA["\x75\163\145\162\137\160\150\157\156\145"]))) {
            goto ux;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        ux:
        zt:
    }
    function miniorange_register_forminator_script()
    {
        wp_register_script("\x6d\x6f\146\x6f\162\x6d\x69\156\x61\164\x6f\x72", MOV_URL . "\x69\x6e\x63\154\165\144\x65\163\x2f\x6a\x73\x2f\x6d\x6f\x66\x6f\162\155\x69\x6e\x61\164\x6f\162\56\152\x73", array("\152\x71\x75\145\x72\x79"));
        wp_localize_script("\155\x6f\x66\x6f\x72\155\151\x6e\141\x74\157\162", "\x6d\x6f\146\157\162\155\151\156\x61\164\x6f\162", array("\163\x69\x74\x65\125\x52\x4c" => wp_ajax_url(), "\x6f\x74\x70\x54\171\x70\145" => $this->ajaxProcessingFields(), "\147\x6e\157\x6e\x63\x65" => wp_create_nonce($this->_nonce), "\x6e\x6f\156\x63\145\113\145\171" => wp_create_nonce($this->_nonceKey), "\x76\156\x6f\156\x63\x65" => wp_create_nonce($this->_nonce), "\x62\x75\164\164\157\156\x74\x65\170\x74" => mo_($this->_buttonText), "\x69\x6d\147\x55\122\x4c" => MOV_LOADER_URL, "\x66\157\x72\x6d\x44\x65\164\x61\151\154\x73" => $this->_formDetails, "\146\x69\145\x6c\144\124\145\170\164" => mo_("\105\156\x74\145\x72\x20\x4f\x54\x50\x20\150\145\162\x65"), "\x76\141\x6c\x69\144\x61\x74\145\144" => $this->getSessionDetails(), "\147\x61\x63\x74\151\x6f\x6e" => $this->_generateOTPAction, "\x76\x61\143\x74\x69\157\x6e" => $this->_validateOTPAction));
        wp_enqueue_script("\x6d\157\146\x6f\x72\155\x69\156\141\x74\x6f\x72");
    }
    function getSessionDetails()
    {
        return [VerificationType::EMAIL => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL), VerificationType::PHONE => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)];
    }
    function _send_otp()
    {
        $FA = $_POST;
        $this->validateAjaxRequest();
        if ($this->_otpType == $this->_typePhoneTag) {
            goto qS;
        }
        $this->_processEmailAndStartOTPVerificationProcess($FA);
        goto gK;
        qS:
        $this->_processPhoneAndStartOTPVerificationProcess($FA);
        gK:
    }
    private function _processEmailAndStartOTPVerificationProcess($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\163\145\x72\137\x65\155\141\151\154", $FA)) {
            goto a6;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->setSessionAndStartOTPVerification($FA["\x75\163\x65\x72\x5f\145\x6d\141\151\154"], $FA["\x75\163\145\162\x5f\x65\x6d\141\x69\154"], NULL, VerificationType::EMAIL);
        goto Fr;
        a6:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        Fr:
    }
    private function _processPhoneAndStartOTPVerificationProcess($FA)
    {
        if (!MoUtility::sanitizeCheck("\x75\x73\x65\162\137\160\x68\157\x6e\x65", $FA)) {
            goto no;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->setSessionAndStartOTPVerification(trim($FA["\165\163\145\x72\137\160\x68\x6f\x6e\x65"]), NULL, trim($FA["\165\x73\x65\x72\x5f\x70\x68\x6f\x6e\x65"]), VerificationType::PHONE);
        goto Hh;
        no:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        Hh:
    }
    private function setSessionAndStartOTPVerification($WH, $BO, $dI, $ml)
    {
        SessionUtils::addEmailOrPhoneVerified($this->_formSessionVar, $WH, $ml);
        $this->sendChallenge('', $BO, NULL, $dI, $ml);
    }
    public function validateForm($wn, $QO, $form)
    {
        if (!is_wp_error($wn)) {
            goto rC;
        }
        return $wn;
        rC:
        $j0 = $form["\x49\104"];
        if (array_key_exists($j0, $this->_formDetails)) {
            goto kp;
        }
        return $wn;
        kp:
        $zA = $this->_formDetails[$j0];
        $wn = $this->checkIfOtpVerificationStarted($wn);
        if (!is_wp_error($wn)) {
            goto PV;
        }
        return $wn;
        PV:
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0 && strcasecmp($QO["\111\x44"], $zA["\x65\155\141\x69\x6c\153\145\171"]) == 0) {
            goto Ck;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && strcasecmp($QO["\111\x44"], $zA["\160\x68\157\156\x65\153\145\x79"]) == 0) {
            goto d9;
        }
        if (empty($errors) && strcasecmp($QO["\111\x44"], $zA["\166\145\162\x69\146\171\x4b\x65\171"]) == 0) {
            goto GF;
        }
        goto ip;
        Ck:
        $wn = $this->processEmail($wn);
        goto ip;
        d9:
        $wn = $this->processPhone($wn);
        goto ip;
        GF:
        $wn = $this->processOTPEntered($wn);
        ip:
        return $wn;
    }
    function processOTPEntered($wn)
    {
        $Bs = $this->getVerificationType();
        $this->validateChallenge($Bs, NULL, $wn);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs)) {
            goto VF;
        }
        $wn = new WP_Error("\x49\116\126\101\114\x49\x44\137\x4f\x54\x50", MoUtility::_get_invalid_otp_method());
        VF:
        return $wn;
    }
    function checkIfOtpVerificationStarted($wn)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $wn : new WP_Error("\x45\116\x54\105\122\x5f\126\105\122\x49\106\x59\137\103\x4f\x44\105", MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
    }
    function processEmail($wn)
    {
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $wn) ? $wn : new WP_Error("\105\115\101\111\114\137\115\x49\x53\115\x41\x54\x43\110", MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
    }
    function processPhone($wn)
    {
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $wn) ? $wn : new WP_Error("\120\110\x4f\x4e\x45\x5f\115\111\x53\x4d\101\124\x43\x48", MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
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
            goto ZQ;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        ZQ:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto aw;
        }
        return;
        aw:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x66\157\x72\155\x69\x6e\141\164\157\162\x5f\x65\x6e\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x66\x6f\162\155\151\x6e\141\164\x6f\162\137\x65\x6e\x61\x62\154\145\x5f\164\x79\160\145");
        $this->_buttonText = $this->sanitizeFormPOST("\146\157\x72\155\151\x6e\141\164\157\x72\137\x62\165\164\x74\x6f\156\x5f\164\145\x78\164");
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\x66\157\162\x6d\151\x6e\x61\x74\x6f\162\137\x65\156\141\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\146\x6f\x72\x6d\x69\x6e\141\164\x6f\162\x5f\x65\x6e\141\x62\x6c\x65\137\164\171\160\x65", $this->_otpType);
        update_mo_option("\x66\x6f\162\x6d\151\x6e\141\164\157\x72\x5f\x62\165\x74\x74\157\156\x5f\x74\x65\170\164", $this->_buttonText);
        update_mo_option("\146\157\162\155\x69\x6e\141\x74\x6f\162\137\x66\157\162\155\x73", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = [];
        if (!(!array_key_exists("\x66\x6f\x72\155\151\x6e\x61\164\x6f\162\137\146\157\162\x6d", $_POST) || !$this->_isFormEnabled)) {
            goto DD;
        }
        return $form;
        DD:
        foreach (array_filter($_POST["\146\x6f\162\x6d\x69\x6e\x61\164\157\x72\x5f\x66\157\x72\x6d"]["\146\x6f\162\155"]) as $j1 => $qL) {
            $j1 = sanitize_text_field($j1);
            $form[sanitize_text_field($qL)] = array("\x65\155\x61\151\154\153\145\x79" => sanitize_text_field($_POST["\x66\157\162\155\151\156\141\x74\157\x72\x5f\146\x6f\x72\155"]["\x65\155\141\151\x6c\153\145\171"][$j1]), "\160\150\x6f\156\145\153\145\x79" => sanitize_text_field($_POST["\x66\157\162\155\151\x6e\141\164\x6f\x72\x5f\146\x6f\x72\155"]["\160\x68\x6f\x6e\x65\x6b\145\x79"][$j1]), "\166\145\x72\x69\146\171\x4b\x65\x79" => sanitize_text_field($_POST["\x66\x6f\162\155\x69\x6e\x61\164\157\x72\137\x66\157\x72\155"]["\x76\x65\x72\x69\x66\171\113\145\171"][$j1]), "\x70\150\x6f\x6e\145\137\163\150\157\x77" => sanitize_text_field($_POST["\x66\157\x72\x6d\151\156\141\164\157\x72\x5f\x66\157\x72\x6d"]["\160\x68\157\x6e\x65\153\x65\171"][$j1]), "\x65\x6d\141\x69\154\137\x73\x68\157\167" => sanitize_text_field($_POST["\x66\157\x72\155\x69\x6e\x61\x74\157\162\137\146\x6f\x72\155"]["\x65\x6d\x61\151\154\153\x65\171"][$j1]), "\166\145\x72\x69\146\x79\137\163\150\x6f\x77" => sanitize_text_field($_POST["\146\157\x72\155\x69\x6e\141\164\x6f\x72\x5f\146\157\162\x6d"]["\166\145\x72\x69\x66\171\113\145\171"][$j1]));
            BS:
        }
        fY:
        return $form;
    }
}
