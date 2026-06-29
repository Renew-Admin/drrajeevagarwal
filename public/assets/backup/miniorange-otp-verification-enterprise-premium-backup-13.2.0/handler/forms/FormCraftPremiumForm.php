<?php


namespace OTP\Handler\Forms;

use mysql_xdevapi\Session;
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
class FormCraftPremiumForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMCRAFT;
        $this->_typePhoneTag = "\x6d\157\137\x66\x6f\162\x6d\x63\x72\x61\146\x74\137\160\150\x6f\156\x65\137\145\156\141\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\157\x5f\x66\x6f\x72\155\143\x72\x61\x66\164\137\145\x6d\141\x69\x6c\137\x65\156\141\142\154\x65";
        $this->_formKey = "\x46\117\x52\115\103\x52\x41\x46\124\x50\x52\x45\x4d\x49\x55\115";
        $this->_formName = mo_("\x46\157\x72\x6d\x43\x72\141\x66\164\x20\50\120\x72\x65\155\x69\165\155\40\126\x65\162\x73\x69\157\156\x29");
        $this->_isFormEnabled = get_mo_option("\x66\143\x70\x72\x65\x6d\151\165\155\x5f\145\x6e\141\x62\x6c\145");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::FORMCRAFT_PREMIUM;
        parent::__construct();
    }
    function handleForm()
    {
        if (MoUtility::getActivePluginVersion("\x46\x6f\x72\x6d\103\162\x61\146\164")) {
            goto fc;
        }
        return;
        fc:
        $this->_otpType = get_mo_option("\146\143\x70\x72\x65\x6d\151\165\155\x5f\145\156\141\142\x6c\145\x5f\x74\171\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x66\x63\x70\162\x65\x6d\x69\165\x6d\x5f\157\164\x70\137\145\156\x61\x62\x6c\145\144"));
        if (!empty($this->_formDetails)) {
            goto AI;
        }
        return;
        AI:
        if ($this->isFormCraftVersion3Installed()) {
            goto Mg;
        }
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\x2e\156\x66\157\162\155\137\x6c\151\40\151\156\160\165\164\x5b\x6e\x61\x6d\145\x5e\x3d" . $qL["\160\150\x6f\x6e\x65\153\145\171"] . "\135");
            Vj:
        }
        rt:
        goto qc;
        Mg:
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\151\x6e\x70\x75\x74\133\156\141\155\145\x5e\x3d" . $qL["\x70\150\x6f\x6e\145\x6b\x65\x79"] . "\135");
            BQ:
        }
        J3:
        qc:
        add_action("\x77\x70\137\141\152\x61\170\137\x66\157\162\x6d\143\x72\x61\146\x74\x5f\163\165\x62\155\151\x74", array($this, "\166\141\154\151\144\x61\x74\145\x5f\146\157\162\x6d\x63\x72\x61\146\x74\x5f\x66\157\162\x6d\x5f\163\x75\142\x6d\151\x74"), 1);
        add_action("\167\x70\137\x61\x6a\x61\x78\x5f\x6e\x6f\160\162\x69\x76\137\x66\x6f\162\x6d\x63\162\x61\146\x74\x5f\x73\x75\x62\155\151\x74", array($this, "\166\141\154\x69\144\x61\164\x65\137\146\x6f\162\155\x63\162\141\146\164\x5f\146\157\162\155\x5f\163\x75\x62\x6d\x69\164"), 1);
        add_action("\x77\x70\137\141\152\141\170\x5f\x66\x6f\x72\155\143\x72\x61\146\x74\x33\137\x66\x6f\162\155\x5f\x73\x75\142\x6d\x69\164", array($this, "\x76\141\x6c\x69\x64\x61\x74\145\x5f\x66\x6f\x72\155\143\162\x61\146\x74\137\x66\157\x72\x6d\x5f\x73\165\x62\x6d\x69\x74"), 1);
        add_action("\x77\160\137\x61\x6a\141\170\137\x6e\157\x70\162\x69\166\137\x66\x6f\x72\x6d\143\x72\x61\146\164\63\137\x66\157\162\155\137\x73\x75\x62\155\151\x74", array($this, "\166\x61\154\151\x64\x61\164\145\x5f\146\157\x72\x6d\143\162\141\146\x74\137\x66\157\162\x6d\x5f\x73\165\x62\155\x69\x74"), 1);
        add_action("\167\160\137\x65\156\161\165\145\165\x65\x5f\163\143\x72\x69\x70\x74\163", array($this, "\x65\156\x71\x75\x65\x75\145\x5f\x73\x63\162\x69\x70\164\x5f\157\x6e\137\x70\x61\147\x65"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\x70\x74\151\157\x6e", $_GET)) {
            goto J1;
        }
        return;
        J1:
        switch (trim($_GET["\x6f\160\x74\x69\x6f\156"])) {
            case "\155\x69\156\x69\x6f\x72\x61\156\x67\x65\55\x66\157\x72\155\x63\x72\141\x66\164\x70\162\145\155\151\165\x6d\x2d\x76\145\162\151\x66\171":
                $this->_handle_formcraft_form($_POST);
                goto Hs;
            case "\x6d\151\156\x69\x6f\162\x61\156\x67\x65\55\146\x6f\162\x6d\143\162\x61\146\x74\160\162\145\x6d\151\x75\x6d\55\146\157\162\x6d\55\x6f\164\x70\55\145\156\x61\142\154\145\144":
                wp_send_json($this->isVerificationEnabledForThisForm(sanitize_text_field($_POST["\146\x6f\162\155\x5f\x69\144"])));
                goto Hs;
        }
        ww:
        Hs:
    }
    function _handle_formcraft_form($FA)
    {
        if ($this->isVerificationEnabledForThisForm(sanitize_text_field($_POST["\146\x6f\162\x6d\x5f\x69\144"]))) {
            goto Mc;
        }
        return;
        Mc:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto ne;
        }
        $this->_send_otp_to_email($FA);
        goto qG;
        ne:
        $this->_send_otp_to_phone($FA);
        qG:
    }
    function _send_otp_to_phone($FA)
    {
        if (array_key_exists("\165\x73\x65\x72\x5f\160\x68\x6f\156\x65", $FA) && !MoUtility::isBlank(sanitize_text_field($FA["\x75\163\145\x72\x5f\x70\x68\x6f\x6e\145"]))) {
            goto ud;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto xb;
        ud:
        SessionUtils::addPhoneVerified($this->_formSessionVar, sanitize_text_field($FA["\165\x73\145\x72\x5f\160\x68\157\156\x65"]));
        $this->sendChallenge("\164\145\x73\164", '', null, trim($FA["\x75\163\145\x72\137\160\150\x6f\x6e\145"]), VerificationType::PHONE);
        xb:
    }
    function _send_otp_to_email($FA)
    {
        if (array_key_exists("\x75\x73\145\x72\x5f\x65\155\141\151\x6c", $FA) && !MoUtility::isBlank(sanitize_email($FA["\x75\x73\x65\162\137\x65\155\x61\x69\x6c"]))) {
            goto SI;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto xJ;
        SI:
        SessionUtils::addEmailVerified($this->_formSessionVar, sanitize_email($FA["\165\163\145\x72\x5f\x65\155\141\151\x6c"]));
        $this->sendChallenge("\x74\x65\x73\164", $FA["\165\x73\145\x72\137\145\155\141\x69\x6c"], null, $FA["\x75\x73\145\x72\x5f\x65\155\141\x69\x6c"], VerificationType::EMAIL);
        xJ:
    }
    function validate_formcraft_form_submit()
    {
        $j0 = sanitize_text_field($_POST["\x69\144"]);
        if ($this->isVerificationEnabledForThisForm($j0)) {
            goto nb;
        }
        return;
        nb:
        $zA = $this->parseSubmittedData($_POST, $j0);
        $this->checkIfVerificationNotStarted($zA);
        $Dk = is_array($zA["\x70\150\x6f\x6e\145"]["\166\141\x6c\165\145"]) ? $zA["\160\150\157\x6e\x65"]["\x76\x61\x6c\165\145"][0] : $zA["\x70\x68\x6f\x6e\145"]["\x76\141\154\x75\x65"];
        $mo = is_array($zA["\145\x6d\x61\x69\154"]["\x76\141\154\x75\145"]) ? $zA["\x65\x6d\141\151\154"]["\x76\141\154\165\145"][0] : $zA["\145\155\x61\151\154"]["\166\x61\154\165\145"];
        $iF = is_array($zA["\x6f\x74\x70"]["\x76\x61\x6c\165\x65"]) ? $zA["\157\164\160"]["\166\141\x6c\165\x65"][0] : $zA["\157\164\x70"]["\x76\x61\154\165\x65"];
        $tA = $this->getVerificationType();
        if ($tA === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Dk)) {
            goto nA;
        }
        if ($tA === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $mo)) {
            goto Kr;
        }
        goto Os;
        nA:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), $zA["\160\150\x6f\156\145"]["\x66\x69\145\154\x64"]);
        goto Os;
        Kr:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), $zA["\x65\155\141\x69\154"]["\x66\151\x65\x6c\x64"]);
        Os:
        if (!MoUtility::isBlank($zA["\157\x74\x70"]["\166\141\154\x75\x65"])) {
            goto BV;
        }
        $this->sendJSONErrorMessage(MoUtility::_get_invalid_otp_method(), $zA["\x6f\x74\160"]["\x66\151\x65\x6c\144"]);
        BV:
        SessionUtils::setFormOrFieldId($this->_formSessionVar, $zA["\157\164\160"]["\x66\151\x65\x6c\x64"]);
        $this->validateChallenge($tA, NULL, $iF);
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\146\x63\x70\x72\x65\x6d\x69\165\x6d\163\143\162\x69\160\x74", MOV_URL . "\151\x6e\x63\x6c\165\x64\145\163\x2f\x6a\163\57\146\157\x72\155\143\162\x61\146\164\160\162\145\x6d\x69\x75\155\56\155\151\156\x2e\x6a\x73\x3f\x76\145\162\163\151\157\156\75" . MOV_VERSION, array("\152\x71\165\145\x72\171"));
        wp_localize_script("\x66\143\160\162\145\x6d\151\165\155\163\143\162\x69\x70\x74", "\155\157\146\x63\160\166\x61\x72\163", array("\x69\x6d\x67\125\122\x4c" => MOV_LOADER_URL, "\x66\157\x72\x6d\103\162\x61\x66\x74\106\x6f\x72\155\163" => $this->_formDetails, "\x73\x69\164\145\x55\x52\x4c" => site_url(), "\x6f\164\x70\124\x79\160\x65" => $this->_otpType, "\x62\165\164\164\157\156\x54\145\x78\x74" => mo_("\x43\154\x69\143\x6b\x20\150\x65\x72\x65\40\164\157\x20\x73\x65\x6e\x64\40\117\x54\x50"), "\142\165\x74\164\157\x6e\x54\151\164\154\145" => $this->_otpType == $this->_typePhoneTag ? mo_("\120\154\x65\141\163\145\x20\x65\x6e\164\x65\162\x20\141\40\120\150\x6f\156\x65\40\116\165\155\142\145\x72\40\x74\x6f\x20\145\x6e\141\142\x6c\x65\40\164\x68\x69\x73\40\x66\151\145\x6c\x64\56") : mo_("\120\x6c\145\x61\x73\145\x20\x65\x6e\x74\x65\x72\x20\x61\x6e\40\x65\155\141\x69\x6c\40\141\144\144\x72\x65\x73\x73\x20\164\157\x20\145\156\141\x62\154\145\x20\164\150\x69\163\x20\146\x69\x65\x6c\144\56"), "\x61\152\x61\170\x75\162\x6c" => wp_ajax_url(), "\164\171\160\x65\120\150\157\x6e\145" => $this->_typePhoneTag, "\143\x6f\x75\156\x74\162\x79\x44\x72\157\160" => get_mo_option("\x73\150\x6f\167\137\x64\162\157\160\144\157\x77\156\x5f\x6f\x6e\137\x66\x6f\x72\x6d"), "\x76\x65\162\x73\x69\157\156\x33" => $this->isFormCraftVersion3Installed()));
        wp_enqueue_script("\146\143\160\x72\x65\155\151\165\x6d\163\143\162\151\x70\164");
    }
    function parseSubmittedData($post, $j0)
    {
        $FA = array();
        $form = $this->_formDetails[$j0];
        foreach ($post as $j1 => $qL) {
            if (!(strpos($j1, "\146\x69\145\154\144") === FALSE)) {
                goto nr;
            }
            goto z5;
            nr:
            $this->getValueAndFieldFromPost($FA, "\145\x6d\x61\x69\x6c", $j1, str_replace("\40", "\x5f", $form["\145\155\x61\151\x6c\x6b\145\171"]), $qL);
            $this->getValueAndFieldFromPost($FA, "\160\x68\157\156\x65", $j1, str_replace("\x20", "\137", $form["\160\x68\x6f\x6e\145\153\145\x79"]), $qL);
            $this->getValueAndFieldFromPost($FA, "\157\164\x70", $j1, str_replace("\x20", "\137", $form["\x76\x65\162\151\x66\x79\113\145\171"]), $qL);
            z5:
        }
        Qc:
        return $FA;
    }
    function getValueAndFieldFromPost(&$FA, $zJ, $Q4, $Dz, $qL)
    {
        if (!(is_null($FA[$zJ]) && strpos($Q4, $Dz, 0) !== FALSE)) {
            goto r_;
        }
        $FA[$zJ]["\x76\141\x6c\x75\145"] = $this->isFormCraftVersion3Installed() && $zJ == "\x6f\164\160" ? $qL[0] : $qL;
        $yP = strpos($Q4, "\x66\151\x65\154\x64", 0);
        $FA[$zJ]["\146\x69\145\154\x64"] = $this->isFormCraftVersion3Installed() ? $Q4 : substr($Q4, $yP, strpos($Q4, "\x5f", $yP) - $yP);
        r_:
    }
    function isVerificationEnabledForThisForm($j0)
    {
        return array_key_exists($j0, $this->_formDetails);
    }
    function sendJSONErrorMessage($errors, $QO)
    {
        if ($this->isFormCraftVersion3Installed()) {
            goto Ok;
        }
        $aU["\x65\x72\162\157\162\163"] = mo_("\x50\x6c\x65\141\163\145\40\x63\157\x72\162\145\143\164\40\x74\x68\x65\x20\x65\162\162\157\x72\x73\x20\x61\x6e\x64\x20\164\x72\171\x20\x61\147\141\151\156");
        $aU[$QO][0] = $errors;
        goto eS;
        Ok:
        $aU["\x66\141\x69\x6c\x65\x64"] = mo_("\x50\154\145\x61\x73\145\40\143\157\x72\x72\145\x63\x74\40\x74\150\x65\40\145\x72\162\x6f\162\x73\40\141\156\x64\x20\x74\x72\x79\40\141\147\x61\x69\x6e");
        $aU["\x65\162\x72\157\162\x73"][$QO] = $errors;
        eS:
        echo json_encode($aU);
        die;
    }
    function checkIfVerificationNotStarted($zA)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Y9;
        }
        return;
        Y9:
        if ($this->_otpType == $this->_typePhoneTag) {
            goto uv;
        }
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), $zA["\145\155\141\x69\x6c"]["\146\x69\145\154\144"]);
        goto ht;
        uv:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), $zA["\160\x68\157\156\145"]["\x66\151\x65\154\144"]);
        ht:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto y5;
        }
        return;
        y5:
        $fk = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $this->sendJSONErrorMessage(MoUtility::_get_invalid_otp_method(), $fk);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        $this->unsetOTPSessionVariables();
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto yU;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        yU:
        return $kp;
    }
    function getFieldId($FA, $zA)
    {
        foreach ($zA as $form) {
            if (!($form["\x65\154\x65\155\145\x6e\x74\x44\x65\x66\141\x75\154\164\163"]["\155\141\151\x6e\x5f\154\x61\x62\x65\x6c"] == $FA)) {
                goto E1;
            }
            return $form["\x69\x64\145\x6e\x74\151\146\x69\145\x72"];
            E1:
            WT:
        }
        Mi:
        return NULL;
    }
    function getFormCraftFormDataFromID($j0)
    {
        global $wpdb, $QE;
        $Tk = $wpdb->get_var("\x53\x45\114\x45\x43\124\x20\x6d\x65\164\141\137\x62\165\151\x6c\x64\145\x72\40\106\x52\x4f\115\40{$QE}\40\127\110\105\122\105\x20\x69\x64\x3d{$j0}");
        $Tk = json_decode(stripcslashes($Tk), 1);
        return $Tk["\x66\151\x65\154\x64\x73"];
    }
    function isFormCraftVersion3Installed()
    {
        return MoUtility::getActivePluginVersion("\106\157\162\x6d\x43\162\x61\x66\x74") == 3 ? true : false;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto zR;
        }
        return;
        zR:
        if (MoUtility::getActivePluginVersion("\106\x6f\162\155\103\162\141\146\x74")) {
            goto iZ;
        }
        return;
        iZ:
        $form = array();
        foreach (array_filter($_POST["\x66\x63\x70\x72\x65\155\x69\x75\x6d\x5f\146\x6f\162\155"]["\146\x6f\162\155"]) as $j1 => $qL) {
            $qL = sanitize_text_field($qL);
            !$this->isFormCraftVersion3Installed() ? $this->processAndGetFormData($_POST, $j1, $qL, $form) : $this->processAndGetForm3Data($_POST, $j1, $qL, $form);
            jH:
        }
        g7:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\146\143\x70\162\145\155\x69\x75\x6d\137\x65\x6e\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\146\143\x70\x72\145\155\151\x75\155\x5f\145\x6e\141\x62\154\145\137\x74\x79\160\x65");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\146\x63\160\162\x65\155\151\165\x6d\137\145\x6e\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\146\x63\x70\162\x65\x6d\151\165\x6d\137\145\x6e\141\x62\x6c\145\137\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\146\143\x70\x72\145\x6d\151\x75\155\x5f\x6f\x74\x70\137\145\156\x61\142\x6c\x65\x64", maybe_serialize($this->_formDetails));
    }
    function processAndGetFormData($post, $j1, $qL, &$form)
    {
        $form[$qL] = array("\x65\x6d\141\x69\x6c\x6b\145\x79" => str_replace("\x20", "\x20", sanitize_text_field($post["\146\x63\x70\162\x65\155\151\x75\155\137\x66\x6f\162\155"]["\x65\x6d\x61\x69\x6c\x6b\145\x79"][$j1])) . "\x5f\x65\155\141\151\154\x5f\x65\x6d\x61\151\x6c\137", "\160\150\157\156\x65\x6b\145\171" => str_replace("\x20", "\x20", sanitize_text_field($post["\x66\x63\x70\x72\145\155\151\x75\x6d\x5f\x66\x6f\x72\155"]["\160\x68\x6f\x6e\x65\x6b\x65\171"][$j1])) . "\137\x74\145\170\x74\137", "\x76\x65\162\151\146\x79\x4b\x65\171" => str_replace("\40", "\x20", sanitize_text_field($post["\146\x63\160\x72\x65\155\x69\x75\x6d\137\x66\157\x72\155"]["\x76\145\x72\x69\146\171\113\145\171"][$j1])) . "\137\164\145\170\x74\137", "\x70\x68\x6f\x6e\145\x5f\163\150\157\167" => sanitize_text_field($post["\x66\143\x70\162\145\x6d\151\165\155\x5f\146\x6f\x72\155"]["\x70\150\157\156\x65\x6b\x65\x79"][$j1]), "\145\155\x61\151\154\137\163\x68\157\x77" => sanitize_text_field($post["\x66\x63\160\x72\x65\x6d\151\165\x6d\137\x66\157\x72\155"]["\x65\155\141\x69\154\x6b\145\x79"][$j1]), "\x76\x65\162\x69\x66\x79\x5f\x73\x68\157\167" => sanitize_text_field($post["\x66\x63\x70\162\145\155\151\x75\155\137\146\x6f\162\155"]["\166\x65\162\x69\x66\171\113\145\x79"][$j1]));
    }
    function processAndGetForm3Data($post, $j1, $qL, &$form)
    {
        $zA = $this->getFormCraftFormDataFromID($qL);
        if (!MoUtility::isBlank($zA)) {
            goto qt;
        }
        return;
        qt:
        $form[$qL] = array("\145\155\141\151\154\x6b\x65\x79" => $this->getFieldId(sanitize_text_field($post["\x66\x63\160\162\145\155\151\x75\x6d\x5f\x66\157\162\x6d"]["\x65\x6d\x61\x69\154\x6b\145\x79"][$j1]), $zA), "\x70\x68\x6f\156\x65\153\145\171" => $this->getFieldId(sanitize_text_field($post["\146\x63\160\x72\145\155\x69\165\x6d\x5f\x66\x6f\x72\155"]["\x70\x68\157\156\x65\x6b\145\171"][$j1]), $zA), "\166\x65\162\x69\x66\x79\113\x65\x79" => $this->getFieldId(sanitize_text_field($post["\x66\x63\x70\x72\145\155\151\165\x6d\x5f\146\x6f\162\x6d"]["\166\145\x72\151\x66\x79\x4b\145\171"][$j1]), $zA), "\160\150\157\156\x65\137\163\x68\157\x77" => sanitize_text_field($post["\x66\x63\160\162\x65\155\x69\165\155\x5f\x66\157\x72\155"]["\x70\x68\x6f\156\x65\153\145\171"][$j1]), "\x65\x6d\141\151\x6c\x5f\163\150\157\167" => sanitize_text_field($post["\x66\143\160\162\145\x6d\x69\165\x6d\137\146\x6f\162\x6d"]["\145\155\x61\x69\154\x6b\145\171"][$j1]), "\x76\x65\162\151\x66\x79\x5f\163\x68\x6f\x77" => sanitize_text_field($post["\x66\143\x70\162\x65\x6d\x69\165\155\x5f\x66\157\162\x6d"]["\x76\145\162\x69\146\171\113\x65\171"][$j1]));
    }
}
