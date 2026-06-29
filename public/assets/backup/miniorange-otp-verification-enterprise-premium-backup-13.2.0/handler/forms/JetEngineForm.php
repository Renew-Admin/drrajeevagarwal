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
class JetEngineForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::JETENGINEFORM;
        $this->_phoneFormId = array();
        $this->_formKey = "\112\105\124\105\x4e\x47\x49\x4e\105\106\x4f\x52\115";
        $this->_typePhoneTag = "\155\157\x5f\x6a\x65\164\145\x6e\x67\x69\156\x65\146\x6f\162\x6d\x5f\160\150\x6f\156\x65\137\x65\156\141\x62\x6c\145";
        $this->_typeEmailTag = "\155\157\x5f\152\145\164\145\x6e\x67\151\156\145\146\x6f\162\155\137\x65\155\141\x69\154\x5f\145\156\x61\x62\154\145";
        $this->_typeBothTag = "\155\157\137\152\145\164\x65\x6e\x67\x69\x6e\145\x66\157\162\155\x5f\142\157\164\150\x5f\145\x6e\x61\x62\x6c\x65";
        $this->_formName = mo_("\x4a\x65\x74\40\x45\156\x67\151\x6e\x65\x20\x46\x6f\x72\x6d\163");
        $this->_isFormEnabled = get_mo_option("\x6a\145\164\145\156\147\151\156\x65\146\x6f\x72\x6d\x5f\x65\x6e\141\x62\154\x65");
        $this->_buttonText = get_mo_option("\x6a\145\x74\145\156\147\151\x6e\x65\146\x6f\x72\155\163\x5f\x62\165\x74\x74\x6f\x6e\x5f\164\145\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\123\x65\x6e\x64\40\117\124\120");
        $this->_generateOTPAction = "\x6d\x69\156\151\157\162\x61\x6e\147\x65\55\152\x65\164\x65\x6e\147\x69\156\145\x66\157\162\155\55\x73\145\x6e\x64\x2d\x6f\164\x70";
        $this->_validateOTPAction = "\x6d\x69\156\151\x6f\x72\141\156\147\145\x2d\152\145\164\145\156\x67\151\x6e\x65\x66\157\x72\155\55\166\x65\x72\x69\146\x79\55\x63\x6f\x64\145";
        $this->_formDocuments = MoOTPDocs::JETENGINE_FORM_LINK;
        $this->error_message = '';
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x6a\145\x74\145\x6e\x67\x69\156\x65\146\x6f\x72\x6d\x5f\x65\156\x61\x62\154\x65\137\x74\171\160\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x6a\x65\164\x65\x6e\x67\151\156\145\x66\157\x72\155\137\x66\157\x72\155\163"));
        if (!empty($this->_formDetails)) {
            goto Ts;
        }
        return;
        Ts:
        if (!($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag)) {
            goto B2;
        }
        foreach ($this->_formDetails as $j1 => $qL) {
            $this->_formID = $j1;
            array_push($this->_phoneFormId, "\x23\x6a\145\164\x65\x6e\x67\151\x6e\x65\146\157\x72\x6d\163\x2d" . $j1 . "\55\x66\x69\145\x6c\x64\x5f" . $qL["\160\x68\157\156\x65\x6b\x65\x79"]);
            eW:
        }
        Sr:
        B2:
        add_action("\x77\x70\x5f\145\156\161\x75\x65\x75\145\x5f\163\x63\x72\151\160\x74\x73", array($this, "\x6d\157\137\145\156\161\x75\x65\165\145\x5f\x6a\x65\x74\x65\x6e\x67\x69\x6e\145\146\157\162\x6d\x73"));
        add_action("\152\x65\164\x2d\145\x6e\x67\x69\156\145\x2f\x66\x6f\x72\155\163\57\150\141\x6e\x64\x6c\145\162\x2f\142\145\x66\x6f\x72\x65\55\x73\145\156\144", array($this, "\x76\141\154\151\144\141\164\145\x66\x6f\162\x6d"), 1, 1);
        add_filter("\x6a\x65\x74\x2d\x65\x6e\147\x69\156\145\x2f\x66\157\162\x6d\x73\57\x68\141\x6e\144\154\x65\x72\57\161\x75\x65\x72\171\x2d\x61\162\147\163", array($this, "\163\145\164\x65\x72\162\157\x72\163"), 1, 3);
        add_action("\x6a\x65\164\55\x65\x6e\x67\x69\x6e\x65\57\x66\157\162\155\163\x2f\x68\141\156\144\154\145\x72\57\x61\146\x74\145\162\x2d\163\145\156\144", array($this, "\x75\156\x73\145\164\x4f\124\120\x53\145\x73\x73\x69\x6f\x6e\x56\141\162\x69\x61\142\x6c\x65\163"));
        add_action("\x77\160\x5f\141\x6a\141\x78\x5f{$this->_generateOTPAction}", [$this, "\x5f\163\145\156\144\137\157\x74\x70"]);
        add_action("\167\160\x5f\141\152\141\170\x5f\156\157\160\162\x69\x76\137{$this->_generateOTPAction}", [$this, "\137\163\x65\x6e\x64\137\x6f\x74\160"]);
        add_action("\167\160\x5f\141\152\x61\170\137{$this->_validateOTPAction}", [$this, "\x70\162\x6f\143\145\163\x73\106\157\x72\x6d\101\156\144\126\x61\x6c\x69\x64\x61\164\145\117\x54\x50"]);
        add_action("\167\x70\x5f\141\152\x61\170\x5f\156\x6f\160\x72\151\166\x5f{$this->_validateOTPAction}", [$this, "\160\162\x6f\x63\x65\x73\x73\106\x6f\x72\x6d\x41\156\x64\x56\x61\x6c\x69\x64\141\x74\145\117\124\x50"]);
    }
    function seterrors($Uj, $Tw, $form)
    {
        $Uj["\163\x74\141\x74\x75\x73"] = $this->error_message;
        return $Uj;
    }
    function validateform($form)
    {
        $j0 = $this->_formID;
        $zA = $this->_formDetails[$j0];
        if (array_key_exists($j0, $this->_formDetails)) {
            goto r8;
        }
        return;
        r8:
        if (!($this->_otpType === $this->_typeEmailTag)) {
            goto Kj;
        }
        $this->processEmail($zA, $form, $j0);
        Kj:
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto EJ;
        }
        $this->processPhone($zA, $form, $j0);
        EJ:
        if (empty($this->error_message)) {
            goto f6;
        }
        remove_action("\152\145\164\55\x65\156\x67\x69\156\x65\x2f\146\157\x72\155\x73\57\x62\157\157\x6b\x69\x6e\x67\57\x6e\157\x74\151\x66\151\x63\x61\164\x69\157\x6e\57\x72\145\x67\x69\x73\x74\145\x72\x5f\x75\x73\145\162", "\162\x65\x67\151\163\x74\x65\162\137\x75\163\145\162");
        f6:
    }
    function mo_enqueue_jetengineforms()
    {
        wp_register_script("\155\157\152\x65\164\145\156\147\151\x6e\x65\146\157\x72\x6d\x73", MOV_URL . "\x69\156\143\x6c\x75\144\x65\x73\57\x6a\163\x2f\x6d\x6f\x6a\x65\164\145\x6e\x67\x69\156\x65\146\157\x72\x6d\x73\x2e\x6d\x69\156\x2e\152\x73", array("\x6a\161\165\x65\x72\x79"));
        wp_localize_script("\155\157\x6a\x65\164\x65\x6e\x67\x69\156\x65\146\157\x72\x6d\163", "\155\157\x6a\145\x74\145\156\147\151\x6e\x65\x66\157\162\155\x73", array("\x73\151\164\x65\125\122\x4c" => wp_ajax_url(), "\x6f\164\160\x54\x79\160\x65" => $this->ajaxProcessingFields(), "\x66\x6f\162\155\x44\x65\164\141\x69\x6c\163" => $this->_formDetails, "\x62\165\x74\x74\x6f\156\x74\145\x78\164" => $this->_buttonText, "\x76\141\154\x69\144\x61\164\145\x64" => $this->getSessionDetails(), "\x69\x6d\147\125\122\x4c" => MOV_LOADER_URL, "\146\x69\x65\x6c\x64\124\145\170\x74" => mo_("\105\x6e\164\145\162\x20\x4f\x54\x50\40\150\x65\162\x65"), "\147\x6e\157\156\143\x65" => wp_create_nonce($this->_nonce), "\x6e\x6f\x6e\x63\x65\113\145\x79" => wp_create_nonce($this->_nonceKey), "\x76\x6e\157\156\143\145" => wp_create_nonce($this->_nonce), "\x67\x61\143\x74\x69\157\156" => $this->_generateOTPAction, "\x76\141\x63\164\151\x6f\x6e" => $this->_validateOTPAction));
        wp_enqueue_script("\155\x6f\x6a\x65\164\145\x6e\147\x69\156\x65\x66\157\x72\155\x73");
    }
    function getSessionDetails()
    {
        return [VerificationType::EMAIL => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL), VerificationType::PHONE => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)];
    }
    function _send_otp()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ("\155\x6f\x5f\x6a\145\164\145\x6e\x67\151\156\x65\x66\x6f\x72\x6d\137" . $_POST["\x6f\x74\x70\x54\171\160\x65"] . "\x5f\145\156\141\x62\x6c\x65" === $this->_typePhoneTag) {
            goto rJ;
        }
        $this->_processEmailAndSendOTP($_POST);
        goto A5;
        rJ:
        $this->_processPhoneAndSendOTP($_POST);
        A5:
    }
    private function _processEmailAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\x75\x73\145\x72\137\x65\x6d\141\x69\154", $FA)) {
            goto dN;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $FA["\165\x73\145\x72\137\145\155\x61\151\154"]);
        $this->sendChallenge('', $FA["\165\163\145\162\137\x65\155\x61\151\x6c"], NULL, NULL, VerificationType::EMAIL);
        goto SQ;
        dN:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        SQ:
    }
    private function _processPhoneAndSendOTP($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\163\x65\x72\x5f\x70\x68\x6f\x6e\x65", $FA)) {
            goto Lq;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, $FA["\x75\163\145\162\137\x70\x68\x6f\156\145"]);
        $this->sendChallenge('', NULL, NULL, $FA["\165\x73\x65\162\x5f\x70\x68\157\x6e\x65"], VerificationType::PHONE);
        goto mB;
        Lq:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        mB:
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
            goto ob;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        ob:
    }
    private function checkIntegrityAndValidateOTP($FA)
    {
        $this->checkIntegrity($FA);
        $this->validateChallenge($FA["\157\164\x70\x54\171\160\x65"], NULL, $FA["\x6f\x74\160\137\164\157\153\145\156"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $FA["\x6f\x74\160\x54\x79\160\145"])) {
            goto XN;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto Pd;
        XN:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        Pd:
    }
    private function checkIntegrity($FA)
    {
        if ($FA["\x6f\164\x70\124\171\x70\145"] === "\160\x68\x6f\156\145") {
            goto mb;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $FA["\165\163\145\162\137\145\x6d\141\x69\154"])) {
            goto uf;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        uf:
        goto BD;
        mb:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $FA["\165\163\x65\162\x5f\x70\150\x6f\x6e\145"])) {
            goto pp;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        pp:
        BD:
    }
    function processEmail($zA, $form, $j0)
    {
        $Fe = $_POST[$zA["\145\155\141\x69\x6c\x6b\145\171"]];
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL)) {
            goto to;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $ro)) {
            goto Ms;
        }
        $this->error_message = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        $form->redirect(array("\163\x74\141\164\x75\163" => "\146\141\x69\x6c\x65\144"));
        Ms:
        goto JR;
        to:
        $this->error_message = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        $form->redirect(array("\163\164\x61\164\x75\x73" => "\146\x61\x69\x6c\x65\x64"));
        JR:
    }
    function processPhone($zA, $form, $j0)
    {
        $ro = $_POST[$zA["\160\x68\157\x6e\145\x6b\x65\171"]];
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)) {
            goto Wf;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $ro)) {
            goto Y2;
        }
        $this->error_message = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        $form->redirect(array("\x73\164\141\164\x75\163" => "\x66\x61\151\x6c\x65\144"));
        Y2:
        goto tl;
        Wf:
        $this->error_message = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        $form->redirect(array("\x73\164\141\x74\165\163" => "\146\141\151\x6c\145\144"));
        tl:
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
            goto Kh;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        Kh:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto NW;
        }
        return;
        NW:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\152\145\x74\x65\x6e\147\151\x6e\x65\146\x6f\162\x6d\x5f\145\x6e\141\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\152\x65\x74\145\x6e\147\151\156\x65\x66\157\162\155\137\x65\156\141\x62\x6c\x65\137\164\x79\160\145");
        $this->_buttonText = $this->sanitizeFormPOST("\152\x65\x74\x65\x6e\147\151\x6e\x65\146\x6f\162\x6d\163\137\x62\x75\164\164\157\x6e\137\164\145\170\x74");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\152\x65\x74\145\x6e\147\151\156\145\x66\x6f\162\155\137\145\x6e\x61\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\x6a\x65\x74\x65\156\147\x69\156\x65\x66\157\162\155\x5f\x65\x6e\x61\x62\154\145\x5f\164\x79\160\145", $this->_otpType);
        update_mo_option("\152\x65\x74\x65\x6e\x67\x69\156\145\x66\157\x72\x6d\163\137\142\165\164\x74\x6f\156\x5f\x74\145\170\164", $this->_buttonText);
        update_mo_option("\x6a\x65\x74\145\x6e\147\151\x6e\x65\146\157\162\x6d\137\x66\157\x72\x6d\x73", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = [];
        if (array_key_exists("\152\x65\x74\x65\156\x67\x69\x6e\x65\146\x6f\162\x6d\137\146\157\x72\155", $_POST)) {
            goto HI;
        }
        return $form;
        HI:
        foreach (array_filter($_POST["\152\145\x74\145\156\147\151\156\x65\x66\157\x72\155\137\146\157\162\155"]["\x66\157\x72\155"]) as $j1 => $qL) {
            $form[$qL] = array("\145\155\x61\151\x6c\153\145\x79" => $_POST["\152\x65\164\145\156\147\151\156\145\146\x6f\162\x6d\137\x66\157\x72\x6d"]["\x65\x6d\x61\151\154\x6b\145\x79"][$j1], "\160\150\157\x6e\x65\x6b\x65\x79" => $_POST["\x6a\145\164\x65\x6e\x67\151\x6e\145\146\x6f\162\155\137\x66\x6f\x72\x6d"]["\160\150\157\x6e\x65\153\145\x79"][$j1], "\160\150\x6f\156\145\x5f\163\150\x6f\x77" => $_POST["\152\x65\164\x65\x6e\147\x69\x6e\145\146\x6f\x72\155\x5f\146\157\x72\155"]["\x70\150\157\156\145\153\145\x79"][$j1], "\145\155\x61\151\x6c\x5f\x73\x68\x6f\167" => $_POST["\x6a\x65\x74\x65\x6e\147\x69\x6e\x65\x66\x6f\x72\155\137\146\x6f\x72\x6d"]["\x65\155\141\151\x6c\153\x65\171"][$j1]);
            a0:
        }
        l2:
        return $form;
    }
}
