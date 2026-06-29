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
use OTP\Traits\Instance;
use ReflectionException;
use WC_Emails;
use WC_Social_Login_Provider_Profile;
class WooCommerceSocialLoginForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_oAuthProviders = array("\x66\141\143\x65\142\x6f\157\153", "\x74\x77\x69\164\x74\x65\162", "\x67\x6f\x6f\147\x6c\x65", "\x61\155\x61\x7a\x6f\156", "\154\151\156\153\145\x64\x49\156", "\160\x61\171\x70\141\x6c", "\x69\156\163\164\141\147\162\141\155", "\144\151\163\161\x75\163", "\x79\141\150\157\157", "\166\x6b");
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = TRUE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WC_SOCIAL_LOGIN;
        $this->_otpType = "\160\150\157\x6e\145";
        $this->_phoneFormId = "\x23\x6d\x6f\x5f\160\150\157\x6e\x65\x5f\156\165\x6d\142\x65\162";
        $this->_formKey = "\127\x43\137\123\x4f\x43\111\x41\114\x5f\114\x4f\x47\111\x4e";
        $this->_formName = mo_("\x57\157\x6f\x63\x6f\x6d\155\x65\162\143\145\40\123\x6f\143\x69\x61\x6c\40\114\x6f\147\x69\x6e\40\50\40\x53\115\123\x20\x56\145\x72\x69\146\x69\143\141\164\x69\x6f\x6e\x20\117\156\154\x79\x20\51");
        $this->_isFormEnabled = get_mo_option("\x77\x63\x5f\x73\x6f\143\151\141\x6c\137\154\x6f\147\x69\x6e\x5f\x65\x6e\141\142\154\x65");
        $this->_formDocuments = MoOTPDocs::WC_SOCIAL_LOGIN;
        parent::__construct();
    }
    function handleForm()
    {
        $this->includeRequiredFiles();
        foreach ($this->_oAuthProviders as $hh) {
            add_filter("\167\143\x5f\x73\x6f\x63\151\x61\x6c\137\x6c\157\x67\151\x6e\137" . $hh . "\x5f\160\x72\157\x66\151\x6c\145", array($this, "\155\x6f\x5f\167\143\137\163\x6f\143\151\x61\154\137\154\157\147\151\156\x5f\160\x72\x6f\x66\x69\154\x65"), 99, 2);
            add_filter("\167\x63\x5f\x73\x6f\143\x69\141\x6c\137\x6c\157\147\x69\x6e\x5f" . $hh . "\x5f\156\145\x77\137\x75\x73\145\x72\137\x64\141\164\141", array($this, "\x6d\157\137\167\x63\x5f\163\157\x63\x69\141\x6c\x5f\x6c\157\x67\x69\x6e"), 99, 2);
            Xjp:
        }
        col:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\x70\164\151\157\x6e", $_REQUEST)) {
            goto vqK;
        }
        return;
        vqK:
        switch (trim($_REQUEST["\157\x70\x74\151\x6f\156"])) {
            case "\155\151\x6e\x69\x6f\x72\141\x6e\x67\145\55\141\x6a\x61\x78\x2d\x6f\164\x70\55\x67\145\156\x65\162\141\x74\145":
                $this->_handle_wc_ajax_send_otp($_POST);
                goto y9v;
            case "\x6d\x69\156\151\157\x72\x61\x6e\147\x65\x2d\141\x6a\141\x78\x2d\157\x74\160\x2d\166\141\x6c\151\144\141\x74\x65":
                $this->processOTPEntered($_REQUEST);
                goto y9v;
            case "\x6d\x6f\x5f\x61\152\x61\x78\137\146\x6f\x72\155\x5f\x76\x61\x6c\151\144\141\164\145":
                $this->_handle_wc_create_user_action($_POST);
                goto y9v;
        }
        wri:
        y9v:
    }
    function includeRequiredFiles()
    {
        if (!function_exists("\x69\x73\137\x70\x6c\165\147\151\x6e\x5f\141\143\164\x69\x76\145")) {
            include_once ABSPATH . "\x77\x70\x2d\141\144\155\151\x6e\x2f\151\x6e\x63\x6c\x75\x64\x65\x73\57\160\x6c\165\147\x69\x6e\x2e\160\x68\x70";
        }
        if (!is_plugin_active("\167\x6f\157\x63\157\155\155\145\162\143\145\x2d\x73\x6f\x63\151\141\x6c\55\x6c\x6f\147\x69\x6e\57\x77\x6f\157\x63\x6f\155\x6d\145\162\143\145\55\163\x6f\x63\151\x61\154\x2d\154\x6f\147\151\x6e\56\160\x68\160")) {
            goto mhy;
        }
        require_once plugin_dir_path(MOV_DIR) . "\x77\157\x6f\x63\x6f\x6d\155\x65\x72\x63\145\55\x73\x6f\x63\151\141\x6c\55\x6c\x6f\147\x69\156\57\151\x6e\143\154\x75\144\x65\163\x2f\x63\154\141\x73\x73\x2d\167\x63\55\x73\157\143\151\x61\154\55\x6c\157\x67\151\156\x2d\x70\162\x6f\x76\x69\x64\x65\x72\55\x70\162\157\x66\151\x6c\x65\56\160\150\160";
        mhy:
    }
    function mo_wc_social_login_profile($b3, $EX)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        MoPHPSessions::addSessionVar("\x77\x63\x5f\x70\162\x6f\x76\151\x64\x65\x72", $b3);
        $_SESSION["\x77\143\x5f\160\x72\x6f\166\151\x64\145\x72\137\151\144"] = maybe_serialize($EX);
        return $b3;
    }
    function mo_wc_social_login($wz, $b3)
    {
        $this->sendChallenge(NULL, $wz["\x75\x73\145\162\x5f\x65\x6d\141\x69\x6c"], NULL, NULL, "\x65\170\x74\145\x72\156\141\154", NULL, array("\144\141\164\141" => $wz, "\x6d\145\163\163\x61\x67\145" => MoMessages::showMessage(MoMessages::PHONE_VALIDATION_MSG), "\146\x6f\162\x6d" => "\x57\103\137\x53\117\103\x49\x41\114", "\143\x75\162\154" => MoUtility::currentPageUrl()));
    }
    function _handle_wc_create_user_action($r9)
    {
        if (!(!$this->checkIfVerificationNotStarted() && SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType()))) {
            goto Nbb;
        }
        $this->create_new_wc_social_customer($r9);
        Nbb:
    }
    function create_new_wc_social_customer($tD)
    {
        require_once plugin_dir_path(MOV_DIR) . "\x77\x6f\157\143\x6f\x6d\x6d\x65\x72\143\145\x2f\151\x6e\x63\154\x75\144\145\x73\57\x63\154\141\163\163\x2d\x77\143\x2d\145\x6d\x61\151\154\x73\x2e\x70\150\160";
        WC_Emails::init_transactional_emails();
        $ir = MoPHPSessions::getSessionVar("\167\143\x5f\160\x72\x6f\166\x69\x64\x65\162");
        $EX = maybe_unserialize(sanitize_text_field($_SESSION["\167\x63\137\x70\162\157\x76\x69\x64\145\x72\x5f\151\144"]));
        $this->unsetOTPSessionVariables();
        $b3 = new WC_Social_Login_Provider_Profile($EX, $ir);
        $Dk = $tD["\x6d\157\x5f\x70\150\x6f\156\145\137\x6e\x75\155\x62\145\x72"];
        $tD = array("\x72\157\x6c\145" => "\x63\x75\x73\164\157\x6d\x65\x72", "\x75\163\145\x72\137\x6c\157\x67\151\x6e" => $b3->has_email() ? sanitize_email($b3->get_email()) : $b3->get_nickname(), "\x75\x73\x65\x72\137\x65\x6d\x61\x69\x6c" => $b3->get_email(), "\165\163\145\x72\137\x70\141\x73\x73" => wp_generate_password(), "\x66\151\x72\x73\164\137\x6e\141\155\145" => $b3->get_first_name(), "\154\141\163\164\x5f\x6e\x61\x6d\x65" => $b3->get_last_name());
        if (!empty($tD["\x75\163\x65\x72\137\x6c\x6f\147\x69\156"])) {
            goto xBc;
        }
        $tD["\x75\163\x65\162\137\x6c\x6f\x67\x69\156"] = $tD["\146\x69\x72\163\x74\137\x6e\141\x6d\x65"] . $tD["\154\x61\x73\x74\x5f\156\141\155\145"];
        xBc:
        $LG = 1;
        $ZR = $tD["\x75\x73\145\x72\x5f\154\x6f\147\151\156"];
        nKq:
        if (!username_exists($tD["\165\163\x65\162\137\154\157\x67\x69\x6e"])) {
            goto GSP;
        }
        $tD["\x75\163\x65\162\x5f\154\157\147\x69\156"] = $ZR . $LG;
        $LG++;
        goto nKq;
        GSP:
        $RQ = wp_insert_user($tD);
        update_user_meta($RQ, "\142\x69\x6c\x6c\x69\x6e\x67\137\x70\150\x6f\x6e\x65", MoUtility::processPhoneNumber($Dk));
        update_user_meta($RQ, "\164\145\154\145\x70\150\x6f\156\145", MoUtility::processPhoneNumber($Dk));
        do_action("\167\x6f\x6f\x63\x6f\x6d\155\x65\162\x63\x65\137\143\162\145\x61\x74\145\x64\x5f\143\x75\163\x74\x6f\x6d\x65\x72", $RQ, $tD, false);
        $user = get_user_by("\x69\x64", $RQ);
        $b3->update_customer_profile($user->ID, $user);
        if (!($bC = apply_filters("\x77\143\137\x73\x6f\143\x69\x61\154\x5f\154\x6f\x67\151\x6e\x5f\x73\x65\164\137\141\x75\x74\x68\137\143\157\x6f\153\151\x65", '', $user))) {
            goto ltJ;
        }
        wc_add_notice($bC, "\x6e\157\x74\151\x63\145");
        goto wZZ;
        ltJ:
        wc_set_customer_auth_cookie($user->ID);
        update_user_meta($user->ID, "\137\x77\x63\x5f\163\157\143\x69\141\154\137\x6c\x6f\147\x69\156\x5f" . $b3->get_provider_id() . "\x5f\154\157\147\x69\156\137\164\x69\x6d\145\x73\164\141\x6d\x70", current_time("\x74\151\155\145\x73\x74\141\155\x70"));
        update_user_meta($user->ID, "\x5f\x77\143\137\x73\157\143\x69\x61\154\137\x6c\x6f\147\151\x6e\137" . $b3->get_provider_id() . "\x5f\154\157\x67\151\156\x5f\x74\151\x6d\145\163\164\141\155\160\137\147\155\x74", time());
        do_action("\x77\x63\137\x73\x6f\x63\151\141\x6c\x5f\x6c\x6f\x67\151\156\x5f\x75\x73\145\162\137\x61\x75\x74\150\145\156\x74\151\x63\141\x74\x65\144", $user->ID, $b3->get_provider_id());
        wZZ:
        if (is_wp_error($RQ)) {
            goto GZl;
        }
        $this->redirect(null, $RQ);
        goto Ujw;
        GZl:
        $this->redirect("\x65\162\162\157\x72", 0, $RQ->get_error_code());
        Ujw:
    }
    function redirect($uO = null, $nL = 0, $qz = "\167\143\x2d\163\x6f\143\151\141\154\x2d\x6c\157\147\x69\x6e\55\x65\x72\x72\x6f\x72")
    {
        $user = get_user_by("\151\144", $nL);
        if (MoUtility::isBlank($user->user_email)) {
            goto Wrm;
        }
        $sW = get_transient("\167\143\163\x6c\x5f" . md5($_SERVER["\122\x45\x4d\117\x54\105\137\x41\x44\x44\122"] . $_SERVER["\x48\x54\124\120\137\x55\x53\105\x52\x5f\101\x47\x45\x4e\124"]));
        $sW = $sW ? esc_url(urldecode($sW)) : wc_get_page_permalink("\x6d\x79\141\x63\143\157\165\156\164");
        delete_transient("\167\143\163\x6c\137" . md5($_SERVER["\x52\x45\115\x4f\x54\x45\x5f\101\104\x44\122"] . $_SERVER["\x48\124\124\120\137\125\x53\105\x52\137\x41\107\x45\116\124"]));
        goto NHV;
        Wrm:
        $sW = add_query_arg("\x77\x63\55\x73\157\x63\151\x61\154\55\154\x6f\x67\x69\x6e\55\155\x69\x73\163\151\x6e\x67\55\145\155\141\x69\154", "\164\162\165\145", wc_customer_edit_account_url());
        NHV:
        if (!("\145\x72\162\157\162" === $uO)) {
            goto zKr;
        }
        $sW = add_query_arg($qz, "\x74\x72\165\145", $sW);
        zKr:
        wp_safe_redirect(esc_url_raw($sW));
        exit;
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    function _handle_wc_ajax_send_otp($FA)
    {
        if ($this->checkIfVerificationNotStarted()) {
            goto YRG;
        }
        $this->sendChallenge("\141\x6a\141\x78\x5f\x70\150\x6f\156\x65", '', null, trim($FA["\x75\163\145\x72\x5f\x70\150\x6f\156\x65"]), $this->_otpType, null, $FA);
        YRG:
    }
    function processOTPEntered($FA)
    {
        if (!$this->checkIfVerificationNotStarted()) {
            goto XNx;
        }
        return;
        XNx:
        if ($this->processPhoneNumber($FA)) {
            goto uFJ;
        }
        $this->validateChallenge($this->getVerificationType());
        goto oi4;
        uFJ:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        oi4:
    }
    function processPhoneNumber($FA)
    {
        $Dk = MoPHPSessions::getSessionVar("\x70\x68\x6f\x6e\145\x5f\x6e\x75\x6d\142\145\162\x5f\155\157");
        return strcmp($Dk, MoUtility::processPhoneNumber($FA["\x75\x73\145\162\x5f\x70\x68\x6f\156\145"])) != 0;
    }
    function checkIfVerificationNotStarted()
    {
        return !SessionUtils::isOTPInitialized($this->_formSessionVar);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!$this->isFormEnabled()) {
            goto LrE;
        }
        array_push($kp, $this->_phoneFormId);
        LrE:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Pko;
        }
        return;
        Pko:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\143\137\163\157\143\x69\141\x6c\137\x6c\x6f\147\x69\156\137\145\156\141\142\x6c\145");
        update_mo_option("\167\x63\x5f\163\x6f\x63\151\x61\x6c\137\x6c\x6f\147\x69\156\137\x65\156\x61\142\154\145", $this->_isFormEnabled);
    }
}
