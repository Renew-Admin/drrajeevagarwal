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
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use um\core\Form;
use WP_Error;
class UltimateMemberRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = get_mo_option("\x75\155\137\x69\x73\137\x61\x6a\x61\x78\x5f\146\157\x72\155");
        $this->_formSessionVar = FormSessionVars::UM_DEFAULT_REG;
        $this->_typePhoneTag = "\x6d\x6f\x5f\x75\155\137\160\150\x6f\156\145\x5f\145\156\141\142\154\x65";
        $this->_typeEmailTag = "\155\157\x5f\x75\x6d\x5f\145\155\141\151\154\137\x65\156\141\142\154\x65";
        $this->_typeBothTag = "\x6d\x6f\x5f\165\x6d\137\142\157\x74\150\137\x65\156\141\x62\x6c\x65";
        $this->_phoneKey = get_mo_option("\x75\x6d\x5f\160\x68\157\x6e\145\x5f\x6b\x65\x79");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\155\x6f\142\151\154\145\137\156\x75\x6d\142\x65\162";
        $this->_phoneFormId = "\x69\156\160\x75\x74\133\156\x61\x6d\x65\x5e\x3d\47" . $this->_phoneKey . "\x27\135";
        $this->_formKey = "\125\x4c\x54\x49\x4d\x41\x54\105\x5f\106\117\x52\115";
        $this->_formName = mo_("\125\154\x74\151\x6d\x61\x74\x65\40\115\145\x6d\x62\x65\162\40\x52\x65\147\151\163\x74\162\x61\x74\x69\157\156\x20\x46\x6f\162\155");
        $this->_isFormEnabled = get_mo_option("\165\x6d\137\144\x65\146\141\165\154\164\137\145\156\141\x62\x6c\x65");
        $this->_restrictDuplicates = get_mo_option("\x75\x6d\x5f\x72\x65\163\164\x72\151\143\x74\x5f\x64\x75\160\154\151\x63\x61\x74\145\163");
        $this->_buttonText = get_mo_option("\165\155\137\x62\165\164\x74\157\x6e\x5f\164\x65\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\154\x69\143\153\x20\x48\145\x72\145\40\x74\x6f\40\x73\x65\x6e\144\x20\117\x54\x50");
        $this->_formKey = get_mo_option("\x75\155\x5f\166\145\x72\x69\x66\x79\x5f\x6d\145\164\141\x5f\x6b\x65\x79");
        $this->_formDocuments = MoOTPDocs::UM_ENABLED;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\165\155\x5f\145\x6e\141\x62\x6c\x65\137\x74\x79\160\145");
        if ($this->isUltimateMemberV2Installed()) {
            goto M_;
        }
        add_action("\x75\155\x5f\163\x75\x62\x6d\151\164\x5f\x66\x6f\x72\155\x5f\145\x72\x72\x6f\162\163\x5f\x68\x6f\157\153\x5f", array($this, "\x6d\x69\156\x69\x6f\162\141\x6e\x67\x65\137\x75\155\137\160\150\157\x6e\145\x5f\166\x61\x6c\151\144\x61\164\x69\157\156"), 99, 1);
        add_action("\165\155\137\142\145\146\x6f\x72\145\x5f\156\x65\x77\137\x75\x73\145\162\x5f\x72\145\x67\151\163\x74\145\162", array($this, "\155\151\x6e\x69\157\x72\x61\156\147\145\137\x75\155\x5f\165\x73\145\162\137\x72\145\147\x69\163\164\162\141\164\151\x6f\156"), 99, 1);
        goto v_;
        M_:
        add_action("\x75\155\x5f\x73\165\x62\x6d\151\164\x5f\146\x6f\162\x6d\x5f\x65\162\162\x6f\162\163\137\150\157\157\x6b\137\x5f\x72\145\x67\x69\x73\x74\x72\x61\x74\x69\x6f\x6e", array($this, "\x6d\x69\156\x69\157\162\141\156\x67\x65\x5f\165\x6d\x32\137\160\x68\157\x6e\x65\137\x76\141\x6c\x69\144\x61\164\x69\157\x6e"), 99, 1);
        add_filter("\165\155\137\162\x65\147\x69\x73\x74\162\x61\164\x69\157\156\x5f\165\x73\145\x72\137\x72\157\154\145", array($this, "\x6d\x69\x6e\151\157\162\x61\x6e\147\145\x5f\165\155\x32\137\165\x73\145\162\137\x72\x65\x67\151\163\x74\162\141\164\x69\x6f\x6e"), 99, 2);
        v_:
        if (!($this->_isAjaxForm && $this->_otpType != $this->_typeBothTag)) {
            goto oZ;
        }
        add_action("\x77\x70\x5f\x65\x6e\x71\165\145\x75\145\x5f\x73\x63\x72\x69\x70\x74\163", array($this, "\x6d\151\156\151\157\162\141\156\x67\145\x5f\x72\x65\x67\151\x73\x74\145\162\137\165\155\x5f\x73\x63\x72\151\x70\x74"));
        $this->routeData();
        oZ:
    }
    function isUltimateMemberV2Installed()
    {
        if (!function_exists("\151\163\137\160\154\x75\x67\x69\156\137\141\143\x74\x69\166\145")) {
            include_once ABSPATH . "\x77\160\x2d\x61\x64\155\151\x6e\57\x69\156\x63\x6c\165\144\145\163\x2f\x70\154\x75\147\151\x6e\56\160\x68\x70";
        }
        return is_plugin_active("\x75\x6c\x74\x69\x6d\141\x74\x65\x2d\x6d\x65\x6d\142\145\162\57\165\154\x74\x69\155\x61\x74\x65\x2d\155\x65\x6d\142\x65\x72\x2e\160\x68\x70");
    }
    private function routeData()
    {
        if (array_key_exists("\x6f\160\164\x69\157\x6e", $_GET)) {
            goto eA;
        }
        return;
        eA:
        switch (trim($_GET["\157\160\164\151\x6f\156"])) {
            case "\155\x69\x6e\x69\157\x72\x61\x6e\147\145\55\165\x6d\x2d\x61\152\x61\x78\x2d\x76\x65\x72\151\146\x79":
                $this->sendAjaxOTPRequest();
                goto RP;
        }
        jx:
        RP:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $wI = MoUtility::sanitizeCheck("\x75\163\x65\x72\x5f\160\x68\x6f\156\145", $_POST);
        $p1 = MoUtility::sanitizeCheck("\x75\163\x65\x72\x5f\145\155\141\151\x6c", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto cG;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $p1);
        goto SL;
        cG:
        $this->checkDuplicates($wI, $this->_phoneKey, null);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $wI);
        SL:
        $this->startOtpTransaction(null, $p1, null, $wI, null, null);
    }
    function miniorange_register_um_script()
    {
        wp_register_script("\x6d\x6f\166\165\x6d", MOV_URL . "\151\x6e\143\x6c\165\x64\x65\163\x2f\x6a\x73\57\x75\155\162\x65\147\56\155\x69\156\56\152\163", array("\152\x71\x75\x65\x72\x79"));
        wp_localize_script("\x6d\x6f\166\165\155", "\x6d\157\165\x6d\166\x61\x72", array("\163\151\164\x65\x55\x52\x4c" => site_url(), "\x6f\x74\160\124\171\x70\x65" => $this->_otpType, "\x6e\157\x6e\143\x65" => wp_create_nonce($this->_nonce), "\142\165\x74\164\x6f\156\x74\x65\x78\x74" => mo_($this->_buttonText), "\146\151\145\x6c\144" => $this->_otpType === $this->_typePhoneTag ? $this->_phoneKey : "\x75\x73\145\162\x5f\145\155\x61\x69\x6c", "\151\x6d\147\125\x52\x4c" => MOV_LOADER_URL));
        wp_enqueue_script("\x6d\x6f\166\x75\155");
    }
    function isPhoneVerificationEnabled()
    {
        $Nn = $this->getVerificationType();
        return $Nn === VerificationType::PHONE || $Nn === VerificationType::BOTH;
    }
    function miniorange_um2_user_registration($sl, $Tw)
    {
        $Bs = $this->getVerificationType();
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs)) {
            goto pS;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar) && $this->_isAjaxForm) {
            goto qM;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $Tw = $this->extractArgs($Tw);
        $this->startOtpTransaction($Tw["\165\163\145\162\137\x6c\x6f\147\151\x6e"], $Tw["\165\x73\145\x72\137\x65\155\x61\151\x6c"], new WP_Error(), $Tw[$this->_phoneKey], $Tw["\165\163\x65\x72\137\x70\x61\163\163\x77\157\162\x64"], null);
        goto q5;
        pS:
        $this->unsetOTPSessionVariables();
        return $sl;
        goto q5;
        qM:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        q5:
        return $sl;
    }
    private function extractArgs($Tw)
    {
        return ["\x75\x73\x65\162\137\x6c\157\x67\151\156" => $Tw["\165\x73\x65\162\137\154\157\x67\x69\156"], "\x75\x73\145\162\x5f\x65\155\x61\151\154" => $Tw["\165\163\x65\x72\137\x65\155\141\x69\154"], $this->_phoneKey => $Tw[$this->_phoneKey], "\165\x73\x65\x72\x5f\160\141\163\163\x77\157\x72\144" => $Tw["\165\163\x65\162\137\160\x61\x73\x73\167\x6f\x72\144"]];
    }
    function miniorange_um_user_registration($Tw)
    {
        $errors = new WP_Error();
        MoUtility::initialize_transaction($this->_formSessionVar);
        foreach ($Tw as $j1 => $qL) {
            if ($j1 == "\x75\163\x65\x72\x5f\x6c\x6f\x67\x69\x6e") {
                goto Nk;
            }
            if ($j1 == "\x75\x73\x65\162\137\145\155\x61\x69\x6c") {
                goto f4;
            }
            if ($j1 == "\165\163\145\x72\137\x70\141\x73\163\x77\x6f\162\144") {
                goto iL;
            }
            if ($j1 == $this->_phoneKey) {
                goto E8;
            }
            $ck[$j1] = $qL;
            goto wJ;
            Nk:
            $zC = $qL;
            goto wJ;
            f4:
            $mo = $qL;
            goto wJ;
            iL:
            $iK = $qL;
            goto wJ;
            E8:
            $NN = $qL;
            wJ:
            II:
        }
        D2:
        $this->startOtpTransaction($zC, $mo, $errors, $NN, $iK, $ck);
    }
    function startOtpTransaction($zC, $mo, $errors, $NN, $iK, $ck)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Fd;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto bY;
        }
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::EMAIL, $iK, $ck);
        goto wd;
        Fd:
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::PHONE, $iK, $ck);
        goto wd;
        bY:
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::BOTH, $iK, $ck);
        wd:
    }
    function miniorange_um2_phone_validation($Tw)
    {
        $form = UM()->form();
        foreach ($Tw as $j1 => $qL) {
            if ($this->_isAjaxForm && $j1 === $this->_formKey) {
                goto Sw;
            }
            if ($j1 === $this->_phoneKey) {
                goto CU;
            }
            goto eM;
            Sw:
            $this->checkIntegrityAndValidateOTP($form, $qL, $Tw);
            goto eM;
            CU:
            $this->processPhoneNumbers($qL, $j1, $form);
            eM:
            JD:
        }
        NT:
    }
    private function processPhoneNumbers($qL, $j1, $form = null)
    {
        global $phoneLogic;
        if (MoUtility::validatePhoneNumber($qL)) {
            goto Cj;
        }
        $bC = str_replace("\43\x23\x70\150\x6f\x6e\145\x23\x23", $qL, $phoneLogic->_get_otp_invalid_format_message());
        $form->add_error($j1, $bC);
        Cj:
        $this->checkDuplicates($qL, $j1, $form);
    }
    private function checkDuplicates($qL, $j1, $form = null)
    {
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($qL, $j1))) {
            goto GK;
        }
        $bC = MoMessages::showMessage(MoMessages::PHONE_EXISTS);
        if ($this->_isAjaxForm && SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto NQ;
        }
        $form->add_error($j1, $bC);
        goto uT;
        NQ:
        wp_send_json(MoUtility::createJson($bC, MoConstants::ERROR_JSON_TYPE));
        uT:
        GK:
    }
    private function checkIntegrityAndValidateOTP($form, $qL, array $Tw)
    {
        $Bs = $this->getVerificationType();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto QP;
        }
        $form->add_error($this->_formKey, MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
        return;
        QP:
        $this->checkIntegrity($form, $Tw, $Bs);
        $this->validateChallenge($Bs, NULL, $qL);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs)) {
            goto AJ;
        }
        $form->add_error($this->_formKey, MoUtility::_get_invalid_otp_method());
        AJ:
    }
    private function checkIntegrity($RU, array $Tw, $Bs)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Sg;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto Nz;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Tw["\165\163\145\162\137\145\x6d\141\x69\154"])) {
            goto TO;
        }
        $RU->add_error($this->_formKey, MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        TO:
        Nz:
        goto Ut;
        Sg:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Tw[$this->_phoneKey])) {
            goto SW;
        }
        $RU->add_error($this->_formKey, MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        SW:
        Ut:
    }
    function miniorange_um_phone_validation($Tw)
    {
        global $ultimatemember;
        foreach ($Tw as $j1 => $qL) {
            if ($this->_isAjaxForm && $j1 === $this->_formKey) {
                goto lq;
            }
            if ($j1 === $this->_phoneKey) {
                goto z7;
            }
            goto Le;
            lq:
            $this->checkIntegrityAndValidateOTP($ultimatemember->form, $qL, $Tw);
            goto Le;
            z7:
            $this->processPhoneNumbers($qL, $j1, $ultimatemember->form);
            Le:
            vJ:
        }
        yv:
    }
    function isPhoneNumberAlreadyInUse($Dk, $j1)
    {
        global $wpdb;
        MoUtility::processPhoneNumber($Dk);
        $OY = "\123\105\x4c\x45\103\124\40\140\x75\163\x65\162\x5f\151\x64\x60\x20\106\x52\117\x4d\40\140{$wpdb->prefix}\x75\163\145\162\x6d\x65\x74\x61\140\40\127\x48\105\x52\105\x20\140\x6d\x65\x74\x61\137\x6b\145\171\x60\40\x3d\x20\47{$j1}\x27\x20\x41\116\x44\x20\140\x6d\145\164\x61\137\x76\x61\154\165\x65\140\40\75\x20\40\47{$Dk}\47";
        $le = $wpdb->get_row($OY);
        return !MoUtility::isBlank($le);
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto MI;
        }
        return;
        MI:
        $Bs = $this->getVerificationType();
        $MZ = $Bs === VerificationType::BOTH ? TRUE : FALSE;
        if ($this->_isAjaxForm) {
            goto R6;
        }
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
        R6:
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        if (!function_exists("\x69\x73\137\x70\x6c\165\147\x69\156\x5f\x61\143\x74\x69\166\x65")) {
            include_once ABSPATH . "\x77\160\x2d\141\x64\x6d\x69\156\57\x69\156\143\x6c\165\x64\x65\x73\57\x70\154\x75\147\151\156\x2e\x70\150\x70";
        }
        if ($this->isUltimateMemberV2Installed()) {
            goto m_;
        }
        $this->register_ultimateMember_user($iI, $p1, $iK, $NN, $ck);
        goto Yx;
        m_:
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
        Yx:
    }
    function register_ultimateMember_user($iI, $p1, $iK, $NN, $ck)
    {
        $Tw = array();
        $Tw["\x75\163\x65\162\x5f\x6c\157\x67\151\x6e"] = $iI;
        $Tw["\165\x73\145\162\x5f\x65\x6d\141\x69\x6c"] = $p1;
        $Tw["\x75\x73\x65\x72\137\x70\141\x73\163\167\157\162\144"] = $iK;
        $Tw = array_merge($Tw, $ck);
        $nL = wp_create_user($iI, $iK, $p1);
        $this->unsetOTPSessionVariables();
        do_action("\165\155\137\141\146\164\145\x72\x5f\x6e\145\167\137\165\163\145\162\x5f\x72\x65\x67\151\163\164\145\x72", $nL, $Tw);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto IX;
        }
        array_push($kp, $this->_phoneFormId);
        IX:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Fy;
        }
        return;
        Fy:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\155\137\x64\x65\x66\x61\165\154\164\137\x65\x6e\141\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x75\x6d\137\x65\x6e\x61\142\154\145\x5f\164\171\160\x65");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\165\x6d\137\x72\x65\163\164\162\x69\x63\164\x5f\x64\x75\160\x6c\x69\x63\x61\164\x65\163");
        $this->_isAjaxForm = $this->sanitizeFormPOST("\x75\155\137\x69\163\137\x61\x6a\x61\x78\x5f\x66\157\x72\x6d");
        $this->_buttonText = $this->sanitizeFormPOST("\165\x6d\x5f\x62\165\164\x74\x6f\x6e\137\x74\x65\x78\x74");
        $this->_formKey = $this->sanitizeFormPOST("\x75\155\x5f\166\x65\162\151\x66\x79\x5f\x6d\145\164\x61\x5f\153\x65\x79");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\155\137\x70\x68\157\156\x65\137\x6b\x65\x79");
        if (!$this->basicValidationCheck(BaseMessages::UM_CHOOSE)) {
            goto jF;
        }
        update_mo_option("\x75\x6d\137\x70\150\157\156\x65\x5f\x6b\x65\x79", $this->_phoneKey);
        update_mo_option("\x75\155\137\x64\145\x66\x61\165\154\164\137\145\156\x61\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\165\x6d\137\x65\156\x61\x62\x6c\145\137\164\x79\x70\x65", $this->_otpType);
        update_mo_option("\165\x6d\x5f\x72\x65\163\x74\x72\x69\x63\164\x5f\144\165\x70\154\151\x63\x61\x74\x65\x73", $this->_restrictDuplicates);
        update_mo_option("\165\155\x5f\151\x73\137\141\152\141\170\137\146\x6f\162\155", $this->_isAjaxForm);
        update_mo_option("\x75\155\137\x62\x75\x74\164\x6f\156\137\164\x65\170\x74", $this->_buttonText);
        update_mo_option("\165\x6d\x5f\x76\145\162\151\146\x79\137\155\x65\x74\141\x5f\153\x65\x79", $this->_formKey);
        jF:
    }
}
