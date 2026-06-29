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
class FormMaker extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORM_MAKER;
        $this->_typePhoneTag = "\x6d\157\137\x66\157\x72\x6d\x5f\x6d\141\153\x65\162\x5f\160\x68\x6f\156\145\137\x65\156\141\x62\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\x66\157\x72\x6d\x5f\155\x61\x6b\145\x72\x5f\145\x6d\141\x69\154\x5f\x65\x6e\x61\x62\154\145";
        $this->_formName = mo_("\106\x6f\162\155\40\115\141\153\145\x72\40\x46\157\162\x6d");
        $this->_formKey = "\106\117\x52\x4d\137\115\x41\113\105\x52";
        $this->_isFormEnabled = get_mo_option("\146\157\x72\x6d\x6d\141\153\x65\x72\x5f\x65\156\x61\142\x6c\x65");
        $this->_otpType = get_mo_option("\x66\157\162\x6d\x6d\x61\153\x65\162\x5f\145\156\141\x62\x6c\x65\x5f\x74\171\x70\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\146\157\x72\x6d\155\x61\153\x65\x72\x5f\x6f\x74\x70\137\x65\156\x61\142\x6c\x65\x64"));
        $this->_buttonText = get_mo_option("\x66\157\162\x6d\x6d\141\153\x65\x72\137\x62\x75\164\164\x6f\156\x5f\x74\x65\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\151\143\153\40\110\x65\x72\145\x20\x74\x6f\x20\163\x65\156\x64\40\117\x54\120");
        $this->_formDocuments = MoOTPDocs::FORMMAKER;
        parent::__construct();
        if (!$this->_isFormEnabled) {
            goto ed;
        }
        add_action("\x77\x70\x5f\145\156\161\165\145\x75\x65\137\163\143\x72\x69\x70\x74\163", array($this, "\x72\x65\147\151\163\164\145\x72\137\146\155\x5f\142\x75\164\164\x6f\x6e\137\x73\143\x72\151\160\x74"));
        ed:
    }
    function handleForm()
    {
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\164\151\157\156", $_GET)) {
            goto q9;
        }
        return;
        q9:
        switch (trim($_GET["\x6f\x70\x74\x69\x6f\156"])) {
            case "\155\x69\x6e\151\157\162\x61\x6e\x67\145\x2d\x66\155\x2d\141\x6a\x61\x78\x2d\166\x65\x72\x69\x66\x79":
                $this->_send_otp_fm_ajax_verify($_POST);
                goto ap;
            case "\155\x69\x6e\x69\x6f\x72\x61\x6e\x67\x65\55\x66\x6d\x2d\x76\145\162\151\x66\x79\x2d\x63\x6f\144\145":
                $this->_validate_otp($_POST);
                goto ap;
        }
        k4:
        ap:
    }
    private function _validate_otp($post)
    {
        $this->validateChallenge($this->getVerificationType(), NULL, sanitize_text_field($post["\x6f\x74\160\137\164\157\x6b\x65\x6e"]));
    }
    function _send_otp_fm_ajax_verify($FA)
    {
        if ($this->_otpType == $this->_typePhoneTag) {
            goto Zk;
        }
        $this->_send_fm_ajax_otp_to_email($FA);
        goto am;
        Zk:
        $this->_send_fm_ajax_otp_to_phone($FA);
        am:
    }
    function _send_fm_ajax_otp_to_phone($FA)
    {
        if (!MoUtility::sanitizeCheck("\165\163\145\x72\x5f\160\150\x6f\x6e\145", $FA)) {
            goto of;
        }
        $this->sendOTP(trim($FA["\x75\x73\145\162\137\x70\150\157\x6e\x65"]), NULL, trim($FA["\165\x73\x65\x72\x5f\x70\x68\x6f\156\145"]), VerificationType::PHONE);
        goto rs;
        of:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        rs:
    }
    function _send_fm_ajax_otp_to_email($FA)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\145\x72\x5f\145\x6d\x61\151\154", $FA)) {
            goto KJ;
        }
        $this->sendOTP($FA["\165\x73\x65\x72\137\145\x6d\141\151\x6c"], $FA["\x75\163\x65\162\137\x65\x6d\141\x69\x6c"], NULL, VerificationType::EMAIL);
        goto P0;
        KJ:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        P0:
    }
    private function checkPhoneOrEmailIntegrity($us)
    {
        if ($this->getVerificationType() === VerificationType::PHONE) {
            goto Hd;
        }
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $us);
        goto ms;
        Hd:
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $us);
        ms:
    }
    private function sendOTP($WH, $BO, $dI, $tA)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($tA === VerificationType::PHONE) {
            goto va;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $WH);
        goto c3;
        va:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $WH);
        c3:
        $this->sendChallenge('', $BO, NULL, $dI, $tA);
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto si;
        }
        return;
        si:
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        if ($this->checkPhoneOrEmailIntegrity(sanitize_text_field($_POST["\x73\165\142\x5f\x66\x69\145\x6c\x64"]))) {
            goto XB;
        }
        if ($this->_otpType == $this->_typePhoneTag) {
            goto b5;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        goto Yp;
        b5:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        Yp:
        goto rR;
        XB:
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(self::VALIDATED, MoConstants::SUCCESS_JSON_TYPE));
        rR:
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->getVerificationType() === VerificationType::PHONE)) {
            goto Io;
        }
        array_push($kp, $this->_phoneFormId);
        Io:
        return $kp;
    }
    function register_fm_button_script()
    {
        wp_register_script("\146\155\x6f\x74\x70\142\x75\x74\164\x6f\x6e\163\143\x72\x69\160\x74", MOV_URL . "\x69\156\x63\x6c\x75\x64\x65\163\57\152\163\x2f\x66\x6f\162\155\155\141\x6b\x65\x72\56\x6d\151\156\x2e\x6a\163", array("\152\x71\165\x65\162\171"));
        wp_localize_script("\146\x6d\x6f\164\160\142\x75\164\164\157\x6e\163\143\x72\x69\160\x74", "\155\x6f\146\x6d\166\x61\162", array("\163\x69\x74\145\125\122\114" => site_url(), "\x6f\x74\x70\x54\x79\160\x65" => $this->_otpType, "\146\x6f\x72\x6d\104\x65\164\x61\151\x6c\163" => $this->_formDetails, "\142\165\164\164\x6f\x6e\164\145\170\x74" => mo_($this->_buttonText), "\151\x6d\147\x55\x52\x4c" => MOV_URL . "\151\x6e\143\154\x75\x64\x65\x73\57\x69\155\141\x67\145\x73\57\154\x6f\x61\144\145\162\x2e\147\151\146"));
        wp_enqueue_script("\x66\x6d\x6f\x74\160\142\x75\164\164\157\x6e\x73\143\162\151\x70\x74");
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto CC;
        }
        return;
        CC:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_otpType = $this->sanitizeFormPOST("\146\x6d\137\x65\x6e\x61\x62\x6c\x65\137\164\171\x70\145");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\146\155\x5f\x65\156\141\142\x6c\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\146\x6d\137\142\x75\x74\164\157\x6e\x5f\164\x65\170\164");
        if (!$this->basicValidationCheck(BaseMessages::FORMMAKER_CHOOSE)) {
            goto zG;
        }
        update_mo_option("\146\157\162\x6d\155\x61\153\145\x72\x5f\145\156\x61\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\x66\x6f\162\x6d\x6d\x61\x6b\145\x72\x5f\145\x6e\141\142\x6c\145\137\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\146\157\162\x6d\x6d\141\153\145\x72\137\157\x74\160\x5f\145\156\x61\x62\154\145\144", maybe_serialize($this->_formDetails));
        update_mo_option("\x66\x6f\162\x6d\155\x61\153\145\x72\x5f\x62\x75\164\x74\157\156\137\164\x65\x78\164", $this->_buttonText);
        zG:
    }
    private function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\146\157\x72\155\x6d\x61\x6b\145\x72\137\146\157\x72\x6d", $_POST)) {
            goto sv;
        }
        return array();
        sv:
        foreach (array_filter($_POST["\146\157\162\x6d\155\x61\153\145\162\x5f\146\x6f\x72\155"]["\x66\x6f\162\155"]) as $j1 => $qL) {
            $qL = sanitize_text_field($qL);
            $form[$qL] = array("\x65\155\141\x69\154\153\145\171" => $this->_get_efield_id(sanitize_text_field($_POST["\146\157\162\155\155\141\x6b\x65\x72\x5f\146\157\x72\155"]["\145\155\141\151\x6c\x6b\x65\171"][$j1]), $qL), "\x70\x68\157\x6e\x65\x6b\145\x79" => $this->_get_efield_id(sanitize_text_field($_POST["\146\157\162\155\x6d\141\153\145\162\137\x66\157\162\155"]["\x70\150\157\x6e\x65\x6b\x65\171"][$j1]), $qL), "\166\145\162\151\x66\x79\113\145\x79" => $this->_get_efield_id(sanitize_text_field($_POST["\x66\x6f\x72\x6d\155\141\x6b\145\162\137\x66\157\x72\x6d"]["\166\x65\162\x69\146\171\113\x65\171"][$j1]), $qL), "\160\150\157\x6e\x65\137\163\150\x6f\167" => sanitize_text_field($_POST["\x66\157\x72\155\155\141\153\x65\x72\x5f\x66\x6f\162\x6d"]["\160\150\157\156\x65\153\x65\171"][$j1]), "\x65\x6d\141\151\154\x5f\x73\x68\157\x77" => sanitize_text_field($_POST["\146\x6f\162\x6d\x6d\141\153\145\x72\x5f\146\x6f\162\155"]["\x65\155\141\x69\x6c\x6b\x65\x79"][$j1]), "\x76\x65\x72\x69\x66\x79\137\x73\x68\157\167" => sanitize_text_field($_POST["\x66\157\162\155\x6d\x61\153\x65\162\137\146\157\162\x6d"]["\x76\x65\x72\x69\x66\171\x4b\x65\171"][$j1]));
            X2:
        }
        N8:
        return $form;
    }
    private function _get_efield_id($qt, $form)
    {
        global $wpdb;
        $zn = $wpdb->get_row("\123\x45\114\105\x43\x54\x20\x2a\40\x46\x52\x4f\x4d\40{$wpdb->prefix}\146\x6f\162\x6d\x6d\x61\153\145\x72\x20\167\150\x65\162\x65\40\140\151\x64\140\x20\75" . $form);
        if (!MoUtility::isBlank($zn)) {
            goto hO;
        }
        return '';
        hO:
        $Xw = explode("\x2a\72\x2a\x6e\145\167\x5f\x66\x69\x65\154\x64\x2a\72\x2a", $zn->form_fields);
        $ru = $sw = $LQ = array();
        foreach ($Xw as $QO) {
            $OB = explode("\52\x3a\52\151\x64\x2a\72\x2a", $QO);
            if (MoUtility::isBlank($OB)) {
                goto ck;
            }
            array_push($ru, $OB[0]);
            if (!array_key_exists(1, $OB)) {
                goto De;
            }
            $OB = explode("\52\x3a\x2a\x74\x79\x70\145\x2a\72\52", $OB[1]);
            array_push($sw, $OB[0]);
            $OB = explode("\52\x3a\x2a\167\x5f\x66\151\145\154\144\137\154\x61\x62\x65\x6c\x2a\72\52", $OB[1]);
            De:
            array_push($LQ, $OB[0]);
            ck:
            UQ:
        }
        Nt:
        $j1 = array_search($qt, $LQ);
        return "\43\167\144\x66\x6f\x72\x6d\x5f" . $ru[$j1] . "\x5f\145\154\145\155\145\156\164" . $form;
    }
}
