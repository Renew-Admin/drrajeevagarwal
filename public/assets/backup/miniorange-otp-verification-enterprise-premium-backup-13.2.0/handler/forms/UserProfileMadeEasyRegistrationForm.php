<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class UserProfileMadeEasyRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::UPME_REG;
        $this->_typePhoneTag = "\155\157\137\x75\160\x6d\x65\137\x70\150\157\156\145\137\145\156\x61\x62\154\145";
        $this->_typeEmailTag = "\x6d\x6f\137\165\160\x6d\x65\x5f\x65\x6d\x61\151\x6c\x5f\145\x6e\x61\x62\x6c\x65";
        $this->_typeBothTag = "\155\157\137\x75\x70\x6d\x65\x5f\142\157\x74\x68\137\145\x6e\141\x62\154\145";
        $this->_formKey = "\x55\120\x4d\x45\x5f\x46\117\x52\115";
        $this->_formName = mo_("\x55\163\145\x72\120\x72\157\x66\151\154\x65\40\115\141\x64\x65\40\105\x61\163\x79\40\x52\x65\147\151\163\x74\x72\141\164\151\157\x6e\40\x46\x6f\162\155");
        $this->_isFormEnabled = get_mo_option("\165\160\155\145\x5f\x64\x65\x66\141\x75\154\x74\137\x65\156\x61\x62\154\x65");
        $this->_formDocuments = MoOTPDocs::UPME_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x75\x70\155\145\x5f\145\156\141\142\x6c\x65\137\x74\x79\160\x65");
        $this->_phoneKey = get_mo_option("\x75\160\155\145\x5f\x70\150\x6f\x6e\145\137\153\145\x79");
        $this->_phoneFormId = "\151\x6e\x70\165\x74\x5b\156\141\x6d\x65\75" . $this->_phoneKey . "\x5d";
        add_filter("\x69\x6e\x73\x65\162\x74\137\165\163\x65\162\137\155\145\164\x61", array($this, "\155\151\156\x69\157\x72\x61\156\147\145\137\165\x70\155\145\x5f\x69\156\163\x65\162\x74\x5f\165\163\145\162"), 1, 3);
        add_filter("\165\x70\155\x65\x5f\x72\145\147\151\163\164\162\141\164\151\157\x6e\137\143\165\x73\164\157\155\x5f\146\151\x65\154\144\x5f\164\171\x70\145\137\162\145\163\x74\x72\151\x63\164\x69\x6f\x6e\x73", array($this, "\155\151\x6e\151\x6f\162\x61\156\x67\x65\x5f\x75\160\x6d\x65\x5f\x63\x68\x65\x63\153\137\160\150\157\156\145"), 1, 2);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto GO;
        }
        if (array_key_exists("\165\x70\155\x65\x2d\x72\145\x67\x69\163\x74\145\x72\x2d\x66\x6f\x72\x6d", $_POST) && !SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Sx;
        }
        goto lv;
        GO:
        $this->unsetOTPSessionVariables();
        goto lv;
        Sx:
        $this->_handle_upme_form_submit($_POST);
        lv:
    }
    function isPhoneVerificationEnabled()
    {
        $Bs = $this->getVerificationType();
        return $Bs === VerificationType::PHONE || $Bs === VerificationType::BOTH;
    }
    function _handle_upme_form_submit($kd)
    {
        $wI = '';
        foreach ($kd as $j1 => $qL) {
            if (!($j1 == $this->_phoneKey)) {
                goto kZ;
            }
            $wI = $qL;
            goto BF;
            kZ:
            aU:
        }
        BF:
        $this->miniorange_upme_user(sanitize_text_field($_POST["\165\x73\x65\x72\137\x6c\157\147\151\x6e"]), sanitize_email($_POST["\x75\163\x65\x72\x5f\x65\155\x61\151\x6c"]), $wI);
    }
    function miniorange_upme_insert_user($Tk, $user, $XE)
    {
        $z7 = MoPHPSessions::getSessionVar("\x66\x69\154\145\137\x75\x70\154\x6f\141\144");
        if (!(!SessionUtils::isOTPInitialized($this->_formSessionVar) || !$z7)) {
            goto pC;
        }
        return $Tk;
        pC:
        foreach ($z7 as $j1 => $qL) {
            $m0 = get_user_meta($user->ID, $j1, true);
            if (!('' != $m0)) {
                goto pK;
            }
            upme_delete_uploads_folder_files($m0);
            pK:
            update_user_meta($user->ID, $j1, $qL);
            dD:
        }
        lD:
        return $Tk;
    }
    function miniorange_upme_check_phone($errors, $Xw)
    {
        global $phoneLogic;
        if (!empty($errors)) {
            goto I2;
        }
        if (!($Xw["\155\145\164\x61"] == $this->_phoneKey)) {
            goto Ez;
        }
        if (MoUtility::validatePhoneNumber($Xw["\x76\141\154\165\x65"])) {
            goto LC;
        }
        $errors[] = str_replace("\x23\43\x70\150\157\x6e\145\43\43", $Xw["\166\x61\154\x75\145"], $phoneLogic->_get_otp_invalid_format_message());
        LC:
        Ez:
        I2:
        return $errors;
    }
    function miniorange_upme_user($Rk, $p1, $NN)
    {
        global $upme_register;
        $upme_register->prepare($_POST);
        $upme_register->handle();
        $z7 = array();
        if (MoUtility::isBlank($upme_register->errors)) {
            goto iD;
        }
        return;
        iD:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->processFileUpload($z7);
        MoPHPSessions::addSessionVar("\146\151\x6c\145\137\x75\160\x6c\157\141\144", $z7);
        $this->processAndStartOTPVerification($Rk, $p1, $NN);
    }
    function processFileUpload(&$z7)
    {
        if (!empty($_FILES)) {
            goto w9;
        }
        return;
        w9:
        $oD = wp_upload_dir();
        $v3 = $oD["\x62\141\x73\145\x64\151\162"] . "\57\x75\x70\155\x65\57";
        if (is_dir($v3)) {
            goto xV;
        }
        mkdir($v3, 0777);
        xV:
        foreach ($_FILES as $j1 => $Uc) {
            $GL = sanitize_file_name(basename($Uc["\156\141\155\145"]));
            $v3 = $v3 . time() . "\x5f" . $GL;
            $iR = $oD["\142\x61\163\145\165\x72\154"] . "\x2f\x75\160\155\x65\x2f";
            $iR = $iR . time() . "\137" . $GL;
            move_uploaded_file($Uc["\x74\x6d\x70\x5f\x6e\141\x6d\145"], $v3);
            $z7[$j1] = $iR;
            Xt:
        }
        i3:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto GX;
        }
        array_push($kp, $this->_phoneFormId);
        GX:
        return $kp;
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
    function processAndStartOTPVerification($Rk, $p1, $NN)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Kl;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto Fh;
        }
        $this->sendChallenge($Rk, $p1, null, $NN, VerificationType::EMAIL);
        goto hd;
        Fh:
        $this->sendChallenge($Rk, $p1, null, $NN, VerificationType::BOTH);
        hd:
        goto T3;
        Kl:
        $this->sendChallenge($Rk, $p1, null, $NN, VerificationType::PHONE);
        T3:
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto EI;
        }
        return;
        EI:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\x70\x6d\145\x5f\x64\x65\146\141\165\154\x74\137\x65\x6e\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x75\160\x6d\145\137\145\156\x61\x62\154\x65\x5f\x74\x79\x70\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\x70\155\145\137\160\150\x6f\x6e\145\x5f\146\151\145\154\144\137\153\x65\171");
        update_mo_option("\165\x70\x6d\145\137\144\145\x66\141\165\154\164\x5f\x65\156\141\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\165\160\x6d\x65\x5f\x65\x6e\x61\142\x6c\145\137\x74\171\160\x65", $this->_otpType);
        update_mo_option("\165\160\155\145\x5f\x70\150\x6f\x6e\x65\137\153\145\x79", $this->_phoneKey);
    }
}
