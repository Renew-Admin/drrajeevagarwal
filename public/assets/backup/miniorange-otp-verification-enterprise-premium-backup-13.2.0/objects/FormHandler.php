<?php


namespace OTP\Objects;

use OTP\Helper\FormList;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
class FormHandler
{
    protected $_typePhoneTag;
    protected $_typeEmailTag;
    protected $_typeBothTag;
    protected $_formKey;
    protected $_formName;
    protected $_otpType;
    protected $_phoneFormId;
    protected $_isFormEnabled;
    protected $_restrictDuplicates;
    protected $_byPassLogin;
    protected $_isLoginOrSocialForm;
    protected $_isAjaxForm;
    protected $_phoneKey;
    protected $_emailKey;
    protected $_buttonText;
    protected $_formDetails;
    protected $_disableAutoActivate;
    protected $_formSessionVar;
    protected $_formSessionVar2;
    protected $_nonce = "\146\157\x72\155\137\x6e\x6f\x6e\143\x65";
    protected $_txSessionId = FormSessionVars::TX_SESSION_ID;
    protected $_formOption = "\x6d\x6f\137\x63\x75\x73\x74\x6f\155\x65\x72\137\x76\x61\154\x69\x64\141\x74\x69\x6f\x6e\137\163\x65\x74\x74\x69\x6e\x67\x73";
    protected $_generateOTPAction;
    protected $_validateOTPAction;
    protected $_nonceKey = "\163\145\143\x75\x72\x69\164\171";
    protected $_isAddOnForm = FALSE;
    protected $_formDocuments = array();
    const VALIDATED = "\126\x41\x4c\111\x44\101\x54\105\x44";
    const VERIFICATION_FAILED = "\x76\145\x72\151\146\151\x63\141\x74\151\157\156\137\x66\141\151\x6c\x65\x64";
    const VALIDATION_CHECKED = "\166\141\x6c\151\x64\x61\164\151\157\x6e\103\x68\145\x63\153\x65\x64";
    protected function __construct()
    {
        add_action("\x61\144\x6d\151\156\137\151\156\151\164", array($this, "\x68\141\156\144\154\145\x46\x6f\162\x6d\x4f\x70\164\151\x6f\156\163"), 2);
        if (!(!MoUtility::micr() || !$this->isFormEnabled())) {
            goto yxl;
        }
        return;
        yxl:
        add_action("\151\x6e\x69\164", array($this, "\150\x61\156\144\x6c\x65\x46\x6f\x72\155"), 1);
        add_filter("\x6d\157\x5f\160\x68\x6f\x6e\x65\137\x64\x72\x6f\x70\144\x6f\167\156\137\x73\x65\x6c\145\x63\164\x6f\162", array($this, "\147\x65\164\x50\150\x6f\x6e\x65\x4e\165\155\142\145\x72\123\145\x6c\145\x63\x74\157\162"), 1, 1);
        if (!(SessionUtils::isOTPInitialized($this->_formSessionVar) || SessionUtils::isOTPInitialized($this->_formSessionVar2))) {
            goto fDl;
        }
        add_action("\157\164\x70\137\x76\x65\x72\151\146\151\x63\141\x74\x69\157\x6e\x5f\x73\x75\143\143\x65\163\163\146\x75\x6c", array($this, "\x68\x61\x6e\x64\x6c\x65\x5f\160\157\163\164\x5f\x76\145\x72\151\x66\x69\x63\141\164\x69\x6f\x6e"), 1, 7);
        add_action("\x6f\164\x70\x5f\x76\145\162\x69\146\151\x63\141\x74\x69\x6f\x6e\137\x66\141\x69\154\x65\144", array($this, "\x68\x61\x6e\144\154\145\x5f\x66\141\151\154\145\144\137\x76\145\162\x69\146\x69\143\x61\x74\x69\x6f\x6e"), 1, 4);
        add_action("\165\156\163\145\164\x5f\x73\145\x73\x73\151\157\x6e\x5f\x76\141\162\x69\x61\x62\x6c\x65", array($this, "\x75\156\163\145\164\117\124\x50\x53\145\x73\x73\151\x6f\156\x56\141\x72\x69\x61\x62\154\145\x73"), 1, 0);
        fDl:
        add_filter("\x69\x73\x5f\141\152\x61\x78\137\x66\x6f\x72\155", array($this, "\x69\163\x5f\141\152\141\x78\x5f\146\157\162\x6d\x5f\151\x6e\137\x70\x6c\x61\x79"), 1, 1);
        add_filter("\151\163\137\x6c\157\147\151\x6e\137\157\x72\137\163\x6f\143\x69\141\154\x5f\x66\157\162\x6d", array($this, "\x69\163\x4c\157\x67\x69\x6e\x4f\x72\123\x6f\x63\151\x61\x6c\x46\157\162\x6d"), 1, 1);
        $ou = FormList::instance();
        $ou->add($this->getFormKey(), $this);
    }
    public function isLoginOrSocialForm($oy)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $this->getisLoginOrSocialForm() : $oy;
    }
    public function is_ajax_form_in_play($S3)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $this->_isAjaxForm : $S3;
    }
    public function sanitizeFormPOST($KN, $Bn = null)
    {
        $KN = ($Bn === null ? "\155\x6f\x5f\x63\165\163\164\x6f\155\x65\162\137\166\141\x6c\151\x64\141\x74\x69\x6f\x6e\137" : '') . $KN;
        return MoUtility::sanitizeCheck($KN, $_POST);
    }
    public function sendChallenge($iI, $p1, $errors, $NN = null, $CD = "\145\x6d\x61\x69\x6c", $iK = '', $ck = null, $kt = false)
    {
        do_action("\x6d\x6f\137\x67\x65\156\145\x72\x61\x74\145\x5f\157\x74\x70", $iI, $p1, $errors, $NN, $CD, $iK, $ck, $kt);
    }
    public function validateChallenge($tA, $qk = "\x6d\157\x5f\x6f\164\x70\137\164\157\153\x65\156", $U4 = NULL)
    {
        do_action("\x6d\157\x5f\x76\141\x6c\151\144\141\164\145\x5f\157\164\160", $tA, $qk, $U4);
    }
    public function basicValidationCheck($bC)
    {
        if (!($this->isFormEnabled() && MoUtility::isBlank($this->_otpType))) {
            goto fB3;
        }
        do_action("\x6d\157\137\x72\145\147\151\x73\x74\162\x61\x74\x69\157\156\x5f\163\x68\x6f\167\137\x6d\x65\163\x73\141\x67\x65", MoMessages::showMessage($bC), MoConstants::ERROR);
        return false;
        fB3:
        return true;
    }
    public function getVerificationType()
    {
        $my = [$this->_typePhoneTag => VerificationType::PHONE, $this->_typeEmailTag => VerificationType::EMAIL, $this->_typeBothTag => VerificationType::BOTH];
        return MoUtility::isBlank($this->_otpType) ? false : $my[$this->_otpType];
    }
    protected function validateAjaxRequest()
    {
        if (check_ajax_referer($this->_nonce, $this->_nonceKey)) {
            goto MTp;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::INVALID_OP), MoConstants::ERROR_JSON_TYPE));
        exit;
        MTp:
    }
    protected function ajaxProcessingFields()
    {
        $my = [$this->_typePhoneTag => [VerificationType::PHONE], $this->_typeEmailTag => [VerificationType::EMAIL], $this->_typeBothTag => [VerificationType::PHONE, VerificationType::EMAIL]];
        return $my[$this->_otpType];
    }
    public function getPhoneHTMLTag()
    {
        return $this->_typePhoneTag;
    }
    public function getEmailHTMLTag()
    {
        return $this->_typeEmailTag;
    }
    public function getBothHTMLTag()
    {
        return $this->_typeBothTag;
    }
    public function getFormKey()
    {
        return $this->_formKey;
    }
    public function getFormName()
    {
        return $this->_formName;
    }
    public function getOtpTypeEnabled()
    {
        return $this->_otpType;
    }
    public function disableAutoActivation()
    {
        return $this->_disableAutoActivate;
    }
    public function getPhoneKeyDetails()
    {
        return $this->_phoneKey;
    }
    public function getEmailKeyDetails()
    {
        return $this->_emailKey;
    }
    public function isFormEnabled()
    {
        return $this->_isFormEnabled;
    }
    public function getButtonText()
    {
        return mo_($this->_buttonText);
    }
    public function getFormDetails()
    {
        return $this->_formDetails;
    }
    public function restrictDuplicates()
    {
        return $this->_restrictDuplicates;
    }
    public function bypassForLoggedInUsers()
    {
        return $this->_byPassLogin;
    }
    public function getisLoginOrSocialForm()
    {
        return (bool) $this->_isLoginOrSocialForm;
    }
    public function getFormOption()
    {
        return $this->_formOption;
    }
    public function isAjaxForm()
    {
        return $this->_isAjaxForm;
    }
    public function isAddOnForm()
    {
        return $this->_isAddOnForm;
    }
    public function getFormDocuments()
    {
        return $this->_formDocuments;
    }
}
