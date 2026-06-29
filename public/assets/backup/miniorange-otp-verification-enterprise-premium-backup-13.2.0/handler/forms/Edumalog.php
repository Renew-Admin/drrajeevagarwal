<?php


namespace OTP\Handler\Forms;

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
use WP_Error;
use WP_User;
class Edumalog extends FormHandler implements IFormHandler
{
    use Instance;
    private $_byPassAdmin;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_formSessionVar = FormSessionVars::EDUMALOG;
        $this->_typePhoneTag = "\155\x6f\137\145\x64\165\x6d\x61\154\x6f\147\137\x70\150\x6f\x6e\x65\x5f\145\156\141\x62\154\x65";
        $this->_typeEmailTag = "\155\157\x5f\x65\x64\x75\155\141\x6c\x6f\147\x5f\145\x6d\141\151\x6c\x5f\x65\156\x61\x62\154\145";
        $this->_formKey = "\105\104\x55\x4d\101\x5f\114\x4f\x47\x49\x4e";
        $this->_formName = mo_("\105\144\x75\155\x61\40\124\150\145\x6d\x65\x20\114\157\x67\x69\x6e\x20\106\157\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\x65\144\165\155\141\x6c\157\x67\137\145\x6e\141\x62\154\145");
        $this->_phoneFormId = "\151\x6e\x70\165\164\x5b\x6e\x61\155\145\x3d\160\x68\157\x6e\x65\137\x6e\x75\x6d\x62\145\162\x5d";
        $this->_formDocuments = MoOTPDocs::EDUMA_LOG;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x65\x64\x75\x6d\x61\154\x6f\147\x5f\x65\x6e\x61\x62\x6c\145\137\164\171\160\x65");
        $this->_phoneKey = get_mo_option("\x65\144\165\x6d\x61\154\x6f\x67\x5f\160\150\x6f\x6e\x65\137\146\151\145\154\144\x5f\153\x65\x79");
        $this->_byPassAdmin = get_mo_option("\145\144\165\x6d\141\154\157\147\x5f\142\x79\x70\141\163\163\x5f\141\144\x6d\x69\156");
        add_action("\154\157\x67\x69\x6e\137\x65\x6e\161\165\145\165\x65\137\163\143\162\x69\160\164\x73", array($this, "\155\x69\x6e\151\x6f\162\x61\x6e\147\145\x5f\162\x65\147\151\x73\164\145\162\137\x6c\157\147\151\156\137\x73\x63\162\151\x70\164"));
        add_action("\167\160\137\x65\x6e\161\x75\145\165\x65\137\163\x63\x72\x69\160\164\163", array($this, "\155\151\x6e\151\x6f\x72\x61\156\147\145\x5f\162\145\147\x69\163\x74\x65\x72\137\x6c\x6f\147\151\156\x5f\163\x63\x72\x69\x70\x74"));
        add_filter("\x61\165\x74\x68\x65\x6e\x74\x69\x63\141\164\145", array($this, "\137\x68\141\156\144\x6c\145\x5f\x6d\x6f\x5f\x77\160\137\x6c\157\147\151\x6e"), 10, 3);
    }
    function _handle_mo_wp_login($user, $zC, $iK)
    {
        if (MoUtility::isBlank($zC)) {
            goto mp;
        }
        $user = $this->getUser($zC, $iK);
        $f7 = get_userdata($user->data->ID);
        $sl = $f7->roles;
        if (!($this->_byPassAdmin && in_array("\x61\x64\155\151\156\x69\x73\164\x72\141\x74\x6f\x72", $sl))) {
            goto E9;
        }
        return;
        E9:
        if (!is_wp_error($user)) {
            goto TY;
        }
        return $user;
        TY:
        $this->startOTPVerificationProcess($user, $zC, $iK);
        mp:
        return $user;
    }
    function startOTPVerificationProcess($user, $zC, $iK)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)) {
            goto Cp;
        }
        $this->unsetOTPSessionVariables();
        return;
        Cp:
        if ($this->_otpType === $this->_typePhoneTag) {
            goto s1;
        }
        if (!($this->_otpType === $this->_typeEmailTag)) {
            goto hh;
        }
        $mo = $user->data->user_email;
        $this->startEmailVerification($zC, $mo);
        hh:
        goto Ec;
        s1:
        $NN = get_user_meta($user->data->ID, $this->_phoneKey, true);
        $NN = $this->check_phone_length($NN);
        $this->fetchPhoneAndStartVerification($zC, $iK, $NN);
        Ec:
    }
    function startEmailVerification($zC, $mo)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->sendChallenge($zC, $mo, null, null, VerificationType::EMAIL);
    }
    function fetchPhoneAndStartVerification($zC, $iK, $NN)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $My = isset($_REQUEST["\x72\x65\x64\151\x72\x65\143\x74\137\x74\x6f"]) ? sanitize_text_field($_REQUEST["\162\x65\144\151\162\x65\x63\164\137\x74\157"]) : $_SERVER["\x48\x54\x54\x50\x5f\x48\117\123\124"];
        $this->sendChallenge($zC, null, null, $NN, VerificationType::PHONE, $iK, $My, false);
    }
    private function check_phone_length($Dk)
    {
        $NR = MoUtility::processPhoneNumber($Dk);
        return strlen($NR) >= 5 ? $NR : '';
    }
    function getUser($zC, $iK = null)
    {
        $user = is_email($zC) ? get_user_by("\x65\x6d\x61\151\x6c", $zC) : get_user_by("\154\157\147\x69\x6e", $zC);
        if (!($this->_typePhoneTag && MoUtility::validatePhoneNumber($zC))) {
            goto N6;
        }
        $zC = MoUtility::processPhoneNumber($zC);
        $user = $this->getUserFromPhoneNumber($zC);
        N6:
        $user = wp_authenticate_username_password(NULL, $user->data->user_login, $iK);
        return $user ? $user : new WP_Error("\x49\116\x56\101\x4c\111\104\x5f\x55\123\x45\x52\116\101\x4d\x45", mo_("\40\x3c\x62\76\x45\x52\x52\117\122\72\74\x2f\142\x3e\x20\111\x6e\166\x61\x6c\x69\x64\40\125\163\x65\x72\116\x61\x6d\x65\x2e\x20"));
    }
    function getUserFromPhoneNumber($zC)
    {
        global $wpdb;
        $le = $wpdb->get_row("\x53\105\114\105\103\x54\40\x60\x75\x73\145\x72\x5f\151\144\140\x20\106\122\x4f\115\40\x60{$wpdb->prefix}\x75\163\145\162\155\145\164\141\140" . "\x57\x48\x45\122\x45\40\x60\155\x65\164\141\137\x6b\x65\171\140\x20\75\x20\x27{$this->_phoneKey}\x27\40\101\116\x44\40\x60\155\x65\x74\x61\x5f\x76\141\154\x75\145\x60\x20\x3d\40\x20\x27{$zC}\47");
        return !MoUtility::isBlank($le) ? get_userdata($le->user_id) : false;
    }
    function miniorange_register_login_script()
    {
        wp_register_script("\145\x64\165\x75\155\141\x6c\x6f\147", MOV_URL . "\151\x6e\143\x6c\165\144\145\x73\x2f\x6a\163\57\145\144\165\155\141\154\157\x67\56\155\x69\x6e\56\x6a\x73", array("\152\x71\x75\145\x72\x79"));
        wp_localize_script("\x65\144\165\x75\x6d\141\154\157\147", "\x65\x64\x75\165\x6d\141\154\x6f\147", array("\x6f\164\160\124\171\x70\x65" => $this->getVerificationType(), "\163\x69\x74\x65\x55\x52\x4c" => wp_ajax_url()));
        wp_enqueue_script("\x65\144\x75\x75\155\141\154\157\147");
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto N3;
        }
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), "\160\x68\x6f\156\145", FALSE);
        N3:
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        $zC = MoUtility::isBlank($iI) ? MoUtility::sanitizeCheck("\x6c\x6f\x67", $_POST) : $iI;
        $zC = MoUtility::isBlank($zC) ? MoUtility::sanitizeCheck("\x75\x73\x65\x72\x6e\141\155\x65", $_POST) : $zC;
        $this->login_wp_user($zC, $ck);
    }
    function login_wp_user($UU, $ck = null)
    {
        $user = is_email($UU) ? get_user_by("\145\155\141\x69\154", $UU) : (MoUtility::validatePhoneNumber($UU) ? $this->getUserFromPhoneNumber(MoUtility::processPhoneNumber($UU)) : get_user_by("\x6c\157\x67\x69\x6e", $UU));
        wp_set_auth_cookie($user->data->ID);
        if (!($this->_delayOtp && $this->_delayOtpInterval > 0)) {
            goto g0;
        }
        update_user_meta($user->data->ID, $this->_timeStampMetaKey, time());
        g0:
        $this->unsetOTPSessionVariables();
        do_action("\167\160\x5f\x6c\157\147\151\156", $user->user_login, $user);
        $oO = MoUtility::isBlank($ck) ? site_url() : $ck;
        wp_redirect($oO);
        exit;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_formSessionVar, $this->_txSessionId]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto hC;
        }
        array_push($kp, $this->_phoneFormId);
        hC:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Fv;
        }
        return;
        Fv:
        $this->_otpType = $this->sanitizeFormPOST("\145\144\x75\155\141\154\157\x67\137\x65\156\x61\x62\154\145\x5f\164\171\x70\x65");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\145\x64\x75\155\x61\154\157\x67\137\145\156\x61\x62\154\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x65\144\x75\155\x61\154\x6f\x67\137\x70\x68\x6f\156\145\137\x66\151\145\154\144\x5f\153\x65\171");
        $this->_byPassAdmin = $this->sanitizeFormPOST("\145\144\x75\x6d\141\154\157\x67\137\142\x79\160\x61\x73\x73\137\141\144\x6d\x69\x6e");
        update_mo_option("\145\x64\165\x6d\141\x6c\157\147\137\x65\x6e\141\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\145\144\165\155\141\x6c\157\x67\x5f\x65\x6e\141\x62\x6c\145\137\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\x65\x64\x75\155\x61\x6c\x6f\147\x5f\x70\x68\x6f\156\145\x5f\146\151\145\x6c\x64\x5f\x6b\145\171", $this->_phoneKey);
        update_mo_option("\145\144\x75\x6d\141\154\157\x67\x5f\142\171\x70\x61\163\x73\x5f\141\144\155\151\156", $this->_byPassAdmin);
    }
    function byPassCheckForAdmins()
    {
        return $this->_byPassAdmin;
    }
}
