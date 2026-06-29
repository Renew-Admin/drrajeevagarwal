<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class WpEmemberForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::EMEMBER;
        $this->_typePhoneTag = "\x6d\157\137\145\155\145\155\x62\x65\x72\137\x70\x68\157\156\x65\137\x65\156\141\142\x6c\x65";
        $this->_typeEmailTag = "\155\157\137\x65\155\145\155\x62\145\162\137\145\155\x61\151\x6c\x5f\x65\x6e\141\x62\x6c\145";
        $this->_typeBothTag = "\x6d\157\x5f\x65\155\145\x6d\142\145\162\x5f\142\x6f\164\150\x5f\x65\x6e\x61\x62\154\x65";
        $this->_formKey = "\x57\120\x5f\x45\115\105\x4d\x42\105\122";
        $this->_formName = mo_("\127\x50\40\x65\x4d\145\155\x62\145\162");
        $this->_isFormEnabled = get_mo_option("\x65\155\x65\x6d\142\145\x72\137\x64\x65\146\x61\x75\154\x74\x5f\x65\x6e\x61\x62\154\x65");
        $this->_phoneKey = "\167\x70\137\145\x6d\145\155\142\x65\x72\137\160\x68\157\156\x65";
        $this->_phoneFormId = "\151\156\160\165\x74\x5b\156\x61\155\x65\x3d" . $this->_phoneKey . "\135";
        $this->_formDocuments = MoOTPDocs::EMEMBER_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\145\155\145\x6d\142\x65\162\137\145\x6e\x61\x62\x6c\145\137\x74\x79\160\x65");
        if (!(array_key_exists("\145\x6d\145\155\142\x65\162\137\144\163\x63\137\x6e\x6f\x6e\x63\x65", $_POST) && !array_key_exists("\x6f\x70\164\151\157\x6e", $_POST))) {
            goto fbH;
        }
        $this->miniorange_emember_user_registration();
        fbH:
    }
    function isPhoneVerificationEnabled()
    {
        $tA = $this->getVerificationType();
        return $tA === VerificationType::PHONE || $tA === VerificationType::BOTH;
    }
    function miniorange_emember_user_registration()
    {
        if (!$this->validatePostFields()) {
            goto ISx;
        }
        $Dk = array_key_exists($this->_phoneKey, $_POST) ? sanitize_text_field($_POST[$this->_phoneKey]) : NULL;
        $this->startTheOTPVerificationProcess(sanitize_text_field($_POST["\167\160\x5f\145\x6d\x65\155\x62\145\162\137\165\x73\x65\x72\x5f\x6e\141\x6d\x65"]), sanitize_email($_POST["\167\x70\137\145\x6d\x65\155\x62\x65\x72\x5f\145\155\x61\x69\x6c"]), $Dk);
        ISx:
    }
    function startTheOTPVerificationProcess($zC, $BO, $Dk)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto tNv;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto oi6;
        }
        $this->sendChallenge($zC, $BO, $errors, $Dk, VerificationType::EMAIL);
        goto yee;
        oi6:
        $this->sendChallenge($zC, $BO, $errors, $Dk, VerificationType::BOTH);
        yee:
        goto R32;
        tNv:
        $this->sendChallenge($zC, $BO, $errors, $Dk, VerificationType::PHONE);
        R32:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        $Bs = $this->getVerificationType();
        $MZ = $Bs === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
    }
    function validatePostFields()
    {
        if (!is_blocked_ip(get_real_ip_addr())) {
            goto vY1;
        }
        return FALSE;
        vY1:
        if (!(emember_wp_username_exists(sanitize_text_field($_POST["\x77\160\137\145\155\145\x6d\142\145\162\137\165\x73\145\x72\x5f\x6e\x61\x6d\145"])) || emember_username_exists(sanitize_text_field($_POST["\167\x70\x5f\145\155\x65\155\142\x65\162\137\165\163\145\162\137\x6e\x61\x6d\x65"])))) {
            goto ni2;
        }
        return FALSE;
        ni2:
        if (!(is_blocked_email($_POST["\167\160\x5f\x65\x6d\145\x6d\x62\x65\x72\137\x65\x6d\x61\151\x6c"]) || emember_registered_email_exists(sanitize_text_field($_POST["\x77\160\137\x65\x6d\x65\155\x62\145\162\x5f\145\155\x61\x69\154"])) || emember_wp_email_exists(sanitize_text_field($_POST["\167\x70\x5f\x65\155\145\155\x62\145\162\137\x65\x6d\141\151\x6c"])))) {
            goto vG9;
        }
        return FALSE;
        vG9:
        if (!(isset($_POST["\x65\x4d\x65\x6d\142\x65\162\x5f\x52\x65\x67\151\x73\164\x65\x72"]) && array_key_exists("\x77\160\137\145\x6d\145\x6d\142\x65\x72\137\160\x77\144\137\x72\145", $_POST) && sanitize_text_field($_POST["\167\160\x5f\145\x6d\145\x6d\x62\x65\x72\x5f\160\x77\144"]) != sanitize_text_field($_POST["\x77\160\137\x65\155\x65\x6d\x62\145\162\137\160\x77\144\137\x72\145"]))) {
            goto ubC;
        }
        return FALSE;
        ubC:
        return TRUE;
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
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto oZ8;
        }
        array_push($kp, $this->_phoneFormId);
        oZ8:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto FEO;
        }
        return;
        FEO:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\145\155\x65\x6d\142\145\x72\137\144\x65\x66\x61\165\x6c\x74\x5f\x65\x6e\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\145\x6d\145\155\142\x65\x72\x5f\x65\x6e\x61\x62\154\145\137\164\171\x70\145");
        update_mo_option("\145\155\145\155\142\145\x72\x5f\x64\x65\146\141\165\154\164\137\145\x6e\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\145\x6d\x65\x6d\x62\145\x72\x5f\145\x6e\x61\142\x6c\x65\137\164\x79\160\145", $this->_otpType);
    }
}
