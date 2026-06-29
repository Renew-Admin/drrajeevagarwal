<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
use WP_User;
class WPLoginForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_savePhoneNumbers;
    private $_byPassAdmin;
    private $_allowLoginThroughPhone;
    private $_skipPasswordCheck;
    private $_userLabel;
    private $_delayOtp;
    private $_delayOtpInterval;
    private $_skipPassFallback;
    private $_createUserAction;
    private $_timeStampMetaKey = "\155\157\166\x5f\154\x61\163\x74\137\166\145\x72\151\146\151\x65\x64\x5f\144\164\x74\x6d";
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = TRUE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WP_LOGIN_REG_PHONE;
        $this->_formSessionVar2 = FormSessionVars::WP_DEFAULT_LOGIN;
        $this->_phoneFormId = "\x23\155\157\x5f\x70\x68\x6f\x6e\145\x5f\x6e\x75\x6d\142\145\162";
        $this->_typePhoneTag = "\x6d\157\x5f\167\x70\137\x6c\x6f\147\151\x6e\x5f\x70\x68\157\x6e\145\x5f\x65\x6e\x61\x62\154\145";
        $this->_typeEmailTag = "\155\157\x5f\x77\x70\137\154\157\147\x69\x6e\137\145\155\141\151\x6c\137\145\x6e\141\142\x6c\145";
        $this->_formKey = "\127\x50\x5f\x44\105\x46\x41\x55\114\124\x5f\114\117\107\111\x4e";
        $this->_formName = mo_("\127\157\162\144\120\162\145\x73\163\40\57\x20\x57\x6f\157\x43\157\155\155\x65\162\143\145\40\x2f\40\x55\154\x74\x69\x6d\x61\x74\x65\x20\115\x65\x6d\x62\145\x72\40\x4c\157\147\151\156\x20\x46\x6f\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\167\x70\x5f\x6c\157\147\x69\x6e\137\145\156\x61\142\154\x65");
        $this->_userLabel = get_mo_option("\x77\160\137\x75\163\x65\162\x6e\x61\155\145\137\154\141\142\145\154\x5f\164\x65\170\x74");
        $this->_userLabel = $this->_userLabel ? mo_($this->_userLabel) : mo_("\x55\x73\145\162\156\141\155\145\x2c\x20\x45\55\155\x61\x69\x6c\40\x6f\x72\x20\120\150\157\x6e\145\40\116\157\x2e");
        $this->_skipPasswordCheck = get_mo_option("\x77\x70\x5f\154\157\147\151\x6e\137\163\x6b\x69\160\137\x70\141\x73\163\x77\x6f\162\144");
        $this->_allowLoginThroughPhone = get_mo_option("\x77\160\137\x6c\157\x67\x69\156\x5f\141\154\x6c\x6f\167\137\x70\150\x6f\x6e\x65\137\154\157\x67\151\x6e");
        $this->_skipPassFallback = get_mo_option("\x77\x70\x5f\x6c\157\x67\151\156\x5f\x73\153\x69\160\x5f\160\x61\163\163\x77\x6f\162\144\137\146\x61\154\154\x62\141\x63\x6b");
        $this->_delayOtp = get_mo_option("\x77\x70\x5f\154\157\x67\x69\x6e\x5f\144\x65\154\141\171\137\x6f\164\160");
        $this->_delayOtpInterval = get_mo_option("\x77\160\137\154\x6f\x67\x69\x6e\137\x64\145\154\x61\171\137\157\164\x70\x5f\151\x6e\164\145\162\x76\141\154");
        $this->_delayOtpInterval = $this->_delayOtpInterval ? $this->_delayOtpInterval : 43800;
        $this->_formDocuments = MoOTPDocs::LOGIN_FORM;
        if (!($this->_skipPasswordCheck || $this->_allowLoginThroughPhone)) {
            goto RtZ;
        }
        add_action("\154\x6f\x67\x69\156\137\145\156\161\165\145\x75\x65\137\163\143\162\x69\160\164\163", array($this, "\x6d\x69\156\x69\157\162\141\156\147\145\137\x72\x65\147\x69\163\x74\145\x72\x5f\x6c\x6f\147\x69\156\x5f\163\143\x72\x69\x70\164"));
        add_action("\167\x70\x5f\145\x6e\x71\x75\145\x75\x65\x5f\x73\143\162\151\160\164\163", array($this, "\x6d\x69\x6e\x69\x6f\162\x61\156\x67\x65\137\x72\145\147\x69\x73\x74\145\x72\x5f\x6c\157\x67\x69\x6e\137\x73\x63\162\x69\x70\x74"));
        RtZ:
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\160\x5f\x6c\157\147\151\156\137\145\156\x61\x62\154\145\137\x74\x79\x70\x65");
        $this->_phoneKey = get_mo_option("\167\x70\137\x6c\157\x67\x69\x6e\x5f\153\145\x79");
        $this->_savePhoneNumbers = get_mo_option("\167\160\x5f\x6c\157\147\151\x6e\x5f\x72\x65\147\151\163\164\145\x72\x5f\x70\150\x6f\156\x65");
        $this->_byPassAdmin = get_mo_option("\167\160\137\154\157\147\151\x6e\x5f\142\171\x70\141\x73\163\x5f\x61\x64\x6d\x69\x6e");
        $this->_restrictDuplicates = get_mo_option("\x77\x70\137\154\157\x67\151\x6e\137\162\x65\x73\164\162\151\x63\164\x5f\x64\x75\160\x6c\x69\143\141\x74\145\x73");
        add_filter("\141\165\x74\x68\145\156\164\151\x63\x61\x74\145", array($this, "\137\150\x61\156\144\x6c\145\137\155\157\137\x77\160\137\x6c\157\147\151\156"), 99, 3);
        add_action("\x77\160\x5f\x61\x6a\141\170\137\155\x6f\55\x61\x64\155\x69\x6e\x2d\143\150\145\143\x6b", [$this, "\x69\163\101\x64\155\151\x6e"]);
        add_action("\x77\x70\x5f\141\152\141\170\137\x6e\x6f\x70\x72\151\166\x5f\x6d\157\x2d\x61\144\x6d\151\156\55\x63\150\145\143\x6b", [$this, "\x69\x73\x41\144\x6d\151\156"]);
        if (!class_exists("\x55\115")) {
            goto w4t;
        }
        add_filter("\167\x70\x5f\141\165\x74\x68\x65\x6e\164\151\143\x61\x74\x65\137\165\163\x65\x72", array($this, "\x5f\x67\x65\164\x5f\x61\x6e\144\137\162\145\164\165\x72\156\137\165\x73\145\x72"), 99, 2);
        w4t:
        $this->routeData();
    }
    function isAdmin()
    {
        $zC = MoUtility::sanitizeCheck("\165\163\x65\162\156\x61\x6d\145", $_POST);
        $user = is_email($zC) ? get_user_by("\145\x6d\x61\x69\154", $zC) : get_user_by("\x6c\x6f\147\x69\156", $zC);
        $FH = MoConstants::SUCCESS_JSON_TYPE;
        $FH = $user ? in_array("\141\x64\x6d\151\x6e\151\163\164\162\141\x74\x6f\162", $user->roles) ? $FH : "\145\162\x72\x6f\x72" : "\145\x72\x72\157\x72";
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_EXISTS), $FH));
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\x74\151\x6f\156", $_REQUEST)) {
            goto fff;
        }
        return;
        fff:
        switch (trim($_REQUEST["\x6f\160\x74\151\x6f\156"])) {
            case "\155\x69\x6e\x69\x6f\x72\141\x6e\147\x65\55\x61\152\141\170\55\157\x74\160\55\x67\145\156\x65\162\x61\164\x65":
                $this->_handle_wp_login_ajax_send_otp();
                goto YFo;
            case "\x6d\151\x6e\x69\x6f\x72\141\x6e\147\145\55\141\152\x61\170\x2d\157\164\160\55\166\141\154\151\x64\x61\x74\x65":
                $this->_handle_wp_login_ajax_form_validate_action();
                goto YFo;
            case "\x6d\157\x5f\141\x6a\141\170\x5f\x66\157\x72\155\137\166\x61\154\151\144\x61\x74\145":
                $this->_handle_wp_login_create_user_action();
                goto YFo;
        }
        AK8:
        YFo:
    }
    function miniorange_register_login_script()
    {
        wp_register_script("\x6d\157\x6c\157\147\x69\156", MOV_URL . "\x69\156\x63\154\x75\144\x65\x73\x2f\x6a\163\57\154\x6f\x67\x69\156\x66\157\x72\x6d\56\155\151\x6e\x2e\x6a\163", array("\152\x71\165\145\x72\171"));
        wp_localize_script("\x6d\x6f\x6c\157\x67\x69\156", "\x6d\x6f\166\x61\162\x6c\157\147\x69\156", array("\165\x73\x65\x72\114\141\142\145\x6c" => $this->_allowLoginThroughPhone ? $this->_userLabel : null, "\163\x6b\151\160\120\x77\144\x43\x68\x65\143\x6b" => $this->_skipPasswordCheck, "\x73\153\x69\160\x50\x77\144\106\x61\154\154\142\x61\x63\x6b" => $this->_skipPassFallback, "\x62\165\x74\164\x6f\x6e\x74\x65\170\x74" => mo_("\114\157\x67\151\156\x20\167\151\164\x68\40\x4f\124\x50"), "\151\x73\101\144\x6d\x69\156\101\143\164\x69\x6f\156" => "\155\157\55\141\144\x6d\x69\156\55\x63\150\145\x63\153", "\x62\x79\120\x61\x73\x73\x41\x64\155\x69\156" => $this->_byPassAdmin, "\163\151\x74\x65\x55\122\114" => wp_ajax_url()));
        wp_enqueue_script("\x6d\x6f\x6c\157\x67\x69\156");
    }
    function _get_and_return_user($zC, $iK)
    {
        if (!is_object($zC)) {
            goto Ow7;
        }
        return $zC;
        Ow7:
        $user = $this->getUser($zC, $iK);
        if (!is_wp_error($user)) {
            goto j99;
        }
        return $user;
        j99:
        UM()->login()->auth_id = $user->data->ID;
        UM()->form()->errors = null;
        return $user;
    }
    function byPassLogin($user, $PR)
    {
        $f7 = get_userdata($user->data->ID);
        $sl = $f7->roles;
        return in_array("\x61\x64\155\x69\156\x69\x73\164\x72\x61\164\x6f\x72", $sl) && $this->_byPassAdmin || $PR || $this->delayOTPProcess($user->data->ID);
    }
    function _handle_wp_login_create_user_action()
    {
        $eD = function ($r9) {
            $zC = MoUtility::sanitizeCheck("\x6c\x6f\x67", $r9);
            if ($zC) {
                goto EGY;
            }
            $Uc = array_filter($r9, function ($j1) {
                return strpos($j1, "\165\x73\145\162\156\x61\155\145") === 0;
            }, ARRAY_FILTER_USE_KEY);
            $zC = !empty($Uc) ? array_shift($Uc) : $zC;
            EGY:
            return is_email($zC) ? get_user_by("\x65\x6d\141\x69\154", $zC) : get_user_by("\154\x6f\x67\x69\x6e", $zC);
        };
        $r9 = $_POST;
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto Dqm;
        }
        return;
        Dqm:
        $user = $eD($r9);
        update_user_meta($user->data->ID, $this->_phoneKey, $this->check_phone_length($r9["\x6d\x6f\137\160\150\157\x6e\x65\x5f\156\x75\155\x62\x65\162"]));
        $this->login_wp_user($user->data->user_login);
    }
    function login_wp_user($UU, $ck = null)
    {
        $user = is_email($UU) ? get_user_by("\145\155\141\151\x6c", $UU) : ($this->allowLoginThroughPhone() && MoUtility::validatePhoneNumber($UU) ? $this->getUserFromPhoneNumber(MoUtility::processPhoneNumber($UU)) : get_user_by("\x6c\x6f\147\x69\x6e", $UU));
        wp_set_auth_cookie($user->data->ID);
        if (!($this->_delayOtp && $this->_delayOtpInterval > 0)) {
            goto ou9;
        }
        update_user_meta($user->data->ID, $this->_timeStampMetaKey, time());
        ou9:
        $this->unsetOTPSessionVariables();
        do_action("\x77\x70\137\154\157\147\151\x6e", $user->user_login, $user);
        $oO = MoUtility::isBlank($ck) ? site_url() : $ck;
        wp_redirect($oO);
        exit;
    }
    function _handle_mo_wp_login($user, $zC, $iK)
    {
        if (MoUtility::isBlank($zC)) {
            goto rSH;
        }
        $PR = $this->skipOTPProcess($iK);
        $user = $this->getUser($zC, $iK);
        if (!is_wp_error($user)) {
            goto GUG;
        }
        return $user;
        GUG:
        if (!$this->byPassLogin($user, $PR)) {
            goto qAy;
        }
        return $user;
        qAy:
        apply_filters("\x6d\x6f\137\155\141\x73\x74\x65\162\137\157\x74\160\137\x73\145\156\144\x5f\x75\x73\x65\162", $user);
        $this->startOTPVerificationProcess($user, $zC, $iK);
        rSH:
        return $user;
    }
    function startOTPVerificationProcess($user, $zC, $iK)
    {
        $tA = $this->getVerificationType();
        if (!(SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $tA) || SessionUtils::isStatusMatch($this->_formSessionVar2, self::VALIDATED, $tA))) {
            goto EHg;
        }
        return;
        EHg:
        if ($tA === VerificationType::PHONE) {
            goto qXs;
        }
        if (!($tA === VerificationType::EMAIL)) {
            goto kUY;
        }
        $mo = $user->data->user_email;
        $this->startEmailVerification($zC, $mo);
        kUY:
        goto JpT;
        qXs:
        $NN = get_user_meta($user->data->ID, $this->_phoneKey, true);
        $NN = $this->check_phone_length($NN);
        $this->askPhoneAndStartVerification($user, $this->_phoneKey, $zC, $NN);
        $this->fetchPhoneAndStartVerification($zC, $iK, $NN);
        JpT:
    }
    function getUser($zC, $iK = null)
    {
        $user = is_email($zC) ? get_user_by("\145\x6d\x61\x69\154", $zC) : get_user_by("\x6c\x6f\147\151\x6e", $zC);
        if (!($this->_allowLoginThroughPhone && MoUtility::validatePhoneNumber($zC))) {
            goto El7;
        }
        $zC = MoUtility::processPhoneNumber($zC);
        $user = $this->getUserFromPhoneNumber($zC);
        El7:
        if (!($user && !$this->isLoginWithOTP($user->roles))) {
            goto o9C;
        }
        $user = wp_authenticate_username_password(NULL, $user->data->user_login, $iK);
        o9C:
        return $user ? $user : new WP_Error("\x49\116\x56\101\x4c\x49\x44\137\x55\x53\x45\122\x4e\x41\115\x45", mo_("\x20\x3c\142\x3e\x45\122\122\x4f\122\72\74\x2f\142\76\x20\x49\156\166\141\154\151\x64\x20\x55\x73\145\162\x4e\x61\155\145\56\40"));
    }
    function getUserFromPhoneNumber($zC)
    {
        global $wpdb;
        $le = $wpdb->get_row("\123\105\114\105\x43\x54\40\x60\x75\x73\145\162\x5f\x69\x64\140\x20\106\x52\x4f\x4d\x20\x60{$wpdb->prefix}\165\x73\x65\162\155\145\x74\141\x60" . "\x57\x48\105\122\105\40\x60\155\145\x74\x61\137\153\145\171\140\x20\x3d\40\47{$this->_phoneKey}\x27\x20\101\116\104\x20\x60\x6d\145\x74\141\137\x76\141\x6c\165\x65\x60\40\x3d\x20\40\x27{$zC}\47");
        return !MoUtility::isBlank($le) ? get_userdata($le->user_id) : false;
    }
    function askPhoneAndStartVerification($user, $j1, $zC, $NN)
    {
        if (MoUtility::isBlank($NN)) {
            goto k3c;
        }
        return;
        k3c:
        if (!$this->savePhoneNumbers()) {
            goto QqJ;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->sendChallenge(NULL, $user->data->user_login, NULL, NULL, "\145\170\x74\x65\x72\x6e\141\x6c", NULL, ["\144\x61\x74\x61" => array("\x75\163\x65\162\x5f\154\x6f\147\x69\x6e" => $zC), "\155\145\x73\163\x61\147\x65" => MoMessages::showMessage(MoMessages::REGISTER_PHONE_LOGIN), "\x66\x6f\162\x6d" => $j1, "\x63\x75\x72\154" => MoUtility::currentPageUrl()]);
        goto pAu;
        QqJ:
        miniorange_site_otp_validation_form(null, null, null, MoMessages::showMessage(MoMessages::PHONE_NOT_FOUND), null, null);
        pAu:
    }
    function fetchPhoneAndStartVerification($zC, $iK, $NN)
    {
        MoUtility::initialize_transaction($this->_formSessionVar2);
        $My = isset($_REQUEST["\x72\x65\144\151\x72\x65\x63\x74\137\164\x6f"]) ? sanitize_text_field($_REQUEST["\162\145\x64\x69\x72\x65\143\x74\137\x74\157"]) : MoUtility::currentPageUrl();
        $this->sendChallenge($zC, null, null, $NN, VerificationType::PHONE, $iK, $My, false);
    }
    function startEmailVerification($zC, $mo)
    {
        MoUtility::initialize_transaction($this->_formSessionVar2);
        $this->sendChallenge($zC, $mo, null, null, VerificationType::EMAIL);
    }
    function _handle_wp_login_ajax_send_otp()
    {
        $FA = $_POST;
        if ($this->restrictDuplicates() && !MoUtility::isBlank($this->getUserFromPhoneNumber(sanitize_text_field($FA["\165\163\145\x72\137\x70\150\x6f\156\145"])))) {
            goto Tye;
        }
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto dS_;
        }
        goto FZw;
        Tye:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_EXISTS), MoConstants::ERROR_JSON_TYPE));
        goto FZw;
        dS_:
        $this->sendChallenge("\x61\x6a\141\x78\137\160\150\x6f\156\x65", '', null, trim(sanitize_text_field($FA["\165\x73\145\x72\x5f\x70\x68\x6f\x6e\x65"])), VerificationType::PHONE, null, $FA);
        FZw:
    }
    function _handle_wp_login_ajax_form_validate_action()
    {
        $FA = $_POST;
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto JfJ;
        }
        return;
        JfJ:
        $Dk = MoPHPSessions::getSessionVar("\x70\150\x6f\x6e\145\137\x6e\x75\155\x62\145\162\137\155\x6f");
        if (strcmp($Dk, $this->check_phone_length($FA["\165\x73\145\x72\x5f\x70\x68\x6f\156\x65"]))) {
            goto I4R;
        }
        $this->validateChallenge($this->getVerificationType());
        goto aU7;
        I4R:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        aU7:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto xa6;
        }
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
        xa6:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar2)) {
            goto Q05;
        }
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), "\160\x68\x6f\156\x65", FALSE);
        Q05:
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Pnp;
        }
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
        wp_send_json(MoUtility::createJson('', MoConstants::SUCCESS_JSON_TYPE));
        Pnp:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar2)) {
            goto n33;
        }
        $zC = MoUtility::isBlank($iI) ? MoUtility::sanitizeCheck("\x6c\x6f\x67", $_POST) : $iI;
        $zC = MoUtility::isBlank($zC) ? MoUtility::sanitizeCheck("\x75\163\145\162\156\141\155\145", $_POST) : $zC;
        $this->login_wp_user($zC, $ck);
        n33:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar, $this->_formSessionVar2]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!$this->isFormEnabled()) {
            goto abk;
        }
        array_push($kp, $this->_phoneFormId);
        abk:
        return $kp;
    }
    private function isLoginWithOTP($fn = array())
    {
        $jU = mo_("\x4c\157\x67\x69\x6e\40\x77\151\164\x68\x20\117\124\120");
        if (!(in_array("\141\144\155\x69\156\151\x73\164\x72\141\164\157\x72", $fn) && $this->_byPassAdmin)) {
            goto ihU;
        }
        return false;
        ihU:
        return MoUtility::sanitizeCheck("\x77\160\x2d\x73\x75\142\x6d\x69\164", $_POST) == $jU || MoUtility::sanitizeCheck("\154\x6f\x67\x69\x6e", $_POST) == $jU || MoUtility::sanitizeCheck("\x6c\157\147\x69\156\164\x79\160\x65", $_POST) == $jU;
    }
    private function skipOTPProcess($iK)
    {
        return $this->_skipPasswordCheck && $this->_skipPassFallback && isset($iK) && !$this->isLoginWithOTP();
    }
    private function check_phone_length($Dk)
    {
        $NR = MoUtility::processPhoneNumber($Dk);
        return strlen($NR) >= 5 ? $NR : '';
    }
    private function delayOTPProcess($nL)
    {
        if (!($this->_delayOtp && $this->_delayOtpInterval < 0)) {
            goto B36;
        }
        return TRUE;
        B36:
        $g1 = get_user_meta($nL, $this->_timeStampMetaKey, true);
        if (!MoUtility::isBlank($g1)) {
            goto Suf;
        }
        return FALSE;
        Suf:
        $si = time() - $g1;
        return $this->_delayOtp && $si < $this->_delayOtpInterval * 60;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto P4F;
        }
        return;
        P4F:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\160\x5f\154\x6f\147\151\x6e\x5f\x65\x6e\x61\x62\154\145");
        $this->_savePhoneNumbers = $this->sanitizeFormPOST("\x77\x70\137\154\x6f\147\151\156\x5f\x72\x65\x67\x69\163\x74\145\x72\x5f\160\x68\x6f\x6e\x65");
        $this->_byPassAdmin = $this->sanitizeFormPOST("\167\160\x5f\154\157\147\x69\x6e\x5f\142\171\160\141\163\x73\137\x61\x64\155\151\156");
        $this->_phoneKey = $this->sanitizeFormPOST("\167\x70\137\154\157\147\151\156\x5f\x70\150\157\156\x65\137\146\151\145\x6c\144\137\153\145\x79");
        $this->_allowLoginThroughPhone = $this->sanitizeFormPOST("\x77\160\137\154\x6f\x67\x69\x6e\137\x61\154\x6c\157\x77\137\x70\150\x6f\x6e\x65\x5f\x6c\157\147\151\156");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x77\160\x5f\154\x6f\x67\151\156\x5f\162\x65\x73\164\x72\x69\143\164\137\x64\x75\160\154\x69\143\x61\x74\x65\x73");
        $this->_otpType = $this->sanitizeFormPOST("\167\160\x5f\154\x6f\147\151\x6e\137\145\x6e\141\x62\154\x65\137\164\171\160\x65");
        $this->_skipPasswordCheck = $this->sanitizeFormPOST("\x77\x70\137\154\157\x67\151\156\137\163\x6b\151\160\x5f\x70\141\x73\163\x77\x6f\162\x64");
        $this->_userLabel = $this->sanitizeFormPOST("\x77\160\137\165\x73\145\162\156\141\155\145\137\154\141\142\x65\x6c\x5f\x74\145\170\164");
        $this->_skipPassFallback = $this->sanitizeFormPOST("\167\x70\137\x6c\157\x67\151\156\137\x73\x6b\151\x70\137\160\141\163\x73\167\x6f\162\x64\137\146\141\x6c\154\142\141\143\153");
        $this->_delayOtp = $this->sanitizeFormPOST("\167\x70\137\x6c\x6f\147\x69\156\x5f\144\x65\154\x61\x79\137\157\x74\x70");
        $this->_delayOtpInterval = $this->sanitizeFormPOST("\167\160\x5f\x6c\x6f\x67\x69\156\x5f\x64\x65\154\141\171\x5f\157\164\160\x5f\x69\156\x74\x65\x72\x76\x61\x6c");
        update_mo_option("\x77\160\137\x6c\157\147\151\156\137\x65\156\141\142\154\x65\137\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\x77\160\137\x6c\x6f\147\x69\156\137\x65\156\141\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x77\x70\137\x6c\157\x67\x69\156\x5f\x72\x65\x67\x69\163\x74\145\162\137\x70\x68\x6f\156\x65", $this->_savePhoneNumbers);
        update_mo_option("\167\x70\x5f\154\157\x67\151\156\x5f\142\x79\160\x61\x73\x73\137\141\144\155\x69\x6e", $this->_byPassAdmin);
        update_mo_option("\167\160\x5f\154\x6f\x67\x69\x6e\137\x6b\x65\x79", $this->_phoneKey);
        update_mo_option("\x77\x70\x5f\154\x6f\147\151\x6e\x5f\x61\x6c\x6c\x6f\x77\137\160\x68\157\156\145\137\154\157\147\151\156", $this->_allowLoginThroughPhone);
        update_mo_option("\167\x70\x5f\154\x6f\147\151\x6e\x5f\x72\145\x73\164\162\151\143\164\137\144\165\160\x6c\x69\x63\x61\164\145\163", $this->_restrictDuplicates);
        update_mo_option("\x77\160\x5f\x6c\157\147\151\x6e\137\x73\153\x69\160\137\x70\x61\x73\x73\x77\157\x72\x64", $this->_skipPasswordCheck && $this->_isFormEnabled);
        update_mo_option("\x77\x70\137\x6c\157\147\151\x6e\137\x73\153\151\160\137\x70\141\x73\163\167\157\162\x64\137\146\x61\x6c\x6c\x62\141\143\x6b", $this->_skipPassFallback);
        update_mo_option("\x77\160\x5f\165\x73\145\x72\x6e\x61\x6d\x65\137\x6c\141\x62\145\154\137\x74\x65\x78\164", $this->_userLabel);
        update_mo_option("\167\160\137\154\157\x67\151\156\137\144\x65\154\141\x79\137\x6f\164\x70", $this->_delayOtp && $this->_isFormEnabled);
        update_mo_option("\x77\160\137\x6c\x6f\x67\x69\x6e\137\144\x65\x6c\x61\x79\137\x6f\164\160\x5f\x69\x6e\164\x65\162\166\x61\154", $this->_delayOtpInterval);
    }
    public function savePhoneNumbers()
    {
        return $this->_savePhoneNumbers;
    }
    function byPassCheckForAdmins()
    {
        return $this->_byPassAdmin;
    }
    function allowLoginThroughPhone()
    {
        return $this->_allowLoginThroughPhone;
    }
    public function getSkipPasswordCheck()
    {
        return $this->_skipPasswordCheck;
    }
    public function getUserLabel()
    {
        return mo_($this->_userLabel);
    }
    public function getSkipPasswordCheckFallback()
    {
        return $this->_skipPassFallback;
    }
    public function isDelayOtp()
    {
        return $this->_delayOtp;
    }
    public function getDelayOtpInterval()
    {
        return $this->_delayOtpInterval;
    }
}
