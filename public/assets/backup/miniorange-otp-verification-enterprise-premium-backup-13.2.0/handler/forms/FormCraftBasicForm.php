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
class FormCraftBasicForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMCRAFT;
        $this->_typePhoneTag = "\x6d\157\x5f\x66\x6f\x72\155\143\162\141\146\164\137\160\x68\157\x6e\145\137\x65\156\x61\x62\154\x65";
        $this->_typeEmailTag = "\155\x6f\137\146\x6f\x72\155\x63\162\141\x66\x74\x5f\x65\155\x61\151\x6c\137\x65\x6e\x61\142\x6c\145";
        $this->_formKey = "\x46\x4f\x52\x4d\x43\122\101\x46\x54\x42\x41\123\x49\x43";
        $this->_formName = mo_("\106\x6f\x72\155\x43\162\141\x66\164\40\102\x61\163\x69\143\40\x28\106\x72\x65\x65\40\126\x65\x72\163\x69\x6f\x6e\x29");
        $this->_isFormEnabled = get_mo_option("\146\157\x72\155\143\162\141\146\x74\x5f\x65\156\141\142\154\x65");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::FORMCRAFT_BASIC_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        if ($this->isFormCraftPluginInstalled()) {
            goto ja;
        }
        return;
        ja:
        $this->_otpType = get_mo_option("\146\157\x72\x6d\x63\x72\141\x66\164\x5f\145\156\141\142\154\145\137\164\x79\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x66\x6f\162\x6d\x63\x72\141\146\x74\x5f\x6f\164\160\x5f\145\x6e\x61\142\x6c\145\144"));
        if (!empty($this->_formDetails)) {
            goto sn;
        }
        return;
        sn:
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\x5b\144\141\x74\x61\x2d\151\x64\75" . $j1 . "\135\40\x69\x6e\x70\x75\x74\x5b\x6e\x61\x6d\x65\75" . $qL["\160\x68\x6f\156\145\153\x65\x79"] . "\x5d");
            EE:
        }
        aH:
        add_action("\167\160\x5f\141\152\x61\170\137\146\x6f\x72\x6d\x63\x72\x61\146\x74\137\142\x61\x73\x69\143\137\x66\x6f\162\155\137\x73\x75\142\155\151\164", array($this, "\166\x61\x6c\x69\x64\x61\x74\x65\x5f\x66\157\162\x6d\143\162\141\x66\x74\x5f\x66\157\x72\155\x5f\x73\165\x62\x6d\151\164"), 1);
        add_action("\x77\x70\137\x61\152\141\x78\x5f\156\157\160\162\x69\x76\137\146\157\x72\155\x63\x72\x61\x66\x74\x5f\x62\141\x73\151\x63\x5f\x66\x6f\162\x6d\137\163\x75\x62\155\x69\164", array($this, "\166\141\154\151\x64\141\x74\x65\137\146\x6f\x72\155\143\162\141\146\164\x5f\x66\x6f\162\x6d\x5f\x73\165\x62\155\x69\x74"), 1);
        add_action("\x77\x70\x5f\141\x6a\x61\170\x5f\x75\x6e\163\x65\x74\137\146\157\162\x6d\x63\x72\x61\146\x74\137\x62\x61\x73\x69\x63\x5f\x73\x65\x73\x73\x69\x6f\156", array($this, "\x75\x6e\163\145\164\117\x54\x50\123\145\163\163\x69\157\x6e\x56\141\162\x69\141\x62\154\x65\x73"));
        add_action("\167\160\137\x61\x6a\x61\x78\137\156\157\160\162\151\x76\137\x75\x6e\x73\145\x74\137\x66\x6f\162\x6d\143\162\x61\x66\164\137\142\x61\163\x69\143\137\163\145\x73\x73\x69\x6f\x6e", array($this, "\165\156\x73\x65\x74\x4f\124\120\123\x65\x73\x73\x69\157\156\126\141\x72\151\x61\142\154\x65\163"));
        add_action("\167\160\137\145\x6e\161\165\145\165\x65\x5f\x73\x63\x72\x69\x70\164\163", array($this, "\x65\x6e\161\x75\145\x75\x65\x5f\x73\x63\162\x69\160\164\137\157\156\137\x70\141\147\145"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\x70\x74\x69\157\156", $_GET)) {
            goto r0;
        }
        return;
        r0:
        switch (trim($_GET["\x6f\160\x74\x69\157\x6e"])) {
            case "\155\x69\x6e\x69\157\162\141\156\147\145\55\x66\157\x72\155\143\162\141\x66\164\x2d\166\x65\162\x69\146\171":
                $this->_handle_formcraft_form($_POST);
                goto HX;
            case "\x6d\x69\156\151\157\x72\x61\x6e\x67\145\x2d\146\x6f\162\x6d\143\x72\141\x66\164\x2d\x66\x6f\162\155\x2d\157\x74\160\x2d\145\x6e\141\142\154\x65\x64":
                wp_send_json($this->isVerificationEnabledForThisForm(sanitize_text_field($_POST["\x66\x6f\x72\155\x5f\151\144"])));
                goto HX;
        }
        x3:
        HX:
    }
    function _handle_formcraft_form($FA)
    {
        if ($this->isVerificationEnabledForThisForm(sanitize_text_field($_POST["\146\157\x72\155\137\151\144"]))) {
            goto Bi;
        }
        return;
        Bi:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto TT;
        }
        $this->_send_otp_to_email($FA);
        goto VI;
        TT:
        $this->_send_otp_to_phone($FA);
        VI:
    }
    function _send_otp_to_phone($FA)
    {
        if (array_key_exists("\165\163\x65\162\x5f\x70\150\157\156\x65", $FA) && !MoUtility::isBlank($FA["\x75\163\145\x72\x5f\160\150\x6f\156\x65"])) {
            goto CX;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto ol;
        CX:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $FA["\165\x73\x65\x72\x5f\x70\150\157\156\145"]);
        $this->sendChallenge("\x74\x65\163\x74", '', null, trim($FA["\165\163\145\x72\137\160\x68\x6f\156\145"]), VerificationType::PHONE);
        ol:
    }
    function _send_otp_to_email($FA)
    {
        if (array_key_exists("\x75\163\x65\162\137\x65\x6d\x61\151\154", $FA) && !MoUtility::isBlank($FA["\x75\x73\x65\x72\137\x65\x6d\x61\151\154"])) {
            goto wG;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto g9;
        wG:
        SessionUtils::addEmailVerified($this->_formSessionVar, $FA["\x75\x73\x65\162\x5f\x65\x6d\141\151\154"]);
        $this->sendChallenge("\x74\x65\x73\164", $FA["\x75\163\x65\x72\137\145\155\x61\x69\154"], null, $FA["\165\163\145\x72\137\x65\155\x61\x69\x6c"], VerificationType::EMAIL);
        g9:
    }
    function validate_formcraft_form_submit()
    {
        $j0 = sanitize_text_field($_POST["\151\144"]);
        if ($this->isVerificationEnabledForThisForm($j0)) {
            goto a_;
        }
        return;
        a_:
        $this->checkIfVerificationNotStarted($j0);
        $zA = $this->_formDetails[$j0];
        $tA = $this->getVerificationType();
        if ($tA === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($_POST[$zA["\160\150\157\x6e\x65\x6b\x65\x79"]]))) {
            goto AD;
        }
        if ($tA === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_text_field($_POST[$zA["\x65\x6d\141\x69\154\153\x65\x79"]]))) {
            goto Gi;
        }
        goto IA;
        AD:
        $this->sendJSONErrorMessage(["\145\162\162\x6f\162\x73" => [$this->_formDetails[$j0]["\160\x68\x6f\156\145\153\x65\171"] => MoMessages::showMessage(MoMessages::PHONE_MISMATCH)]]);
        goto IA;
        Gi:
        $this->sendJSONErrorMessage(["\145\x72\x72\x6f\162\x73" => [$this->_formDetails[$j0]["\145\x6d\141\151\x6c\x6b\145\171"] => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH)]]);
        IA:
        if (MoUtility::sanitizeCheck($_POST, $zA["\x76\145\x72\151\146\x79\x4b\x65\x79"])) {
            goto Kw;
        }
        $this->sendJSONErrorMessage(["\x65\x72\x72\x6f\x72\x73" => [$this->_formDetails[$j0]["\x76\x65\x72\151\x66\171\113\x65\x79"] => MoUtility::_get_invalid_otp_method()]]);
        Kw:
        SessionUtils::setFormOrFieldId($this->_formSessionVar, $j0);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $tA)) {
            goto yg;
        }
        $this->validateChallenge($tA, NULL, sanitize_text_field($_POST[$zA["\x76\x65\162\151\146\x79\x4b\x65\x79"]]));
        yg:
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\x66\157\162\155\x63\x72\x61\146\164\163\143\162\x69\x70\164", MOV_URL . "\x69\x6e\x63\x6c\165\144\x65\163\57\152\x73\x2f\146\157\162\x6d\x63\162\x61\x66\x74\142\141\x73\x69\143\x2e\x6d\151\156\56\x6a\x73\77\166\x65\x72\163\151\x6f\x6e\x3d" . MOV_VERSION, array("\x6a\161\x75\145\162\171"));
        wp_localize_script("\x66\157\162\x6d\143\162\x61\x66\164\163\143\162\151\x70\x74", "\x6d\x6f\146\x63\166\x61\x72\163", array("\x69\155\147\x55\x52\x4c" => MOV_LOADER_URL, "\x66\157\162\155\103\162\x61\x66\164\x46\157\x72\x6d\x73" => $this->_formDetails, "\163\x69\x74\x65\125\122\114" => site_url(), "\x61\152\141\170\x55\122\x4c" => wp_ajax_url(), "\157\164\160\124\171\x70\x65" => $this->_otpType, "\142\165\164\164\x6f\156\x54\x65\170\x74" => mo_("\x43\x6c\x69\x63\153\x20\x68\145\x72\145\x20\x74\157\x20\x73\145\156\x64\x20\x4f\x54\x50"), "\142\x75\164\164\157\x6e\124\x69\x74\154\145" => $this->_otpType === $this->_typePhoneTag ? mo_("\x50\154\x65\x61\x73\x65\x20\145\x6e\x74\145\x72\40\141\40\120\150\157\x6e\145\x20\x4e\x75\155\x62\145\162\40\164\x6f\40\x65\x6e\141\x62\x6c\145\40\x74\x68\151\163\x20\x66\151\x65\154\144\x2e") : mo_("\120\154\145\x61\x73\145\x20\x65\x6e\x74\x65\x72\40\141\x6e\x20\145\x6d\x61\151\154\x20\x61\144\144\x72\x65\x73\x73\40\x74\x6f\x20\145\x6e\141\x62\x6c\145\40\164\150\x69\163\40\146\151\145\154\144\56"), "\x61\x6a\141\170\x75\x72\154" => wp_ajax_url(), "\x74\x79\x70\x65\x50\x68\157\156\x65" => $this->_typePhoneTag, "\143\x6f\x75\156\164\162\171\x44\x72\157\x70" => get_mo_option("\163\x68\x6f\167\x5f\144\x72\x6f\160\x64\x6f\x77\156\x5f\157\x6e\x5f\x66\157\162\155")));
        wp_enqueue_script("\146\157\162\155\x63\162\141\146\x74\x73\x63\x72\151\x70\164");
    }
    function isVerificationEnabledForThisForm($j0)
    {
        return array_key_exists($j0, $this->_formDetails);
    }
    function sendJSONErrorMessage($errors)
    {
        $aU["\146\x61\x69\154\x65\x64"] = mo_("\120\154\x65\x61\x73\145\40\143\157\x72\x72\145\x63\x74\x20\x74\150\145\40\x65\x72\162\157\x72\163");
        $aU["\x65\162\162\157\x72\163"] = $errors;
        echo json_encode($aU);
        die;
    }
    function checkIfVerificationNotStarted($j0)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto ZL;
        }
        return;
        ZL:
        $AE = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto G4;
        }
        $this->sendJSONErrorMessage(["\x65\162\x72\x6f\162\x73" => [$this->_formDetails[$j0]["\x65\155\x61\x69\x6c\153\x65\x79"] => $AE]]);
        goto Hw;
        G4:
        $this->sendJSONErrorMessage(["\145\x72\162\157\x72\x73" => [$this->_formDetails[$j0]["\160\x68\x6f\156\x65\153\x65\x79"] => $AE]]);
        Hw:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Eb;
        }
        return;
        Eb:
        $dZ = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
        $this->sendJSONErrorMessage(["\x65\162\162\157\162\163" => [$this->_formDetails[$dZ]["\x76\x65\162\x69\x66\x79\x4b\145\x79"] => MoUtility::_get_invalid_otp_method()]]);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
        wp_send_json(MoUtility::createJson("\165\156\x73\x65\164\40\166\141\162\151\x61\x62\x6c\x65\x20\163\x75\143\x63\145\x73\x73", MoConstants::SUCCESS_JSON_TYPE));
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto Hc;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        Hc:
        return $kp;
    }
    function isFormCraftPluginInstalled()
    {
        return MoUtility::getActivePluginVersion("\106\157\x72\155\103\x72\141\146\x74") < 3 ? true : false;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto pj;
        }
        return;
        pj:
        if ($this->isFormCraftPluginInstalled()) {
            goto fB;
        }
        return;
        fB:
        if (array_key_exists("\146\157\x72\x6d\x63\x72\141\146\164\137\146\157\162\155", $_POST)) {
            goto FD;
        }
        return;
        FD:
        foreach (array_filter($_POST["\146\x6f\x72\x6d\x63\162\141\x66\164\x5f\146\157\x72\155"]["\146\157\162\155"]) as $j1 => $qL) {
            $qL = sanitize_text_field($qL);
            $zA = $this->getFormCraftFormDataFromID($qL);
            if (!MoUtility::isBlank($zA)) {
                goto L_;
            }
            goto S0;
            L_:
            $LO = $this->getFieldIDs($_POST, $j1, $zA);
            $form[$qL] = array("\x65\x6d\x61\x69\x6c\x6b\x65\171" => $LO["\145\x6d\141\151\x6c\113\145\x79"], "\x70\x68\x6f\x6e\x65\x6b\x65\171" => $LO["\x70\150\x6f\x6e\145\x4b\x65\171"], "\x76\145\x72\x69\146\x79\113\145\x79" => $LO["\166\x65\162\x69\146\x79\113\145\x79"], "\x70\150\x6f\x6e\x65\x5f\x73\x68\x6f\x77" => sanitize_text_field($_POST["\x66\157\x72\x6d\x63\x72\141\146\x74\137\x66\x6f\162\x6d"]["\x70\x68\157\x6e\x65\x6b\145\x79"][$j1]), "\145\155\x61\151\x6c\x5f\163\x68\x6f\x77" => sanitize_text_field($_POST["\146\x6f\x72\x6d\143\162\x61\146\164\x5f\146\x6f\x72\155"]["\145\x6d\141\x69\154\153\145\x79"][$j1]), "\x76\x65\162\x69\x66\x79\x5f\x73\150\157\x77" => sanitize_text_field($_POST["\x66\157\162\155\x63\x72\141\x66\x74\x5f\146\x6f\162\155"]["\166\145\162\x69\146\171\113\145\171"][$j1]));
            S0:
        }
        jo:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x66\157\162\x6d\143\162\141\146\x74\x5f\x65\x6e\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x66\157\162\155\x63\162\141\146\x74\x5f\x65\156\141\142\154\x65\137\164\x79\x70\x65");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\146\x6f\x72\x6d\x63\x72\141\x66\164\137\145\x6e\x61\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\146\157\x72\x6d\143\162\x61\x66\x74\137\145\x6e\141\142\154\145\137\x74\x79\x70\145", $this->_otpType);
        update_mo_option("\x66\157\x72\155\143\162\x61\146\x74\137\x6f\x74\x70\x5f\145\x6e\141\x62\154\x65\144", maybe_serialize($this->_formDetails));
    }
    private function getFieldIDs($FA, $j1, $zA)
    {
        $LO = array("\x65\x6d\141\x69\154\113\145\x79" => '', "\x70\x68\x6f\156\x65\x4b\x65\171" => '', "\166\x65\x72\151\146\171\x4b\x65\x79" => '');
        if (!empty($FA)) {
            goto WL;
        }
        return $LO;
        WL:
        foreach ($zA as $form) {
            if (!(strcasecmp($form["\145\x6c\145\155\x65\x6e\x74\x44\145\146\x61\165\154\164\163"]["\155\x61\x69\156\x5f\154\x61\142\145\154"], sanitize_text_field($FA["\x66\157\162\x6d\143\162\141\x66\164\137\x66\x6f\x72\155"]["\x65\x6d\x61\151\154\153\145\171"][$j1])) === 0)) {
                goto QL;
            }
            $LO["\x65\x6d\141\151\x6c\113\x65\171"] = $form["\x69\144\145\156\x74\151\x66\151\145\x72"];
            QL:
            if (!(strcasecmp($form["\145\154\x65\x6d\145\x6e\164\x44\145\x66\141\x75\x6c\x74\163"]["\x6d\x61\x69\156\x5f\154\x61\142\145\x6c"], sanitize_text_field($FA["\146\x6f\162\x6d\x63\162\x61\x66\164\x5f\x66\157\x72\155"]["\x70\x68\x6f\156\145\x6b\x65\x79"][$j1])) === 0)) {
                goto t5;
            }
            $LO["\x70\x68\x6f\x6e\145\x4b\145\x79"] = $form["\x69\144\145\156\164\151\x66\151\145\162"];
            t5:
            if (!(strcasecmp($form["\145\154\145\155\x65\x6e\164\104\145\146\x61\x75\x6c\x74\163"]["\155\x61\x69\x6e\137\x6c\141\x62\145\154"], sanitize_text_field($FA["\x66\157\162\x6d\x63\x72\x61\146\164\x5f\x66\x6f\x72\155"]["\x76\x65\x72\151\146\x79\113\145\x79"][$j1])) === 0)) {
                goto Ni;
            }
            $LO["\166\145\x72\x69\x66\x79\x4b\x65\171"] = $form["\x69\144\x65\156\164\x69\x66\151\145\x72"];
            Ni:
            TN:
        }
        np:
        return $LO;
    }
    function getFormCraftFormDataFromID($j0)
    {
        global $wpdb, $forms_table;
        $Tk = $wpdb->get_var("\123\x45\x4c\105\x43\x54\40\x6d\145\164\141\137\142\x75\151\x6c\x64\x65\x72\x20\106\x52\117\115\x20{$forms_table}\x20\x57\x48\x45\122\105\x20\151\x64\75{$j0}");
        $Tk = json_decode(stripcslashes($Tk), 1);
        return $Tk["\146\x69\145\154\144\163"];
    }
}
