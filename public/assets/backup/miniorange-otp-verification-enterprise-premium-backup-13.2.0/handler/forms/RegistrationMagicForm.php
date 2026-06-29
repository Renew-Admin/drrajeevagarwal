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
class RegistrationMagicForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::CRF_DEFAULT_REG;
        $this->_typePhoneTag = "\155\x6f\137\143\162\146\x5f\x70\150\157\156\x65\x5f\x65\x6e\x61\142\x6c\x65";
        $this->_typeEmailTag = "\155\157\137\143\162\146\x5f\145\x6d\x61\151\154\137\145\x6e\141\x62\154\x65";
        $this->_typeBothTag = "\155\157\137\143\162\146\x5f\x62\x6f\164\150\137\145\x6e\141\142\x6c\145";
        $this->_formKey = "\103\122\x46\x5f\106\x4f\122\x4d";
        $this->_formName = mo_("\103\x75\163\164\x6f\x6d\x20\x55\163\x65\162\40\122\x65\147\151\x73\x74\x72\x61\164\151\157\156\x20\x46\157\162\x6d\40\102\x75\151\x6c\144\x65\162\40\50\x52\145\x67\x69\x73\164\162\x61\x74\151\157\156\40\x4d\x61\147\151\143\51");
        $this->_isFormEnabled = get_mo_option("\x63\162\x66\x5f\144\145\146\141\165\154\164\137\x65\x6e\x61\142\x6c\x65");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::CRF_FORM_ENABLE;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\143\162\146\137\145\x6e\x61\x62\x6c\x65\137\x74\171\160\145");
        $this->_restrictDuplicates = get_mo_option("\143\162\146\137\x72\145\x73\x74\162\151\143\164\137\x64\x75\x70\x6c\x69\x63\141\x74\145\x73");
        $this->_formDetails = maybe_unserialize(get_mo_option("\143\x72\146\x5f\x6f\x74\160\137\x65\x6e\141\142\154\x65\x64"));
        if (!empty($this->_formDetails)) {
            goto oJ;
        }
        return;
        oJ:
        foreach ($this->_formDetails as $j1 => $qL) {
            array_push($this->_phoneFormId, "\x69\x6e\160\x75\164\133\x6e\141\x6d\x65\x3d" . $this->getFieldID($qL["\160\150\157\156\145\153\145\x79"], $j1) . "\x5d");
            LQ:
        }
        rG:
        if ($this->checkIfPromptForOTP()) {
            goto aK;
        }
        return;
        aK:
        $this->_handle_crf_form_submit($_REQUEST);
    }
    private function checkIfPromptForOTP()
    {
        if (!(array_key_exists("\x6f\x70\x74\151\x6f\156", $_POST) || !array_key_exists("\x72\x6d\x5f\146\157\x72\155\137\x73\165\x62\137\x69\144", $_POST))) {
            goto qq;
        }
        return FALSE;
        qq:
        foreach ($this->_formDetails as $j1 => $qL) {
            if (!(strpos(sanitize_text_field($_POST["\162\155\137\146\157\x72\155\x5f\163\165\x62\x5f\x69\144"]), "\146\157\162\x6d\x5f" . $j1 . "\x5f") !== FALSE)) {
                goto Rh;
            }
            MoUtility::initialize_transaction($this->_formSessionVar);
            SessionUtils::setFormOrFieldId($this->_formSessionVar, $j1);
            return TRUE;
            Rh:
            E_:
        }
        CO:
        return FALSE;
    }
    private function isPhoneVerificationEnabled()
    {
        $Bs = $this->getVerificationType();
        return $Bs === VerificationType::PHONE || $Bs === VerificationType::BOTH;
    }
    private function isEmailVerificationEnabled()
    {
        $Bs = $this->getVerificationType();
        return $Bs === VerificationType::EMAIL || $Bs === VerificationType::BOTH;
    }
    private function _handle_crf_form_submit($aC)
    {
        $mo = $this->isEmailVerificationEnabled() ? $this->getCRFEmailFromRequest($aC) : '';
        $Dk = $this->isPhoneVerificationEnabled() ? $this->getCRFPhoneFromRequest($aC) : '';
        $this->miniorange_crf_user($mo, isset($aC["\165\x73\145\x72\137\156\141\x6d\145"]) ? sanitize_text_field($aC["\x75\163\145\x72\137\x6e\x61\x6d\145"]) : NULL, $Dk);
        $this->checkIfValidated();
    }
    private function checkIfValidated()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto nY;
        }
        $this->unsetOTPSessionVariables();
        nY:
    }
    private function getCRFEmailFromRequest($aC)
    {
        $zB = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $vH = $this->_formDetails[$zB]["\x65\x6d\x61\151\x6c\153\145\171"];
        return $this->getFormPostSubmittedValue($this->getFieldID($vH, $zB), $aC);
    }
    private function getCRFPhoneFromRequest($aC)
    {
        $zB = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $oL = $this->_formDetails[$zB]["\x70\x68\x6f\x6e\x65\x6b\x65\x79"];
        return $this->getFormPostSubmittedValue($this->getFieldID($oL, $zB), $aC);
    }
    private function getFormPostSubmittedValue($xO, $aC)
    {
        return isset($aC[$xO]) ? $aC[$xO] : '';
    }
    private function getFieldID($j1, $dZ)
    {
        global $wpdb;
        $Pe = $wpdb->prefix . "\162\x6d\x5f\146\151\145\154\144\x73";
        $Au = $wpdb->get_row("\x53\x45\114\x45\103\124\40\52\x20\x46\122\117\115\40{$Pe}\x20\167\x68\145\x72\145\40\146\157\x72\155\x5f\x69\144\x20\75\x20\x27" . $dZ . "\47\40\x61\156\144\40\146\x69\x65\154\x64\x5f\x6c\x61\x62\145\154\x20\75\47" . $j1 . "\47");
        return isset($Au) ? ($Au->field_type == "\x4d\157\x62\151\154\145" ? "\x54\145\x78\164\142\157\170" : $Au->field_type) . "\137" . $Au->field_id : "\x6e\x75\x6c\x6c";
    }
    private function miniorange_crf_user($p1, $Rk, $NN)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        if (!$this->isPhoneNumberAlreadyInUse($NN)) {
            goto o5;
        }
        miniorange_site_otp_validation_form('', '', '', "\x50\x68\157\156\145\40\x6e\x75\x6d\142\x65\162\40\x61\154\x72\x65\141\x64\171\40\151\x6e\40\165\x73\x65\x2e\40\120\x6c\x65\141\x73\145\40\105\156\x74\x65\162\40\x61\x20\144\x69\x66\x66\x65\x72\x65\156\164\40\x50\150\157\x6e\145\x20\156\165\x6d\x62\145\x72\56", '', '');
        o5:
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto k1;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto jJ;
        }
        $this->sendChallenge($Rk, $p1, $errors, $NN, VerificationType::EMAIL);
        goto AW;
        jJ:
        $this->sendChallenge($Rk, $p1, $errors, $NN, VerificationType::BOTH);
        AW:
        goto Nd;
        k1:
        $this->sendChallenge($Rk, $p1, $errors, $NN, VerificationType::PHONE);
        Nd:
    }
    function isPhoneNumberAlreadyInUse($Dk)
    {
        if (!$this->_restrictDuplicates) {
            goto EN;
        }
        global $wpdb;
        $Dk = MoUtility::processPhoneNumber($Dk);
        $le = $wpdb->get_row("\x53\105\x4c\105\103\124\40\x60\165\x73\145\162\137\151\x64\x60\x20\106\x52\117\x4d\x20\x60{$wpdb->prefix}\165\163\145\162\x6d\x65\164\141\x60\x20\127\x48\105\122\105\x20\x60\x6d\x65\x74\x61\x5f\x76\x61\x6c\165\x65\x60\40\75\x20\47{$Dk}\x27");
        return !MoUtility::isBlank($le);
        EN:
        return false;
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Rf;
        }
        return;
        Rf:
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
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto pY;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        pY:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Gq;
        }
        return;
        Gq:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x63\162\x66\137\144\145\x66\141\165\x6c\x74\x5f\x65\x6e\x61\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\143\x72\x66\x5f\x65\x6e\x61\x62\154\x65\x5f\164\171\x70\145");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x63\162\146\x5f\162\145\x73\x74\x72\151\x63\164\137\x64\x75\x70\x6c\x69\143\141\164\x65\x73");
        update_mo_option("\143\x72\x66\137\x64\x65\146\x61\x75\154\x74\137\145\x6e\141\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x63\162\146\137\x65\x6e\141\x62\x6c\145\x5f\x74\x79\160\145", $this->_otpType);
        update_mo_option("\x63\162\x66\137\x6f\164\x70\137\145\156\x61\x62\x6c\x65\144", maybe_serialize($this->_formDetails));
        update_mo_option("\x63\x72\146\137\x72\145\163\x74\162\x69\x63\164\x5f\x64\165\160\154\151\143\x61\x74\145\x73", $this->_restrictDuplicates);
    }
    function parseFormDetails()
    {
        $form = array();
        if (!(!array_key_exists("\143\x72\146\x5f\146\157\162\155", $_POST) && empty($_POST["\x63\162\146\x5f\x66\157\x72\155"]["\x66\157\162\x6d"]))) {
            goto lU;
        }
        return $form;
        lU:
        foreach (array_filter($_POST["\143\x72\146\x5f\146\157\x72\x6d"]["\x66\x6f\x72\x6d"]) as $j1 => $qL) {
            $form[sanitize_text_field($qL)] = array("\x65\155\141\x69\x6c\x6b\x65\x79" => sanitize_text_field($_POST["\143\162\x66\137\x66\x6f\x72\x6d"]["\x65\155\141\151\x6c\x6b\x65\171"][$j1]), "\x70\x68\157\156\145\153\145\171" => sanitize_text_field($_POST["\x63\162\x66\137\x66\157\162\155"]["\x70\x68\157\156\145\153\145\171"][$j1]), "\145\155\x61\151\154\137\x73\x68\x6f\x77" => sanitize_text_field($_POST["\x63\162\146\137\146\157\x72\x6d"]["\145\x6d\x61\151\x6c\x6b\x65\x79"][$j1]), "\x70\150\x6f\x6e\145\137\163\150\x6f\x77" => sanitize_text_field($_POST["\143\162\146\x5f\x66\x6f\x72\155"]["\160\x68\x6f\156\x65\153\x65\171"][$j1]));
            nn:
        }
        ei:
        return $form;
    }
}
