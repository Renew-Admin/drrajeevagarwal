<?php


namespace OTP\Addons\PasswordReset\Handler;

use OTP\Addons\PasswordReset\Helper\UMPasswordResetMessages;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use UM;
use um\core\Form;
use um\core\Options;
use um\core\Password;
use um\core\User;
use WP_User;
class UMPasswordResetHandler extends FormHandler implements IFormHandler
{
    use Instance;
    private $_fieldKey;
    private $_isOnlyPhoneReset;
    protected function __construct()
    {
        $this->_isAjaxForm = TRUE;
        $this->_isAddOnForm = TRUE;
        $this->_formOption = "\165\155\137\x70\x61\x73\163\167\x6f\x72\144\137\162\x65\x73\x65\x74\x5f\150\141\156\x64\x6c\145\162";
        $this->_formSessionVar = FormSessionVars::UM_DEFAULT_PASS;
        $this->_typePhoneTag = "\x6d\x6f\137\165\155\x5f\160\150\157\156\145\x5f\145\x6e\x61\142\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\x5f\x75\155\137\145\155\x61\151\154\137\x65\156\x61\x62\x6c\x65";
        $this->_phoneFormId = "\165\163\x65\x72\x6e\x61\x6d\x65\x5f\142";
        $this->_fieldKey = "\x75\x73\x65\x72\156\141\x6d\145\137\142";
        $this->_formKey = "\125\114\x54\111\115\101\x54\x45\137\120\x41\123\x53\137\122\105\123\x45\124";
        $this->_formName = mo_("\125\x6c\x74\x69\155\141\164\x65\40\115\145\x6d\142\145\162\x20\x50\141\x73\x73\167\157\162\x64\x20\122\145\163\145\x74\x20\x75\163\151\x6e\x67\x20\117\x54\x50");
        $this->_isFormEnabled = get_umpr_option("\160\x61\x73\163\x5f\x65\156\141\x62\154\x65") ? TRUE : FALSE;
        $this->_generateOTPAction = "\x6d\157\137\165\155\x70\162\137\163\145\156\144\137\x6f\164\x70";
        $this->_buttonText = get_umpr_option("\160\141\163\x73\137\142\165\164\x74\157\156\137\x74\145\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x52\x65\x73\x65\164\40\x50\141\x73\x73\167\157\x72\144");
        $this->_phoneKey = get_umpr_option("\160\x61\163\163\x5f\x70\x68\157\x6e\x65\x4b\x65\171");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\155\x6f\142\x69\154\x65\x5f\156\165\x6d\x62\x65\x72";
        $this->_isOnlyPhoneReset = get_umpr_option("\157\156\x6c\171\137\160\150\x6f\x6e\x65\137\162\x65\x73\x65\164");
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_umpr_option("\145\156\x61\142\x6c\x65\144\x5f\x74\x79\x70\x65");
        if (!$this->_isOnlyPhoneReset) {
            goto Vm;
        }
        $this->_phoneFormId = "\x69\x6e\x70\165\x74\43\165\x73\145\162\x6e\141\x6d\x65\137\x62";
        Vm:
        add_action("\167\160\137\x61\152\141\170\x5f\x6e\157\x70\x72\x69\166\x5f" . $this->_generateOTPAction, array($this, "\x73\x65\x6e\x64\x41\152\141\170\117\x54\120\122\145\x71\165\145\163\164"));
        add_action("\167\160\x5f\141\152\141\x78\137" . $this->_generateOTPAction, array($this, "\x73\x65\156\144\x41\152\x61\x78\x4f\x54\120\x52\145\x71\x75\145\163\x74"));
        add_action("\x77\160\x5f\x65\x6e\161\165\145\x75\145\137\x73\143\x72\151\x70\164\163", array($this, "\x6d\x69\x6e\x69\157\x72\141\156\147\145\x5f\x72\145\147\x69\163\x74\145\x72\x5f\165\x6d\x5f\x73\143\162\151\160\164"));
        add_action("\165\x6d\x5f\x72\145\x73\145\x74\137\160\x61\x73\x73\167\157\162\x64\137\x65\x72\162\157\x72\x73\x5f\150\157\157\x6b", array($this, "\x75\x6d\137\x72\x65\x73\x65\x74\x5f\160\x61\163\x73\x77\157\x72\x64\137\145\x72\x72\x6f\x72\163\x5f\150\x6f\x6f\153"), 99);
        add_action("\x75\155\x5f\x72\x65\x73\x65\164\137\x70\x61\163\163\167\x6f\x72\x64\137\160\x72\x6f\x63\x65\163\163\x5f\x68\157\x6f\153", array($this, "\x75\155\x5f\x72\145\x73\x65\164\x5f\x70\141\x73\163\x77\157\162\144\137\160\162\157\143\x65\163\x73\137\x68\x6f\157\x6b"), 1);
    }
    public function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $zC = MoUtility::sanitizeCheck("\x75\163\145\x72\156\x61\155\145", $_POST);
        SessionUtils::addUserInSession($this->_formSessionVar, $zC);
        $user = $this->getUser($zC);
        if (!$user) {
            goto pd;
        }
        $Dk = get_user_meta($user->ID, $this->_phoneKey, true);
        $this->startOtpTransaction(null, $user->user_email, null, $Dk, null, null);
        goto oO;
        pd:
        if ($this->_isOnlyPhoneReset) {
            goto az;
        }
        wp_send_json(MoUtility::createJson(UMPasswordResetMessages::showMessage(UMPasswordResetMessages::USERNAME_NOT_EXIST), "\x65\162\162\x6f\x72"));
        goto lF;
        az:
        wp_send_json(MoUtility::createJson(UMPasswordResetMessages::showMessage(UMPasswordResetMessages::RESET_LABEL_OP), "\145\162\162\x6f\162"));
        lF:
        oO:
    }
    public function um_reset_password_process_hook()
    {
        $user = MoUtility::sanitizeCheck("\x75\163\x65\x72\156\141\155\x65\137\142", $_POST);
        $user = $this->getUser(trim($user));
        $sO = $this->getUmPwdObj();
        um_fetch_user($user->ID);
        $this->getUmUserObj()->password_reset();
        wp_redirect($sO->reset_url());
        exit;
    }
    public function um_reset_password_errors_hook()
    {
        $form = $this->getUmFormObj();
        $zC = MoUtility::sanitizeCheck($this->_fieldKey, $_POST);
        if (!isset($form->errors)) {
            goto Bm;
        }
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && MoUtility::validatePhoneNumber($zC))) {
            goto dR;
        }
        $user = $this->getUserFromPhoneNumber($zC);
        if (!$user) {
            goto Lk;
        }
        $form->errors = null;
        if (isset($form->errors)) {
            goto BH;
        }
        $this->check_reset_password_limit($form, $user->ID);
        BH:
        goto md;
        Lk:
        $form->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::USERNAME_NOT_EXIST));
        md:
        dR:
        Bm:
        if (isset($form->errors)) {
            goto xI;
        }
        $this->checkIntegrityAndValidateOTP($form, MoUtility::sanitizeCheck("\166\145\x72\x69\x66\x79\137\146\x69\145\154\144", $_POST), $_POST);
        xI:
    }
    private function checkIntegrityAndValidateOTP(&$form, $qL, array $Tw)
    {
        $Bs = $this->getVerificationType();
        $this->checkIntegrity($form, $Tw);
        $this->validateChallenge($Bs, NULL, $qL);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs)) {
            goto q1;
        }
        $form->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::INVALID_OTP));
        q1:
    }
    private function checkIntegrity($RU, array $Tw)
    {
        $vO = SessionUtils::getUserSubmitted($this->_formSessionVar);
        if (!($vO !== $Tw[$this->_fieldKey])) {
            goto d5;
        }
        $RU->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::USERNAME_MISMATCH));
        d5:
    }
    public function getUserId($user)
    {
        $user = $this->getUser($user);
        return $user ? $user->ID : false;
    }
    public function getUser($zC)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && MoUtility::validatePhoneNumber($zC)) {
            goto ki;
        }
        if (is_email($zC)) {
            goto dw;
        }
        $user = get_user_by("\154\x6f\x67\x69\156", $zC);
        goto Ty;
        dw:
        $user = get_user_by("\145\x6d\x61\x69\154", $zC);
        Ty:
        goto F9;
        ki:
        $zC = MoUtility::processPhoneNumber($zC);
        $user = $this->getUserFromPhoneNumber($zC);
        F9:
        return $user;
    }
    function getUserFromPhoneNumber($zC)
    {
        global $wpdb;
        $le = $wpdb->get_row("\x53\x45\114\x45\x43\x54\x20\x60\x75\x73\x65\162\137\151\144\x60\40\106\x52\117\x4d\40\x60{$wpdb->prefix}\165\163\x65\162\x6d\x65\164\x61\x60\40\127\110\x45\122\105\x20\x60\155\x65\x74\141\137\153\x65\171\x60\40\x3d\x20\x27{$this->_phoneKey}\x27\x20\101\x4e\104\x20\x60\x6d\145\x74\141\x5f\x76\141\x6c\165\145\140\x20\x3d\x20\40\47{$zC}\47");
        return !MoUtility::isBlank($le) ? get_userdata($le->user_id) : false;
    }
    public function check_reset_password_limit(Form &$form, $nL)
    {
        $La = (int) get_user_meta($nL, "\160\x61\163\163\x77\x6f\162\144\x5f\x72\x73\164\x5f\141\164\x74\x65\x6d\x70\164\163", true);
        $G3 = user_can(intval($nL), "\x6d\x61\x6e\141\147\145\x5f\157\160\x74\151\x6f\x6e\x73");
        if (!$this->getUmOptions()->get("\145\156\141\x62\x6c\145\137\162\x65\x73\145\164\137\x70\141\x73\163\x77\157\x72\144\137\154\x69\155\151\164")) {
            goto Kv;
        }
        if ($this->getUmOptions()->get("\144\151\163\x61\x62\154\145\137\141\144\155\x69\x6e\x5f\162\145\163\145\164\137\160\141\x73\x73\x77\x6f\x72\x64\137\x6c\151\x6d\151\x74") && $G3) {
            goto zl;
        }
        $B4 = $this->getUmOptions()->get("\x72\145\163\x65\164\137\x70\x61\x73\x73\167\x6f\162\144\x5f\x6c\x69\155\151\164\x5f\156\165\155\142\145\162");
        if ($La >= $B4) {
            goto aO;
        }
        update_user_meta($nL, "\160\141\163\163\x77\157\x72\144\x5f\162\163\x74\137\x61\x74\x74\145\x6d\160\x74\x73", $La + 1);
        goto UJ;
        aO:
        $form->add_error($this->_fieldKey, __("\131\x6f\x75\x20\150\x61\x76\145\40\162\x65\x61\x63\x68\145\144\x20\164\150\x65\x20\154\151\155\x69\x74\x20\146\x6f\x72\40\x72\x65\161\x75\x65\163\x74\151\x6e\x67\x20\x70\141\163\x73\167\x6f\162\x64\x20\x22\56\15\xa\x20\40\40\40\40\x20\x20\40\x20\40\40\x20\40\x20\x20\40\40\40\40\40\42\x63\x68\x61\x6e\x67\145\x20\x66\157\x72\40\x74\150\x69\163\40\165\163\145\x72\x20\141\x6c\162\145\141\x64\x79\56\x20\103\157\x6e\164\141\143\x74\x20\x73\x75\160\x70\157\x72\x74\40\151\146\x20\171\157\165\40\x63\141\x6e\156\x6f\164\40\x6f\160\x65\x6e\40\x74\x68\145\40\x65\x6d\x61\151\154", "\x75\154\x74\x69\155\x61\164\x65\x2d\x6d\145\x6d\x62\x65\x72"));
        UJ:
        goto pg;
        zl:
        pg:
        Kv:
    }
    private function getUmFormObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto Z3;
        }
        global $ultimatemember;
        return $ultimatemember->form;
        goto Da;
        Z3:
        return UM()->form();
        Da:
    }
    private function getUmUserObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto mD;
        }
        global $ultimatemember;
        return $ultimatemember->user;
        goto e1;
        mD:
        return UM()->user();
        e1:
    }
    private function getUmPwdObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto cO;
        }
        global $ultimatemember;
        return $ultimatemember->password;
        goto Pu;
        cO:
        return UM()->password();
        Pu:
    }
    private function getUmOptions()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto gM;
        }
        global $ultimatemember;
        return $ultimatemember->options;
        goto vg;
        gM:
        return UM()->options();
        vg:
    }
    function isUltimateMemberV2Installed()
    {
        if (!function_exists("\x69\163\x5f\x70\x6c\165\147\151\x6e\137\141\143\164\x69\166\x65")) {
            include_once ABSPATH . "\167\160\55\141\x64\155\x69\156\x2f\x69\156\x63\154\x75\x64\145\x73\57\160\154\x75\x67\x69\156\56\x70\150\160";
        }
        return is_plugin_active("\165\154\164\151\155\x61\164\145\x2d\155\x65\155\142\145\x72\57\165\x6c\164\151\155\x61\164\145\x2d\155\145\x6d\142\145\x72\56\160\150\x70");
    }
    private function startOtpTransaction($zC, $mo, $errors, $NN, $iK, $ck)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto HG;
        }
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::EMAIL, $iK, $ck);
        goto LJ;
        HG:
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::PHONE, $iK, $ck);
        LJ:
    }
    public function miniorange_register_um_script()
    {
        wp_register_script("\155\157\165\x6d\x70\x72", UMPR_URL . "\x69\156\x63\x6c\x75\x64\x65\x73\57\x6a\163\57\x6d\157\x75\x6d\x70\x72\x2e\155\x69\156\56\152\163", array("\152\x71\x75\x65\x72\x79"));
        wp_localize_script("\155\157\165\155\160\162", "\x6d\x6f\x75\x6d\x70\162\166\141\162", array("\163\x69\x74\145\125\122\114" => wp_ajax_url(), "\x6e\x6f\x6e\x63\x65" => wp_create_nonce($this->_nonce), "\142\x75\164\x74\x6f\x6e\x74\x65\x78\x74" => mo_($this->_buttonText), "\151\155\147\x55\122\x4c" => MOV_LOADER_URL, "\141\x63\164\151\157\156" => ["\x73\x65\156\x64" => $this->_generateOTPAction], "\x66\151\145\154\144\x4b\145\x79" => $this->_fieldKey, "\162\x65\163\x65\164\x4c\x61\x62\x65\x6c\x54\x65\170\x74" => UMPasswordResetMessages::showMessage($this->_isOnlyPhoneReset ? UMPasswordResetMessages::RESET_LABEL_OP : UMPasswordResetMessages::RESET_LABEL), "\160\x68\124\x65\170\x74" => $this->_isOnlyPhoneReset ? mo_("\x45\x6e\164\x65\x72\40\131\x6f\x75\162\x20\120\x68\x6f\156\x65\x20\x4e\x75\x6d\x62\x65\162") : mo_("\105\156\164\145\162\x20\x59\157\165\162\40\105\x6d\x61\151\154\x2c\x20\125\x73\x65\x72\x6e\141\155\145\x20\157\162\x20\120\150\157\x6e\145\x20\116\x75\155\x62\x65\162")));
        wp_enqueue_script("\x6d\x6f\x75\x6d\160\162");
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    public function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Z1;
        }
        return;
        Z1:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\155\x5f\x70\162\137\145\156\x61\142\x6c\145");
        $this->_buttonText = $this->sanitizeFormPOST("\165\x6d\x5f\160\x72\x5f\x62\x75\164\x74\x6f\x6e\x5f\x74\145\170\x74");
        $this->_buttonText = $this->_buttonText ? $this->_buttonText : "\x52\x65\x73\x65\164\x20\120\x61\163\163\167\157\162\144";
        $this->_otpType = $this->sanitizeFormPOST("\165\x6d\137\x70\x72\x5f\145\x6e\141\x62\x6c\x65\137\x74\x79\x70\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\x6d\137\x70\x72\x5f\x70\150\157\x6e\145\x5f\x66\151\145\x6c\144\x5f\x6b\145\171");
        $this->_isOnlyPhoneReset = $this->sanitizeFormPOST("\x75\x6d\137\160\162\x5f\157\156\154\x79\137\x70\x68\x6f\x6e\145");
        update_umpr_option("\x6f\156\154\171\137\160\x68\x6f\x6e\x65\137\162\x65\163\x65\164", $this->_isOnlyPhoneReset);
        update_umpr_option("\160\141\x73\163\x5f\x65\x6e\141\x62\154\x65", $this->_isFormEnabled);
        update_umpr_option("\160\x61\163\x73\137\x62\165\164\164\x6f\156\x5f\x74\x65\x78\x74", $this->_buttonText);
        update_umpr_option("\x65\156\x61\x62\154\x65\x64\137\x74\171\x70\x65", $this->_otpType);
        update_umpr_option("\160\141\x73\163\137\x70\150\157\x6e\x65\113\x65\x79", $this->_phoneKey);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto fl;
        }
        array_push($kp, $this->_phoneFormId);
        fl:
        return $kp;
    }
    public function getIsOnlyPhoneReset()
    {
        return $this->_isOnlyPhoneReset;
    }
}
