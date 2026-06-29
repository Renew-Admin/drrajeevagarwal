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
class ElementorPro extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::ELEMENTOR_PRO;
        $this->_phoneFormId = array();
        $this->_formKey = "\105\114\x45\115\x45\116\x54\x4f\122\137\x50\x52\117";
        $this->_typePhoneTag = "\x6d\157\137\x65\154\145\x6d\145\156\164\157\162\160\x72\157\x66\157\162\155\x5f\160\x68\x6f\156\145\137\x65\x6e\x61\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\157\137\x65\x6c\x65\155\145\x6e\164\x6f\x72\160\162\x6f\x66\x6f\x72\155\137\x65\x6d\x61\x69\154\x5f\x65\156\141\142\154\x65";
        $this->_typeBothTag = "\x6d\157\x5f\145\x6c\145\155\x65\156\x74\x6f\x72\160\x72\157\146\x6f\162\x6d\x5f\142\x6f\164\x68\x5f\x65\156\x61\142\154\145";
        $this->_formName = mo_("\x45\154\145\155\x65\156\164\157\x72\40\x50\x72\x6f\40\x46\x6f\x72\155\163");
        $this->_isFormEnabled = get_mo_option("\x65\x6c\145\155\145\x6e\x74\x6f\162\x70\162\157\146\157\162\x6d\137\145\x6e\141\x62\154\145");
        $this->_buttonText = get_mo_option("\145\x6c\145\155\x65\x6e\164\x6f\x72\160\162\x6f\x66\157\x72\155\163\x5f\142\x75\x74\164\x6f\156\x5f\x74\x65\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x53\145\x6e\144\40\117\x54\120");
        $this->_generateOTPAction = "\x6d\x69\156\151\x6f\162\x61\x6e\x67\145\x2d\x65\154\145\155\x65\x6e\x74\x6f\x72\x70\162\x6f\146\157\x72\x6d\x2d\163\145\156\x64\55\x6f\x74\x70";
        $this->_validateOTPAction = "\155\151\156\151\157\162\141\156\x67\x65\x2d\145\x6c\145\155\x65\156\164\x6f\162\x70\162\x6f\x66\x6f\x72\155\55\x76\x65\x72\151\146\171\55\143\x6f\144\x65";
        $this->_formDocuments = MoOTPDocs::ELEMENTORPRO_FORMS_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\145\154\x65\x6d\145\x6e\164\157\x72\160\162\x6f\146\157\162\155\x5f\x65\156\141\142\x6c\145\x5f\164\171\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\145\x6c\x65\155\x65\156\x74\x6f\162\x70\162\x6f\146\157\162\x6d\137\146\x6f\x72\155\163"));
        if (!empty($this->_formDetails)) {
            goto s5;
        }
        return;
        s5:
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto KU;
        }
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\43" . $qL["\x70\x68\157\x6e\x65\153\x65\171"]);
            SM:
        }
        rj:
        KU:
        add_action("\x77\160\x5f\x65\156\161\x75\145\x75\145\x5f\x73\x63\x72\151\160\x74\x73", array($this, "\x6d\157\x5f\x65\156\x71\165\x65\165\x65\137\x65\154\145\x6d\x65\x6e\x74\x6f\x72\160\x72\157\146\x6f\162\x6d\x73"));
        add_action("\145\x6c\145\x6d\x65\156\164\157\162\x5f\x70\162\157\57\x66\x6f\162\x6d\x73\57\166\x61\154\151\144\x61\x74\x69\157\x6e", array($this, "\166\141\154\x69\x64\x61\164\145\x66\157\162\x6d"), 99, 2);
        add_action("\x65\x6c\x65\155\x65\156\x74\x6f\x72\137\x70\x72\157\57\146\x6f\x72\155\x73\57\156\x65\x77\x5f\x72\x65\x63\x6f\x72\x64", array($this, "\x75\x6e\x73\x65\x74\x53\x65\x73\x73\x69\157\156\126\141\x72\151\x61\x62\154\145"), 1, 1);
        add_action("\x77\x70\x5f\x61\152\141\x78\x5f{$this->_generateOTPAction}", [$this, "\137\163\145\x6e\x64\137\x6f\164\x70"]);
        add_action("\167\x70\137\x61\x6a\x61\x78\x5f\156\x6f\x70\x72\151\x76\137{$this->_generateOTPAction}", [$this, "\137\x73\x65\156\x64\137\x6f\x74\160"]);
        add_action("\167\160\x5f\x61\152\141\170\137{$this->_validateOTPAction}", [$this, "\x70\162\157\x63\145\x73\163\x46\157\162\x6d\101\156\144\126\141\154\151\144\141\164\x65\117\124\x50"]);
        add_action("\x77\x70\x5f\141\152\x61\x78\x5f\x6e\x6f\160\x72\x69\x76\137{$this->_validateOTPAction}", [$this, "\160\162\157\x63\145\x73\163\x46\157\162\155\x41\156\x64\x56\x61\x6c\151\x64\141\x74\x65\117\x54\x50"]);
    }
    function validateform($AR, $UD)
    {
        foreach (json_decode(get_post_meta($_POST["\160\x6f\163\164\137\151\x64"], "\x5f\x65\x6c\145\155\145\x6e\x74\157\162\137\x64\x61\x74\141")[0]) as $j1 => $qL) {
            $form_settings = $AR->get('form_settings');
            $fk = $form_settings['form_id'];
            if (array_key_exists($fk, $this->_formDetails)) {
                goto hU;
            }
            goto lN;
            hU:
            if ($this->_otpType === $this->_typePhoneTag) {
                goto MS;
            }
            $Fe = $this->_formDetails[$fk]["\145\155\141\x69\154\x5f\x73\150\x6f\x77"];
            $xW = $AR->get_field(["\x69\x64" => $Fe]);
            $this->processEmail($xW, $Fe, $UD);
            goto i2;
            MS:
            $Fe = $this->_formDetails[$fk]["\x70\150\x6f\x6e\145\137\x73\x68\157\167"];
            $xW = $AR->get_field(["\x69\x64" => $Fe]);
            $this->processPhone($xW, $Fe, $UD);
            i2:
            lN:
        }
        Yr:
    }
    function unsetSessionVariable($AR)
    {
        $this->unsetOTPSessionVariables();
    }
    function mo_enqueue_elementorproforms()
    {
        wp_register_script("\x6d\157\x65\x6c\145\155\145\156\x74\x6f\x72\x70\x72\157", MOV_URL . "\x69\x6e\x63\x6c\x75\x64\145\163\57\152\x73\57\x6d\x6f\x65\154\145\155\x65\x6e\x74\x6f\162\160\162\x6f\x2e\x6d\151\156\56\x6a\163", array("\152\161\165\145\x72\x79"));
        wp_localize_script("\x6d\157\145\154\145\x6d\145\156\x74\157\162\160\162\x6f", "\155\157\x65\x6c\x65\155\x65\156\x74\x6f\162\x70\162\157", array("\163\151\x74\x65\125\122\114" => wp_ajax_url(), "\157\164\x70\x54\x79\x70\x65" => $this->ajaxProcessingFields(), "\x66\x6f\162\x6d\x44\145\164\x61\x69\x6c\x73" => $this->_formDetails, "\142\x75\164\x74\157\156\x74\145\x78\x74" => $this->_buttonText, "\x76\141\x6c\151\144\141\164\145\144" => $this->getSessionDetails(), "\x69\155\x67\x55\122\x4c" => MOV_LOADER_URL, "\x66\x69\145\x6c\144\124\x65\x78\164" => mo_("\105\x6e\164\x65\162\x20\117\x54\x50\x20\x68\x65\x72\145"), "\147\156\157\156\x63\145" => wp_create_nonce($this->_nonce), "\156\x6f\x6e\143\x65\113\x65\171" => wp_create_nonce($this->_nonceKey), "\x76\156\x6f\156\143\x65" => wp_create_nonce($this->_nonce), "\147\141\143\x74\x69\157\156" => $this->_generateOTPAction, "\x76\141\x63\164\151\157\x6e" => $this->_validateOTPAction));
        wp_enqueue_script("\x6d\x6f\x65\x6c\x65\x6d\145\x6e\164\157\162\160\162\x6f");
    }
    function getSessionDetails()
    {
        return [VerificationType::EMAIL => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL), VerificationType::PHONE => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)];
    }
    function _send_otp()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ("\155\x6f\137\x65\x6c\x65\x6d\145\x6e\x74\157\162\160\162\157\x66\157\x72\x6d\x5f" . $_POST["\157\164\160\x54\x79\160\x65"] . "\x5f\x65\156\141\142\x6c\x65" === $this->_typePhoneTag) {
            goto OX;
        }
        $this->_processEmailAndSendOTP($_POST);
        goto g2;
        OX:
        $this->_processPhoneAndSendOTP($_POST);
        g2:
    }
    private function _processEmailAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\145\162\x5f\145\155\141\151\x6c", $FA)) {
            goto H1;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $FA["\x75\x73\145\162\137\145\x6d\141\151\x6c"]);
        $this->sendChallenge('', $FA["\165\163\x65\x72\x5f\145\155\141\x69\154"], NULL, NULL, VerificationType::EMAIL);
        goto DY;
        H1:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        DY:
    }
    private function _processPhoneAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\x65\x72\x5f\x70\150\157\x6e\145", $FA)) {
            goto bX;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, $FA["\x75\163\x65\162\137\x70\x68\x6f\x6e\x65"]);
        $this->sendChallenge('', NULL, NULL, $FA["\x75\163\145\162\x5f\x70\x68\x6f\156\145"], VerificationType::PHONE);
        goto YA;
        bX:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        YA:
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
            goto fp;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        fp:
    }
    private function checkIntegrityAndValidateOTP($FA)
    {
        $this->checkIntegrity($FA);
        $this->validateChallenge($FA["\x6f\164\x70\x54\171\160\145"], NULL, $FA["\x6f\x74\160\137\x74\x6f\x6b\x65\156"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $FA["\157\x74\x70\x54\x79\x70\x65"])) {
            goto Cv;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto uR;
        Cv:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        uR:
    }
    private function checkIntegrity($FA)
    {
        if ($FA["\x6f\x74\160\124\x79\x70\145"] === "\x70\x68\157\x6e\145") {
            goto ke;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $FA["\x75\163\145\x72\137\145\155\141\x69\x6c"])) {
            goto qC;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        qC:
        goto Ww;
        ke:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $FA["\165\x73\145\x72\x5f\x70\x68\x6f\156\x65"])) {
            goto zK;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        zK:
        Ww:
    }
    function processEmail($xW, $Fe, $UD)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL)) {
            goto Fg;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\146\157\162\155\137\146\151\145\154\x64\163"][$Fe])) {
            goto Fx;
        }
        $UD->add_error($xW[$Fe]["\151\x64"], MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        Fx:
        goto Rc;
        Fg:
        $UD->add_error($xW[$Fe]["\151\x64"], MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
        Rc:
    }
    function processPhone($xW, $Fe, $UD)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)) {
            goto gi;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\x66\x6f\x72\155\x5f\x66\x69\145\154\144\x73"][$Fe])) {
            goto AC;
        }
        $UD->add_error($xW[$Fe]["\151\x64"], MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        AC:
        goto HE;
        gi:
        $UD->add_error($xW[$Fe]["\151\x64"], MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
        HE:
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
            goto Lm;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        Lm:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto gZ;
        }
        return;
        gZ:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\145\x6c\x65\x6d\145\156\x74\x6f\x72\x70\x72\157\146\x6f\162\155\137\x65\156\x61\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x65\x6c\x65\x6d\145\x6e\x74\x6f\x72\160\x72\x6f\x66\x6f\x72\155\x5f\x65\156\141\142\x6c\145\137\x74\x79\160\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\x65\x6c\x65\155\145\x6e\x74\x6f\162\160\x72\157\146\157\162\x6d\x73\137\x62\x75\164\164\157\156\x5f\164\145\x78\x74");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\145\x6c\145\155\145\156\x74\x6f\162\x70\x72\157\146\157\x72\155\x5f\145\156\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x65\154\x65\x6d\x65\x6e\164\x6f\x72\160\x72\157\146\x6f\x72\x6d\x5f\145\156\141\142\154\145\x5f\x74\171\x70\145", $this->_otpType);
        update_mo_option("\145\x6c\x65\x6d\x65\x6e\x74\157\162\x70\162\x6f\146\157\162\x6d\x73\x5f\142\x75\x74\164\x6f\156\137\x74\145\170\x74", $this->_buttonText);
        update_mo_option("\145\154\145\x6d\145\x6e\164\x6f\162\160\162\x6f\146\157\x72\x6d\x5f\146\157\x72\155\163", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = [];
        if (array_key_exists("\145\154\x65\x6d\x65\x6e\x74\157\x72\160\x72\157\x66\157\162\x6d\137\x66\x6f\162\x6d", $_POST)) {
            goto Dv;
        }
        return $form;
        Dv:
        foreach (array_filter($_POST["\145\x6c\145\x6d\x65\x6e\x74\x6f\x72\160\x72\x6f\146\x6f\162\x6d\x5f\146\157\x72\155"]["\x66\x6f\x72\x6d"]) as $j1 => $qL) {
            $form[$qL] = array("\145\x6d\x61\x69\x6c\x6b\145\x79" => "\146\x6f\x72\155\x2d\146\x69\x65\154\x64\55" . $_POST["\x65\x6c\145\155\x65\x6e\164\157\x72\x70\162\157\146\x6f\162\x6d\x5f\x66\x6f\x72\155"]["\145\x6d\141\151\154\153\145\x79"][$j1], "\160\150\157\156\145\153\145\x79" => "\146\x6f\x72\x6d\55\x66\x69\x65\154\144\55" . $_POST["\145\154\x65\x6d\145\156\164\x6f\x72\x70\162\x6f\x66\157\x72\x6d\137\x66\x6f\x72\x6d"]["\160\x68\x6f\156\x65\153\x65\171"][$j1], "\x70\x68\x6f\x6e\145\x5f\163\150\x6f\x77" => $_POST["\x65\154\x65\155\x65\156\164\157\162\x70\x72\157\x66\x6f\x72\155\137\x66\157\162\x6d"]["\160\x68\x6f\x6e\x65\x6b\145\x79"][$j1], "\145\155\141\151\154\x5f\163\x68\x6f\x77" => $_POST["\145\x6c\145\x6d\x65\x6e\164\157\162\x70\x72\157\146\157\162\155\x5f\146\x6f\162\x6d"]["\145\x6d\x61\x69\x6c\x6b\x65\171"][$j1]);
            hX:
        }
        F6:
        return $form;
    }
}
