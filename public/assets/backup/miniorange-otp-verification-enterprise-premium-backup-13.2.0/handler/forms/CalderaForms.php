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
class CalderaForms extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::CALDERA;
        $this->_typePhoneTag = "\155\157\x5f\143\141\x6c\x64\145\x72\141\x5f\160\x68\157\x6e\145\x5f\x65\156\141\142\154\x65";
        $this->_typeEmailTag = "\155\x6f\137\143\141\154\x64\x65\162\x61\x5f\145\155\x61\151\154\x5f\x65\156\141\x62\x6c\145";
        $this->_formKey = "\x43\x41\x4c\104\x45\x52\101";
        $this->_formName = mo_("\x43\141\x6c\144\145\x72\141\x20\x46\x6f\x72\155\163");
        $this->_isFormEnabled = get_mo_option("\x63\141\154\x64\145\162\141\137\x65\156\x61\x62\154\x65");
        $this->_buttonText = get_mo_option("\143\x61\154\x64\x65\162\x61\x5f\142\x75\x74\164\x6f\156\137\x74\x65\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\x69\x63\x6b\40\x48\145\x72\x65\x20\164\157\40\x73\145\x6e\x64\40\117\124\x50");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::CALDERA_FORMS_LINK;
        $this->_generateOTPAction = "\x6d\x69\156\x69\x6f\162\x61\156\x67\145\137\x63\141\x6c\144\x65\x72\x61\x5f\147\145\156\x65\162\141\x74\145\137\x6f\164\160";
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\143\141\x6c\x64\145\x72\x61\x5f\145\156\141\x62\x6c\145\137\164\171\x70\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\143\x61\x6c\144\145\x72\141\x5f\146\x6f\x72\155\163"));
        if (!empty($this->_formDetails)) {
            goto xM;
        }
        return;
        xM:
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\x69\x6e\160\165\164\133\156\x61\155\145\x3d" . $qL["\x70\x68\157\x6e\x65\x6b\145\x79"]);
            add_filter("\143\x61\x6c\x64\x65\x72\141\x5f\x66\x6f\x72\x6d\x73\137\166\x61\154\151\144\x61\164\x65\137\146\151\145\154\x64\137" . $qL["\160\150\x6f\x6e\145\153\145\x79"], [$this, "\166\141\154\x69\144\141\x74\x65\106\157\162\155"], 99, 3);
            add_filter("\x63\x61\154\x64\145\x72\141\x5f\x66\157\x72\155\163\137\x76\x61\x6c\151\x64\x61\164\x65\137\146\x69\145\154\144\137" . $qL["\145\x6d\141\151\x6c\153\x65\x79"], [$this, "\x76\x61\154\151\144\x61\164\x65\x46\x6f\x72\155"], 99, 3);
            add_filter("\x63\141\154\144\x65\162\141\137\x66\x6f\162\x6d\x73\x5f\x76\x61\154\151\144\141\x74\x65\x5f\x66\151\145\x6c\x64\x5f" . $qL["\x76\145\x72\151\x66\x79\x4b\x65\171"], [$this, "\x76\141\154\x69\x64\x61\164\x65\106\x6f\x72\155"], 99, 3);
            add_action("\x63\x61\154\x64\145\162\x61\137\146\157\x72\x6d\163\x5f\x73\165\142\x6d\x69\164\137\143\x6f\155\160\x6c\145\x74\x65", [$this, "\165\156\163\145\164\x4f\124\x50\x53\x65\x73\x73\151\x6f\156\x56\x61\x72\x69\141\142\154\x65\x73"], 99);
            oh:
        }
        vF:
        add_action("\x77\160\x5f\x61\x6a\x61\x78\x5f{$this->_generateOTPAction}", [$this, "\137\x73\145\156\144\x5f\x6f\164\160"]);
        add_action("\x77\x70\x5f\141\152\141\x78\x5f\156\157\x70\x72\x69\x76\137{$this->_generateOTPAction}", [$this, "\x5f\x73\145\x6e\144\137\157\164\x70"]);
        add_action("\167\x70\137\x65\156\161\165\x65\x75\x65\x5f\163\143\162\151\x70\x74\x73", array($this, "\x6d\x69\x6e\x69\x6f\162\141\x6e\x67\145\137\162\145\147\x69\163\x74\145\x72\137\143\x61\x6c\x64\x65\x72\x61\x5f\x73\143\162\151\x70\x74"));
    }
    function unsetSessionVariable()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto ng;
        }
        $this->unsetOTPSessionVariables();
        ng:
    }
    function miniorange_register_caldera_script()
    {
        wp_register_script("\x6d\x6f\x63\141\x6c\144\145\162\141", MOV_URL . "\x69\x6e\143\x6c\x75\144\145\163\x2f\x6a\163\x2f\143\x61\154\144\x65\x72\141\56\155\151\x6e\x2e\152\163", array("\x6a\161\x75\145\162\x79"));
        wp_localize_script("\x6d\x6f\x63\x61\154\144\145\x72\x61", "\155\157\143\x61\x6c\x64\x65\162\x61", array("\163\x69\164\x65\125\x52\x4c" => wp_ajax_url(), "\x6f\x74\160\x54\171\160\x65" => $this->_otpType, "\146\x6f\x72\x6d\153\x65\x79" => strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? "\160\150\157\156\x65\x6b\x65\x79" : "\x65\x6d\141\x69\154\x6b\145\x79", "\156\157\x6e\x63\145" => wp_create_nonce($this->_nonce), "\142\x75\164\164\x6f\156\x74\x65\170\164" => mo_($this->_buttonText), "\151\x6d\147\x55\x52\114" => MOV_LOADER_URL, "\x66\157\162\x6d\163" => $this->_formDetails, "\147\145\156\x65\x72\x61\164\x65\x55\122\x4c" => $this->_generateOTPAction));
        wp_enqueue_script("\x6d\x6f\x63\141\x6c\144\145\162\141");
    }
    function _send_otp()
    {
        $FA = $_POST;
        $this->validateAjaxRequest();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType == $this->_typePhoneTag) {
            goto v9;
        }
        $this->_processEmailAndStartOTPVerificationProcess($FA);
        goto Hj;
        v9:
        $this->_processPhoneAndStartOTPVerificationProcess($FA);
        Hj:
    }
    private function _processEmailAndStartOTPVerificationProcess($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\163\x65\162\x5f\145\155\x61\x69\154", $FA)) {
            goto Su;
        }
        $this->setSessionAndStartOTPVerification($FA["\165\x73\x65\x72\x5f\x65\155\141\x69\154"], $FA["\165\x73\145\x72\137\145\x6d\141\151\x6c"], NULL, VerificationType::EMAIL);
        goto n4;
        Su:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        n4:
    }
    private function _processPhoneAndStartOTPVerificationProcess($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\145\162\x5f\x70\150\x6f\x6e\145", $FA)) {
            goto Pp;
        }
        $this->setSessionAndStartOTPVerification(trim($FA["\165\163\x65\x72\137\x70\x68\x6f\156\x65"]), NULL, trim($FA["\165\x73\x65\162\x5f\160\150\157\x6e\145"]), VerificationType::PHONE);
        goto Ae;
        Pp:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        Ae:
    }
    private function setSessionAndStartOTPVerification($WH, $BO, $dI, $ml)
    {
        SessionUtils::addEmailOrPhoneVerified($this->_formSessionVar, $WH, $ml);
        $this->sendChallenge('', $BO, NULL, $dI, $ml);
    }
    public function validateForm($wn, $QO, $form)
    {
        if (!is_wp_error($wn)) {
            goto yJ;
        }
        return $wn;
        yJ:
        $j0 = $form["\111\x44"];
        if (array_key_exists($j0, $this->_formDetails)) {
            goto dP;
        }
        return $wn;
        dP:
        $zA = $this->_formDetails[$j0];
        $wn = $this->checkIfOtpVerificationStarted($wn);
        if (!is_wp_error($wn)) {
            goto a8;
        }
        return $wn;
        a8:
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0 && strcasecmp($QO["\111\104"], $zA["\x65\155\141\151\154\x6b\145\171"]) == 0) {
            goto jg;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && strcasecmp($QO["\111\104"], $zA["\160\150\x6f\156\x65\153\x65\x79"]) == 0) {
            goto Mr;
        }
        if (strcasecmp($QO["\x49\x44"], $zA["\x76\145\x72\x69\146\x79\x4b\x65\171"]) == 0) {
            goto go;
        }
        goto GA;
        jg:
        $wn = $this->processEmail($wn);
        goto GA;
        Mr:
        $wn = $this->processPhone($wn);
        goto GA;
        go:
        $wn = $this->processOTPEntered($wn);
        GA:
        return $wn;
    }
    function processOTPEntered($wn)
    {
        $Bs = $this->getVerificationType();
        $this->validateChallenge($Bs, NULL, $wn);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs)) {
            goto Fw;
        }
        $wn = new WP_Error("\111\116\126\x41\x4c\x49\x44\137\117\x54\x50", MoUtility::_get_invalid_otp_method());
        Fw:
        return $wn;
    }
    function checkIfOtpVerificationStarted($wn)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $wn : new WP_Error("\x45\116\x54\105\x52\x5f\x56\x45\122\111\106\x59\x5f\x43\x4f\x44\105", MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
    }
    function processEmail($wn)
    {
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $wn) ? $wn : new WP_Error("\105\x4d\101\111\114\137\115\x49\123\115\101\x54\x43\110", MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
    }
    function processPhone($wn)
    {
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $wn) ? $wn : new WP_Error("\x50\x48\117\x4e\x45\x5f\x4d\111\x53\x4d\101\124\x43\x48", MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
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
            goto Xf;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        Xf:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto tx;
        }
        return;
        tx:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\143\x61\x6c\x64\145\x72\x61\x5f\145\x6e\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\143\x61\154\x64\x65\x72\141\x5f\x65\156\141\142\154\145\x5f\x74\171\x70\145");
        $this->_buttonText = $this->sanitizeFormPOST("\x63\x61\x6c\x64\x65\x72\141\137\142\165\x74\x74\157\x6e\137\x74\x65\x78\x74");
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\143\141\154\144\x65\162\141\x5f\145\x6e\x61\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\143\x61\154\x64\x65\162\x61\x5f\145\156\141\x62\x6c\x65\137\164\171\x70\x65", $this->_otpType);
        update_mo_option("\143\141\154\144\145\x72\141\x5f\x62\165\x74\164\157\x6e\x5f\x74\145\170\x74", $this->_buttonText);
        update_mo_option("\x63\x61\154\144\145\x72\x61\x5f\146\157\162\x6d\163", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = [];
        if (!(!array_key_exists("\143\141\154\x64\145\162\x61\x5f\x66\157\x72\155", $_POST) || !$this->_isFormEnabled)) {
            goto Fk;
        }
        return $form;
        Fk:
        foreach (array_filter($_POST["\143\141\x6c\144\x65\162\x61\137\x66\x6f\x72\x6d"]["\x66\x6f\162\x6d"]) as $j1 => $qL) {
            $j1 = sanitize_text_field($j1);
            $form[sanitize_text_field($qL)] = array("\145\155\x61\x69\154\153\x65\171" => sanitize_text_field($_POST["\x63\x61\154\x64\145\162\x61\x5f\146\157\x72\x6d"]["\x65\x6d\141\x69\x6c\153\x65\171"][$j1]), "\x70\x68\157\156\x65\153\x65\171" => sanitize_text_field($_POST["\143\141\x6c\x64\145\x72\x61\x5f\x66\x6f\x72\x6d"]["\160\x68\157\156\145\153\145\x79"][$j1]), "\166\145\x72\x69\146\x79\x4b\145\171" => sanitize_text_field($_POST["\x63\141\154\x64\x65\x72\x61\x5f\x66\x6f\x72\155"]["\166\145\162\x69\146\171\113\x65\171"][$j1]), "\x70\150\x6f\x6e\x65\x5f\163\150\x6f\167" => sanitize_text_field($_POST["\143\x61\x6c\x64\145\x72\141\x5f\146\157\162\x6d"]["\160\150\x6f\x6e\x65\153\x65\171"][$j1]), "\145\x6d\x61\151\x6c\137\x73\x68\x6f\x77" => sanitize_text_field($_POST["\x63\141\154\x64\x65\x72\x61\137\146\157\162\155"]["\145\x6d\x61\151\x6c\153\x65\x79"][$j1]), "\166\145\162\x69\146\171\137\163\150\x6f\167" => sanitize_text_field($_POST["\143\x61\154\144\145\162\x61\137\146\x6f\162\x6d"]["\x76\x65\162\x69\x66\171\113\x65\171"][$j1]));
            YJ:
        }
        KB:
        return $form;
    }
}
