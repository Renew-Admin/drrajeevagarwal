<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoException;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class WooCommerceRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_redirectToPage;
    private $_redirect_after_registration;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_DEFAULT_REG;
        $this->_typePhoneTag = "\x6d\x6f\137\x77\x63\x5f\160\150\157\156\x65\137\145\x6e\141\142\x6c\x65";
        $this->_typeEmailTag = "\x6d\x6f\x5f\167\143\x5f\x65\x6d\141\151\x6c\137\x65\x6e\x61\142\x6c\145";
        $this->_typeBothTag = "\155\x6f\x5f\x77\x63\137\142\x6f\164\150\137\x65\156\x61\142\154\145";
        $this->_phoneFormId = "\x23\162\145\147\137\142\x69\x6c\x6c\151\x6e\x67\137\x70\150\x6f\156\x65";
        $this->_formKey = "\x57\x43\137\x52\105\107\x5f\x46\117\122\115";
        $this->_formName = mo_("\127\157\x6f\143\157\155\x6d\x65\x72\x63\145\x20\122\x65\x67\x69\x73\164\x72\141\164\151\x6f\156\40\x46\157\162\x6d");
        $this->_isFormEnabled = get_mo_option("\x77\143\x5f\x64\145\x66\141\165\x6c\164\137\x65\x6e\x61\142\x6c\x65");
        $this->_buttonText = get_mo_option("\167\143\137\x62\x75\x74\x74\x6f\156\x5f\164\145\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\154\x69\x63\153\40\110\145\x72\145\40\x74\157\x20\163\145\x6e\x64\40\117\x54\120");
        $this->_formDocuments = MoOTPDocs::WC_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_isAjaxForm = get_mo_option("\x77\143\137\151\x73\x5f\x61\x6a\x61\170\x5f\x66\157\x72\x6d");
        $this->_otpType = get_mo_option("\167\x63\137\x65\x6e\141\142\x6c\x65\137\164\171\x70\145");
        $this->_redirectToPage = get_mo_option("\167\143\137\x72\145\144\x69\x72\145\x63\164");
        $this->_redirect_after_registration = get_mo_option("\167\143\x72\x65\x67\137\x72\145\x64\x69\x72\x65\143\164\137\x61\x66\164\x65\x72\137\x72\x65\147\x69\163\x74\x72\141\164\151\157\156");
        $this->_restrictDuplicates = get_mo_option("\167\x63\x5f\162\x65\163\164\x72\x69\x63\164\137\x64\165\x70\x6c\x69\143\141\164\x65\163");
        add_filter("\x77\157\x6f\x63\157\x6d\155\x65\x72\x63\145\137\160\x72\157\x63\x65\x73\163\x5f\x72\x65\147\x69\x73\164\162\x61\164\151\x6f\156\137\x65\x72\162\x6f\x72\x73", array($this, "\167\157\157\x63\157\155\x6d\x65\162\143\x65\x5f\x73\x69\x74\x65\137\162\x65\x67\151\x73\x74\162\141\164\151\157\156\x5f\145\x72\x72\x6f\162\163"), 99, 4);
        add_action("\167\x6f\x6f\x63\157\x6d\x6d\x65\x72\143\145\137\143\x72\145\141\164\x65\x64\x5f\143\x75\163\x74\157\155\145\162", array($this, "\162\x65\147\x69\x73\164\x65\162\137\x77\157\x6f\143\157\155\x6d\x65\x72\143\145\x5f\165\x73\145\x72"), 1, 3);
        add_filter("\x77\157\157\143\157\155\x6d\x65\x72\143\145\137\x72\x65\x67\151\x73\164\162\x61\164\x69\157\156\137\162\x65\144\x69\162\145\x63\164", array($this, "\x63\165\163\164\157\155\x5f\x72\x65\147\x69\163\164\162\x61\x74\151\x6f\x6e\137\x72\x65\x64\151\162\x65\x63\164"), 99, 1);
        if (!$this->isPhoneVerificationEnabled()) {
            goto sW;
        }
        add_action("\x77\157\x6f\143\x6f\x6d\155\x65\x72\143\145\137\162\x65\147\x69\163\164\x65\162\x5f\146\x6f\162\155", array($this, "\155\157\x5f\141\144\144\x5f\160\150\x6f\x6e\145\137\146\151\145\154\144"), 1);
        add_action("\x77\143\155\x70\137\x76\x65\156\x64\157\162\137\x72\145\x67\x69\163\x74\x65\162\x5f\x66\157\162\x6d", array($this, "\155\x6f\x5f\141\144\144\137\160\x68\157\156\x65\137\146\x69\x65\154\x64"), 1);
        sW:
        if (!($this->_isAjaxForm && $this->_otpType != $this->_typeBothTag)) {
            goto xg;
        }
        add_action("\x77\x6f\157\143\157\155\x6d\x65\x72\x63\145\x5f\x72\145\x67\151\x73\164\145\x72\137\x66\157\x72\155", array($this, "\155\x6f\x5f\141\x64\144\137\166\x65\162\x69\x66\151\x63\x61\164\x69\157\x6e\137\x66\x69\145\154\x64"), 1);
        add_action("\x77\143\x6d\160\x5f\166\x65\156\x64\x6f\162\137\162\145\147\x69\x73\164\145\162\x5f\x66\157\162\155", array($this, "\155\157\x5f\141\144\x64\x5f\166\145\162\x69\x66\x69\143\x61\x74\151\157\156\137\146\x69\x65\x6c\144"), 1);
        add_action("\x77\x70\137\x65\x6e\161\x75\x65\165\145\137\x73\143\x72\151\x70\164\163", array($this, "\x6d\x69\156\x69\x6f\x72\x61\156\147\x65\137\162\x65\x67\151\x73\x74\x65\x72\x5f\167\x63\x5f\x73\x63\162\x69\160\x74"));
        $this->routeData();
        xg:
    }
    private function routeData()
    {
        if (array_key_exists("\x6f\x70\164\151\x6f\156", $_GET)) {
            goto KV;
        }
        return;
        KV:
        switch (trim($_GET["\x6f\160\x74\x69\x6f\156"])) {
            case "\155\x69\x6e\151\x6f\x72\x61\x6e\147\145\55\167\143\x2d\x72\145\x67\x2d\x76\145\x72\151\x66\171":
                $this->sendAjaxOTPRequest();
                goto nQ;
        }
        vT:
        nQ:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $wI = MoUtility::sanitizeCheck("\165\x73\145\x72\x5f\160\150\157\x6e\145", $_POST);
        $p1 = MoUtility::sanitizeCheck("\x75\x73\145\162\137\x65\155\141\151\x6c", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto cb;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $p1);
        goto bq;
        cb:
        SessionUtils::addPhoneVerified($this->_formSessionVar, MoUtility::processPhoneNumber($wI));
        bq:
        $uV = $this->processFormFields(null, $p1, new WP_Error(), null, $wI);
        if (!$uV->get_error_code()) {
            goto PQ;
        }
        wp_send_json(MoUtility::createJson($uV->get_error_message(), MoConstants::ERROR_JSON_TYPE));
        PQ:
    }
    function miniorange_register_wc_script()
    {
        wp_register_script("\x6d\x6f\x77\143\162\x65\147", MOV_URL . "\151\x6e\x63\x6c\x75\x64\x65\163\x2f\x6a\x73\x2f\167\x63\x72\145\x67\x2e\155\x69\156\x2e\152\x73", array("\x6a\161\165\x65\x72\x79"));
        wp_localize_script("\155\157\167\143\162\145\147", "\x6d\157\167\x63\x72\145\x67", array("\163\151\164\145\125\x52\114" => site_url(), "\x6f\x74\x70\124\x79\160\x65" => $this->_otpType, "\x6e\x6f\x6e\x63\x65" => wp_create_nonce($this->_nonce), "\142\x75\164\164\157\x6e\164\x65\170\x74" => mo_($this->_buttonText), "\146\x69\x65\154\144" => $this->_otpType === $this->_typePhoneTag ? "\162\x65\147\x5f\142\x69\154\x6c\151\x6e\x67\137\160\x68\157\156\x65" : "\x72\x65\147\x5f\145\155\141\x69\154", "\151\x6d\x67\x55\122\x4c" => MOV_LOADER_URL));
        wp_enqueue_script("\155\x6f\x77\x63\x72\145\147");
    }
    function custom_registration_redirect($ob)
    {
        if (!($this->_redirect_after_registration && get_mo_option("\x77\x63\137\x64\x65\x66\141\x75\x6c\164\137\145\x6e\141\142\x6c\145"))) {
            goto aM;
        }
        return get_permalink(get_page_by_title($this->_redirectToPage)->ID);
        aM:
        return $ob;
    }
    function isPhoneVerificationEnabled()
    {
        $Bs = $this->getVerificationType();
        return $Bs === VerificationType::BOTH || $Bs === VerificationType::PHONE;
    }
    function woocommerce_site_registration_errors(WP_Error $errors, $zC, $iK, $mo)
    {
        if (MoUtility::isBlank(array_filter($errors->errors))) {
            goto mn;
        }
        return $errors;
        mn:
        if ($this->_isAjaxForm) {
            goto k6;
        }
        return $this->processFormAndSendOTP($zC, $iK, $mo, $errors);
        goto M2;
        k6:
        $this->assertOTPField($errors, $_POST);
        $this->checkIfOTPWasSent($errors);
        return $this->checkIntegrityAndValidateOTP($_POST, $errors);
        M2:
    }
    private function assertOTPField(&$errors, $OA)
    {
        if (MoUtility::sanitizeCheck("\x6d\x6f\x76\145\162\x69\146\171", $OA)) {
            goto JP;
        }
        $errors = new WP_Error("\x72\145\x67\151\163\164\162\141\164\151\x6f\x6e\55\145\162\x72\157\x72\x2d\157\164\160\x2d\156\x65\145\144\145\144", MoMessages::showMessage(MoMessages::REQUIRED_OTP));
        JP:
    }
    private function checkIfOTPWasSent(&$errors)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Sq;
        }
        $errors = new WP_Error("\x72\145\x67\x69\x73\164\x72\x61\164\x69\x6f\156\x2d\x65\162\x72\157\162\x2d\156\x65\145\x64\x2d\x76\141\154\x69\144\141\x74\151\x6f\x6e", MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        Sq:
    }
    private function checkIntegrityAndValidateOTP($FA, WP_Error $errors)
    {
        if (empty($errors->errors)) {
            goto Qx;
        }
        return $errors;
        Qx:
        if (!isset($FA["\x62\151\154\x6c\151\156\147\x5f\160\150\x6f\156\x65"])) {
            goto ze;
        }
        $FA["\142\x69\x6c\154\x69\156\x67\x5f\160\150\157\x6e\x65"] = MoUtility::processPhoneNumber($FA["\142\x69\154\x6c\151\156\147\x5f\160\x68\x6f\156\145"]);
        ze:
        $errors = $this->checkIntegrity($FA, $errors);
        if (empty($errors->errors)) {
            goto P_;
        }
        return $errors;
        P_:
        $Bs = $this->getVerificationType();
        $this->validateChallenge($Bs, NULL, sanitize_text_field($FA["\x6d\157\166\145\x72\151\146\x79"]));
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs)) {
            goto yp;
        }
        return new WP_Error("\x72\145\x67\x69\x73\164\x72\x61\x74\x69\x6f\x6e\55\x65\162\x72\x6f\162\x2d\151\156\x76\141\154\x69\x64\x2d\157\x74\160", MoUtility::_get_invalid_otp_method());
        goto iA;
        yp:
        $this->unsetOTPSessionVariables();
        iA:
        return $errors;
    }
    private function checkIntegrity($FA, WP_Error $errors)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto rIl;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto yDW;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, sanitize_email($FA["\x65\x6d\141\x69\x6c"]))) {
            goto KPG;
        }
        return new WP_Error("\x72\x65\147\x69\x73\x74\162\141\x74\151\x6f\156\x2d\x65\162\x72\157\162\55\151\x6e\166\141\154\151\x64\x2d\145\x6d\141\151\x6c", MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        KPG:
        yDW:
        goto Gx1;
        rIl:
        if (Sessionutils::isPhoneVerifiedMatch($this->_formSessionVar, sanitize_text_field($FA["\x62\151\x6c\x6c\x69\156\147\x5f\160\x68\x6f\x6e\145"]))) {
            goto pf;
        }
        return new WP_Error("\x62\151\x6c\x6c\x69\156\147\137\x70\150\x6f\156\145\137\145\x72\162\x6f\x72", MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        pf:
        Gx1:
        return $errors;
    }
    private function processFormAndSendOTP($zC, $iK, $mo, WP_Error $errors)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto C40;
        }
        $this->unsetOTPSessionVariables();
        return $errors;
        C40:
        $ZD = isset($_POST["\142\151\x6c\x6c\x69\156\x67\137\160\150\157\156\x65"]) ? sanitize_text_field($_POST["\142\151\x6c\154\x69\x6e\x67\x5f\x70\150\x6f\156\x65"]) : '';
        MoUtility::initialize_transaction($this->_formSessionVar);
        try {
            $this->assertUserName($zC);
            $this->assertPassword($iK);
            $this->assertEmail($mo);
        } catch (MoException $Xn) {
            return new WP_Error($Xn->getMoCode(), $Xn->getMessage());
        }
        do_action("\x77\157\157\x63\157\155\x6d\x65\162\143\145\137\162\x65\147\151\x73\164\x65\162\x5f\x70\157\x73\x74", $zC, $mo, $errors);
        return $errors->get_error_code() ? $errors : $this->processFormFields($zC, $mo, $errors, $iK, $ZD);
    }
    private function assertPassword($iK)
    {
        if (!(get_mo_option("\167\x6f\x6f\x63\157\155\155\x65\162\x63\x65\x5f\x72\x65\x67\x69\x73\164\162\141\x74\151\157\x6e\137\x67\x65\x6e\x65\162\141\x74\145\x5f\x70\x61\163\x73\167\157\x72\144", '') === "\156\157")) {
            goto OHp;
        }
        if (!MoUtility::isBlank($iK)) {
            goto wav;
        }
        throw new MoException("\x72\x65\x67\151\163\164\162\x61\x74\151\x6f\x6e\55\145\x72\x72\x6f\162\x2d\x69\x6e\166\141\x6c\151\144\55\160\x61\x73\163\x77\157\x72\x64", mo_("\120\x6c\x65\141\163\x65\x20\x65\x6e\164\145\x72\40\x61\x20\166\x61\x6c\x69\x64\40\141\x63\143\x6f\165\156\164\x20\x70\x61\163\163\x77\x6f\162\144\x2e"), 204);
        wav:
        OHp:
    }
    private function assertEmail($mo)
    {
        if (!(MoUtility::isBlank($mo) || !is_email($mo))) {
            goto zjv;
        }
        throw new MoException("\162\145\x67\151\163\x74\162\x61\164\151\157\x6e\x2d\x65\x72\x72\x6f\162\55\x69\156\x76\x61\x6c\151\x64\55\145\155\141\151\x6c", mo_("\120\154\x65\x61\x73\x65\40\x65\156\x74\x65\x72\40\141\x20\166\x61\x6c\x69\144\40\x65\x6d\x61\x69\154\40\x61\x64\x64\162\x65\163\x73\x2e"), 202);
        zjv:
        if (!email_exists($mo)) {
            goto e7q;
        }
        throw new MoException("\x72\x65\x67\x69\163\164\162\x61\x74\151\157\156\x2d\x65\162\162\157\162\x2d\145\155\141\151\x6c\55\145\x78\151\163\x74\163", mo_("\101\156\40\141\143\143\x6f\x75\x6e\x74\x20\151\163\x20\141\154\x72\x65\141\144\x79\40\162\145\x67\151\163\x74\145\x72\x65\x64\x20\167\x69\164\x68\40\171\x6f\165\x72\x20\x65\x6d\141\151\x6c\x20\x61\144\144\162\x65\x73\x73\x2e\40\x50\x6c\x65\141\x73\x65\x20\x6c\x6f\x67\x69\x6e\56"), 203);
        e7q:
    }
    private function assertUserName($zC)
    {
        if (!(get_mo_option("\x77\157\x6f\143\x6f\x6d\155\145\x72\143\x65\137\162\x65\x67\151\163\x74\162\141\164\151\157\x6e\137\x67\x65\156\145\162\141\x74\145\137\x75\x73\x65\x72\156\141\x6d\145", '') === "\156\157")) {
            goto ghZ;
        }
        if (!(MoUtility::isBlank($zC) || !validate_username($zC))) {
            goto CMT;
        }
        throw new MoException("\x72\x65\147\151\163\164\x72\x61\x74\151\x6f\x6e\x2d\x65\x72\x72\157\x72\x2d\151\x6e\166\141\x6c\x69\x64\x2d\165\x73\145\162\x6e\x61\155\145", mo_("\x50\154\145\x61\x73\x65\40\x65\156\x74\x65\x72\40\141\x20\x76\141\x6c\151\x64\x20\141\143\143\x6f\x75\x6e\164\x20\x75\x73\x65\x72\x6e\x61\155\x65\56"), 200);
        CMT:
        if (!username_exists($zC)) {
            goto hJQ;
        }
        throw new MoException("\162\x65\147\x69\x73\x74\x72\141\164\151\157\156\x2d\x65\x72\162\157\x72\55\165\x73\x65\x72\156\141\x6d\145\55\145\x78\x69\x73\164\163", mo_("\x41\156\x20\141\x63\x63\x6f\165\x6e\164\x20\x69\163\40\141\154\x72\x65\141\x64\171\x20\162\x65\147\151\163\x74\x65\x72\145\144\40\167\x69\x74\x68\40\x74\150\x61\x74\x20\165\x73\145\162\156\141\x6d\145\x2e\40\120\154\145\x61\163\x65\x20\143\150\x6f\x6f\x73\x65\x20\x61\156\x6f\164\150\145\162\56"), 201);
        hJQ:
        ghZ:
    }
    function processFormFields($zC, $mo, $errors, $iK, $Dk)
    {
        global $phoneLogic;
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto Wru;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0) {
            goto mEW;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeBothTag) === 0)) {
            goto SQ6;
        }
        if (!isset($Dk) || !MoUtility::validatePhoneNumber($Dk)) {
            goto Gzx;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($Dk, "\x62\151\154\x6c\x69\156\147\x5f\160\x68\x6f\156\x65")) {
            goto mi9;
        }
        goto z6x;
        Gzx:
        return new WP_Error("\142\151\x6c\x6c\x69\156\x67\x5f\x70\x68\157\x6e\x65\x5f\145\162\x72\x6f\162", str_replace("\43\x23\x70\x68\x6f\156\x65\x23\43", sanitize_text_field($_POST["\142\151\154\154\151\156\147\x5f\160\x68\157\x6e\145"]), $phoneLogic->_get_otp_invalid_format_message()));
        goto z6x;
        mi9:
        return new WP_Error("\x62\151\x6c\x6c\x69\156\147\137\160\x68\157\156\x65\x5f\145\162\x72\157\x72", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        z6x:
        $this->sendChallenge($zC, $mo, $errors, sanitize_text_field($_POST["\142\151\x6c\154\151\156\x67\137\160\x68\157\156\x65"]), VerificationType::BOTH, $iK);
        SQ6:
        goto HJC;
        mEW:
        $Dk = isset($Dk) ? $Dk : '';
        $this->sendChallenge($zC, $mo, $errors, $Dk, VerificationType::EMAIL, $iK);
        HJC:
        goto A1S;
        Wru:
        if (!isset($Dk) || !MoUtility::validatePhoneNumber($Dk)) {
            goto HJj;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($Dk, "\142\x69\x6c\154\x69\x6e\147\x5f\160\150\157\x6e\145")) {
            goto wml;
        }
        goto KdV;
        HJj:
        return new WP_Error("\x62\x69\154\154\151\156\x67\137\160\150\157\156\145\x5f\x65\162\162\157\x72", str_replace("\43\43\x70\x68\157\156\145\43\43", $Dk, $phoneLogic->_get_otp_invalid_format_message()));
        goto KdV;
        wml:
        return new WP_Error("\142\151\x6c\154\151\156\147\137\x70\x68\x6f\x6e\x65\137\145\162\x72\157\x72", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        KdV:
        $this->sendChallenge($zC, $mo, $errors, $Dk, VerificationType::PHONE, $iK);
        A1S:
        return $errors;
    }
    public function register_woocommerce_user($RQ, $S0, $G5)
    {
        if (!isset($_POST["\x62\151\154\x6c\151\156\147\x5f\x70\150\x6f\156\145"])) {
            goto qPT;
        }
        $Dk = MoUtility::sanitizeCheck("\x62\x69\154\154\151\x6e\147\x5f\x70\x68\157\156\145", $_POST);
        update_user_meta($RQ, "\x62\151\x6c\x6c\151\156\147\137\x70\150\x6f\156\x65", MoUtility::processPhoneNumber($Dk));
        qPT:
    }
    function mo_add_phone_field()
    {
        if (!(!did_action("\167\x6f\157\x63\157\x6d\155\x65\x72\x63\145\x5f\162\145\x67\151\x73\x74\145\162\137\146\157\x72\x6d") || !did_action("\x77\x63\x6d\x70\x5f\166\145\156\144\x6f\x72\x5f\x72\145\x67\x69\x73\x74\145\162\x5f\x66\x6f\162\x6d"))) {
            goto QPU;
        }
        echo "\74\x70\40\143\x6c\x61\163\x73\75\42\x66\157\162\155\x2d\x72\157\x77\40\146\157\162\x6d\55\162\x6f\167\x2d\x77\x69\144\145\42\x3e\15\12\x20\40\x20\40\x20\x20\40\x20\x20\x20\x20\40\40\x20\x20\x20\74\154\141\x62\x65\x6c\40\x66\157\x72\75\x22\162\145\x67\137\x62\x69\x6c\154\151\156\x67\137\160\x68\x6f\x6e\145\42\76\15\12\x20\40\x20\x20\40\x20\x20\x20\40\x20\x20\40\x20\x20\x20\40\40\40\x20\40" . mo_("\x50\150\157\156\x65") . "\15\xa\40\40\x20\40\x20\40\x20\x20\x20\x20\40\40\40\40\40\40\40\x20\40\x20\x3c\163\160\141\x6e\40\143\x6c\x61\x73\163\75\42\162\x65\x71\x75\x69\x72\145\144\x22\76\x2a\x3c\57\x73\160\x61\x6e\x3e\xd\xa\40\40\40\x20\x20\x20\40\40\40\x20\40\x20\40\40\x20\40\74\57\x6c\x61\x62\145\x6c\x3e\xd\12\x20\40\40\x20\x20\40\40\x20\40\x20\x20\40\x20\40\x20\40\x3c\x69\x6e\x70\x75\x74\40\x74\x79\160\145\75\42\164\x65\170\164\42\x20\x63\154\x61\x73\x73\75\x22\151\156\160\165\x74\x2d\x74\x65\170\164\x22\40\xd\xa\40\40\40\40\x20\40\40\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\40\40\40\40\40\x20\156\x61\x6d\145\x3d\x22\x62\x69\154\x6c\x69\156\147\x5f\160\x68\x6f\156\145\42\40\x69\x64\75\x22\x72\145\x67\x5f\142\x69\x6c\x6c\x69\156\147\137\160\150\157\x6e\x65\x22\x20\15\12\40\x20\x20\x20\40\x20\40\40\x20\40\x20\x20\40\x20\40\x20\40\x20\x20\40\x20\40\40\40\x76\141\154\165\145\x3d\x22" . (!empty($_POST["\x62\x69\x6c\154\x69\156\x67\x5f\160\150\x6f\156\145"]) ? sanitize_text_field($_POST["\x62\x69\154\154\151\x6e\x67\137\160\x68\x6f\x6e\145"]) : '') . "\x22\x20\x2f\x3e\15\12\x20\40\x20\40\x20\40\x20\x20\x20\x20\40\40\40\x20\x3c\x2f\160\x3e";
        QPU:
    }
    function mo_add_verification_field()
    {
        if (!(!did_action("\167\157\x6f\x63\157\x6d\x6d\145\x72\x63\145\137\x72\145\x67\x69\163\164\145\162\x5f\x66\x6f\162\155") || !did_action("\167\143\x6d\x70\137\x76\145\156\144\157\x72\x5f\162\145\x67\151\163\x74\145\x72\137\146\x6f\x72\155"))) {
            goto Eqh;
        }
        echo "\74\160\x20\x63\154\141\x73\x73\75\42\x66\x6f\x72\155\55\162\x6f\167\40\x66\x6f\162\155\55\162\x6f\167\55\167\x69\x64\145\x22\x3e\15\12\40\40\x20\x20\40\40\40\x20\x20\x20\40\x20\40\40\x20\x20\x3c\154\141\x62\x65\x6c\40\146\157\x72\75\42\x72\x65\147\137\166\x65\x72\151\146\151\143\141\x74\151\157\x6e\x5f\x70\x68\157\156\x65\x22\x3e\15\12\40\40\40\40\40\40\40\x20\40\x20\x20\40\40\x20\x20\x20\40\40\40\x20" . mo_("\x45\156\164\145\x72\40\x43\x6f\144\145") . "\15\12\40\40\x20\40\40\x20\x20\40\40\x20\x20\40\40\40\40\x20\40\x20\40\x20\74\163\x70\141\156\40\143\154\141\x73\x73\75\42\x72\x65\x71\x75\151\x72\145\x64\x22\x3e\x2a\x3c\57\163\160\x61\x6e\76\15\12\40\40\40\x20\x20\40\40\40\40\40\x20\40\40\x20\40\40\74\57\154\x61\142\x65\x6c\76\15\xa\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\40\x20\40\x20\x20\x3c\x69\156\x70\165\x74\x20\164\171\160\x65\75\42\164\x65\x78\x74\x22\x20\143\x6c\x61\163\163\75\42\x69\156\x70\165\164\x2d\164\x65\x78\x74\42\40\x6e\141\x6d\145\75\42\155\157\166\145\162\x69\x66\x79\x22\40\15\12\x20\40\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\40\40\40\x20\x20\x20\40\x20\x20\40\40\40\151\x64\x3d\x22\162\145\x67\x5f\x76\145\162\x69\x66\151\143\141\164\x69\x6f\x6e\x5f\x66\151\145\x6c\x64\x22\x20\15\12\x20\x20\x20\x20\40\x20\x20\x20\x20\40\x20\40\40\x20\40\40\40\x20\x20\40\x20\x20\40\40\166\x61\154\x75\145\75\x22\42\x20\x2f\x3e\15\12\40\40\x20\x20\40\40\40\40\40\40\x20\x20\40\x20\x3c\57\x70\x3e";
        Eqh:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if ($this->_isAjaxForm) {
            goto sp9;
        }
        $Bs = $this->getVerificationType();
        $MZ = $Bs === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
        goto ZXq;
        sp9:
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
        ZXq:
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
            goto XED;
        }
        array_push($kp, $this->_phoneFormId);
        XED:
        return $kp;
    }
    function isPhoneNumberAlreadyInUse($Dk, $j1)
    {
        global $wpdb;
        $Dk = MoUtility::processPhoneNumber($Dk);
        $le = $wpdb->get_row("\123\105\114\x45\x43\x54\40\140\x75\x73\x65\162\137\151\144\140\40\106\122\117\x4d\x20\140{$wpdb->prefix}\165\163\145\x72\x6d\x65\164\141\x60\x20\x57\x48\x45\x52\x45\x20\140\x6d\145\x74\x61\137\153\145\171\x60\40\75\x20\x27{$j1}\47\40\101\116\104\x20\140\x6d\x65\x74\141\x5f\166\141\x6c\165\145\140\40\75\40\40\47{$Dk}\47");
        return !MoUtility::isBlank($le);
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto aEo;
        }
        return;
        aEo:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x63\x5f\144\145\146\141\x75\x6c\x74\x5f\145\x6e\141\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x63\x5f\145\x6e\x61\142\154\x65\x5f\x74\x79\x70\145");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\167\x63\x5f\162\145\x73\x74\x72\151\x63\164\137\x64\x75\160\154\151\143\141\164\145\x73");
        $this->_redirectToPage = isset($_POST["\x70\x61\147\x65\x5f\151\x64"]) ? get_the_title($_POST["\x70\x61\x67\x65\137\x69\x64"]) : "\x4d\171\x20\x41\x63\x63\157\x75\156\x74";
        $this->_isAjaxForm = $this->sanitizeFormPOST("\167\143\x5f\151\163\x5f\141\152\141\x78\137\146\157\x72\x6d");
        $this->_buttonText = $this->sanitizeFormPOST("\x77\143\137\x62\165\164\164\x6f\156\137\164\x65\170\x74");
        $this->_redirect_after_registration = $this->sanitizeFormPOST("\x77\143\x72\x65\x67\137\162\145\x64\x69\162\145\143\164\x5f\x61\x66\164\x65\162\x5f\x72\145\x67\x69\163\164\x72\141\x74\151\157\156");
        update_mo_option("\167\x63\x72\145\147\137\162\145\x64\151\x72\x65\x63\x74\x5f\141\146\x74\145\162\137\x72\x65\x67\x69\x73\164\x72\x61\164\151\157\x6e", $this->_redirect_after_registration);
        update_mo_option("\x77\143\x5f\144\x65\146\141\165\154\x74\x5f\x65\156\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\143\x5f\145\156\x61\142\x6c\145\x5f\x74\x79\x70\x65", $this->_otpType);
        update_mo_option("\x77\143\x5f\x72\145\x73\x74\x72\151\x63\x74\137\x64\165\160\x6c\x69\x63\x61\164\x65\x73", $this->_restrictDuplicates);
        update_mo_option("\167\143\137\162\x65\144\151\162\145\143\x74", $this->_redirectToPage);
        update_mo_option("\x77\143\x5f\151\x73\x5f\141\152\141\170\137\146\157\162\155", $this->_isAjaxForm);
        update_mo_option("\x77\x63\137\142\165\x74\x74\157\x6e\x5f\x74\x65\x78\x74", $this->_buttonText);
    }
    public function redirectToPage()
    {
        return $this->_redirectToPage;
    }
    public function isredirectToPageEnabled()
    {
        return $this->_redirect_after_registration;
    }
}
