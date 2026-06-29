<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class PaidMembershipForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PMPRO_REGISTRATION;
        $this->_formKey = "\x50\x4d\137\120\122\x4f\x5f\106\117\122\115";
        $this->_formName = mo_("\x50\x61\151\144\40\x4d\145\x6d\x62\x65\x72\x53\150\151\x70\40\120\x72\x6f\x20\x52\x65\147\x69\x73\164\162\141\164\151\157\156\x20\106\x6f\x72\155");
        $this->_phoneFormId = "\x69\156\x70\x75\x74\x5b\x6e\x61\155\145\x3d\x70\150\157\156\x65\x5f\160\x61\151\x64\x6d\x65\155\142\145\162\x73\150\x69\x70\x5d";
        $this->_typePhoneTag = "\160\x6d\160\x72\x6f\137\x70\150\x6f\x6e\x65\x5f\145\156\x61\x62\154\x65";
        $this->_typeEmailTag = "\x70\x6d\160\x72\x6f\137\x65\x6d\x61\151\154\137\145\156\141\x62\x6c\x65";
        $this->_isFormEnabled = get_mo_option("\160\155\x70\x72\x6f\137\145\x6e\x61\x62\154\x65");
        $this->_formDocuments = MoOTPDocs::PAID_MEMBERSHIP_PRO;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x70\155\160\162\x6f\137\157\164\x70\x5f\164\171\160\x65");
        add_action("\167\160\137\x65\x6e\x71\165\145\x75\x65\x5f\163\x63\x72\x69\160\164\x73", array($this, "\137\x73\x68\x6f\167\137\160\x68\157\156\x65\137\146\151\145\x6c\x64\x5f\x6f\156\x5f\x70\x61\147\145"));
        add_filter("\160\155\x70\162\157\x5f\x63\150\x65\143\x6b\157\165\164\x5f\x62\x65\146\157\x72\145\x5f\160\162\157\x63\x65\x73\163\151\x6e\147", array($this, "\x5f\x70\x61\151\144\x4d\x65\155\142\145\x72\x73\x68\x69\160\120\162\157\122\x65\147\x69\x73\x74\x72\x61\164\x69\157\x6e\103\150\145\143\153"), 1, 1);
        add_filter("\x70\155\x70\162\x6f\x5f\x63\150\145\x63\153\x6f\x75\164\x5f\143\x6f\156\x66\x69\162\x6d\x65\144", array($this, "\151\163\126\x61\154\151\144\141\164\145\144"), 99, 2);
        add_action("\x75\163\145\162\137\162\145\147\x69\x73\x74\x65\162", array($this, "\x6d\151\x6e\x69\x6f\162\x61\156\147\x65\137\x72\x65\x67\151\x73\164\x72\141\x74\x69\x6f\x6e\137\x73\141\166\x65"), 10, 1);
    }
    function miniorange_registration_save($nL)
    {
        update_user_meta($nL, "\x6d\157\x5f\x70\150\157\156\145\x5f\156\x75\x6d\142\145\162", sanitize_text_field($_POST["\160\150\x6f\156\145\x5f\x70\x61\x69\144\155\x65\x6d\142\x65\162\x73\x68\x69\160"]));
    }
    public function isValidated($bk, $sT)
    {
        global $FT;
        return $FT == "\x70\x6d\x70\x72\x6f\x5f\145\162\162\x6f\162" ? false : $bk;
    }
    public function _paidMembershipProRegistrationCheck()
    {
        global $FT;
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto xj;
        }
        $this->unsetOTPSessionVariables();
        return;
        xj:
        $this->validatePhone($_POST);
        if (!($FT != "\x70\x6d\x70\162\x6f\137\145\162\x72\157\162")) {
            goto YC;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->startOTPVerificationProcess($_POST);
        YC:
    }
    private function startOTPVerificationProcess($FA)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto es;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0) {
            goto hW;
        }
        goto tz;
        es:
        $this->sendChallenge('', '', null, trim(sanitize_text_field($FA["\160\x68\x6f\x6e\x65\137\x70\141\151\144\x6d\x65\155\142\145\x72\163\150\151\x70"])), "\x70\x68\157\156\x65");
        goto tz;
        hW:
        $this->sendChallenge('', sanitize_email($FA["\x62\x65\x6d\x61\x69\x6c"]), null, sanitize_email($FA["\x62\x65\155\141\151\154"]), "\x65\x6d\141\x69\x6c");
        tz:
    }
    public function validatePhone($FA)
    {
        if (!($this->getVerificationType() != VerificationType::PHONE)) {
            goto Yi;
        }
        return;
        Yi:
        global $qZ, $FT, $phoneLogic, $tr;
        if (!($FT == "\160\155\160\162\157\x5f\145\162\162\x6f\162")) {
            goto HM;
        }
        return;
        HM:
        $Fb = sanitize_text_field($FA["\x70\x68\x6f\156\x65\137\160\141\151\144\155\145\155\x62\x65\162\163\150\151\x70"]);
        if (MoUtility::validatePhoneNumber($Fb)) {
            goto JQ;
        }
        $bC = str_replace("\x23\43\160\x68\x6f\x6e\x65\x23\43", $Fb, $phoneLogic->_get_otp_invalid_format_message());
        $FT = "\160\155\x70\x72\x6f\137\x65\x72\x72\x6f\x72";
        $tr = false;
        $qZ = apply_filters("\x70\155\160\162\x6f\137\x73\x65\x74\137\x6d\x65\x73\163\141\x67\x65", $bC, $FT);
        JQ:
    }
    function _show_phone_field_on_page()
    {
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto Cn;
        }
        wp_enqueue_script("\x70\x61\x69\144\x6d\145\x6d\x62\x65\x72\x73\150\151\160\163\143\162\x69\x70\x74", MOV_URL . "\x69\x6e\143\154\165\144\x65\x73\57\152\163\57\160\x61\151\x64\155\145\x6d\142\145\x72\x73\x68\x69\x70\160\162\x6f\56\155\151\x6e\56\152\163\77\166\x65\x72\x73\x69\157\x6e\75" . MOV_VERSION, array("\152\161\x75\145\x72\x79"));
        Cn:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        $Bs = $this->getVerificationType();
        $MZ = $Bs === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
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
        if (!(self::isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto kM;
        }
        array_push($kp, $this->_phoneFormId);
        kM:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto e0;
        }
        return;
        e0:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\160\x6d\160\162\x6f\137\x65\156\141\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x70\155\160\x72\x6f\137\x63\157\x6e\x74\141\143\164\137\x74\x79\160\x65");
        update_mo_option("\160\x6d\x70\x72\157\137\x65\x6e\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x70\x6d\x70\162\x6f\x5f\x6f\x74\160\137\164\171\x70\145", $this->_otpType);
    }
}
