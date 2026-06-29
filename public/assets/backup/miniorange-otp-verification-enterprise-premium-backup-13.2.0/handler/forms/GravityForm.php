<?php


namespace OTP\Handler\Forms;

use GF_Field;
use GFAPI;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class GravityForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::GF_FORMS;
        $this->_typePhoneTag = "\155\x6f\137\x67\146\137\x63\x6f\x6e\x74\x61\x63\164\x5f\160\150\157\156\145\x5f\x65\156\x61\142\154\x65";
        $this->_typeEmailTag = "\155\x6f\137\147\x66\x5f\143\157\x6e\164\x61\143\164\x5f\145\155\141\151\154\x5f\x65\x6e\x61\x62\x6c\145";
        $this->_formKey = "\x47\x52\x41\x56\111\124\131\x5f\106\x4f\x52\115";
        $this->_formName = mo_("\x47\162\141\166\x69\164\x79\40\106\x6f\162\155");
        $this->_isFormEnabled = get_mo_option("\x67\146\137\x63\x6f\156\164\x61\143\164\x5f\x65\x6e\141\142\x6c\x65");
        $this->_phoneFormId = "\x2e\147\x69\156\x70\x75\x74\137\143\x6f\156\164\141\x69\156\x65\162\137\160\x68\x6f\x6e\145";
        $this->_buttonText = get_mo_option("\147\146\x5f\142\x75\164\164\x6f\156\137\x74\145\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\154\151\143\x6b\x20\x48\x65\x72\145\x20\164\157\40\x73\145\156\144\40\x4f\124\x50");
        $this->_formDocuments = MoOTPDocs::GF_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\147\146\137\x63\x6f\156\x74\141\143\x74\x5f\x74\x79\160\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\147\x66\x5f\x6f\x74\x70\137\145\156\141\142\x6c\145\x64"));
        if (!empty($this->_formDetails)) {
            goto q8;
        }
        return;
        q8:
        add_filter("\x67\146\x6f\162\155\x5f\146\x69\x65\x6c\x64\x5f\x63\x6f\x6e\164\x65\x6e\164", array($this, "\x5f\141\x64\x64\137\163\x63\162\x69\160\x74\x73"), 1, 5);
        add_filter("\147\x66\x6f\162\x6d\x5f\146\x69\145\154\x64\137\x76\141\x6c\x69\x64\141\x74\151\x6f\x6e", array($this, "\x76\141\x6c\151\144\x61\164\x65\x5f\x66\x6f\162\x6d\137\163\165\142\x6d\151\x74"), 1, 5);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\x70\164\151\157\156", $_GET)) {
            goto Y4;
        }
        return;
        Y4:
        switch (trim($_GET["\157\160\164\x69\x6f\156"])) {
            case "\x6d\151\156\x69\x6f\162\141\156\147\x65\55\147\146\x2d\x63\157\x6e\164\x61\143\x74":
                $this->_handle_gf_form($_POST);
                goto Tk;
        }
        Nc:
        Tk:
    }
    function _handle_gf_form($Un)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (!($this->_otpType === $this->_typeEmailTag)) {
            goto L3;
        }
        $this->processEmailAndStartOTPVerificationProcess($Un);
        L3:
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto i4;
        }
        $this->processPhoneAndStartOTPVerificationProcess($Un);
        i4:
    }
    function processEmailAndStartOTPVerificationProcess($Un)
    {
        if (MoUtility::sanitizeCheck("\x75\163\x65\162\x5f\145\155\x61\x69\x6c", $Un)) {
            goto Wo;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto ti;
        Wo:
        SessionUtils::addEmailVerified($this->_formSessionVar, $Un["\x75\x73\145\162\x5f\145\155\x61\151\154"]);
        $this->sendChallenge('', $Un["\165\x73\145\x72\137\145\x6d\141\151\x6c"], null, $Un["\165\x73\x65\162\x5f\x65\155\141\x69\x6c"], VerificationType::EMAIL);
        ti:
    }
    function processPhoneAndStartOTPVerificationProcess($Un)
    {
        if (MoUtility::sanitizeCheck("\165\x73\145\162\137\160\x68\157\156\145", $Un)) {
            goto SV;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto oW;
        SV:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($Un["\x75\163\x65\162\137\160\x68\x6f\156\x65"]));
        $this->sendChallenge('', '', null, trim($Un["\x75\163\145\162\x5f\x70\150\x6f\x6e\145"]), VerificationType::PHONE);
        oW:
    }
    function _add_scripts($rI, $QO, $qL, $qw, $fk)
    {
        $zA = $this->_formDetails[$fk];
        if (MoUtility::isBlank($zA)) {
            goto Ql;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && get_class($QO) === "\x47\x46\x5f\x46\x69\x65\x6c\144\x5f\105\x6d\x61\x69\x6c" && $QO["\151\x64"] == $zA["\145\155\x61\151\x6c\x6b\x65\x79"])) {
            goto sV;
        }
        $rI = $this->_add_shortcode_to_form("\x65\x6d\141\x69\x6c", $rI, $QO, $fk);
        sV:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && get_class($QO) === "\x47\x46\x5f\106\151\x65\154\x64\x5f\x50\150\x6f\156\145" && $QO["\151\x64"] == $zA["\160\150\x6f\156\145\153\145\171"])) {
            goto Ns;
        }
        $rI = $this->_add_shortcode_to_form("\x70\150\x6f\x6e\x65", $rI, $QO, $fk);
        Ns:
        Ql:
        return $rI;
    }
    function _add_shortcode_to_form($Xm, $rI, $QO, $fk)
    {
        $Ev = "<div style='display:table;text-align:center;'><img decoding='async' src='".MOV_URL. "includes/images/loader.gif'></div>";
        $rI .= "\74\x64\151\166\40\163\x74\x79\x6c\x65\75\47\x6d\x61\162\x67\x69\x6e\x2d\x74\157\160\x3a\40\62\45\x3b\x27\x3e\x3c\151\x6e\x70\x75\x74\40\x74\171\160\x65\75\x27\142\165\x74\x74\157\156\x27\x20\143\154\x61\x73\x73\75\x27\x67\146\x6f\162\x6d\x5f\x62\x75\x74\x74\157\156\x20\142\x75\x74\164\157\156\40\155\145\144\x69\x75\155\47\x20";
        $rI .= "\x69\144\x3d\47\x6d\x69\x6e\151\157\162\x61\156\x67\x65\137\x6f\x74\x70\137\x74\x6f\x6b\145\x6e\x5f\x73\165\x62\155\151\164\47\x20\x74\x69\164\154\x65\x3d\x27\120\x6c\145\x61\x73\x65\x20\x45\x6e\164\145\162\40\141\x6e\x20" . $Xm . "\x20\x74\157\x20\145\156\x61\142\154\145\x20\164\150\x69\163\47\40";
        $rI .= "\x76\x61\154\165\x65\75\40\47" . mo_($this->_buttonText) . "\47\x3e\x3c\x64\x69\166\40\163\x74\x79\x6c\x65\75\47\155\141\x72\147\151\x6e\x2d\164\157\160\72\62\45\47\x3e";
        $rI .= "\74\x64\x69\x76\x20\x69\x64\75\47\155\x6f\137\x6d\145\x73\x73\141\x67\145\47\40\150\x69\x64\144\x65\x6e\x3d\x27\47\x20\x73\164\x79\154\145\x3d\47\142\141\x63\x6b\147\x72\x6f\x75\156\x64\x2d\x63\x6f\154\x6f\162\72\40\43\146\x37\146\66\146\67\73\160\141\x64\144\x69\x6e\147\72\x20\61\145\155\x20\62\x65\155\40\x31\x65\x6d\x20\x33\56\65\x65\155\73\x27\x3e\74\x2f\144\151\166\76\x3c\57\x64\x69\166\x3e\74\57\144\x69\166\76";
        $rI .= "\74\x73\164\171\154\145\76\100\155\145\144\151\141\x20\157\x6e\x6c\x79\x20\163\x63\x72\145\145\156\40\141\156\144\x20\50\x6d\151\x6e\55\167\151\144\164\x68\72\x20\66\64\61\160\x78\x29\x20\173\x20\43\x6d\x6f\137\155\x65\x73\163\141\x67\x65\40\173\x20\x77\151\x64\164\x68\72\x20\x63\141\x6c\143\x28\65\60\45\x20\55\x20\70\x70\170\51\x3b\175\175\74\x2f\163\x74\171\x6c\145\76";
        $rI .= "\74\x73\x63\x72\151\160\164\76\152\x51\x75\x65\162\x79\50\144\157\x63\165\x6d\145\156\x74\x29\x2e\162\x65\x61\144\171\50\x66\165\x6e\143\164\x69\x6f\x6e\x28\51\173\44\155\157\x3d\x6a\x51\x75\145\x72\171\73\x24\x6d\x6f\x28\x22\43\x67\146\x6f\x72\x6d\x5f" . $fk . "\40\x23\x6d\151\156\x69\157\x72\x61\156\147\145\137\157\164\x70\x5f\x74\x6f\x6b\x65\156\137\x73\165\142\155\151\164\42\x29\x2e\x63\x6c\x69\x63\x6b\x28\x66\165\x6e\x63\x74\x69\x6f\x6e\x28\157\x29\173";
        $rI .= "\166\141\x72\x20\145\x3d\44\155\x6f\x28\x22\x23\x69\156\160\x75\164\x5f" . $fk . "\x5f" . $QO->id . "\42\51\56\166\141\x6c\x28\x29\73\x20\x24\x6d\x6f\50\42\x23\x67\x66\x6f\162\155\x5f" . $fk . "\40\43\x6d\x6f\x5f\x6d\x65\x73\x73\x61\147\145\x22\x29\56\145\155\160\x74\171\x28\51\x2c\44\x6d\157\x28\x22\x23\147\146\157\x72\x6d\137" . $fk . "\40\x23\155\157\137\x6d\145\x73\x73\141\x67\x65\42\51\56\141\x70\160\x65\156\x64\x28\42" . $Ev . "\x22\x29";
        $rI .= "\x2c\44\155\157\x28\x22\x23\147\x66\x6f\162\155\137" . $fk . "\x20\43\155\x6f\137\155\145\x73\163\141\x67\x65\42\x29\x2e\163\150\x6f\167\x28\51\54\x24\155\x6f\x2e\x61\152\x61\x78\50\x7b\165\162\x6c\x3a\42" . site_url() . "\57\x3f\157\x70\164\151\x6f\156\x3d\155\x69\156\151\157\162\x61\x6e\147\145\55\147\146\55\143\157\156\164\141\x63\x74\x22\54\164\x79\160\145\x3a\42\120\117\x53\x54\x22\54\x64\141\164\141\x3a\173\x75\163\x65\162\x5f";
        $rI .= $Xm . "\x3a\145\x7d\x2c\x63\162\x6f\163\x73\104\x6f\155\141\x69\x6e\72\41\x30\x2c\144\141\164\141\x54\171\x70\145\x3a\x22\152\x73\x6f\x6e\42\x2c\163\165\x63\x63\x65\163\x73\72\146\x75\156\x63\x74\x69\157\x6e\50\157\x29\173\40\151\x66\x28\x6f\x2e\162\145\x73\165\x6c\x74\75\75\x3d\x22\163\x75\x63\143\145\x73\x73\42\x29\x7b\x24\x6d\157\50\42\x23\147\x66\x6f\162\155\x5f" . $fk . "\x20\x23\x6d\157\x5f\155\x65\163\163\141\147\145\x22\x29\x2e\x65\x6d\160\164\x79\x28\51";
        $rI .= "\54\x24\x6d\157\50\42\x23\147\146\157\x72\155\137" . $fk . "\40\x23\x6d\x6f\x5f\155\x65\x73\x73\141\147\145\x22\51\56\x61\x70\160\x65\x6e\144\x28\x6f\56\x6d\145\163\163\x61\x67\x65\x29\x2c\44\x6d\x6f\x28\42\43\x67\146\157\x72\155\137" . $fk . "\40\43\155\x6f\137\x6d\x65\163\x73\141\147\x65\x22\51\x2e\143\163\x73\50\42\x62\157\162\x64\x65\162\x2d\x74\x6f\160\x22\x2c\x22\63\160\x78\40\163\x6f\154\x69\x64\40\147\162\x65\145\x6e\42\x29\54\x24\x6d\x6f\50\x22";
        $rI .= "\x23\147\146\x6f\x72\x6d\x5f" . $fk . "\x20\x69\x6e\160\x75\164\x5b\156\x61\155\145\x3d\145\155\141\x69\154\x5f\166\x65\162\x69\x66\x79\x5d\x22\x29\x2e\x66\157\x63\x75\163\50\x29\x7d\145\154\x73\x65\173\44\x6d\157\x28\42\x23\147\146\157\162\x6d\x5f" . $fk . "\40\x23\x6d\157\x5f\x6d\x65\x73\163\141\147\145\x22\51\x2e\145\x6d\160\164\x79\x28\51\x2c\x24\x6d\x6f\x28\x22\43\147\x66\x6f\162\x6d\137" . $fk . "\x20\43\x6d\157\x5f\x6d\x65\x73\x73\x61\147\x65\x22\51\56\x61\160\160\145\x6e\144\50\x6f\56\x6d\x65\x73\x73\141\x67\145\51\x2c";
        $rI .= "\44\x6d\x6f\x28\42\43\147\x66\157\162\155\x5f" . $fk . "\x20\43\155\157\x5f\x6d\x65\x73\x73\x61\x67\x65\42\51\x2e\x63\163\x73\x28\42\142\x6f\162\144\x65\x72\55\x74\157\x70\42\54\x22\63\x70\170\x20\x73\157\154\x69\144\x20\x72\x65\x64\42\x29\x2c\x24\x6d\157\50\x22\43\x67\x66\x6f\162\155\x5f" . $fk . "\x20\x69\x6e\x70\165\164\133\x6e\x61\155\x65\x3d\x70\150\x6f\156\145\137\x76\145\162\x69\146\171\x5d\x22\51\56\146\x6f\x63\x75\x73\x28\x29\175\x20\73\x7d\x2c";
        $rI .= "\x65\x72\162\157\162\72\x66\x75\x6e\143\164\151\x6f\156\50\x6f\x2c\145\54\156\51\173\175\175\x29\x7d\51\73\x7d\51\x3b\x3c\57\163\x63\162\151\160\x74\x3e";
        return $rI;
    }
    function validate_form_submit($uV, $qL, $form, $QO)
    {
        $VU = MoUtility::sanitizeCheck($QO->formId, $this->_formDetails);
        if (!($VU && $uV["\x69\x73\137\166\141\154\151\144"] == 1)) {
            goto xk;
        }
        if (strpos($QO->label, $VU["\166\145\x72\x69\146\x79\113\x65\x79"]) !== false && SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto dJ;
        }
        if (!$this->isEmailOrPhoneField($QO, $VU)) {
            goto yr;
        }
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Rq;
        }
        $uV = ["\x69\x73\137\166\141\x6c\151\144" => null, "\x6d\145\x73\163\x61\147\145" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE)];
        goto TI;
        Rq:
        $uV = $this->validate_submitted_email_or_phone($uV["\151\x73\137\x76\141\154\151\x64"], $qL, $uV);
        TI:
        yr:
        goto AA;
        dJ:
        $uV = $this->validate_otp($uV, $qL);
        AA:
        xk:
        return $uV;
    }
    function validate_otp($uV, $qL)
    {
        $tA = $this->getVerificationType();
        if (MoUtility::isBlank($qL)) {
            goto nM;
        }
        $this->validateChallenge($tA, NULL, $qL);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $tA)) {
            goto Wa;
        }
        $this->unsetOTPSessionVariables();
        goto Dp;
        Wa:
        $uV = ["\151\163\x5f\x76\141\154\x69\x64" => null, "\155\145\163\x73\x61\x67\x65" => MoUtility::_get_invalid_otp_method()];
        Dp:
        goto Ea;
        nM:
        $uV = ["\151\163\x5f\x76\x61\x6c\151\x64" => null, "\155\x65\x73\163\141\x67\145" => MoUtility::_get_invalid_otp_method()];
        Ea:
        return $uV;
    }
    function validate_submitted_email_or_phone($GF, $qL, $uV)
    {
        $tA = $this->getVerificationType();
        if (!$GF) {
            goto PI;
        }
        if ($tA === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $qL)) {
            goto Q7;
        }
        if (!($tA === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $qL))) {
            goto t8;
        }
        return array("\x69\x73\137\x76\141\154\151\144" => null, "\x6d\145\163\x73\141\x67\145" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        t8:
        goto vd;
        Q7:
        return array("\x69\163\x5f\x76\141\x6c\151\144" => null, "\155\145\163\163\x61\147\x65" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        vd:
        PI:
        return $uV;
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
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
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto e3;
        }
        foreach ($this->_formDetails as $j1 => $Ne) {
            $KP = sprintf("\x25\x73\137\x25\x64\x5f\x25\144", "\151\x6e\x70\165\x74", $j1, $Ne["\160\150\x6f\x6e\145\x6b\145\171"]);
            array_push($kp, sprintf("\45\163\x20\43\45\x73", $this->_phoneFormId, $KP));
            Ie:
        }
        Tb:
        e3:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto dG;
        }
        return;
        dG:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x67\146\x5f\143\157\x6e\x74\141\143\x74\x5f\145\156\141\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\147\146\137\x63\x6f\x6e\164\x61\143\x74\x5f\x74\171\160\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\x67\x66\137\x62\x75\x74\164\x6f\x6e\137\x74\145\170\x74");
        $rW = $this->parseFormDetails();
        $this->_formDetails = is_array($rW) ? $rW : '';
        update_mo_option("\x67\x66\x5f\157\164\160\x5f\145\x6e\x61\142\x6c\145\x64", maybe_serialize($this->_formDetails));
        update_mo_option("\x67\x66\137\x63\157\156\164\141\143\x74\x5f\145\156\141\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x67\146\x5f\x63\157\x6e\164\141\x63\164\x5f\164\171\x70\x65", $this->_otpType);
        update_mo_option("\147\x66\x5f\142\x75\164\x74\157\x6e\137\x74\145\170\164", $this->_buttonText);
    }
    private function parseFormDetails()
    {
        $rW = [];
        $wh = function ($uT, $Rd, $uO) {
            foreach ($uT as $QO) {
                if (!(get_class($QO) === $uO && $QO["\x6c\141\x62\145\154"] == $Rd)) {
                    goto Ht;
                }
                return $QO["\151\144"];
                Ht:
                kx:
            }
            yn:
            return null;
        };
        $form = NULL;
        if (!(!array_key_exists("\x67\162\x61\x76\151\164\171\x5f\x66\157\162\155", $_POST) || !$this->_isFormEnabled)) {
            goto XW;
        }
        return array();
        XW:
        foreach (array_filter($_POST["\147\162\141\x76\151\164\171\137\146\157\162\155"]["\146\157\162\155"]) as $j1 => $qL) {
            $zA = GFAPI::get_form($qL);
            $vH = sanitize_text_field($_POST["\147\162\x61\x76\x69\164\x79\137\x66\x6f\162\x6d"]["\145\x6d\141\x69\x6c\153\x65\171"][$j1]);
            $Z1 = sanitize_text_field($_POST["\x67\162\141\x76\x69\x74\x79\x5f\146\x6f\x72\x6d"]["\160\150\157\x6e\x65\153\145\171"][$j1]);
            $rW[sanitize_text_field($qL)] = array("\145\155\x61\x69\x6c\x6b\x65\171" => $wh($zA["\x66\151\x65\154\x64\x73"], $vH, "\x47\x46\x5f\106\x69\145\154\144\137\105\155\x61\x69\154"), "\x70\x68\x6f\x6e\x65\x6b\145\x79" => $wh($zA["\146\x69\x65\x6c\x64\x73"], $Z1, "\x47\106\x5f\106\151\145\154\144\x5f\x50\150\x6f\156\x65"), "\x76\145\x72\x69\x66\171\x4b\145\x79" => sanitize_text_field($_POST["\x67\x72\141\166\x69\164\x79\137\146\157\162\x6d"]["\x76\x65\x72\x69\x66\171\x4b\x65\171"][$j1]), "\x70\x68\157\156\145\137\x73\x68\x6f\167" => sanitize_text_field($_POST["\x67\162\141\166\x69\164\x79\x5f\146\x6f\x72\x6d"]["\160\x68\157\156\x65\x6b\x65\171"][$j1]), "\x65\155\141\x69\154\x5f\163\150\x6f\167" => sanitize_text_field($_POST["\147\162\141\166\x69\164\x79\x5f\146\157\162\x6d"]["\145\x6d\141\151\x6c\153\x65\x79"][$j1]), "\166\145\162\x69\x66\171\x5f\x73\150\x6f\167" => sanitize_text_field($_POST["\147\162\x61\166\x69\164\171\137\x66\x6f\162\155"]["\166\145\162\151\x66\x79\113\145\171"][$j1]));
            FK:
        }
        uM:
        return $rW;
    }
    private function isEmailOrPhoneField($QO, $cP)
    {
        return $this->_otpType === $this->_typePhoneTag && $QO->id === $cP["\160\150\x6f\x6e\x65\153\145\171"] || $this->_otpType === $this->_typeEmailTag && $QO->id === $cP["\x65\155\141\151\x6c\x6b\x65\171"];
    }
}
