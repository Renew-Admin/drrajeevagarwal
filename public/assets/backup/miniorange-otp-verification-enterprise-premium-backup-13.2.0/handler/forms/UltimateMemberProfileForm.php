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
use UM\Core\Form;
class UltimateMemberProfileForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_verifyFieldKey;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::UM_PROFILE_UPDATE;
        $this->_typePhoneTag = "\x6d\x6f\x5f\165\x6d\137\x70\162\157\x66\151\x6c\x65\x5f\160\150\x6f\156\x65\137\x65\x6e\x61\142\154\x65";
        $this->_typeEmailTag = "\155\x6f\x5f\165\x6d\x5f\160\x72\x6f\146\x69\x6c\x65\x5f\x65\155\x61\151\154\137\145\156\x61\x62\x6c\x65";
        $this->_typeBothTag = "\x6d\157\x5f\x75\155\x5f\x70\x72\x6f\x66\x69\154\145\x5f\x62\x6f\x74\150\x5f\145\156\141\x62\x6c\x65";
        $this->_formKey = "\x55\114\124\x49\115\101\x54\x45\137\120\x52\x4f\106\111\x4c\x45\x5f\x46\117\x52\x4d";
        $this->_verifyFieldKey = "\166\145\162\151\x66\x79\x5f\x66\151\x65\154\144";
        $this->_formName = mo_("\125\154\x74\x69\x6d\x61\164\145\40\x4d\x65\155\x62\145\162\x20\120\162\157\x66\x69\x6c\145\57\x41\143\x63\x6f\165\x6e\164\40\106\x6f\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\x75\x6d\x5f\160\x72\157\x66\x69\x6c\x65\x5f\x65\156\x61\142\x6c\x65");
        $this->_restrictDuplicates = get_mo_option("\x75\x6d\137\160\162\x6f\146\151\154\x65\137\162\145\x73\x74\162\x69\x63\164\x5f\x64\165\x70\x6c\x69\x63\141\x74\x65\x73");
        $this->_buttonText = get_mo_option("\x75\x6d\x5f\x70\x72\x6f\146\151\x6c\145\x5f\x62\165\x74\x74\157\x6e\x5f\164\x65\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\154\151\x63\x6b\x20\110\145\162\x65\x20\164\x6f\40\163\145\x6e\x64\40\x4f\124\120");
        $this->_emailKey = "\165\x73\145\162\x5f\145\x6d\141\151\x6c";
        $this->_phoneKey = get_mo_option("\165\155\x5f\x70\x72\x6f\146\x69\x6c\x65\137\160\x68\x6f\156\145\137\x6b\x65\x79");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\x6d\x6f\142\151\154\145\x5f\x6e\x75\155\x62\145\162";
        $this->_phoneFormId = "\151\156\x70\x75\x74\x5b\156\x61\155\x65\136\x3d\x27{$this->_phoneKey}\47\135";
        $this->_formDocuments = MoOTPDocs::UM_PROFILE;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\x75\x6d\x5f\160\x72\157\146\151\x6c\x65\x5f\x65\156\x61\x62\154\x65\x5f\x74\171\x70\x65");
        add_action("\167\160\137\145\156\x71\x75\145\x75\x65\137\163\x63\x72\151\160\164\x73", array($this, "\155\151\x6e\151\x6f\162\141\156\x67\x65\137\162\145\x67\x69\163\164\145\x72\137\x75\155\137\x73\143\x72\x69\160\x74"));
        add_action("\x75\155\x5f\x73\x75\142\x6d\x69\x74\x5f\x61\143\x63\157\x75\156\164\x5f\145\x72\162\x6f\162\x73\x5f\x68\157\x6f\153", array($this, "\155\151\x6e\x69\x6f\x72\x61\x6e\x67\145\x5f\165\155\x5f\x76\141\x6c\x69\x64\x61\164\x69\157\156"), 99, 1);
        add_action("\x75\155\137\x61\x64\x64\137\145\162\x72\x6f\162\x5f\x6f\156\x5f\x66\x6f\x72\155\x5f\x73\x75\x62\155\x69\164\x5f\x76\141\x6c\x69\x64\x61\x74\151\x6f\x6e", array($this, "\x6d\x69\x6e\151\x6f\162\x61\156\147\145\137\x75\x6d\x5f\x70\162\157\146\151\154\145\137\x76\x61\x6c\x69\144\141\164\151\x6f\x6e"), 1, 3);
        $this->routeData();
    }
    private function isAccountVerificationEnabled()
    {
        return strcasecmp($this->_otpType, $this->_typeEmailTag) == 0 || strcasecmp($this->_otpType, $this->_typeBothTag) == 0;
    }
    private function isProfileVerificationEnabled()
    {
        return strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 || strcasecmp($this->_otpType, $this->_typeBothTag) == 0;
    }
    private function routeData()
    {
        if (array_key_exists("\157\160\x74\151\157\156", $_GET)) {
            goto mF;
        }
        return;
        mF:
        switch (trim($_GET["\157\x70\x74\151\x6f\x6e"])) {
            case "\x6d\151\x6e\x69\157\162\x61\x6e\x67\145\x2d\165\x6d\55\x61\143\143\55\x61\152\141\x78\55\166\145\x72\151\x66\x79":
                $this->sendAjaxOTPRequest();
                goto wX;
        }
        Bx:
        wX:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $wI = MoUtility::sanitizeCheck("\165\x73\145\x72\137\160\x68\x6f\x6e\145", $_POST);
        $p1 = MoUtility::sanitizeCheck("\x75\163\145\x72\137\145\x6d\141\151\x6c", $_POST);
        $gd = MoUtility::sanitizeCheck("\x6f\x74\160\137\162\x65\161\165\145\163\x74\x5f\164\171\160\145", $_POST);
        $this->startOtpTransaction($p1, $wI, $gd);
    }
    private function startOtpTransaction($mo, $NN, $gd)
    {
        if (strcasecmp($gd, $this->_typePhoneTag) == 0) {
            goto GS;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $mo);
        $this->sendChallenge(null, $mo, null, $NN, VerificationType::EMAIL, null, null);
        goto hR;
        GS:
        $this->checkDuplicates($NN, $this->_phoneKey);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $NN);
        $this->sendChallenge(null, $mo, null, $NN, VerificationType::PHONE, null, null);
        hR:
    }
    private function checkDuplicates($qL, $j1)
    {
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($qL, $j1))) {
            goto Yz;
        }
        $bC = MoMessages::showMessage(MoMessages::PHONE_EXISTS);
        wp_send_json(MoUtility::createJson($bC, MoConstants::ERROR_JSON_TYPE));
        Yz:
    }
    private function getUserData($j1)
    {
        $current_user = wp_get_current_user();
        if ($j1 === $this->_phoneKey) {
            goto Mm;
        }
        return $current_user->user_email;
        goto Vq;
        Mm:
        global $wpdb;
        $OY = "\123\x45\114\105\103\124\x20\155\145\x74\x61\x5f\x76\x61\154\165\145\x20\x46\x52\x4f\x4d\40\140{$wpdb->prefix}\165\163\145\x72\x6d\x65\164\x61\140\x20\127\110\105\x52\105\40\x60\x6d\145\164\x61\137\x6b\145\x79\x60\40\x3d\40\47{$j1}\x27\40\101\116\104\40\140\165\x73\145\x72\137\x69\x64\140\40\75\40{$current_user->ID}";
        $le = $wpdb->get_row($OY);
        return isset($le) ? $le->meta_value : '';
        Vq:
    }
    private function checkFormSession($form)
    {
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto DP;
        }
        $form->add_error($this->_emailKey, MoUtility::_get_invalid_otp_method());
        $form->add_error($this->_phoneKey, MoUtility::_get_invalid_otp_method());
        goto th;
        DP:
        $this->unsetOTPSessionVariables();
        th:
    }
    private function getUmFormObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto Jo;
        }
        global $ultimatemember;
        return $ultimatemember->form;
        goto mj;
        Jo:
        return UM()->form();
        mj:
    }
    function isUltimateMemberV2Installed()
    {
        if (!function_exists("\x69\x73\x5f\160\154\x75\x67\x69\x6e\137\x61\143\164\x69\x76\x65")) {
            include_once ABSPATH . "\167\x70\55\x61\x64\155\x69\156\57\151\x6e\x63\x6c\x75\x64\145\163\x2f\x70\x6c\165\x67\x69\x6e\56\160\150\160";
        }
        return is_plugin_active("\x75\x6c\164\x69\x6d\141\x74\145\55\x6d\x65\x6d\142\x65\x72\x2f\165\x6c\164\x69\x6d\141\164\x65\55\155\x65\x6d\x62\145\x72\56\160\x68\x70");
    }
    function isPhoneNumberAlreadyInUse($Dk, $j1)
    {
        global $wpdb;
        MoUtility::processPhoneNumber($Dk);
        $OY = "\x53\x45\x4c\x45\x43\x54\x20\140\165\163\145\x72\137\x69\x64\140\40\106\122\x4f\115\x20\x60{$wpdb->prefix}\x75\x73\x65\x72\x6d\145\x74\x61\140\40\127\x48\105\122\x45\40\x60\x6d\x65\x74\141\x5f\153\145\171\x60\40\x3d\x20\47{$j1}\47\x20\101\x4e\104\x20\x60\155\x65\164\141\137\166\141\154\165\145\140\40\x3d\x20\40\x27{$Dk}\47";
        $le = $wpdb->get_row($OY);
        return !MoUtility::isBlank($le);
    }
    public function miniorange_register_um_script()
    {
        wp_register_script("\155\x6f\x76\x75\155\160\162\157\146\x69\x6c\145", MOV_URL . "\151\156\143\x6c\x75\144\x65\163\x2f\x6a\163\x2f\x6d\x6f\165\155\160\162\157\146\x69\154\x65\56\x6d\151\x6e\x2e\x6a\163", array("\x6a\161\165\x65\162\171"));
        wp_localize_script("\x6d\x6f\166\x75\155\x70\x72\x6f\146\x69\154\145", "\x6d\157\165\155\141\143\166\141\x72", array("\x73\x69\x74\145\x55\x52\114" => site_url(), "\157\164\160\x54\171\160\x65" => $this->_otpType, "\x65\155\141\x69\154\117\x74\160\x54\x79\x70\x65" => $this->_typeEmailTag, "\160\150\x6f\x6e\145\x4f\164\160\124\x79\x70\x65" => $this->_typePhoneTag, "\x62\157\164\150\117\x54\x50\x54\x79\160\x65" => $this->_typeBothTag, "\x6e\x6f\156\143\145" => wp_create_nonce($this->_nonce), "\142\165\x74\164\x6f\x6e\x54\145\170\164" => mo_($this->_buttonText), "\151\155\147\125\122\114" => MOV_LOADER_URL, "\146\157\x72\x6d\x4b\145\x79" => $this->_verifyFieldKey, "\x65\x6d\141\151\154\x56\x61\154\x75\x65" => $this->getUserData($this->_emailKey), "\x70\x68\157\x6e\x65\126\141\154\165\145" => $this->getUserData($this->_phoneKey), "\x70\x68\x6f\x6e\145\113\x65\171" => $this->_phoneKey));
        wp_enqueue_script("\x6d\157\x76\x75\155\x70\162\x6f\146\151\154\x65");
    }
    private function userHasChangeData($uO, $Tw)
    {
        $FA = $this->getUserData($uO);
        return strcasecmp($FA, $Tw[$uO]) !== 0;
    }
    public function miniorange_um_validation($Tw, $uO = "\x75\163\x65\162\x5f\145\x6d\x61\151\x6c")
    {
        if (!(!(isset($_POST["\x5f\x75\155\x5f\x61\143\x63\157\x75\156\164\137\x74\x61\142"]) && sanitize_text_field($_POST["\x5f\x75\155\x5f\x61\x63\143\157\165\156\x74\137\164\x61\x62"]) == "\147\x65\x6e\145\x72\x61\x6c" && isset($_POST["\x75\x73\x65\162\137\x65\155\141\x69\x6c"])) && !isset($_POST["\160\x72\x6f\x66\151\x6c\x65\137\156\x6f\x6e\143\x65"]))) {
            goto zg;
        }
        return;
        zg:
        $y0 = MoUtility::sanitizeCheck("\x6d\157\144\x65", $Tw);
        if (!($this->userHasChangeData($uO, $Tw) && $y0 != "\x72\145\147\151\x73\x74\145\162")) {
            goto H2;
        }
        $form = $this->getUmFormObj();
        if ($this->isValidationRequired($uO) && !SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto rv;
        }
        foreach ($Tw as $j1 => $qL) {
            if ($j1 === $this->_verifyFieldKey) {
                goto UR;
            }
            if ($j1 === $this->_phoneKey) {
                goto jq;
            }
            goto bJ;
            UR:
            $this->checkIntegrityAndValidateOTP($form, $qL, $Tw, $y0);
            goto bJ;
            jq:
            $this->processPhoneNumbers($qL, $form);
            bJ:
            eb:
        }
        XQ:
        goto vm;
        rv:
        $j1 = $this->isProfileVerificationEnabled() && $y0 == "\x70\x72\157\146\x69\154\x65" ? $this->_phoneKey : $this->_emailKey;
        $form->add_error($j1, MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        vm:
        H2:
    }
    private function isValidationRequired($uO)
    {
        return $this->isAccountVerificationEnabled() && $uO === "\x75\163\145\162\137\145\x6d\x61\151\154" || $this->isProfileVerificationEnabled() && $uO === $this->_phoneKey;
    }
    public function miniorange_um_profile_validation($form, $j1, $Tw)
    {
        if (!($j1 === $this->_phoneKey)) {
            goto CB;
        }
        $this->miniorange_um_validation($Tw, $this->_phoneKey);
        CB:
    }
    private function processPhoneNumbers($qL, $form)
    {
        global $phoneLogic;
        if (MoUtility::validatePhoneNumber($qL)) {
            goto Cw;
        }
        $bC = str_replace("\43\x23\160\150\x6f\156\x65\x23\43", $qL, $phoneLogic->_get_otp_invalid_format_message());
        $form->add_error($this->_phoneKey, $bC);
        Cw:
        $this->checkDuplicates($qL, $this->_phoneKey);
    }
    private function checkIntegrityAndValidateOTP($form, $qL, array $Tw, $y0)
    {
        $this->checkIntegrity($form, $Tw);
        if (!($form->count_errors() > 0)) {
            goto nD;
        }
        return;
        nD:
        if ($this->isProfileVerificationEnabled() && $y0 == "\x70\162\x6f\x66\x69\154\x65") {
            goto bL;
        }
        $this->validateChallenge("\145\x6d\x61\x69\x6c", NULL, $qL);
        goto y7;
        bL:
        $this->validateChallenge("\x70\x68\157\156\145", NULL, $qL);
        y7:
        $this->checkFormSession($form);
    }
    private function checkIntegrity($RU, array $Tw)
    {
        if (!$this->isProfileVerificationEnabled()) {
            goto kV;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Tw[$this->_phoneKey])) {
            goto Du;
        }
        $RU->add_error($this->_phoneKey, MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        Du:
        kV:
        if (!$this->isAccountVerificationEnabled()) {
            goto OP;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Tw[$this->_emailKey])) {
            goto rB;
        }
        $RU->add_error($this->_emailKey, MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        rB:
        OP:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    public function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->isProfileVerificationEnabled())) {
            goto n3;
        }
        array_push($kp, $this->_phoneFormId);
        n3:
        return $kp;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Zp;
        }
        return;
        Zp:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\x6d\137\x70\x72\157\x66\x69\x6c\x65\137\x65\156\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\165\x6d\137\x70\x72\x6f\146\x69\154\145\137\x65\156\x61\142\154\145\x5f\x74\x79\160\145");
        $this->_buttonText = $this->sanitizeFormPOST("\x75\x6d\137\160\162\x6f\x66\151\x6c\145\137\x62\x75\164\x74\x6f\156\x5f\x74\x65\x78\x74");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x75\155\x5f\x70\x72\157\x66\x69\x6c\145\137\162\145\x73\x74\x72\x69\143\x74\x5f\144\165\160\154\151\x63\141\164\x65\x73");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\x6d\x5f\160\x72\157\146\151\154\x65\x5f\160\150\x6f\156\145\x5f\x6b\x65\x79");
        if (!$this->basicValidationCheck(BaseMessages::UM_PROFILE_CHOOSE)) {
            goto ql;
        }
        update_mo_option("\165\155\137\x70\x72\x6f\x66\x69\154\x65\x5f\145\x6e\141\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\x75\155\x5f\160\162\157\146\151\x6c\145\137\145\156\141\x62\154\145\x5f\x74\171\x70\145", $this->_otpType);
        update_mo_option("\165\x6d\137\160\162\157\146\x69\x6c\x65\x5f\142\165\164\x74\x6f\156\137\164\x65\x78\x74", $this->_buttonText);
        update_mo_option("\165\x6d\137\160\162\x6f\146\151\x6c\145\x5f\162\x65\x73\x74\x72\x69\143\x74\x5f\x64\x75\x70\x6c\151\x63\x61\x74\145\x73", $this->_restrictDuplicates);
        update_mo_option("\165\155\x5f\x70\162\157\146\x69\x6c\x65\137\160\x68\x6f\156\145\137\x6b\x65\x79", $this->_phoneKey);
        ql:
    }
}
