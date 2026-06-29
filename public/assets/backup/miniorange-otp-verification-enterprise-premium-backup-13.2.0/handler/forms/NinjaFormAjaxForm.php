<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class NinjaFormAjaxForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::NINJA_FORM_AJAX;
        $this->_typePhoneTag = "\x6d\x6f\137\x6e\x69\156\x6a\x61\x5f\146\x6f\162\155\x5f\160\x68\x6f\156\145\x5f\x65\156\141\142\154\145";
        $this->_typeEmailTag = "\x6d\157\137\x6e\x69\x6e\x6a\x61\137\146\157\x72\155\x5f\145\155\141\x69\154\x5f\145\156\x61\142\x6c\145";
        $this->_typeBothTag = "\155\x6f\137\156\x69\x6e\152\141\137\x66\x6f\162\x6d\x5f\142\157\x74\x68\x5f\145\156\141\142\154\145";
        $this->_formKey = "\x4e\x49\x4e\x4a\x41\x5f\106\117\122\x4d\x5f\x41\x4a\x41\130";
        $this->_formName = mo_("\x4e\151\x6e\x6a\141\x20\x46\157\162\x6d\163\40\x28\x20\x41\x62\157\166\x65\40\166\145\x72\x73\151\x6f\156\x20\63\x2e\x30\x20\x29");
        $this->_isFormEnabled = get_mo_option("\156\x6a\141\x5f\x65\156\x61\x62\154\x65");
        $this->_buttonText = get_mo_option("\x6e\x6a\141\137\142\x75\x74\164\157\156\x5f\x74\x65\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\x69\143\153\40\x48\145\162\x65\x20\164\157\40\163\145\156\x64\x20\117\x54\x50");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::NINJA_FORMS_AJAX_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x6e\151\x6e\152\x61\x5f\146\157\x72\155\x5f\x65\x6e\x61\142\x6c\x65\x5f\164\171\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\156\151\x6e\152\141\137\146\x6f\162\155\x5f\x6f\164\160\137\145\x6e\141\x62\x6c\x65\x64"));
        if (!empty($this->_formDetails)) {
            goto nu;
        }
        return;
        nu:
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\151\x6e\160\x75\x74\x5b\151\144\x3d\x6e\146\55\146\151\145\154\x64\55" . $qL["\160\150\157\x6e\x65\153\x65\x79"] . "\135");
            jM:
        }
        bt:
        add_action("\x6e\x69\156\152\x61\137\x66\157\162\x6d\163\x5f\141\146\x74\x65\x72\137\146\x6f\x72\155\x5f\x64\151\x73\x70\x6c\x61\171", array($this, "\x65\156\161\x75\145\165\x65\x5f\156\x6a\137\x66\x6f\162\x6d\x5f\x73\x63\x72\151\x70\164"), 99, 1);
        add_filter("\156\151\x6e\x6a\141\137\146\157\162\x6d\x73\137\x73\165\x62\x6d\151\164\x5f\x64\141\164\141", array($this, "\137\150\141\x6e\x64\154\145\x5f\x6e\152\137\141\152\141\x78\137\x66\157\162\x6d\137\163\165\x62\x6d\151\164"), 99, 1);
        $tA = $this->getVerificationType();
        if (!$tA) {
            goto Xc;
        }
        add_filter("\x6e\151\x6e\152\141\137\146\x6f\162\x6d\x73\137\154\157\143\x61\154\x69\172\x65\x5f\x66\151\145\x6c\x64\x5f\163\x65\164\x74\151\x6e\x67\163\137" . $tA, array($this, "\x5f\141\x64\x64\x5f\142\x75\x74\x74\x6f\156"), 99, 2);
        Xc:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\x74\x69\157\x6e", $_GET)) {
            goto ju;
        }
        return;
        ju:
        switch (trim($_GET["\157\160\x74\151\157\156"])) {
            case "\x6d\x69\x6e\151\157\x72\141\156\147\x65\55\156\x6a\x2d\141\152\x61\170\x2d\x76\145\x72\x69\146\171":
                $this->_send_otp_nj_ajax_verify($_POST);
                goto fb;
        }
        Mx:
        fb:
    }
    function enqueue_nj_form_script($fk)
    {
        if (!array_key_exists($fk, $this->_formDetails)) {
            goto b6;
        }
        $zA = $this->_formDetails[$fk];
        $oa = array_keys($this->_formDetails);
        wp_register_script("\156\152\163\x63\x72\x69\160\x74", MOV_URL . "\151\x6e\143\x6c\165\144\145\x73\57\152\x73\x2f\156\151\156\152\141\x66\x6f\x72\x6d\141\x6a\141\x78\x2e\155\151\x6e\x2e\x6a\163", array("\152\x71\165\x65\x72\x79"), MOV_VERSION, true);
        wp_localize_script("\x6e\x6a\163\143\162\151\x70\164", "\155\x6f\156\151\156\152\x61\x76\x61\x72\163", array("\x69\x6d\147\x55\x52\x4c" => MOV_URL . "\151\x6e\x63\154\x75\x64\145\163\57\151\155\141\147\145\163\x2f\x6c\x6f\141\144\145\162\x2e\147\x69\x66", "\x73\x69\x74\x65\125\122\114" => site_url(), "\157\x74\x70\124\171\x70\x65" => $this->_otpType == $this->_typePhoneTag ? VerificationType::PHONE : VerificationType::EMAIL, "\x66\157\x72\155\163" => $this->_formDetails, "\146\x6f\x72\155\113\145\171\x56\x61\154\163" => $oa));
        wp_enqueue_script("\156\152\163\143\x72\151\160\164");
        b6:
        return $fk;
    }
    function _add_button($CW, $form)
    {
        $zB = $form->get_id();
        if (array_key_exists($zB, $this->_formDetails)) {
            goto S2;
        }
        return $CW;
        S2:
        $zA = $this->_formDetails[$zB];
        $h_ = $this->_otpType == $this->_typePhoneTag ? "\160\150\x6f\x6e\145\x6b\x65\x79" : "\145\x6d\x61\x69\x6c\153\145\171";
        if (!($CW["\x69\144"] == $zA[$h_])) {
            goto Tx;
        }
        $CW["\141\x66\164\x65\x72\106\x69\145\x6c\144"] = "\xd\12\x20\x20\x20\x20\40\x20\40\40\40\x20\x20\x20\x20\40\x20\x20\x3c\x64\151\x76\x20\151\x64\x3d\x22\x6e\x66\55\146\151\145\154\144\55\64\55\x63\157\156\164\141\x69\156\x65\162\42\40\143\x6c\x61\163\x73\x3d\42\x6e\146\55\146\151\145\x6c\144\55\x63\157\156\164\141\151\156\x65\162\40\x73\165\x62\155\x69\164\55\143\157\156\164\141\x69\x6e\145\162\x20\x20\154\141\x62\145\x6c\55\141\x62\x6f\166\145\x20\x22\x3e\xd\xa\x20\40\40\40\40\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\x20\x20\74\144\x69\166\40\x63\x6c\141\x73\163\75\x22\x6e\x66\x2d\x62\145\x66\x6f\x72\x65\x2d\x66\151\x65\x6c\x64\x22\76\xd\xa\x20\x20\x20\x20\40\40\x20\x20\x20\40\40\40\40\x20\40\x20\40\40\x20\40\x20\40\40\40\x3c\x6e\x66\x2d\163\145\x63\164\151\157\x6e\x3e\74\57\x6e\x66\x2d\163\x65\143\164\x69\x6f\x6e\x3e\15\12\x20\40\40\40\40\40\x20\40\x20\40\40\40\40\x20\40\40\40\x20\40\40\x3c\57\144\151\166\x3e\xd\12\x20\x20\40\x20\x20\40\x20\x20\40\40\x20\40\x20\x20\x20\40\40\40\x20\x20\x3c\x64\x69\166\40\x63\x6c\x61\163\x73\x3d\42\x6e\146\x2d\146\x69\x65\154\144\42\76\15\xa\40\40\x20\x20\x20\40\40\x20\x20\40\40\40\40\40\40\x20\40\40\40\x20\x20\40\40\x20\x3c\144\x69\x76\40\x63\x6c\x61\163\163\75\x22\x66\151\145\x6c\144\55\167\x72\141\x70\x20\x73\165\142\155\x69\x74\55\167\162\141\160\x22\x3e\15\xa\40\x20\x20\x20\40\x20\40\40\x20\x20\x20\x20\x20\40\40\x20\40\40\40\40\40\40\x20\40\40\x20\40\40\74\144\x69\x76\40\143\x6c\x61\163\163\x3d\x22\x6e\x66\x2d\x66\151\x65\x6c\x64\x2d\x6c\141\x62\x65\x6c\42\76\74\x2f\144\x69\x76\76\15\xa\x20\40\x20\x20\40\x20\40\x20\x20\40\x20\x20\40\x20\x20\40\40\x20\x20\40\x20\40\x20\40\40\40\40\x20\x3c\144\x69\166\x20\x63\x6c\x61\163\x73\75\42\156\146\x2d\x66\x69\x65\x6c\144\x2d\x65\x6c\x65\x6d\x65\x6e\x74\x22\76\15\xa\40\40\40\x20\40\40\x20\40\x20\x20\40\40\x20\x20\40\x20\40\x20\40\x20\40\x20\40\40\x20\40\40\x20\x20\x20\x20\40\74\x69\x6e\160\165\x74\40\40\x69\x64\x3d\42\155\x69\x6e\x69\x6f\x72\x61\156\147\145\x5f\x6f\164\160\x5f\164\x6f\153\x65\x6e\x5f\163\x75\142\x6d\x69\x74\x5f" . $zB . "\x22\x20\143\x6c\141\x73\163\x3d\x22\x6e\x69\156\152\x61\55\x66\x6f\x72\x6d\x73\55\x66\x69\x65\x6c\144\x20\156\x66\x2d\x65\154\x65\x6d\145\156\164\x22\15\12\40\40\40\x20\x20\40\x20\40\x20\x20\x20\x20\x20\40\x20\40\40\40\40\40\40\x20\40\x20\x20\40\40\x20\40\40\40\40\40\40\x20\x20\x20\x20\x20\x20\x76\x61\154\x75\x65\75\42" . mo_($this->_buttonText) . "\x22\x20\164\x79\x70\x65\75\x22\142\x75\x74\x74\x6f\156\42\76\xd\xa\40\x20\x20\x20\40\40\x20\40\x20\x20\40\40\x20\40\x20\x20\40\x20\40\x20\40\x20\x20\40\x20\x20\40\x20\74\57\144\151\166\76\xd\xa\x20\x20\40\40\40\40\x20\40\40\40\40\x20\x20\40\40\x20\x20\x20\x20\x20\x20\x20\x20\40\74\57\x64\x69\x76\x3e\15\12\40\40\x20\x20\40\40\40\x20\40\40\40\x20\x20\x20\40\x20\x20\40\40\x20\74\57\144\151\166\x3e\xd\xa\40\40\x20\40\40\x20\40\40\x20\x20\x20\x20\x20\40\x20\x20\40\x20\x20\40\74\144\x69\x76\x20\x63\x6c\141\163\163\x3d\42\x6e\146\55\141\x66\x74\x65\162\x2d\x66\x69\145\154\x64\x22\x3e\15\xa\40\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\40\x20\40\x20\40\40\x20\40\40\x20\40\40\40\74\156\146\x2d\163\x65\143\x74\151\x6f\156\76\15\xa\40\40\x20\40\x20\x20\40\x20\40\x20\x20\x20\x20\x20\40\40\x20\x20\40\40\x20\40\40\40\x20\x20\40\40\74\144\x69\x76\40\143\154\141\163\163\75\x22\x6e\146\55\x69\156\160\x75\x74\55\x6c\x69\155\x69\x74\x22\76\74\x2f\x64\151\x76\76\15\12\x20\40\x20\40\40\40\40\x20\40\x20\x20\40\40\40\40\x20\x20\40\40\40\40\40\40\x20\40\40\40\x20\x3c\x64\151\166\40\143\x6c\x61\x73\x73\x3d\x22\156\x66\x2d\145\x72\162\x6f\162\x2d\x77\x72\x61\x70\40\156\x66\x2d\145\x72\x72\157\162\x22\x3e\x3c\57\144\x69\166\x3e\15\xa\x20\x20\x20\x20\x20\x20\40\40\x20\40\40\40\40\40\x20\x20\x20\40\40\x20\x20\x20\x20\40\x3c\57\x6e\146\x2d\163\145\x63\x74\x69\157\156\76\15\xa\40\x20\40\x20\x20\x20\x20\40\x20\x20\x20\40\40\40\x20\x20\x20\x20\40\x20\74\57\x64\151\x76\76\xd\12\x20\x20\40\40\40\x20\40\40\40\x20\40\40\x20\40\40\x20\74\x2f\x64\x69\x76\76\xd\xa\x20\x20\x20\40\40\x20\40\x20\40\40\40\x20\x20\40\40\40\74\144\x69\x76\40\x69\144\75\x22\155\x6f\x5f\x6d\145\x73\163\141\x67\x65\137" . $zB . "\x22\x20\150\x69\x64\x64\x65\156\75\42\x22\40\x73\x74\171\154\145\x3d\x22\x62\x61\x63\x6b\x67\162\x6f\x75\x6e\144\55\x63\157\x6c\x6f\162\x3a\40\x23\x66\67\x66\66\x66\x37\x3b\x70\141\144\x64\151\156\x67\x3a\40\x31\x65\155\40\62\x65\x6d\x20\x31\x65\155\40\63\56\65\145\155\x3b\x22\76\x3c\57\x64\x69\x76\x3e";
        Tx:
        return $CW;
    }
    function _handle_nj_ajax_form_submit($FA)
    {
        if (array_key_exists($FA["\151\x64"], $this->_formDetails)) {
            goto Nx;
        }
        return $FA;
        Nx:
        $zA = $this->_formDetails[$FA["\x69\144"]];
        $FA = $this->checkIfOtpVerificationStarted($zA, $FA);
        if (!isset($FA["\145\162\x72\x6f\162\163"]["\146\151\145\154\144\163"])) {
            goto Mj;
        }
        return $FA;
        Mj:
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto lP;
        }
        $FA = $this->processEmail($zA, $FA);
        lP:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto i0;
        }
        $FA = $this->processPhone($zA, $FA);
        i0:
        if (isset($FA["\x65\x72\x72\157\x72\163"]["\x66\x69\x65\154\x64\163"])) {
            goto Mu;
        }
        $FA = $this->processOTPEntered($FA, $zA);
        Mu:
        return $FA;
    }
    function processOTPEntered($FA, $zA)
    {
        $rM = $zA["\166\x65\x72\x69\146\x79\x4b\145\171"];
        $tA = $this->getVerificationType();
        $this->validateChallenge($tA, NULL, $FA["\146\x69\145\154\x64\x73"][$rM]["\x76\x61\154\165\x65"]);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $tA)) {
            goto YD;
        }
        $this->unsetOTPSessionVariables();
        goto LV;
        YD:
        $FA["\145\x72\162\157\162\x73"]["\146\151\145\x6c\x64\x73"][$rM] = MoUtility::_get_invalid_otp_method();
        LV:
        return $FA;
    }
    function checkIfOtpVerificationStarted($zA, $FA)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto sI;
        }
        return $FA;
        sI:
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0) {
            goto kg;
        }
        $FA["\145\x72\162\x6f\162\163"]["\146\151\x65\154\x64\163"][$zA["\x70\x68\x6f\156\145\153\145\171"]] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        goto fA;
        kg:
        $FA["\145\162\162\157\x72\163"]["\146\151\x65\x6c\144\x73"][$zA["\145\x6d\x61\x69\154\153\145\x79"]] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        fA:
        return $FA;
    }
    function processEmail($zA, $FA)
    {
        $Fe = $zA["\x65\x6d\x61\x69\x6c\x6b\x65\x79"];
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $FA["\x66\151\x65\154\x64\163"][$Fe]["\166\x61\x6c\165\145"])) {
            goto o1;
        }
        $FA["\x65\x72\162\157\x72\x73"]["\146\151\x65\154\x64\163"][$Fe] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        o1:
        return $FA;
    }
    function processPhone($zA, $FA)
    {
        $Fe = $zA["\160\x68\x6f\156\145\153\x65\171"];
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $FA["\146\151\x65\154\144\x73"][$Fe]["\166\x61\x6c\x75\x65"])) {
            goto iM;
        }
        $FA["\x65\162\162\x6f\x72\x73"]["\x66\151\145\154\144\163"][$Fe] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        iM:
        return $FA;
    }
    function _send_otp_nj_ajax_verify($FA)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType == $this->_typePhoneTag) {
            goto T7;
        }
        $this->_send_nj_ajax_otp_to_email($FA);
        goto Cz;
        T7:
        $this->_send_nj_ajax_otp_to_phone($FA);
        Cz:
    }
    function _send_nj_ajax_otp_to_phone($FA)
    {
        if (!array_key_exists("\165\163\x65\x72\137\x70\150\x6f\x6e\x65", $FA) || !isset($FA["\x75\163\x65\x72\x5f\160\150\x6f\156\x65"])) {
            goto so;
        }
        $this->setSessionAndStartOTPVerification(trim($FA["\165\x73\145\162\137\x70\150\157\156\145"]), NULL, trim($FA["\165\163\145\162\x5f\x70\150\157\156\x65"]), VerificationType::PHONE);
        goto Oq;
        so:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        Oq:
    }
    function _send_nj_ajax_otp_to_email($FA)
    {
        if (!array_key_exists("\x75\163\145\162\x5f\145\x6d\141\151\x6c", $FA) || !isset($FA["\165\163\145\162\x5f\x65\x6d\141\151\154"])) {
            goto QW;
        }
        $this->setSessionAndStartOTPVerification($FA["\165\163\145\x72\x5f\x65\155\141\x69\154"], $FA["\x75\x73\x65\162\137\x65\155\x61\151\x6c"], NULL, VerificationType::EMAIL);
        goto DL;
        QW:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        DL:
    }
    function setSessionAndStartOTPVerification($WH, $BO, $dI, $tA)
    {
        if ($tA === VerificationType::PHONE) {
            goto sa;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $WH);
        goto tj;
        sa:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $WH);
        tj:
        $this->sendChallenge('', $BO, NULL, $dI, $tA);
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
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto lu;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        lu:
        return $kp;
    }
    function getFieldId($j0, $FA)
    {
        global $wpdb;
        if (!($FA == "\x65\x6d\141\151\x6c")) {
            goto fE;
        }
        return $wpdb->get_var("\123\x45\114\105\103\124\x20\151\144\x20\x46\x52\117\x4d\x20{$wpdb->prefix}\x6e\x66\63\x5f\x66\x69\x65\x6c\144\x73\x20\167\150\145\x72\x65\x20\x60\160\x61\162\x65\156\164\x5f\x69\x64\140\75\40{$j0}\40\141\x6e\144\x20\x20\140\153\x65\x79\x60\40\75\47" . $FA . "\47");
        fE:
        return $wpdb->get_var("\x53\105\x4c\x45\x43\x54\40\151\144\40\x46\122\x4f\115\x20{$wpdb->prefix}\x6e\x66\63\x5f\x66\x69\x65\154\144\163\x20\167\150\145\162\x65\40\140\x6b\145\x79\140\40\75\47" . $FA . "\47");
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto JH;
        }
        return;
        JH:
        if (!isset($_POST["\155\x6f\x5f\x63\165\163\164\157\x6d\145\x72\x5f\166\141\x6c\x69\x64\141\164\151\x6f\156\x5f\156\x69\x6e\x6a\141\x5f\146\x6f\162\x6d\x5f\x65\x6e\141\142\x6c\145"])) {
            goto eo;
        }
        return;
        eo:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_otpType = $this->sanitizeFormPOST("\x6e\152\141\x5f\x65\x6e\x61\142\x6c\145\137\164\171\x70\145");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x6e\x6a\141\x5f\x65\156\141\x62\154\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\156\x6a\x61\x5f\x62\x75\x74\164\x6f\156\137\x74\145\x78\164");
        update_mo_option("\x6e\x69\156\152\141\x5f\146\x6f\162\155\137\145\x6e\141\142\154\145", 0);
        update_mo_option("\156\152\x61\137\x65\x6e\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x6e\151\x6e\152\x61\x5f\146\157\x72\x6d\137\x65\x6e\141\142\x6c\x65\x5f\164\171\160\x65", $this->_otpType);
        update_mo_option("\156\151\156\x6a\141\137\x66\x6f\162\x6d\137\x6f\164\160\x5f\x65\x6e\141\x62\154\145\x64", maybe_serialize($this->_formDetails));
        update_mo_option("\x6e\152\x61\137\142\165\x74\x74\157\156\137\x74\x65\x78\x74", $this->_buttonText);
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\156\151\156\x6a\141\137\141\x6a\141\x78\x5f\x66\x6f\x72\x6d", $_POST)) {
            goto PH;
        }
        return array();
        PH:
        foreach (array_filter($_POST["\x6e\x69\156\152\141\x5f\x61\x6a\x61\x78\137\x66\x6f\x72\155"]["\x66\157\x72\x6d"]) as $j1 => $qL) {
            $form[sanitize_text_field($qL)] = array("\x65\x6d\x61\x69\x6c\153\145\171" => $this->getFieldId(sanitize_text_field($qL), sanitize_text_field($_POST["\156\151\x6e\152\141\137\141\152\x61\170\137\x66\x6f\162\x6d"]["\145\155\x61\151\x6c\x6b\145\x79"][$j1])), "\x70\x68\157\x6e\x65\153\145\x79" => $this->getFieldId(sanitize_text_field($qL), sanitize_text_field($_POST["\156\x69\x6e\152\141\137\x61\152\141\x78\137\146\x6f\162\x6d"]["\x70\x68\x6f\x6e\145\153\x65\x79"][$j1])), "\166\145\x72\x69\x66\x79\x4b\x65\x79" => $this->getFieldId(sanitize_text_field($qL), sanitize_text_field($_POST["\156\x69\156\x6a\x61\x5f\x61\x6a\141\x78\137\146\157\x72\x6d"]["\166\145\162\x69\146\x79\113\x65\x79"][$j1])), "\160\x68\x6f\156\x65\137\163\150\157\167" => sanitize_text_field($_POST["\156\151\x6e\152\x61\137\x61\152\x61\x78\137\x66\x6f\162\155"]["\160\150\x6f\156\145\x6b\x65\x79"][$j1]), "\145\155\x61\x69\154\x5f\163\x68\x6f\167" => sanitize_text_field($_POST["\156\x69\x6e\x6a\141\137\x61\152\141\x78\x5f\146\157\x72\x6d"]["\145\155\141\x69\154\x6b\x65\171"][$j1]), "\x76\145\162\x69\146\x79\x5f\163\150\x6f\x77" => sanitize_text_field($_POST["\x6e\x69\x6e\x6a\x61\x5f\x61\152\141\170\x5f\146\157\162\155"]["\x76\145\x72\x69\146\171\x4b\x65\x79"][$j1]));
            Vk:
        }
        ok:
        return $form;
    }
}
