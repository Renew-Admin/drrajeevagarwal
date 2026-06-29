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
class WooCommerceBilling extends FormHandler implements IFormHandler
{
    use Instance;
    function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_BILLING;
        $this->_typePhoneTag = "\x6d\x6f\137\x77\x63\142\137\160\x68\x6f\x6e\145\137\145\156\141\x62\x6c\x65";
        $this->_typeEmailTag = "\155\x6f\x5f\x77\143\x62\x5f\145\155\x61\x69\x6c\x5f\145\156\x61\x62\154\x65";
        $this->_phoneFormId = "\x23\142\x69\x6c\x6c\151\156\x67\x5f\x70\x68\157\156\145";
        $this->_formKey = "\x57\x43\137\102\x49\x4c\114\111\116\107\x5f\106\117\x52\x4d";
        $this->_formName = mo_("\127\157\157\143\157\x6d\155\x65\x72\143\x65\x20\x42\151\x6c\x6c\151\156\x67\40\101\144\144\x72\x65\x73\163\x20\106\x6f\162\155");
        $this->_isFormEnabled = get_mo_option("\167\x63\x5f\x62\151\x6c\x6c\151\x6e\x67\137\x65\156\x61\x62\x6c\x65");
        $this->_buttonText = get_mo_option("\167\143\137\x62\151\x6c\x6c\151\156\147\137\x62\x75\164\164\157\156\x5f\x74\145\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\x69\x63\x6b\x20\110\x65\x72\x65\x20\x74\x6f\x20\163\x65\156\144\40\x4f\x54\x50");
        $this->_formDocuments = MoOTPDocs::WC_BILLING_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_restrictDuplicates = get_mo_option("\167\143\x5f\x62\151\x6c\154\x69\156\x67\137\x72\145\x73\164\x72\151\x63\x74\137\x64\x75\x70\x6c\x69\x63\x61\164\x65\163");
        $this->_otpType = get_mo_option("\167\143\x5f\142\151\x6c\154\x69\156\x67\137\164\171\x70\x65\137\x65\x6e\141\x62\x6c\145\144");
        if ($this->_otpType === $this->_typeEmailTag) {
            goto UD;
        }
        add_filter("\167\157\x6f\143\157\x6d\x6d\x65\162\143\x65\x5f\x70\x72\x6f\x63\x65\x73\x73\x5f\x6d\x79\x61\x63\x63\157\165\x6e\x74\137\146\151\x65\x6c\144\137\142\151\154\x6c\151\x6e\147\137\x70\150\x6f\x6e\x65", [$this, "\137\167\143\x5f\165\x73\145\162\x5f\141\x63\x63\157\165\x6e\x74\x5f\165\x70\144\x61\x74\x65"], 99, 1);
        goto Mv;
        UD:
        add_filter("\167\x6f\157\143\x6f\155\155\x65\162\143\x65\x5f\160\162\x6f\x63\145\x73\163\137\155\x79\141\x63\143\157\x75\x6e\164\x5f\x66\151\x65\154\x64\x5f\142\x69\x6c\x6c\151\x6e\x67\137\145\155\141\151\x6c", [$this, "\x5f\x77\143\137\165\163\x65\162\x5f\141\143\143\x6f\x75\156\164\137\165\x70\144\x61\x74\x65"], 99, 1);
        Mv:
    }
    function _wc_user_account_update($qL)
    {
        $qL = $this->_otpType === $this->_typePhoneTag ? MoUtility::processPhoneNumber($qL) : $qL;
        $uO = $this->getVerificationType();
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $uO)) {
            goto V_;
        }
        $this->unsetOTPSessionVariables();
        return $qL;
        V_:
        if (!$this->userHasNotChangeData($qL)) {
            goto r9;
        }
        return $qL;
        r9:
        if (!($this->_restrictDuplicates && $this->isDuplicate($qL, $uO))) {
            goto YZ;
        }
        return $qL;
        YZ:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->sendChallenge(null, sanitize_email($_POST["\142\x69\154\x6c\151\156\x67\137\x65\155\x61\151\154"]), null, sanitize_text_field($_POST["\142\x69\154\154\151\x6e\147\x5f\160\x68\157\x6e\145"]), $uO);
        return $qL;
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
    private function userHasNotChangeData($qL)
    {
        $FA = $this->getUserData();
        return strcasecmp($FA, $qL) == 0;
    }
    private function getUserData()
    {
        global $wpdb;
        $current_user = wp_get_current_user();
        $j1 = $this->_otpType === $this->_typePhoneTag ? "\142\151\x6c\154\151\x6e\147\x5f\160\x68\157\x6e\x65" : "\x62\151\154\154\151\156\x67\x5f\145\x6d\141\x69\x6c";
        $OY = "\123\x45\114\105\x43\x54\40\x6d\x65\164\141\137\x76\x61\154\165\145\40\106\122\x4f\115\x20\x60{$wpdb->prefix}\x75\163\145\162\x6d\145\164\141\140\40\x57\x48\105\x52\x45\x20\140\x6d\145\164\141\x5f\x6b\x65\x79\140\x20\75\x20\47{$j1}\x27\40\x41\116\x44\40\140\x75\163\145\x72\x5f\x69\144\140\x20\75\40{$current_user->ID}";
        $le = $wpdb->get_row($OY);
        return isset($le) ? $le->meta_value : '';
    }
    private function isDuplicate($qL, $uO)
    {
        global $wpdb;
        $j1 = "\142\x69\154\x6c\151\156\x67\x5f" . $uO;
        $le = $wpdb->get_row("\123\x45\x4c\x45\103\124\x20\x60\x75\x73\x65\162\x5f\151\x64\x60\40\x46\122\117\x4d\40\140{$wpdb->prefix}\165\163\x65\x72\x6d\x65\164\x61\140\x20\127\x48\x45\122\105\x20\x60\x6d\145\164\141\137\153\145\171\x60\x20\75\40\47{$j1}\x27\40\101\x4e\x44\40\x60\x6d\145\x74\x61\x5f\166\141\x6c\x75\145\140\x20\x3d\40\x20\x27{$qL}\x27");
        if (!isset($le)) {
            goto x4;
        }
        if ($uO === VerificationType::PHONE) {
            goto Xq;
        }
        if (!($uO === VerificationType::EMAIL)) {
            goto Kz;
        }
        wc_add_notice(MoMessages::showMessage(MoMessages::EMAIL_EXISTS), MoConstants::ERROR_JSON_TYPE);
        Kz:
        goto UH;
        Xq:
        wc_add_notice(MoMessages::showMessage(MoMessages::PHONE_EXISTS), MoConstants::ERROR_JSON_TYPE);
        UH:
        return TRUE;
        x4:
        return FALSE;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->_isFormEnabled && $this->_otpType == $this->_typePhoneTag)) {
            goto oc;
        }
        array_push($kp, $this->_phoneFormId);
        oc:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto XT;
        }
        return;
        XT:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\143\137\142\151\x6c\154\x69\x6e\x67\137\145\156\x61\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x63\137\142\151\x6c\154\151\x6e\x67\x5f\164\171\x70\145\137\x65\156\141\142\154\x65\144");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x77\143\137\142\151\154\x6c\151\x6e\x67\137\162\x65\163\164\x72\x69\143\x74\x5f\x64\165\160\154\x69\x63\x61\164\145\163");
        if (!$this->basicValidationCheck(BaseMessages::WC_BILLING_CHOOSE)) {
            goto MF;
        }
        update_mo_option("\x77\x63\x5f\142\x69\154\154\x69\156\x67\x5f\145\x6e\141\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\167\143\x5f\142\x69\x6c\x6c\x69\x6e\147\137\x74\x79\x70\x65\x5f\145\156\x61\142\154\x65\144", $this->_otpType);
        update_mo_option("\x77\x63\137\142\151\154\154\151\156\147\x5f\x72\x65\x73\x74\x72\151\x63\164\x5f\144\x75\x70\154\x69\x63\141\x74\145\x73", $this->_restrictDuplicates);
        MF:
    }
}
