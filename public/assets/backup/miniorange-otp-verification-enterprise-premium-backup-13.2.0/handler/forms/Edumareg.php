<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class Edumareg extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::EDUMAREG;
        $this->_typePhoneTag = "\155\x6f\x5f\x65\x64\x75\155\x61\x72\x65\147\x5f\160\150\x6f\x6e\x65\137\145\156\x61\x62\x6c\x65";
        $this->_typeEmailTag = "\155\157\137\x65\x64\x75\x6d\x61\x72\x65\147\x5f\x65\x6d\x61\x69\x6c\137\145\x6e\x61\142\x6c\x65";
        $this->_phoneKey = "\x74\x65\x6c\145\160\x68\x6f\156\x65";
        $this->_formKey = "\x45\x44\125\x4d\101\x52\x45\107\x5f\124\110\105\x4d\105";
        $this->_formName = mo_("\x45\x64\165\x6d\x61\x20\x54\x68\x65\155\x65\40\122\x65\147\151\x73\x74\x72\x61\164\151\157\156\40\x46\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\145\144\165\x6d\x61\x72\x65\147\x5f\x65\x6e\141\142\154\x65");
        $this->_phoneFormId = "\43\x70\x68\x6f\156\145\x5f\156\165\x6d\x62\x65\x72\137\x6d\x6f";
        $this->_formDocuments = MoOTPDocs::EDUMA_REG;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\145\x64\x75\155\x61\x72\x65\147\137\x65\x6e\x61\x62\x6c\x65\x5f\x74\x79\160\145");
        add_action("\x72\x65\x67\151\163\164\145\x72\137\x66\x6f\162\x6d", array($this, "\155\x69\x6e\151\x6f\x72\141\156\x67\145\137\141\144\x64\137\x70\150\157\156\145\x66\151\145\154\x64"));
        add_action("\165\163\145\x72\x5f\162\145\x67\x69\x73\164\x65\162", array($this, "\155\151\156\151\157\162\141\156\x67\145\x5f\162\x65\147\x69\x73\x74\162\x61\x74\151\x6f\x6e\x5f\163\141\166\x65"), 10, 1);
        add_filter("\162\x65\x67\151\x73\x74\162\141\x74\x69\x6f\156\137\145\x72\162\157\162\163", array($this, "\x6d\x69\x6e\x69\x6f\162\x61\156\147\x65\x5f\x73\x69\164\x65\137\x72\145\147\x69\x73\164\162\x61\x74\x69\157\x6e\137\x65\162\x72\x6f\162\163"), 99, 3);
    }
    function miniorange_add_phonefield()
    {
        echo "\x3c\151\156\160\x75\164\x20\164\171\x70\145\x3d\x22\150\151\x64\x64\x65\156\x22\40\156\x61\x6d\145\75\42\x72\x65\x67\151\x73\164\x65\x72\x5f\x6e\x6f\x6e\x63\x65\x22\x20\x76\x61\x6c\x75\x65\75\x22\x72\145\x67\151\163\x74\x65\x72\x5f\x6e\157\x6e\x63\x65\42\x2f\x3e";
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto Se;
        }
        echo "\74\160\x3e\x3c\151\x6e\160\165\164\40\164\171\x70\x65\x3d\x22\164\x65\x78\x74\x22\x20\156\x61\155\x65\75\x22\x70\150\x6f\x6e\145\137\156\x75\x6d\x62\x65\162\137\x6d\x6f\42\x20\151\x64\x3d\42\160\x68\157\x6e\x65\x5f\x6e\165\155\142\x65\x72\x5f\155\157\x22\x20\x63\154\x61\163\163\75\x22\x69\x6e\x70\165\x74\x20\162\x65\161\165\151\162\x65\144\42\x20\166\141\x6c\x75\145\75\x22\x22\x20\x70\x6c\x61\x63\145\150\157\154\144\145\x72\75\42\120\150\157\x6e\x65\40\x4e\165\x6d\x62\145\x72\42\x20\163\164\x79\x6c\145\75\x22\42\x2f\x3e\x3c\57\160\76";
        Se:
    }
    function miniorange_registration_save($nL)
    {
        $dI = MoPHPSessions::getSessionVar("\x70\150\157\x6e\145\x5f\x6e\x75\155\x62\145\162\x5f\155\157");
        if (!$dI) {
            goto lX;
        }
        add_user_meta($nL, $this->_phoneKey, $dI);
        lX:
    }
    function miniorange_site_registration_errors(WP_Error $errors, $rs, $p1)
    {
        $NN = isset($_POST["\160\150\157\x6e\145\x5f\156\165\155\x62\145\162\137\x6d\157"]) ? sanitize_text_field($_POST["\x70\x68\x6f\156\x65\x5f\x6e\x75\x6d\142\145\162\137\x6d\x6f"]) : null;
        $this->checkIfPhoneNumberUnique($errors, $NN);
        if (empty($errors->errors)) {
            goto u4;
        }
        return $errors;
        u4:
        if ($this->_otpType) {
            goto YW;
        }
        return $errors;
        YW:
        return $this->startOTPTransaction($rs, $p1, $errors, $NN);
    }
    private function checkIfPhoneNumberUnique(WP_Error &$errors, $NN)
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto O4;
        }
        return;
        O4:
        if (!(MoUtility::isBlank($NN) || !MoUtility::validatePhoneNumber($NN))) {
            goto Qj;
        }
        $errors->add("\151\x6e\166\141\x6c\x69\144\137\x70\150\157\156\x65", MoMessages::showMessage(MoMessages::ENTER_PHONE_DEFAULT));
        Qj:
    }
    function isPhoneNumberAlreadyInUse($Dk, $j1)
    {
        global $wpdb;
        $Dk = MoUtility::processPhoneNumber($Dk);
        $le = $wpdb->get_row("\x53\105\114\x45\103\124\40\x60\165\x73\x65\x72\x5f\x69\144\x60\40\x46\x52\117\x4d\40\x60{$wpdb->prefix}\x75\163\145\x72\155\145\164\141\140\x20\127\110\x45\122\x45\x20\x60\x6d\x65\164\141\137\153\145\x79\140\40\x3d\40\x27{$j1}\47\x20\x41\116\x44\40\140\155\145\164\141\x5f\166\141\154\x75\145\140\40\x3d\x20\40\x27{$Dk}\x27");
        return !MoUtility::isBlank($le);
    }
    function startOTPTransaction($rs, $p1, $errors, $NN)
    {
        if (!(!MoUtility::isBlank(array_filter($errors->errors)) || !isset($_POST["\x72\145\147\x69\163\x74\x65\x72\x5f\x6e\157\156\143\145"]))) {
            goto Wm;
        }
        return $errors;
        Wm:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto Th;
        }
        $this->sendChallenge($rs, $p1, $errors, $NN, VerificationType::EMAIL);
        goto Vn;
        Th:
        $this->sendChallenge($rs, $p1, $errors, $NN, VerificationType::PHONE);
        Vn:
        return $errors;
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        $Bs = $this->getVerificationType();
        $MZ = $Bs === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
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
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto oN;
        }
        array_push($kp, $this->_phoneFormId);
        oN:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto vN;
        }
        return;
        vN:
        $this->_otpType = $this->sanitizeFormPOST("\x65\x64\165\155\141\162\145\147\x5f\x65\x6e\x61\x62\154\145\137\x74\x79\x70\145");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x65\x64\165\x6d\141\162\x65\x67\137\x65\156\x61\x62\154\145");
        update_mo_option("\x65\x64\165\x6d\x61\162\145\x67\x5f\x65\156\141\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\145\x64\165\155\x61\x72\x65\x67\x5f\x65\x6e\141\142\154\145\137\164\x79\x70\145", $this->_otpType);
    }
}
