<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class MultiSiteFormRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::MULTISITE;
        $this->_phoneFormId = "\x69\x6e\x70\x75\x74\x5b\156\x61\155\x65\75\x6d\x75\154\164\151\x73\151\164\x65\x5f\x75\163\x65\162\137\x70\150\x6f\x6e\145\x5f\x6d\151\156\x69\x6f\x72\141\x6e\x67\145\135";
        $this->_typePhoneTag = "\155\157\x5f\155\165\x6c\x74\x69\163\x69\x74\145\x5f\x63\x6f\156\x74\x61\143\x74\137\160\x68\x6f\x6e\145\137\145\x6e\x61\x62\154\x65";
        $this->_typeEmailTag = "\155\157\x5f\155\165\154\x74\x69\x73\151\164\145\137\x63\x6f\156\164\x61\x63\x74\x5f\x65\x6d\141\x69\154\x5f\x65\x6e\x61\x62\x6c\145";
        $this->_formKey = "\127\x50\x5f\x53\111\107\x4e\x55\x50\137\x46\x4f\122\x4d";
        $this->_formName = mo_("\127\157\162\x64\120\162\x65\163\163\40\115\x75\154\x74\151\163\151\x74\145\40\x53\x69\x67\x6e\125\x70\40\x46\x6f\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\155\165\x6c\164\x69\x73\x69\x74\145\137\145\x6e\x61\142\x6c\x65");
        $this->_phoneKey = "\164\x65\x6c\x65\x70\x68\x6f\156\x65";
        $this->_formDocuments = MoOTPDocs::MULTISITE_REG_FORM;
        parent::__construct();
    }
    public function handleForm()
    {
        add_action("\167\160\x5f\x65\x6e\x71\x75\145\x75\x65\x5f\x73\143\x72\x69\x70\x74\163", array($this, "\x61\x64\x64\x50\150\x6f\156\145\106\x69\x65\x6c\x64\123\x63\162\x69\x70\164"));
        add_action("\x75\x73\x65\x72\x5f\x72\145\x67\x69\163\164\x65\x72", array($this, "\137\163\x61\x76\x65\x50\x68\157\x6e\145\x4e\x75\x6d\x62\x65\162"), 10, 1);
        $this->_otpType = get_mo_option("\x6d\165\154\164\151\x73\151\164\x65\137\157\x74\x70\137\x74\171\160\x65");
        if (array_key_exists("\157\160\x74\x69\157\156", $_POST)) {
            goto bC;
        }
        return;
        bC:
        switch (trim($_POST["\157\x70\164\151\157\156"])) {
            case "\x6d\x75\154\164\151\x73\151\164\145\x5f\162\145\x67\151\x73\164\x65\x72":
                $this->_sanitizeAndRouteData($_POST);
                goto i1;
            case "\155\151\156\x69\x6f\x72\141\x6e\x67\x65\x2d\x76\141\154\151\x64\141\164\145\55\157\164\160\55\146\x6f\x72\x6d":
                $this->_startValidation();
                goto i1;
        }
        zf:
        i1:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
        $this->unsetOTPSessionVariables();
    }
    public function _savePhoneNumber($nL)
    {
        $dI = MoPHPSessions::getSessionVar("\160\150\157\x6e\145\x5f\156\165\x6d\142\x65\x72\x5f\x6d\x6f");
        if (!$dI) {
            goto NG;
        }
        update_user_meta($nL, $this->_phoneKey, $dI);
        NG:
    }
    public function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto LL;
        }
        return;
        LL:
        $Bs = $this->getVerificationType();
        $MZ = $Bs === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
    }
    function _sanitizeAndRouteData($Un)
    {
        $s_ = wpmu_validate_user_signup(sanitize_text_field($_POST["\165\x73\145\x72\137\x6e\x61\x6d\145"]), sanitize_email($_POST["\165\x73\x65\162\137\145\155\x61\x69\x6c"]));
        $errors = $s_["\x65\x72\x72\x6f\162\x73"];
        if (!$errors->get_error_code()) {
            goto DI;
        }
        return false;
        DI:
        Moutility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto cl;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto tu;
        }
        $this->_processEmail($Un);
        tu:
        goto pv;
        cl:
        $this->_processPhone($Un);
        pv:
        return false;
    }
    private function _startValidation()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto eY;
        }
        return;
        eY:
        $Bs = $this->getVerificationType();
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs)) {
            goto rU;
        }
        return;
        rU:
        $this->validateChallenge($Bs);
    }
    public function addPhoneFieldScript()
    {
        wp_enqueue_script("\x6d\x75\x6c\x74\x69\x73\151\164\x65\163\x63\162\151\160\x74", MOV_URL . "\151\156\143\x6c\165\x64\145\163\x2f\x6a\x73\x2f\155\x75\154\x74\151\x73\151\164\x65\x2e\155\x69\156\x2e\152\163\x3f\x76\x65\x72\163\151\157\x6e\75" . MOV_VERSION, array("\x6a\x71\165\145\162\171"));
    }
    private function _processPhone($Un)
    {
        if (isset($Un["\155\165\154\164\151\163\x69\x74\145\x5f\x75\163\145\162\x5f\x70\x68\157\x6e\145\137\x6d\151\x6e\151\157\162\x61\x6e\147\145"])) {
            goto d_;
        }
        return;
        d_:
        $this->sendChallenge('', '', null, trim($Un["\x6d\x75\154\x74\151\x73\x69\x74\x65\x5f\165\163\145\162\137\x70\150\157\x6e\145\x5f\155\x69\156\x69\x6f\162\141\x6e\x67\x65"]), VerificationType::PHONE);
    }
    private function _processEmail($Un)
    {
        if (isset($Un["\165\163\145\162\x5f\145\x6d\x61\x69\154"])) {
            goto fG;
        }
        return;
        fG:
        $this->sendChallenge('', $Un["\165\163\x65\x72\137\145\155\x61\151\x6c"], null, null, VerificationType::EMAIL, '');
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!self::isFormEnabled()) {
            goto nE;
        }
        array_push($kp, $this->_phoneFormId);
        nE:
        return $kp;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto UX;
        }
        return;
        UX:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\155\x75\154\164\x69\x73\x69\x74\x65\x5f\x65\x6e\x61\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x6d\x75\x6c\164\151\163\x69\x74\x65\137\x63\157\156\x74\141\143\x74\137\x74\x79\160\145");
        update_mo_option("\155\x75\x6c\x74\151\163\151\x74\145\137\x65\x6e\141\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\155\x75\154\x74\x69\163\x69\164\145\x5f\157\164\x70\137\x74\x79\160\x65", $this->_otpType);
    }
}
