<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
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
use WP_Error;
class MemberPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::MEMBERPRESS_REG;
        $this->_typePhoneTag = "\x6d\157\137\x6d\162\160\137\160\x68\x6f\x6e\145\x5f\x65\156\x61\x62\154\x65";
        $this->_typeEmailTag = "\155\x6f\137\155\162\160\137\145\155\141\x69\x6c\x5f\145\x6e\x61\x62\x6c\x65";
        $this->_typeBothTag = "\x6d\x6f\x5f\155\162\x70\x5f\142\x6f\164\x68\137\145\156\x61\x62\154\145";
        $this->_formName = mo_("\115\145\155\x62\145\162\120\x72\145\x73\163\x20\x52\145\147\x69\163\x74\x72\x61\164\151\157\156\x20\106\x6f\162\155");
        $this->_formKey = "\115\x45\115\102\105\x52\120\122\105\x53\123";
        $this->_isFormEnabled = get_mo_option("\x6d\x72\160\137\x64\145\146\141\x75\x6c\164\x5f\145\x6e\141\142\x6c\x65");
        $this->_formDocuments = MoOTPDocs::MRP_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_byPassLogin = get_mo_option("\155\162\x70\x5f\x61\x6e\x6f\x6e\x5f\x6f\156\154\x79");
        $this->_phoneKey = get_mo_option("\x6d\x72\160\137\x70\150\x6f\x6e\x65\x5f\153\x65\171");
        $this->_otpType = get_mo_option("\155\162\x70\x5f\x65\x6e\x61\142\154\x65\x5f\164\171\160\145");
        $this->_phoneFormId = "\x69\x6e\160\165\x74\133\156\141\x6d\145\75" . $this->_phoneKey . "\x5d";
        add_filter("\155\145\x70\162\55\166\x61\154\x69\144\141\164\145\55\163\151\147\156\165\160", array($this, "\155\x69\156\x69\157\162\x61\x6e\147\x65\137\163\151\164\145\137\x72\145\147\151\x73\164\145\162\x5f\x66\x6f\162\155"), 99, 1);
    }
    function miniorange_site_register_form($errors)
    {
        if (!($this->_byPassLogin && is_user_logged_in())) {
            goto oe;
        }
        return $errors;
        oe:
        $wz = $_POST;
        $NN = '';
        if (!$this->isPhoneVerificationEnabled()) {
            goto r3;
        }
        $NN = sanitize_text_field($_POST[$this->_phoneKey]);
        $errors = $this->validatePhoneNumberField($errors);
        r3:
        if (!(is_array($errors) && !empty($errors))) {
            goto Vs;
        }
        return $errors;
        Vs:
        if (!$this->checkIfVerificationIsComplete()) {
            goto Br;
        }
        return $errors;
        Br:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        foreach ($_POST as $j1 => $qL) {
            if ($j1 == "\165\x73\145\162\137\x66\151\162\163\x74\x5f\156\141\155\145") {
                goto KR;
            }
            if ($j1 == "\165\163\x65\x72\137\x65\155\141\x69\154") {
                goto Dz;
            }
            if ($j1 == "\x6d\145\x70\162\x5f\165\163\x65\x72\137\x70\x61\163\163\167\x6f\162\x64") {
                goto iz;
            }
            $ck[$j1] = $qL;
            goto Je;
            KR:
            $zC = $qL;
            goto Je;
            Dz:
            $mo = $qL;
            goto Je;
            iz:
            $iK = $qL;
            Je:
            jB:
        }
        ZI:
        $ck["\165\x73\145\162\155\x65\164\141"] = $wz;
        $this->startVerificationProcess($zC, $mo, $errors, $NN, $iK, $ck);
        return $errors;
    }
    function validatePhoneNumberField($errors)
    {
        global $phoneLogic;
        if (!MoUtility::sanitizeCheck($this->_phoneKey, $_POST)) {
            goto WW;
        }
        if (MoUtility::validatePhoneNumber(sanitize_text_field($_POST[$this->_phoneKey]))) {
            goto sr;
        }
        $errors[] = $phoneLogic->_get_otp_invalid_format_message();
        sr:
        goto mP;
        WW:
        $errors[] = mo_("\120\x68\157\156\x65\40\156\165\x6d\x62\x65\x72\x20\x66\151\145\x6c\x64\40\x63\141\156\x20\x6e\157\164\x20\x62\145\x20\x62\x6c\x61\x6e\x6b");
        mP:
        return $errors;
    }
    function startVerificationProcess($zC, $mo, $errors, $NN, $iK, $ck)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto yQ;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto VW;
        }
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::EMAIL, $iK, $ck);
        goto Ao;
        yQ:
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::PHONE, $iK, $ck);
        goto Ao;
        VW:
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::BOTH, $iK, $ck);
        Ao:
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto zq;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        zq:
        return FALSE;
    }
    function moMRPgetphoneFieldId()
    {
        global $wpdb;
        return $wpdb->get_var("\123\105\114\105\x43\x54\x20\x69\144\40\x46\x52\x4f\115\40{$wpdb->prefix}\142\x70\x5f\x78\x70\x72\x6f\146\x69\x6c\145\137\x66\151\x65\154\x64\x73\40\167\150\x65\162\x65\x20\156\x61\155\145\40\x3d\47" . $this->_phoneKey . "\x27");
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto gF;
        }
        return;
        gF:
        $Bs = $this->getVerificationType();
        $MZ = $Bs === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!(self::isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto mM;
        }
        array_push($kp, $this->_phoneFormId);
        mM:
        return $kp;
    }
    function isPhoneVerificationEnabled()
    {
        $tA = $this->getVerificationType();
        return $tA === VerificationType::PHONE || $tA === VerificationType::BOTH;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto tU;
        }
        return;
        tU:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\155\x72\160\137\x64\x65\146\x61\x75\x6c\x74\x5f\x65\x6e\x61\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x6d\x72\x70\137\145\156\x61\x62\x6c\x65\x5f\x74\x79\160\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\x6d\162\x70\x5f\160\x68\157\x6e\x65\137\146\151\145\154\x64\x5f\153\x65\x79");
        $this->_byPassLogin = $this->sanitizeFormPOST("\x6d\160\162\x5f\141\156\157\x6e\137\157\156\x6c\171");
        if (!$this->basicValidationCheck(BaseMessages::MEMBERPRESS_CHOOSE)) {
            goto p6;
        }
        update_mo_option("\155\x72\x70\137\144\x65\x66\x61\x75\154\164\x5f\x65\x6e\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x6d\162\160\137\145\x6e\141\142\154\145\137\x74\x79\x70\145", $this->_otpType);
        update_mo_option("\x6d\x72\160\x5f\x70\x68\157\156\x65\137\x6b\145\171", $this->_phoneKey);
        update_mo_option("\155\162\x70\137\141\156\157\156\137\x6f\156\x6c\171", $this->_byPassLogin);
        p6:
    }
}
