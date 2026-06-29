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
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class VisualFormBuilder extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::VISUAL_FORM;
        $this->_typePhoneTag = "\155\x6f\x5f\x76\x69\x73\x75\x61\154\x5f\x66\x6f\162\155\137\x70\x68\x6f\156\145\137\145\x6e\141\x62\154\145";
        $this->_typeEmailTag = "\155\x6f\137\166\151\x73\165\141\x6c\x5f\x66\157\162\155\x5f\145\155\141\151\154\x5f\145\156\141\142\x6c\x65";
        $this->_typeBothTag = "\155\157\137\166\151\163\165\141\154\x5f\146\x6f\x72\x6d\x5f\x62\157\164\150\137\x65\156\x61\x62\x6c\145";
        $this->_formKey = "\x56\111\123\x55\101\114\x5f\106\117\122\115";
        $this->_formName = mo_("\126\151\163\165\x61\154\x20\106\x6f\162\x6d\40\102\165\x69\x6c\144\x65\x72");
        $this->_phoneFormId = [];
        $this->_isFormEnabled = get_mo_option("\x76\x69\163\x75\x61\154\137\x66\157\x72\155\x5f\145\x6e\x61\142\x6c\x65");
        $this->_buttonText = get_mo_option("\166\151\163\165\141\x6c\137\x66\157\x72\155\x5f\142\x75\164\164\x6f\156\137\164\x65\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\151\x63\x6b\x20\110\x65\x72\145\40\164\x6f\40\x73\x65\x6e\144\40\117\x54\120");
        $this->_generateOTPAction = "\155\x69\156\x69\x6f\162\x61\156\x67\x65\55\x76\x66\x2d\x73\x65\x6e\144\55\157\x74\x70";
        $this->_validateOTPAction = "\155\151\156\151\x6f\x72\141\x6e\147\x65\x2d\166\146\55\x76\145\x72\x69\x66\171\x2d\143\x6f\x64\x65";
        $this->_formDocuments = MoOTPDocs::VISUAL_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\166\151\x73\165\x61\154\137\x66\x6f\162\155\137\145\x6e\141\142\x6c\145\x5f\x74\x79\x70\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\166\x69\x73\x75\141\154\x5f\146\157\162\x6d\x5f\x6f\x74\x70\137\x65\156\141\x62\x6c\x65\144"));
        if (!(empty($this->_formDetails) || !$this->_isFormEnabled)) {
            goto Ky;
        }
        return;
        Ky:
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\x23" . $qL["\160\150\157\x6e\145\153\x65\x79"]);
            R8:
        }
        n1:
        add_action("\x77\x70\x5f\x65\156\x71\x75\x65\165\145\137\x73\x63\x72\151\160\164\x73", array($this, "\x6d\x6f\x5f\145\156\161\x75\x65\165\x65\x5f\166\x66"));
        add_action("\167\x70\x5f\x61\152\x61\170\x5f{$this->_generateOTPAction}", [$this, "\137\163\145\x6e\x64\137\157\x74\x70\137\x76\146\137\x61\152\x61\170"]);
        add_action("\167\x70\x5f\141\152\141\x78\137\156\157\x70\162\x69\166\x5f{$this->_generateOTPAction}", [$this, "\137\x73\x65\156\144\137\x6f\164\x70\137\x76\x66\x5f\x61\152\141\x78"]);
        add_action("\167\160\137\x61\x6a\x61\x78\137{$this->_validateOTPAction}", [$this, "\x70\162\157\143\x65\x73\163\x46\157\x72\155\x41\x6e\144\126\141\x6c\x69\144\141\x74\x65\117\124\120"]);
        add_action("\x77\x70\137\141\152\141\170\x5f\x6e\x6f\x70\x72\151\x76\137{$this->_validateOTPAction}", [$this, "\x70\x72\157\143\x65\x73\x73\x46\157\162\155\x41\156\x64\x56\141\x6c\151\144\x61\164\x65\117\124\120"]);
    }
    function mo_enqueue_vf()
    {
        wp_register_script("\166\146\x73\143\162\x69\160\x74", MOV_URL . "\151\156\x63\x6c\165\144\x65\163\x2f\152\163\x2f\x76\146\x73\x63\162\151\x70\x74\x2e\155\x69\156\x2e\x6a\163", array("\152\x71\x75\x65\x72\171"));
        wp_localize_script("\x76\146\163\143\x72\x69\x70\x74", "\155\157\x76\146\x76\x61\x72", array("\163\x69\164\x65\125\x52\114" => wp_ajax_url(), "\x6f\x74\160\124\x79\160\145" => strcasecmp($this->_otpType, $this->_typePhoneTag), "\x66\157\x72\155\104\x65\x74\141\x69\x6c\163" => $this->_formDetails, "\142\x75\164\x74\157\156\164\145\x78\x74" => $this->_buttonText, "\x69\155\147\125\122\x4c" => MOV_LOADER_URL, "\146\151\x65\154\144\124\x65\x78\164" => mo_("\x45\x6e\x74\145\x72\x20\117\x54\x50\40\x68\x65\x72\x65"), "\x67\x6e\157\156\x63\x65" => wp_create_nonce($this->_nonce), "\156\157\x6e\x63\145\x4b\145\171" => wp_create_nonce($this->_nonceKey), "\166\156\x6f\156\x63\145" => wp_create_nonce($this->_nonce), "\147\x61\143\x74\x69\x6f\x6e" => $this->_generateOTPAction, "\x76\141\x63\164\151\157\x6e" => $this->_validateOTPAction));
        wp_enqueue_script("\166\146\163\143\162\151\x70\164");
    }
    function _send_otp_vf_ajax()
    {
        $this->validateAjaxRequest();
        if ($this->_otpType == $this->_typePhoneTag) {
            goto XH;
        }
        $this->_send_vf_otp_to_email($_POST);
        goto NJ;
        XH:
        $this->_send_vf_otp_to_phone($_POST);
        NJ:
    }
    function _send_vf_otp_to_phone($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\163\145\x72\137\x70\150\157\156\145", $FA)) {
            goto G1;
        }
        $this->startOTPVerification(sanitize_text_field(trim($FA["\165\163\145\162\x5f\x70\x68\x6f\156\x65"])), NULL, sanitize_text_field(trim($FA["\165\163\x65\x72\x5f\x70\150\x6f\x6e\x65"])), VerificationType::PHONE);
        goto hw;
        G1:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        hw:
    }
    function _send_vf_otp_to_email($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\145\x72\137\145\155\141\151\154", $FA)) {
            goto zy;
        }
        $this->startOTPVerification(sanitize_email($FA["\x75\163\145\x72\137\x65\155\x61\x69\x6c"]), sanitize_email($FA["\165\163\x65\162\x5f\x65\x6d\x61\151\x6c"]), NULL, VerificationType::EMAIL);
        goto il;
        zy:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        il:
    }
    private function startOTPVerification($WH, $BO, $dI, $tA)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($tA === VerificationType::PHONE) {
            goto m4;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $WH);
        goto Hk;
        m4:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $WH);
        Hk:
        $this->sendChallenge('', $BO, NULL, $dI, $tA);
    }
    function processFormAndValidateOTP()
    {
        $this->validateAjaxRequest();
        $this->checkIfVerificationNotStarted();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfVerificationNotStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto mL;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        mL:
    }
    private function checkIntegrityAndValidateOTP($post)
    {
        $this->checkIntegrity($post);
        $this->validateChallenge($this->getVerificationType(), NULL, sanitize_text_field($post["\x6f\164\x70\x5f\164\x6f\x6b\x65\x6e"]));
    }
    private function checkIntegrity($post)
    {
        if ($this->isPhoneVerificationEnabled()) {
            goto JN;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_text_field($post["\x73\x75\142\x5f\146\x69\145\154\144"]))) {
            goto R0;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        R0:
        goto YL;
        JN:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($post["\x73\165\142\137\146\x69\145\x6c\x64"]))) {
            goto Aj;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        Aj:
        YL:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->_isFormEnabled && $this->isPhoneVerificationEnabled())) {
            goto qm;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        qm:
        return $kp;
    }
    function isPhoneVerificationEnabled()
    {
        $Bs = $this->getVerificationType();
        return $Bs == VerificationType::PHONE || $Bs === VerificationType::BOTH;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Zr;
        }
        return;
        Zr:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\166\x69\x73\165\141\x6c\x5f\146\157\162\x6d\x5f\145\x6e\x61\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x76\x69\163\x75\x61\x6c\x5f\x66\x6f\162\155\x5f\145\156\x61\142\x6c\x65\x5f\164\171\x70\x65");
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_buttonText = $this->sanitizeFormPOST("\x76\151\x73\165\141\154\x5f\146\x6f\162\155\137\142\x75\164\164\157\x6e\x5f\164\145\170\164");
        if (!$this->basicValidationCheck(BaseMessages::VISUAL_FORM_CHOOSE)) {
            goto dC;
        }
        update_mo_option("\166\x69\x73\x75\x61\x6c\137\x66\x6f\162\x6d\x5f\142\x75\x74\164\157\x6e\x5f\164\x65\x78\164", $this->_buttonText);
        update_mo_option("\x76\x69\163\x75\141\154\137\146\157\162\155\x5f\x65\156\x61\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\166\151\x73\x75\x61\154\137\x66\157\x72\155\137\145\156\141\142\x6c\145\137\164\x79\x70\145", $this->_otpType);
        update_mo_option("\x76\x69\163\165\x61\154\137\x66\157\x72\155\137\157\164\x70\x5f\145\x6e\x61\142\x6c\145\144", maybe_serialize($this->_formDetails));
        dC:
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\x76\151\x73\x75\141\154\x5f\146\x6f\x72\155", $_POST)) {
            goto Oo;
        }
        return array();
        Oo:
        foreach (array_filter($_POST["\x76\x69\x73\165\x61\x6c\x5f\x66\157\x72\x6d"]["\146\x6f\162\x6d"]) as $j1 => $qL) {
            $form[$qL] = array("\x65\155\141\151\x6c\x6b\x65\171" => $this->getFieldID(sanitize_text_field($_POST["\166\151\163\165\141\x6c\137\146\157\x72\155"]["\x65\x6d\141\x69\x6c\x6b\145\171"][$j1]), $qL), "\160\x68\157\x6e\x65\x6b\x65\171" => $this->getFieldID(sanitize_text_field($_POST["\x76\151\163\165\x61\x6c\x5f\x66\157\x72\x6d"]["\x70\150\x6f\156\145\x6b\x65\171"][$j1]), $qL), "\x70\x68\157\x6e\x65\137\x73\x68\157\x77" => sanitize_text_field($_POST["\x76\151\x73\x75\141\154\137\146\157\162\x6d"]["\160\150\157\x6e\145\153\145\171"][$j1]), "\x65\155\141\x69\x6c\x5f\x73\150\157\167" => sanitize_text_field($_POST["\166\151\163\165\141\154\137\146\157\162\155"]["\145\155\x61\151\154\x6b\x65\171"][$j1]));
            pm:
        }
        om:
        return $form;
    }
    private function getFieldID($j1, $zB)
    {
        global $wpdb;
        $KI = "\x53\x45\114\105\103\124\x20\52\x20\x46\122\x4f\x4d\x20" . VFB_WP_FIELDS_TABLE_NAME . "\x20\167\150\x65\162\x65\x20\146\x69\145\x6c\144\x5f\x6e\x61\x6d\145\x20\75\x27" . $j1 . "\x27\x61\156\x64\x20\x66\x6f\x72\155\137\x69\144\x20\75\40\x27" . $zB . "\47";
        $s_ = $wpdb->get_row($KI);
        return !MoUtility::isBlank($s_) ? "\166\146\142\55" . $s_->field_id : '';
    }
}
