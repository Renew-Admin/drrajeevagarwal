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
use WP_Comment;
class WordPressComments extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPCOMMENT;
        $this->_phoneFormId = "\151\156\x70\x75\164\x5b\x6e\x61\x6d\145\75\160\x68\x6f\156\x65\x5d";
        $this->_formKey = "\127\120\103\117\x4d\115\x45\116\124";
        $this->_typePhoneTag = "\x6d\x6f\137\167\160\x63\x6f\x6d\x6d\x65\156\164\x5f\160\150\x6f\x6e\145\x5f\145\156\141\142\x6c\x65";
        $this->_typeEmailTag = "\x6d\x6f\x5f\167\x70\x63\x6f\155\x6d\145\x6e\x74\137\145\x6d\x61\151\x6c\137\145\x6e\141\142\x6c\145";
        $this->_formName = mo_("\127\157\162\x64\120\162\x65\x73\x73\x20\x43\157\x6d\155\145\156\x74\x20\x46\157\162\155");
        $this->_isFormEnabled = get_mo_option("\x77\x70\x63\x6f\155\x6d\145\156\x74\x5f\145\x6e\x61\142\154\x65");
        $this->_formDocuments = MoOTPDocs::WP_COMMENT_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\x70\143\157\155\x6d\x65\156\x74\x5f\x65\x6e\141\x62\154\x65\x5f\164\x79\160\x65");
        $this->_byPassLogin = get_mo_option("\167\160\x63\157\x6d\x6d\145\156\164\137\x65\156\141\x62\x6c\145\x5f\146\x6f\x72\x5f\x6c\157\147\147\x65\x64\151\x6e\x5f\165\x73\x65\x72\163");
        if (!$this->_byPassLogin) {
            goto NZ9;
        }
        add_filter("\143\x6f\155\155\145\156\x74\137\x66\157\162\x6d\x5f\x64\x65\x66\141\165\x6c\164\137\146\151\145\154\144\x73", array($this, "\137\x61\x64\144\137\x63\165\x73\164\x6f\155\x5f\146\151\x65\x6c\x64\x73"), 99, 1);
        goto uNw;
        NZ9:
        add_action("\x63\x6f\155\155\x65\x6e\164\137\146\x6f\x72\x6d\137\154\157\147\147\x65\144\137\x69\x6e\137\x61\146\x74\x65\162", array($this, "\x5f\141\x64\x64\x5f\163\x63\x72\151\x70\164\x73\137\141\156\144\137\x61\x64\x64\x69\164\151\157\x6e\141\x6c\137\146\151\x65\154\144\x73"), 1);
        add_action("\x63\157\x6d\x6d\145\x6e\164\137\146\x6f\162\155\137\x61\146\x74\145\x72\x5f\146\151\145\154\x64\163", array($this, "\137\x61\x64\x64\x5f\x73\x63\x72\x69\160\164\x73\137\x61\156\x64\x5f\141\144\144\151\164\x69\x6f\156\x61\x6c\137\146\151\x65\154\x64\163"), 1);
        uNw:
        add_filter("\160\x72\145\160\162\x6f\143\145\x73\x73\x5f\x63\x6f\155\155\145\156\x74", array($this, "\166\145\x72\x69\146\x79\137\x63\x6f\x6d\x6d\145\156\164\x5f\x6d\145\x74\x61\x5f\x64\141\164\141"), 1, 1);
        add_action("\x63\x6f\x6d\x6d\145\156\x74\x5f\x70\x6f\x73\164", array($this, "\x73\141\166\145\x5f\143\x6f\155\155\x65\x6e\164\x5f\x6d\x65\x74\141\137\144\141\164\x61"), 1, 1);
        add_action("\x61\144\144\137\x6d\145\164\x61\137\142\x6f\x78\x65\x73\x5f\x63\157\155\155\x65\x6e\164", array($this, "\145\170\164\x65\156\144\x5f\143\157\x6d\x6d\145\x6e\x74\137\x61\x64\144\x5f\155\x65\x74\141\137\142\157\170"), 1, 1);
        add_action("\x65\x64\x69\164\137\x63\x6f\155\155\145\156\x74", array($this, "\145\x78\x74\145\x6e\x64\137\143\x6f\x6d\x6d\145\x6e\164\137\145\x64\x69\164\137\x6d\145\x74\141\146\151\145\x6c\144\163"), 1, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\x74\x69\157\x6e", $_GET)) {
            goto G18;
        }
        return;
        G18:
        switch (trim($_GET["\157\160\164\151\157\x6e"])) {
            case "\x6d\x6f\x2d\x63\x6f\x6d\155\145\x6e\164\163\55\166\x65\162\x69\x66\171":
                $this->_startOTPVerificationProcess($_POST);
                goto ZCh;
        }
        LeF:
        ZCh:
    }
    function _startOTPVerificationProcess($Un)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && MoUtility::sanitizeCheck("\165\x73\x65\x72\x5f\x65\x6d\x61\x69\x6c", $Un)) {
            goto csL;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && MoUtility::sanitizeCheck("\x75\x73\x65\x72\x5f\x70\x68\157\x6e\145", $Un)) {
            goto k3L;
        }
        $bC = strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? MoMessages::showMessage(MoMessages::ENTER_PHONE) : MoMessages::showMessage(MoMessages::ENTER_EMAIL);
        wp_send_json(MoUtility::createJson($bC, MoConstants::ERROR_JSON_TYPE));
        goto lnU;
        k3L:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim(sanitize_text_field($Un["\165\x73\x65\162\x5f\160\x68\x6f\156\145"])));
        $this->sendChallenge('', '', null, trim(sanitize_text_field($Un["\165\x73\145\162\137\x70\150\157\156\145"])), VerificationType::PHONE);
        lnU:
        goto XU7;
        csL:
        SessionUtils::addEmailVerified($this->_formSessionVar, sanitize_email($Un["\165\x73\145\162\x5f\145\x6d\141\151\154"]));
        $this->sendChallenge('', sanitize_email($Un["\x75\163\145\162\x5f\145\155\141\x69\154"]), null, sanitize_email($Un["\165\x73\145\x72\x5f\x65\155\141\151\154"]), VerificationType::EMAIL);
        XU7:
    }
    function extend_comment_edit_metafields($L2)
    {
        if (!(!isset($_POST["\145\x78\x74\x65\x6e\x64\137\x63\x6f\155\x6d\145\x6e\164\x5f\165\160\144\141\x74\x65"]) || !wp_verify_nonce($_POST["\x65\170\164\145\x6e\x64\x5f\x63\157\x6d\x6d\x65\x6e\164\137\165\x70\x64\x61\x74\145"], "\145\x78\164\x65\x6e\x64\x5f\x63\157\155\155\145\x6e\x74\137\165\160\144\x61\x74\145"))) {
            goto WsW;
        }
        return;
        WsW:
        if (isset($_POST["\160\x68\157\x6e\145"]) && sanitize_text_field($_POST["\x70\150\x6f\x6e\145"]) != '') {
            goto sMB;
        }
        delete_comment_meta($L2, "\x70\x68\157\x6e\x65");
        goto pqO;
        sMB:
        $Dk = sanitize_text_field($_POST["\160\x68\157\x6e\x65"]);
        $Dk = wp_filter_nohtml_kses($Dk);
        update_comment_meta($L2, "\160\150\157\x6e\x65", $Dk);
        pqO:
    }
    function extend_comment_add_meta_box()
    {
        add_meta_box("\164\x69\x74\x6c\x65", mo_("\105\170\164\162\141\40\106\151\x65\154\x64\163"), array($this, "\145\x78\x74\145\156\x64\137\x63\x6f\x6d\155\145\x6e\x74\x5f\155\x65\x74\141\137\142\x6f\170"), "\x63\x6f\x6d\155\145\156\164", "\156\x6f\x72\x6d\x61\154", "\x68\151\x67\150");
    }
    function extend_comment_meta_box($Y6)
    {
        $Dk = get_comment_meta($Y6->comment_ID, "\x70\x68\x6f\156\145", true);
        wp_nonce_field("\x65\x78\x74\145\156\144\x5f\143\157\155\155\x65\x6e\164\x5f\x75\x70\x64\141\x74\x65", "\x65\x78\164\x65\x6e\x64\x5f\x63\157\x6d\x6d\145\156\164\137\x75\x70\x64\141\164\145", false);
        echo "\x3c\164\x61\x62\x6c\x65\x20\143\154\x61\163\163\75\x22\146\157\x72\155\x2d\164\141\142\154\x65\40\145\x64\151\x74\x63\x6f\x6d\155\x65\156\x74\42\76\xd\xa\40\40\x20\x20\x20\40\40\40\x20\x20\x20\x20\x20\x20\40\x20\74\x74\x62\157\144\171\76\xd\12\x20\x20\40\x20\x20\40\x20\40\x20\x20\x20\x20\x20\x20\40\x20\74\x74\162\x3e\15\12\40\40\x20\x20\40\40\40\40\x20\x20\x20\40\x20\40\x20\x20\40\40\x20\x20\74\164\144\x20\x63\x6c\x61\163\x73\x3d\x22\x66\x69\162\x73\x74\x22\76\74\154\141\142\x65\x6c\x20\146\157\162\x3d\x22\x70\x68\x6f\156\x65\42\76" . mo_("\x50\150\x6f\x6e\145") . "\x3a\x3c\x2f\154\x61\142\145\154\76\x3c\57\164\144\x3e\xd\12\40\x20\40\x20\x20\40\40\x20\40\40\x20\x20\x20\40\40\x20\40\40\40\40\x3c\x74\x64\76\74\151\156\x70\165\164\40\164\171\160\145\x3d\x22\x74\145\170\x74\x22\40\x6e\141\x6d\x65\x3d\x22\160\x68\157\156\145\x22\40\x73\x69\x7a\x65\75\x22\x33\x30\x22\x20\166\141\154\165\145\75\x22" . esc_attr($Dk) . "\42\x20\x69\144\75\42\160\150\157\x6e\145\x22\76\74\57\164\144\x3e\xd\xa\40\x20\x20\x20\x20\x20\x20\x20\x20\40\40\40\x20\40\40\x20\74\x2f\164\162\76\15\12\x20\x20\x20\40\40\40\x20\x20\x20\x20\40\40\40\40\40\x20\74\x2f\x74\142\x6f\144\171\x3e\15\12\40\x20\x20\x20\x20\x20\x20\x20\x20\40\40\40\x3c\x2f\164\x61\x62\x6c\x65\76";
    }
    function verify_comment_meta_data($cq)
    {
        if (!($this->_byPassLogin && is_user_logged_in())) {
            goto NkM;
        }
        return $cq;
        NkM:
        if (!(!isset($_POST["\x70\150\x6f\x6e\x65"]) && strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto Uri;
        }
        wp_die(MoMessages::showMessage(MoMessages::WPCOMMNENT_PHONE_ENTER));
        Uri:
        if (isset($_POST["\166\x65\x72\151\146\171\157\x74\160"])) {
            goto z6b;
        }
        wp_die(MoMessages::showMessage(MoMessages::WPCOMMNENT_VERIFY_ENTER));
        z6b:
        $Bs = $this->getVerificationType();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto btm;
        }
        wp_die(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        btm:
        if (!($Bs === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email($_POST["\x65\x6d\141\x69\x6c"])))) {
            goto X7J;
        }
        wp_die(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        X7J:
        if (!($Bs === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($_POST["\x70\x68\x6f\x6e\145"])))) {
            goto XrU;
        }
        wp_die(MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        XrU:
        $this->validateChallenge($Bs, NULL, sanitize_text_field($_POST["\166\x65\162\151\146\171\x6f\x74\160"]));
        return $cq;
    }
    function _add_scripts_and_additional_fields()
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto MCB;
        }
        echo $this->_getFieldHTML("\x65\155\141\x69\154");
        MCB:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto FcG;
        }
        echo $this->_getFieldHTML("\x70\x68\x6f\156\145");
        FcG:
        echo $this->_getFieldHTML("\x76\145\162\x69\x66\171\x6f\164\160");
    }
    function _add_custom_fields($Xw)
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto FwC;
        }
        $Xw["\145\155\141\151\x6c"] = $this->_getFieldHTML("\145\x6d\x61\151\x6c");
        FwC:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto EIE;
        }
        $Xw["\160\x68\x6f\x6e\145"] = $this->_getFieldHTML("\160\x68\157\156\145");
        EIE:
        $Xw["\x76\145\x72\x69\146\171\157\x74\160"] = $this->_getFieldHTML("\166\145\x72\x69\146\x79\157\x74\160");
        return $Xw;
    }
    function _getFieldHTML($TA)
    {
        $X4 = ["\145\155\x61\151\154" => (!is_user_logged_in() && !$this->_byPassLogin ? '' : "\x3c\x70\x20\143\x6c\x61\x73\x73\75\42\143\157\x6d\155\x65\156\164\55\x66\x6f\x72\x6d\x2d\145\155\141\151\154\42\76" . "\74\154\141\142\145\x6c\x20\x66\x6f\x72\75\42\x65\155\x61\x69\154\x22\76" . mo_("\105\x6d\x61\x69\154\x20\x2a") . "\x3c\57\x6c\141\x62\x65\154\x3e" . "\x3c\151\156\160\x75\x74\x20\x69\144\x3d\42\145\x6d\x61\151\x6c\42\40\156\x61\155\145\x3d\x22\x65\x6d\x61\151\x6c\42\x20\164\x79\160\145\x3d\42\164\x65\170\164\42\40\x73\151\x7a\x65\75\x22\x33\x30\42\x20\40\x74\141\x62\x69\156\x64\x65\x78\75\x22\x34\x22\40\x2f\76" . "\x3c\x2f\160\x3e") . $this->get_otp_html_content("\x65\155\141\151\x6c"), "\x70\x68\157\x6e\145" => "\x3c\160\40\143\154\141\163\x73\75\42\143\x6f\155\x6d\x65\156\x74\55\146\157\162\x6d\x2d\145\x6d\x61\151\x6c\x22\76" . "\x3c\x6c\141\x62\x65\154\x20\x66\x6f\x72\x3d\42\x70\x68\157\156\145\x22\76" . mo_("\120\x68\157\156\145\x20\52") . "\x3c\57\154\x61\142\145\154\x3e" . "\74\x69\x6e\x70\165\x74\40\x69\144\75\x22\x70\150\x6f\x6e\145\x22\40\156\x61\155\x65\75\42\160\x68\157\x6e\145\42\x20\x74\x79\160\x65\x3d\42\164\145\170\164\42\x20\x73\x69\x7a\x65\x3d\42\x33\60\42\40\40\x74\x61\142\x69\x6e\x64\x65\x78\x3d\x22\64\42\x20\x2f\76" . "\74\x2f\x70\x3e" . $this->get_otp_html_content("\x70\150\x6f\156\x65"), "\166\x65\x72\x69\x66\171\x6f\164\160" => "\74\160\40\x63\x6c\141\x73\163\x3d\x22\143\157\155\x6d\x65\156\x74\x2d\146\x6f\x72\155\x2d\x65\x6d\141\151\x6c\42\76" . "\74\x6c\141\142\x65\x6c\x20\x66\x6f\x72\75\42\166\145\x72\151\x66\171\157\x74\x70\x22\76" . mo_("\126\x65\x72\x69\146\151\x63\x61\x74\151\x6f\x6e\40\103\x6f\x64\145") . "\74\57\154\x61\142\x65\154\76" . "\x3c\x69\156\160\x75\164\40\x69\x64\75\x22\166\145\162\x69\146\x79\x6f\x74\x70\42\x20\156\141\x6d\x65\x3d\x22\x76\x65\x72\151\x66\x79\x6f\164\x70\x22\40\164\171\160\145\x3d\42\164\x65\170\164\x22\x20\x73\x69\x7a\x65\75\42\63\60\x22\x20\x20\164\141\x62\151\156\x64\145\x78\x3d\x22\x34\42\40\57\76" . "\x3c\x2f\x70\76\74\x62\162\76"];
        return $X4[$TA];
    }
    function get_otp_html_content($j0)
    {
        $Ev = "\74\144\x69\x76\40\163\x74\171\154\145\75\47\144\x69\x73\x70\x6c\x61\x79\72\164\141\x62\154\145\73\164\x65\170\x74\55\x61\154\151\147\x6e\x3a\x63\x65\x6e\164\145\x72\73\x27\x3e\74\151\x6d\147\x20\x73\162\x63\75\47" . MOV_URL . "\151\x6e\143\x6c\165\x64\x65\x73\57\x69\155\x61\147\x65\x73\x2f\154\157\141\144\145\162\56\x67\x69\x66\47\76\74\57\x64\x69\166\x3e";
        $Ua = "\74\x64\x69\x76\40\x73\164\x79\154\145\75\42\155\141\162\147\151\x6e\x2d\142\157\x74\x74\157\155\x3a\63\x25\42\x3e\x3c\x69\x6e\x70\x75\x74\x20\164\x79\160\145\x3d\x22\142\x75\164\x74\157\x6e\x22\x20\143\154\x61\163\x73\x3d\42\x62\165\x74\x74\157\156\40\141\x6c\164\42\40\163\x74\171\154\145\75\x22\167\x69\x64\164\150\72\x31\60\60\45\x22\x20\x69\144\75\42\155\x69\156\151\x6f\x72\141\x6e\147\x65\137\157\164\160\x5f\164\157\153\x65\156\137\163\x75\x62\x6d\x69\164\x22";
        $Ua .= strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\164\151\164\x6c\x65\75\42\120\x6c\x65\x61\x73\145\40\105\156\164\145\x72\40\141\40\x70\x68\157\x6e\145\40\x6e\165\155\142\145\162\40\x74\157\40\145\156\141\x62\x6c\145\40\164\150\x69\x73\x2e\42\x20" : "\x74\151\164\154\145\75\x22\120\154\145\141\x73\145\40\105\x6e\164\145\162\40\141\x20\145\155\x61\151\154\x20\156\x75\155\x62\x65\x72\x20\164\157\x20\x65\156\x61\x62\x6c\x65\40\x74\150\x69\x73\x2e\x22\x20";
        $Ua .= strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\x76\141\154\x75\x65\x3d\42\x43\x6c\x69\x63\x6b\x20\x68\x65\x72\x65\x20\x74\x6f\x20\x76\x65\162\151\x66\x79\x20\171\157\165\x72\x20\120\x68\x6f\x6e\145\42\76" : "\166\x61\x6c\x75\145\x3d\x22\103\154\x69\x63\153\x20\x68\x65\162\145\40\164\x6f\40\x76\x65\x72\151\x66\171\40\x79\x6f\x75\x72\40\105\x6d\141\x69\x6c\x22\76";
        $Ua .= "\x3c\x64\151\x76\x20\x69\x64\x3d\42\155\x6f\137\x6d\145\163\x73\x61\x67\145\42\x20\150\151\x64\x64\145\x6e\x3d\x22\42\x20\x73\164\171\x6c\145\75\42\x62\141\143\153\x67\162\x6f\x75\156\x64\x2d\143\157\x6c\157\162\72\x20\43\146\67\x66\66\146\67\x3b\160\141\x64\x64\x69\156\x67\x3a\x20\x31\145\x6d\40\x32\145\155\40\x31\145\x6d\40\63\56\x35\x65\x6d\x3b\x22\x3e\74\57\144\151\x76\x3e\74\x2f\x64\x69\166\76";
        $Ua .= "\x3c\163\143\162\151\x70\x74\76\x6a\x51\x75\x65\162\x79\50\x64\x6f\x63\x75\x6d\x65\156\x74\x29\x2e\162\145\141\x64\171\x28\x66\165\x6e\143\x74\x69\x6f\x6e\x28\51\x7b\44\155\x6f\x3d\152\x51\x75\145\x72\171\x3b\x24\x6d\x6f\x28\42\x23\x6d\151\x6e\x69\157\162\x61\156\147\x65\137\157\x74\x70\137\x74\157\153\x65\x6e\137\163\165\142\155\x69\x74\42\51\x2e\143\x6c\x69\143\153\x28\146\165\x6e\x63\x74\x69\x6f\156\x28\x6f\51\x7b";
        $Ua .= "\x76\x61\162\40\145\x3d\44\x6d\x6f\50\x22\151\156\160\x75\x74\133\156\x61\x6d\145\x3d" . $j0 . "\x5d\42\51\x2e\166\141\154\x28\x29\x3b\40\x24\x6d\157\x28\x22\43\x6d\x6f\137\x6d\x65\x73\x73\141\x67\145\x22\51\56\x65\x6d\160\x74\171\50\51\x2c\44\x6d\x6f\x28\42\x23\x6d\157\137\x6d\x65\163\163\x61\x67\145\x22\x29\56\141\160\x70\145\x6e\x64\x28\x22" . $Ev . "\42\51\54";
        $Ua .= "\x24\155\x6f\x28\x22\43\155\157\x5f\155\x65\x73\163\141\x67\x65\x22\51\x2e\x73\150\157\167\x28\x29\x2c\x24\x6d\157\x2e\x61\x6a\x61\x78\x28\173\165\x72\x6c\72\42" . site_url() . "\x2f\77\157\160\x74\x69\x6f\156\75\x6d\157\55\x63\157\x6d\155\x65\x6e\x74\163\55\x76\x65\162\x69\146\x79\x22\x2c\164\x79\160\145\x3a\x22\120\117\x53\x54\42\54";
        $Ua .= "\144\x61\x74\141\72\173\165\x73\x65\162\x5f\x70\x68\157\156\145\x3a\x65\x2c\165\x73\x65\162\x5f\145\155\x61\x69\154\72\145\175\x2c\143\162\157\163\163\x44\x6f\155\141\151\156\72\x21\60\x2c\x64\141\164\141\x54\x79\160\x65\72\x22\152\x73\x6f\156\x22\x2c\163\x75\143\143\145\x73\x73\x3a\146\165\x6e\x63\x74\151\157\x6e\x28\157\x29\173\x20\x69\146\x28\157\56\x72\x65\163\x75\154\164\75\x3d\x3d\42\163\165\x63\x63\x65\163\x73\x22\51\x7b";
        $Ua .= "\x24\x6d\157\50\42\43\x6d\x6f\137\x6d\x65\x73\x73\141\147\145\42\x29\x2e\145\155\x70\164\171\x28\51\54\x24\x6d\x6f\x28\42\x23\x6d\157\x5f\x6d\x65\163\x73\141\147\x65\x22\x29\56\x61\160\160\x65\156\144\50\157\56\155\x65\163\163\x61\x67\145\x29\x2c\44\155\157\50\x22\x23\155\x6f\x5f\x6d\145\x73\x73\141\x67\x65\42\51\56\143\x73\163\50\42\x62\157\162\144\x65\x72\x2d\164\x6f\160\x22\x2c\42\63\x70\170\x20\x73\157\154\151\x64\x20\x67\x72\145\x65\x6e\x22\x29\54";
        $Ua .= "\44\x6d\x6f\50\x22\151\156\160\165\164\x5b\x6e\x61\155\x65\x3d\145\x6d\x61\x69\154\x5f\166\145\x72\151\x66\171\135\x22\51\56\146\157\143\165\x73\x28\x29\x7d\145\x6c\x73\145\173\44\x6d\x6f\x28\42\x23\x6d\157\137\155\145\x73\x73\141\x67\x65\x22\51\56\x65\155\x70\x74\171\x28\x29\x2c\44\155\157\x28\42\x23\155\157\x5f\x6d\x65\x73\163\141\x67\x65\x22\x29\56\x61\160\160\x65\156\x64\50\157\x2e\x6d\x65\x73\x73\x61\147\145\x29\54";
        $Ua .= "\x24\x6d\157\x28\x22\x23\155\x6f\137\155\x65\163\163\141\147\x65\x22\51\56\x63\x73\163\x28\x22\142\x6f\162\x64\145\x72\x2d\x74\x6f\160\x22\54\x22\63\x70\170\x20\163\157\x6c\151\x64\40\162\x65\144\x22\x29\x2c\44\x6d\157\50\x22\x69\x6e\160\165\164\x5b\x6e\x61\x6d\145\75\160\150\x6f\x6e\x65\137\x76\x65\x72\x69\x66\x79\x5d\42\x29\56\x66\157\x63\x75\x73\x28\x29\175\x20\x3b\x7d\54";
        $Ua .= "\x65\x72\x72\x6f\x72\x3a\146\165\156\x63\x74\151\157\156\50\157\x2c\145\x2c\156\x29\x7b\x7d\175\x29\x7d\x29\x3b\x7d\51\73\x3c\57\x73\143\x72\x69\x70\x74\76";
        return $Ua;
    }
    function save_comment_meta_data($L2)
    {
        if (!(isset($_POST["\x70\x68\x6f\x6e\x65"]) && sanitize_text_field($_POST["\x70\150\x6f\x6e\x65"]) != '')) {
            goto PLi;
        }
        $Dk = sanitize_text_field($_POST["\160\x68\157\156\x65"]);
        $Dk = wp_filter_nohtml_kses($Dk);
        add_comment_meta($L2, "\x70\x68\157\x6e\x65", $Dk);
        PLi:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        wp_die(MoUtility::_get_invalid_otp_method());
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        $this->unsetOTPSessionVariables();
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto rhl;
        }
        array_push($kp, $this->_phoneFormId);
        rhl:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto X30;
        }
        return;
        X30:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x70\143\x6f\x6d\155\x65\x6e\164\x5f\x65\x6e\x61\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x77\160\x63\157\155\155\145\156\x74\137\x65\156\141\142\x6c\x65\137\164\171\160\x65");
        $this->_byPassLogin = $this->sanitizeFormPOST("\x77\160\x63\157\x6d\155\x65\156\x74\x5f\145\x6e\141\x62\x6c\145\137\x66\157\x72\x5f\x6c\157\x67\147\x65\144\151\x6e\x5f\165\163\x65\x72\163");
        update_mo_option("\167\x70\x63\x6f\x6d\x6d\x65\x6e\x74\137\145\156\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x77\160\x63\x6f\x6d\155\145\156\164\137\145\x6e\x61\142\x6c\x65\x5f\x74\171\160\x65", $this->_otpType);
        update_mo_option("\x77\160\143\157\x6d\x6d\x65\x6e\164\137\145\156\x61\142\154\145\x5f\x66\x6f\x72\x5f\x6c\157\x67\147\x65\144\151\156\137\x75\x73\145\162\163", $this->_byPassLogin);
    }
}
