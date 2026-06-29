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
class ProfileBuilderRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PB_DEFAULT_REG;
        $this->_typePhoneTag = "\x6d\x6f\137\160\142\x5f\160\x68\157\156\145\x5f\x65\x6e\141\142\154\145";
        $this->_typeEmailTag = "\x6d\157\137\x70\142\137\x65\x6d\141\151\x6c\x5f\x65\156\x61\142\x6c\x65";
        $this->_typeBothTag = "\155\157\137\160\142\x5f\142\x6f\x74\x68\137\145\156\x61\142\154\145";
        $this->_formKey = "\120\x42\x5f\x44\105\x46\101\x55\x4c\x54\137\106\x4f\x52\115";
        $this->_formName = mo_("\x50\x72\x6f\146\x69\154\145\x20\x42\165\x69\x6c\x64\x65\x72\40\122\x65\x67\151\163\x74\162\141\x74\151\x6f\x6e\40\106\157\162\155");
        $this->_isFormEnabled = get_mo_option("\160\x62\137\x64\145\146\141\x75\154\164\137\x65\156\x61\142\x6c\x65");
        $this->_formDocuments = MoOTPDocs::PB_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\160\142\x5f\x65\x6e\x61\142\154\145\137\164\x79\x70\x65");
        $this->_phoneKey = get_mo_option("\x70\142\137\160\x68\157\156\145\137\x6d\x65\x74\x61\137\153\x65\171");
        $this->_phoneFormId = "\x69\x6e\160\x75\164\133\x6e\141\x6d\x65\x3d" . $this->_phoneKey . "\135";
        add_filter("\x77\160\160\x62\x5f\x6f\165\164\x70\x75\x74\137\146\151\145\x6c\144\137\145\x72\162\x6f\162\x73\137\x66\x69\154\164\x65\162", array($this, "\x66\x6f\162\155\142\165\x69\154\144\145\x72\x5f\163\151\164\145\x5f\x72\x65\147\151\163\x74\x72\141\x74\151\157\x6e\x5f\x65\162\x72\x6f\x72\x73"), 99, 4);
    }
    function isPhoneVerificationEnabled()
    {
        $Bs = $this->getVerificationType();
        return $Bs === VerificationType::PHONE || $Bs === VerificationType::BOTH;
    }
    function formbuilder_site_registration_errors($e5, $Yb, $LP, $zb)
    {
        if (empty($e5)) {
            goto Ee;
        }
        return $e5;
        Ee:
        if (!($LP["\141\x63\x74\x69\x6f\x6e"] == "\x72\145\x67\x69\163\164\145\162")) {
            goto wc;
        }
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto AE;
        }
        $this->unsetOTPSessionVariables();
        return $e5;
        AE:
        $this->startOTPVerificationProcess($e5, $LP);
        wc:
        return $e5;
    }
    function startOTPVerificationProcess($e5, $FA)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $Tw = $this->extractArgs($FA, $this->_phoneKey);
        $this->sendChallenge($Tw["\x75\x73\145\162\x6e\x61\x6d\x65"], $Tw["\x65\x6d\x61\151\x6c"], new WP_Error(), $Tw["\x70\150\x6f\156\x65"], $this->getVerificationType(), $Tw["\160\141\163\x73\167\x31"], array());
    }
    private function extractArgs($Tw, $Z1)
    {
        return ["\165\x73\145\162\156\141\x6d\x65" => $Tw["\165\x73\145\x72\156\141\x6d\x65"], "\145\155\141\x69\x6c" => $Tw["\145\x6d\x61\151\154"], "\160\141\x73\x73\167\x31" => $Tw["\x70\x61\163\163\x77\x31"], "\x70\x68\157\156\x65" => MoUtility::sanitizeCheck($Z1, $Tw)];
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $this->getVerificationType(), FALSE);
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
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto pX;
        }
        array_push($kp, $this->_phoneFormId);
        pX:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto eK;
        }
        return;
        eK:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\160\142\137\x64\x65\146\141\x75\x6c\x74\137\x65\x6e\x61\x62\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\160\142\137\x65\x6e\141\142\x6c\x65\137\x74\x79\x70\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\160\x62\137\160\x68\x6f\156\x65\x5f\x66\151\145\154\144\x5f\x6b\x65\171");
        update_mo_option("\160\x62\x5f\144\145\x66\141\165\154\164\137\145\x6e\141\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x70\x62\x5f\145\x6e\x61\x62\154\x65\x5f\164\171\x70\x65", $this->_otpType);
        update_mo_option("\160\142\137\160\150\x6f\156\145\x5f\x6d\x65\x74\x61\x5f\153\x65\171", $this->_phoneKey);
    }
}
