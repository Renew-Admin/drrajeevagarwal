<?php


namespace OTP\Handler\Forms;

use mysql_xdevapi\Session;
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
use stdClass;
class SimplrRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::SIMPLR_REG;
        $this->_typePhoneTag = "\155\157\x5f\160\150\x6f\156\x65\x5f\x65\156\141\x62\154\145";
        $this->_typeEmailTag = "\x6d\x6f\137\x65\x6d\x61\151\x6c\x5f\x65\156\141\142\x6c\145";
        $this->_typeBothTag = "\x6d\x6f\x5f\142\157\x74\x68\137\145\156\141\x62\x6c\x65";
        $this->_formKey = "\123\111\115\x50\x4c\x52\x5f\x46\117\x52\x4d";
        $this->_formName = mo_("\123\x69\x6d\x70\x6c\162\x20\x55\163\x65\x72\x20\122\x65\147\151\x73\x74\x72\x61\x74\x69\157\x6e\40\106\x6f\162\x6d\40\x50\154\x75\163");
        $this->_isFormEnabled = get_mo_option("\x73\151\x6d\x70\154\x72\137\144\x65\146\x61\x75\154\164\137\145\x6e\141\x62\x6c\145");
        $this->_formDocuments = MoOTPDocs::SIMPLR_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_formKey = get_mo_option("\x73\x69\x6d\x70\154\162\137\x66\x69\145\154\x64\137\153\145\171");
        $this->_otpType = get_mo_option("\163\x69\x6d\160\x6c\162\137\x65\156\141\x62\154\x65\x5f\164\171\160\x65");
        $this->_phoneFormId = "\x69\x6e\x70\x75\x74\x5b\156\x61\155\x65\75" . $this->_formKey . "\135";
        add_filter("\163\x69\155\160\x6c\162\x5f\166\141\154\151\x64\141\x74\145\x5f\x66\157\162\x6d", array($this, "\x73\x69\155\160\154\x72\137\163\151\164\x65\137\162\x65\x67\x69\163\x74\162\141\x74\x69\157\x6e\137\145\x72\x72\157\162\x73"), 10, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $Bs = $this->getVerificationType();
        return $Bs === VerificationType::PHONE || $Bs === VerificationType::BOTH;
    }
    function simplr_site_registration_errors($errors)
    {
        $iK = $NN = '';
        if (!(!empty($errors) || isset($_POST["\x66\142\x75\x73\x65\x72\x5f\151\x64"]))) {
            goto IY;
        }
        return $errors;
        IY:
        foreach ($_POST as $j1 => $qL) {
            if ($j1 == "\x75\163\145\162\x6e\141\x6d\145") {
                goto FO;
            }
            if ($j1 == "\x65\x6d\141\151\154") {
                goto Fo;
            }
            if ($j1 == "\x70\141\x73\x73\x77\x6f\162\x64") {
                goto rY;
            }
            if ($j1 == $this->_formKey) {
                goto rp;
            }
            $ck[$j1] = $qL;
            goto qA;
            FO:
            $zC = $qL;
            goto qA;
            Fo:
            $mo = $qL;
            goto qA;
            rY:
            $iK = $qL;
            goto qA;
            rp:
            $NN = $qL;
            qA:
            Ud:
        }
        L4:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && !$this->processPhone($NN, $errors))) {
            goto M3;
        }
        return $errors;
        M3:
        $this->processAndStartOTPVerificationProcess($zC, $mo, $errors, $NN, $iK, $ck);
        return $errors;
    }
    function processPhone($NN, &$errors)
    {
        if (MoUtility::validatePhoneNumber($NN)) {
            goto mG;
        }
        global $phoneLogic;
        $errors[] .= str_replace("\43\x23\160\150\157\156\145\43\x23", $NN, $phoneLogic->_get_otp_invalid_format_message());
        add_filter($this->_formKey . "\x5f\145\x72\162\157\x72\x5f\x63\x6c\141\x73\x73", "\x5f\x73\162\145\x67\137\162\145\x74\x75\162\x6e\137\x65\162\x72\x6f\x72");
        return FALSE;
        mG:
        return TRUE;
    }
    function processAndStartOTPVerificationProcess($zC, $mo, $errors, $NN, $iK, $ck)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto O6;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto Ug;
        }
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::EMAIL, $iK, $ck);
        goto h8;
        Ug:
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::BOTH, $iK, $ck);
        h8:
        goto El;
        O6:
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::PHONE, $iK, $ck);
        El:
    }
    function register_simplr_user($iI, $p1, $iK, $NN, $ck)
    {
        $FA = array();
        global $sreg;
        if ($sreg) {
            goto Pv;
        }
        $sreg = new stdClass();
        Pv:
        $FA["\165\163\x65\x72\156\x61\155\x65"] = $iI;
        $FA["\145\155\141\151\154"] = $p1;
        $FA["\x70\x61\163\x73\x77\157\162\144"] = $iK;
        if (!$this->_formKey) {
            goto yV;
        }
        $FA[$this->_formKey] = $NN;
        yV:
        $FA = array_merge($FA, $ck);
        $Lg = $ck["\x61\x74\164\x73"];
        $sreg->output = simplr_setup_user($Lg, $FA);
        if (!MoUtility::isBlank($sreg->errors)) {
            goto mi;
        }
        $this->checkMessageAndRedirect($Lg);
        mi:
    }
    function checkMessageAndRedirect($Lg)
    {
        global $sreg, $simplr_options;
        $vw = isset($Lg["\164\x68\141\x6e\x6b\x73"]) ? get_permalink($Lg["\x74\x68\x61\x6e\x6b\163"]) : (!MoUtility::isBlank($simplr_options->thank_you) ? get_permalink($simplr_options->thank_you) : '');
        if (MoUtility::isBlank($vw)) {
            goto OZ;
        }
        wp_redirect($vw);
        exit;
        goto mO;
        OZ:
        $sreg->success = $sreg->output;
        mO:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto M4;
        }
        return;
        M4:
        $Bs = $this->getVerificationType();
        $MZ = $Bs === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        $this->unsetOTPSessionVariables();
        $this->register_simplr_user($iI, $p1, $iK, $NN, $ck);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto zE;
        }
        array_push($kp, $this->_phoneFormId);
        zE:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto k5;
        }
        return;
        k5:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x73\151\x6d\x70\x6c\x72\x5f\x64\x65\146\x61\x75\x6c\x74\x5f\145\156\141\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x73\151\x6d\x70\154\x72\x5f\145\156\141\142\154\145\x5f\x74\171\x70\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x73\151\155\x70\x6c\162\137\x70\x68\157\156\145\x5f\146\x69\145\x6c\x64\x5f\x6b\145\171");
        update_mo_option("\x73\x69\x6d\160\154\x72\137\x64\145\146\x61\x75\154\x74\x5f\145\x6e\141\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\163\x69\155\x70\x6c\162\x5f\x65\156\x61\142\x6c\x65\137\x74\171\x70\x65", $this->_otpType);
        update_mo_option("\x73\151\155\160\x6c\x72\137\146\x69\x65\x6c\144\x5f\153\145\171", $this->_phoneKey);
    }
}
