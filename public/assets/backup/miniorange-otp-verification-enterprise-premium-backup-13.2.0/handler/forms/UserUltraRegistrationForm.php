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
use XooUserRegister;
use XooUserRegisterLite;
class UserUltraRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::UULTRA_REG;
        $this->_typePhoneTag = "\155\x6f\x5f\x75\x75\x6c\164\162\141\137\x70\150\157\x6e\x65\137\145\x6e\141\x62\x6c\x65";
        $this->_typeEmailTag = "\x6d\x6f\x5f\165\x75\x6c\x74\x72\x61\137\145\x6d\x61\x69\154\137\145\x6e\141\142\x6c\145";
        $this->_typeBothTag = "\155\157\x5f\165\165\154\164\162\141\x5f\x62\x6f\164\x68\137\145\156\x61\142\x6c\x65";
        $this->_formKey = "\125\x55\x4c\124\x52\101\137\106\117\122\x4d";
        $this->_formName = mo_("\125\163\145\162\x20\125\154\164\x72\141\40\122\145\147\x69\163\x74\x72\x61\164\x69\157\x6e\x20\106\x6f\162\155");
        $this->_isFormEnabled = get_mo_option("\x75\165\154\x74\x72\141\137\144\145\146\141\165\x6c\x74\137\145\156\141\x62\154\x65");
        $this->_formDocuments = MoOTPDocs::UULTRA_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_phoneKey = get_mo_option("\x75\x75\x6c\x74\162\141\137\x70\150\x6f\156\x65\x5f\x6b\x65\171");
        $this->_otpType = get_mo_option("\165\165\x6c\164\x72\x61\137\x65\156\x61\142\154\x65\137\164\x79\160\145");
        $this->_phoneFormId = "\x69\x6e\x70\165\x74\133\x6e\x61\x6d\x65\x3d" . $this->_phoneKey . "\135";
        $Bs = $this->getVerificationType();
        if (MoUtility::sanitizeCheck("\170\157\157\x75\163\145\162\x75\154\164\162\141\55\162\x65\147\151\x73\x74\145\162\55\146\x6f\162\x6d", $_POST)) {
            goto NH;
        }
        return;
        NH:
        $Dk = $this->isPhoneVerificationEnabled() ? sanitize_text_field($_POST[$this->_phoneKey]) : NULL;
        $this->_handle_uultra_form_submit(sanitize_text_field($_POST["\x75\163\145\162\x5f\154\x6f\x67\151\156"]), sanitize_email($_POST["\165\163\145\x72\x5f\x65\x6d\141\151\154"]), $Dk);
    }
    function isPhoneVerificationEnabled()
    {
        $Bs = $this->getVerificationType();
        return $Bs == VerificationType::PHONE || $Bs === VerificationType::BOTH;
    }
    function _handle_uultra_form_submit($Rk, $p1, $Dk)
    {
        $UK = class_exists("\130\x6f\157\125\x73\x65\x72\122\x65\147\151\163\164\x65\x72\x4c\151\164\145") ? new XooUserRegisterLite() : new XooUserRegister();
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto ve;
        }
        return;
        ve:
        $UK->uultra_prepare_request($_POST);
        $UK->uultra_handle_errors();
        if (!MoUtility::isBlank($UK->errors)) {
            goto ss;
        }
        $_POST["\156\157\x5f\143\x61\x70\x74\x63\150\141"] = "\171\x65\163";
        $this->_handle_otp_verification_uultra($Rk, $p1, null, $Dk);
        ss:
        return;
    }
    function _handle_otp_verification_uultra($Rk, $p1, $errors, $Dk)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto bN;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto BO;
        }
        $this->sendChallenge($Rk, $p1, $errors, $Dk, VerificationType::EMAIL);
        goto Tq;
        BO:
        $this->sendChallenge($Rk, $p1, $errors, $Dk, VerificationType::BOTH);
        Tq:
        goto cX;
        bN:
        $this->sendChallenge($Rk, $p1, $errors, $Dk, VerificationType::PHONE);
        cX:
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
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto dh;
        }
        array_push($kp, $this->_phoneFormId);
        dh:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto zI;
        }
        return;
        zI:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\165\x6c\164\x72\141\x5f\144\x65\146\x61\x75\x6c\164\137\x65\x6e\141\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x75\165\154\x74\x72\x61\x5f\145\156\x61\142\154\x65\137\x74\171\160\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\x75\x6c\x74\162\x61\x5f\160\150\157\x6e\145\137\146\x69\x65\154\x64\137\x6b\145\171");
        update_mo_option("\x75\165\154\164\x72\141\137\x64\x65\x66\141\165\x6c\164\137\145\156\x61\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\x75\165\154\x74\162\141\x5f\145\156\x61\x62\154\x65\137\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\165\x75\x6c\x74\x72\141\137\160\150\157\156\145\x5f\153\145\x79", $this->_phoneKey);
    }
}
