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
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class WpMemberForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPMEMBER_REG;
        $this->_emailKey = "\165\163\x65\162\137\x65\x6d\x61\x69\154";
        $this->_phoneKey = get_mo_option("\x77\160\137\x6d\145\x6d\x62\145\162\x5f\x72\x65\x67\x5f\160\x68\157\x6e\x65\137\146\x69\x65\x6c\144\x5f\153\145\x79");
        $this->_phoneFormId = "\151\x6e\160\x75\x74\x5b\156\141\155\145\x3d{$this->_phoneKey}\135";
        $this->_formKey = "\x57\x50\x5f\x4d\105\115\102\105\x52\x5f\x46\x4f\x52\x4d";
        $this->_typePhoneTag = "\155\157\137\x77\160\x6d\x65\155\142\145\162\137\162\145\x67\x5f\160\x68\157\x6e\x65\137\145\x6e\141\x62\x6c\145";
        $this->_typeEmailTag = "\155\x6f\137\167\160\155\x65\x6d\142\x65\162\137\162\145\147\x5f\145\155\141\x69\x6c\137\145\x6e\141\x62\x6c\145";
        $this->_formName = mo_("\127\120\x2d\115\145\155\142\x65\162\x73");
        $this->_isFormEnabled = get_mo_option("\167\x70\137\155\x65\x6d\x62\145\x72\x5f\162\x65\147\x5f\x65\156\x61\x62\154\x65");
        $this->_formDocuments = MoOTPDocs::WP_MEMBER_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\160\137\155\x65\x6d\x62\x65\x72\137\162\x65\x67\137\x65\156\x61\142\x6c\x65\x5f\x74\171\x70\x65");
        add_filter("\167\x70\x6d\x65\x6d\137\162\145\147\151\163\x74\x65\162\137\x66\x6f\162\155\137\x72\157\x77\163", array($this, "\167\160\x6d\145\155\x62\x65\162\137\141\x64\x64\x5f\x62\165\164\x74\x6f\x6e"), 99, 2);
        add_action("\167\x70\x6d\145\155\x5f\160\x72\145\137\x72\x65\x67\x69\x73\x74\145\x72\x5f\144\141\164\x61", array($this, "\x76\141\154\151\144\141\x74\145\137\167\x70\x6d\145\155\x62\x65\x72\x5f\x73\165\142\x6d\151\164"), 99, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\x70\x74\151\x6f\156", $_REQUEST)) {
            goto Qch;
        }
        return;
        Qch:
        switch (trim($_REQUEST["\x6f\x70\x74\x69\x6f\156"])) {
            case "\x6d\151\156\151\x6f\162\141\156\x67\x65\55\x77\x70\x6d\145\x6d\x62\x65\162\x2d\146\x6f\x72\155":
                $this->_handle_wp_member_form($_POST);
                goto wrS;
        }
        CmO:
        wrS:
    }
    function _handle_wp_member_form($FA)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (!($this->_otpType === $this->_typeEmailTag)) {
            goto TU_;
        }
        $this->processEmailAndStartOTPVerificationProcess($FA);
        TU_:
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto khw;
        }
        $this->processPhoneAndStartOTPVerificationProcess($FA);
        khw:
    }
    function processEmailAndStartOTPVerificationProcess($FA)
    {
        if (MoUtility::sanitizeCheck("\165\163\145\162\x5f\145\155\141\x69\x6c", $FA)) {
            goto vMv;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto c5g;
        vMv:
        $p1 = sanitize_email($FA["\165\x73\145\162\x5f\x65\x6d\141\151\x6c"]);
        SessionUtils::addEmailVerified($this->_formSessionVar, $p1);
        $this->sendChallenge(null, $p1, null, '', VerificationType::EMAIL, null, null, false);
        c5g:
    }
    function processPhoneAndStartOTPVerificationProcess($FA)
    {
        if (MoUtility::sanitizeCheck("\x75\163\x65\162\x5f\160\150\157\x6e\145", $FA)) {
            goto Yxn;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto kSW;
        Yxn:
        $ue = sanitize_text_field($FA["\165\163\x65\x72\137\160\150\x6f\156\145"]);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $ue);
        $this->sendChallenge(null, '', null, $ue, VerificationType::PHONE, null, null, false);
        kSW:
    }
    function wpmember_add_button($xl, $yn)
    {
        foreach ($xl as $j1 => $QO) {
            if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && $j1 === $this->_phoneKey) {
                goto nQB;
            }
            if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && $j1 === $this->_emailKey)) {
                goto C3y;
            }
            $xl[$j1]["\146\x69\145\x6c\x64"] .= $this->_add_shortcode_to_wpmember("\x65\x6d\x61\151\154", $QO["\155\x65\x74\x61"]);
            goto IIq;
            C3y:
            goto IoT;
            nQB:
            $xl[$j1]["\x66\x69\145\x6c\x64"] .= $this->_add_shortcode_to_wpmember("\160\150\x6f\156\x65", $QO["\155\x65\x74\141"]);
            goto IIq;
            IoT:
            ueJ:
        }
        IIq:
        return $xl;
    }
    function validate_wpmember_submit($Xw)
    {
        global $wpmem_themsg;
        $tA = $this->getVerificationType();
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto wFP;
        }
        if ($this->validate_submitted($Xw, $tA)) {
            goto gb9;
        }
        return;
        gb9:
        goto Z66;
        wFP:
        $wpmem_themsg = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        Z66:
        $this->validateChallenge($tA, NULL, $Xw["\x76\141\x6c\151\x64\141\164\145\x5f\x6f\164\x70"]);
    }
    function validate_submitted($Xw, $tA)
    {
        global $wpmem_themsg;
        if ($tA === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Xw[$this->_emailKey])) {
            goto x3_;
        }
        if ($tA == VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Xw[$this->_phoneKey])) {
            goto NcK;
        }
        return true;
        goto qNB;
        NcK:
        $wpmem_themsg = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        return false;
        qNB:
        goto LsW;
        x3_:
        $wpmem_themsg = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        return false;
        LsW:
    }
    function _add_shortcode_to_wpmember($Xm, $QO)
    {
        $Ev = "<div style='display:table;text-align:center;'><img decoding='async' src='".MOV_URL. "includes/images/loader.gif'></div>";
        $rI = "\74\144\x69\166\40\x73\x74\171\x6c\145\75\x27\x6d\x61\162\147\151\156\55\x74\157\160\x3a\x20\x32\x25\x3b\47\x3e\x3c\142\x75\x74\164\x6f\156\40\164\171\160\145\x3d\47\142\165\x74\164\x6f\156\x27\x20\143\x6c\x61\x73\x73\x3d\47\142\165\x74\x74\x6f\156\40\141\x6c\x74\x27\40\x73\164\171\x6c\145\75\x27\167\151\x64\164\150\72\61\60\60\45\73\150\145\151\147\150\164\72\63\x30\160\x78\x3b";
        $rI .= "\x66\x6f\156\x74\55\x66\141\x6d\151\x6c\171\x3a\40\x52\157\x62\x6f\x74\157\73\146\x6f\x6e\x74\55\163\x69\x7a\x65\72\x20\61\x32\160\170\x20\x21\151\x6d\x70\157\x72\164\141\x6e\x74\73\x27\x20\151\144\75\x27\x6d\x69\x6e\x69\157\162\141\x6e\147\145\x5f\157\164\160\137\x74\157\x6b\x65\156\x5f\163\165\x62\155\151\x74\47\x20";
        $rI .= "\164\151\164\x6c\145\75\47\x50\x6c\145\141\x73\x65\x20\105\x6e\164\145\x72\x20\141\x6e\40\x27" . $Xm . "\47\164\x6f\x20\145\x6e\141\142\154\x65\x20\164\x68\x69\x73\x2e\47\x3e\103\154\151\143\x6b\40\x48\x65\162\x65\40\164\157\x20\126\145\x72\151\146\x79\40" . $Xm . "\x3c\x2f\x62\165\164\164\x6f\156\76\74\57\144\x69\166\76";
        $rI .= "\x3c\x64\x69\x76\x20\163\164\171\154\x65\75\47\155\x61\162\147\151\156\55\164\x6f\x70\72\x32\45\47\x3e\x3c\x64\x69\x76\x20\151\x64\75\47\155\157\137\155\x65\x73\x73\141\x67\145\x27\x20\150\x69\144\x64\145\x6e\75\47\x27\40\163\x74\x79\x6c\x65\x3d\47\x62\141\143\153\x67\162\157\165\156\x64\55\143\x6f\154\x6f\x72\72\x20\x23\x66\x37\x66\66\146\x37\x3b\x70\141\x64\x64\x69\156\x67\72\x20";
        $rI .= "\x31\145\155\x20\x32\145\155\40\61\x65\155\40\x33\x2e\x35\145\155\x3b\x27\x3e\74\57\x64\151\x76\x3e\x3c\x2f\144\151\x76\x3e";
        $rI .= "\74\163\143\x72\x69\x70\x74\76\152\121\165\145\x72\x79\50\144\x6f\x63\165\155\145\156\164\x29\56\x72\x65\141\144\171\50\x66\x75\156\x63\164\151\x6f\x6e\50\x29\x7b\44\155\157\x3d\152\121\x75\145\x72\171\73\44\155\157\x28\x22\x23\155\x69\156\x69\x6f\x72\141\x6e\147\145\137\x6f\x74\x70\137\x74\x6f\x6b\145\156\x5f\163\x75\142\x6d\151\164\x22\x29\56\x63\154\x69\143\x6b\x28\146\x75\156\143\164\x69\x6f\x6e\50\157\x29\173\x20";
        $rI .= "\166\141\162\40\145\x3d\44\x6d\157\x28\x22\x69\x6e\160\165\x74\x5b\x6e\141\155\145\x3d" . $QO . "\x5d\42\51\x2e\166\x61\154\50\x29\x3b\x20\44\x6d\157\50\x22\43\x6d\157\137\155\145\163\163\x61\x67\145\42\x29\x2e\145\x6d\160\x74\171\x28\51\x2c\x24\155\157\50\x22\43\155\x6f\137\155\145\163\x73\141\x67\x65\42\51\56\141\x70\160\145\x6e\144\x28\x22" . $Ev . "\42\x29\x2c";
        $rI .= "\x24\x6d\157\x28\x22\43\155\x6f\x5f\155\x65\x73\x73\x61\147\145\42\51\x2e\163\x68\x6f\167\50\x29\x2c\44\x6d\157\x2e\x61\x6a\141\170\50\173\x75\x72\154\x3a\42" . site_url() . "\57\77\157\x70\164\x69\x6f\x6e\75\x6d\x69\156\x69\157\162\x61\156\x67\145\55\167\x70\155\145\155\x62\145\x72\55\x66\157\x72\x6d\x22\54\164\x79\160\145\x3a\42\120\117\x53\124\x22\54";
        $rI .= "\144\141\164\141\x3a\173\165\163\x65\x72\137" . $Xm . "\72\x65\x7d\54\143\162\x6f\163\163\104\157\x6d\x61\151\x6e\x3a\x21\60\x2c\144\x61\164\141\124\171\160\x65\x3a\x22\152\163\157\156\42\54\163\165\x63\143\x65\163\x73\x3a\x66\x75\x6e\143\164\151\157\156\50\157\x29\173\x20";
        $rI .= "\x69\146\x28\157\56\x72\145\163\x75\x6c\x74\75\75\x3d\x22\163\x75\x63\x63\145\163\x73\x22\51\173\x24\x6d\x6f\50\x22\x23\155\157\x5f\x6d\x65\163\163\x61\147\x65\42\x29\56\x65\x6d\160\x74\171\50\x29\x2c\x24\155\157\50\x22\x23\155\x6f\x5f\155\x65\163\163\141\x67\x65\x22\51\x2e\x61\x70\x70\145\156\144\50\x6f\56\155\x65\163\163\141\147\x65\51\54";
        $rI .= "\44\x6d\157\x28\42\x23\155\157\x5f\x6d\x65\x73\163\x61\x67\145\42\51\x2e\x63\163\x73\x28\42\x62\157\x72\144\145\162\55\164\157\160\x22\x2c\42\x33\x70\x78\x20\x73\157\x6c\151\144\x20\x67\162\x65\x65\x6e\42\51\54\x24\x6d\x6f\x28\42\151\156\160\165\164\x5b\156\x61\x6d\145\x3d\145\x6d\x61\x69\x6c\x5f\166\x65\x72\x69\146\x79\135\x22\51\56\146\x6f\143\x75\x73\x28\51\175\145\x6c\x73\145\173";
        $rI .= "\44\155\157\x28\x22\43\155\157\x5f\155\145\163\x73\141\x67\145\42\51\x2e\145\x6d\160\164\x79\x28\51\54\44\155\x6f\x28\42\43\155\x6f\x5f\155\x65\163\x73\141\147\x65\x22\x29\x2e\x61\160\160\145\156\144\x28\x6f\56\155\145\x73\163\x61\x67\145\51\54\44\155\x6f\x28\x22\43\x6d\157\x5f\155\145\163\163\141\x67\145\42\51\x2e\143\x73\x73\x28\x22\142\x6f\162\144\145\162\55\x74\x6f\160\42\x2c\x22\x33\160\170\x20\163\157\154\151\144\40\162\145\x64\42\51";
        $rI .= "\54\44\x6d\x6f\50\42\151\156\x70\165\x74\x5b\x6e\x61\155\x65\x3d\x70\150\x6f\x6e\x65\137\166\x65\x72\151\x66\171\x5d\42\x29\x2e\x66\x6f\143\165\163\x28\51\x7d\x20\x3b\175\x2c\x65\x72\162\157\162\x3a\x66\165\156\143\164\x69\x6f\156\50\157\x2c\x65\54\x6e\x29\173\175\x7d\x29\x7d\x29\73\x7d\51\x3b\x3c\57\x73\143\x72\151\x70\x74\76";
        return $rI;
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        global $wpmem_themsg;
        $wpmem_themsg = MoUtility::_get_invalid_otp_method();
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
            goto Wjf;
        }
        array_push($kp, $this->_phoneFormId);
        Wjf:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto txU;
        }
        return;
        txU:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\x70\x5f\x6d\x65\x6d\142\145\x72\x5f\162\145\147\x5f\x65\156\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\167\160\x5f\155\x65\155\142\x65\162\137\x72\x65\147\137\145\156\x61\x62\154\145\x5f\164\171\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\167\160\x5f\x6d\x65\155\x62\x65\162\137\x72\145\x67\x5f\x70\150\157\x6e\x65\x5f\x66\151\x65\154\144\137\x6b\145\171");
        if (!$this->basicValidationCheck(BaseMessages::WP_MEMBER_CHOOSE)) {
            goto Q34;
        }
        update_mo_option("\x77\160\137\x6d\x65\x6d\142\145\162\x5f\162\145\x67\x5f\x70\150\x6f\x6e\x65\x5f\x66\151\x65\x6c\144\137\153\145\x79", $this->_phoneKey);
        update_mo_option("\167\x70\x5f\155\x65\155\142\145\x72\x5f\x72\145\x67\x5f\x65\156\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\x70\137\155\x65\155\142\145\162\137\x72\x65\x67\x5f\x65\156\141\142\154\145\137\x74\171\x70\145", $this->_otpType);
        Q34:
    }
}
