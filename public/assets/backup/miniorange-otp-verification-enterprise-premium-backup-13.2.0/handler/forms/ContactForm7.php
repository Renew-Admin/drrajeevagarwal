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
use WPCF7_FormTag;
use WPCF7_Validation;
class ContactForm7 extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::CF7_FORMS;
        $this->_typePhoneTag = "\x6d\x6f\x5f\x63\146\x37\x5f\143\157\156\164\x61\x63\164\137\x70\150\x6f\156\x65\x5f\145\156\x61\142\154\145";
        $this->_typeEmailTag = "\x6d\157\137\x63\146\67\137\x63\157\x6e\x74\x61\x63\164\137\x65\x6d\x61\151\x6c\137\x65\x6e\x61\142\x6c\145";
        $this->_formKey = "\103\x46\x37\x5f\106\117\122\x4d";
        $this->_formName = mo_("\103\x6f\156\164\x61\x63\x74\40\106\157\162\x6d\40\x37\x20\55\x20\103\157\156\x74\141\x63\x74\x20\x46\157\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\143\x66\x37\137\143\x6f\156\x74\141\x63\x74\137\x65\x6e\x61\x62\x6c\x65");
        $this->_generateOTPAction = "\155\x69\x6e\151\x6f\162\141\x6e\x67\145\x2d\143\x66\x37\x2d\143\x6f\156\x74\x61\x63\164";
        $this->_formDocuments = MoOTPDocs::CF7_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\143\146\67\x5f\x63\x6f\x6e\164\141\143\164\x5f\x74\171\160\x65");
        $this->_emailKey = get_mo_option("\143\x66\67\137\x65\x6d\x61\151\154\137\x6b\145\x79");
        $this->_phoneKey = "\x6d\157\x5f\160\x68\157\x6e\145";
        $this->_phoneFormId = ["\56\x63\154\141\x73\x73\x5f" . $this->_phoneKey, "\x69\x6e\x70\x75\x74\133\x6e\141\155\145\75" . $this->_phoneKey . "\135"];
        add_filter("\x77\160\143\146\x37\x5f\166\x61\154\x69\144\141\164\x65\137\x74\x65\x78\x74\52", array($this, "\x76\141\154\151\144\141\x74\x65\x46\157\162\155\120\x6f\163\164"), 1, 2);
        add_filter("\167\x70\143\146\x37\137\166\x61\x6c\x69\x64\x61\x74\145\x5f\145\x6d\141\x69\154\52", array($this, "\166\x61\x6c\151\144\141\164\x65\106\x6f\x72\155\x50\157\x73\164"), 1, 2);
        add_filter("\167\160\143\146\x37\x5f\x76\141\x6c\151\x64\141\x74\x65\137\x65\x6d\x61\x69\154", array($this, "\x76\141\x6c\151\144\141\164\145\106\x6f\x72\x6d\120\157\163\164"), 1, 2);
        add_filter("\x77\160\x63\146\67\x5f\x76\x61\x6c\151\144\x61\164\145\x5f\x74\145\154\x2a", array($this, "\166\x61\154\151\144\141\164\145\106\x6f\162\155\120\x6f\x73\164"), 1, 2);
        add_action("\167\160\x63\146\67\137\x62\x65\146\157\162\x65\x5f\x73\x65\156\x64\137\x6d\x61\x69\x6c", array($this, "\165\156\163\x65\x74\123\145\x73\163\x69\x6f\x6e"), 1, 1);
        add_shortcode("\155\157\137\166\145\162\151\146\171\x5f\145\155\141\151\x6c", array($this, "\137\143\146\67\x5f\x65\x6d\141\151\154\137\x73\x68\157\x72\164\x63\x6f\144\x65"));
        add_shortcode("\x6d\157\137\x76\145\162\151\x66\171\137\x70\150\157\x6e\x65", array($this, "\137\x63\x66\x37\137\160\x68\x6f\156\x65\x5f\163\150\157\162\x74\x63\157\x64\145"));
        add_action("\167\x70\x5f\141\152\141\170\x5f\156\x6f\160\162\x69\166\137{$this->_generateOTPAction}", [$this, "\x5f\x68\x61\156\x64\154\145\137\x63\146\x37\137\x63\x6f\x6e\164\x61\143\x74\137\x66\x6f\x72\155"]);
        add_action("\167\160\137\141\x6a\141\170\137{$this->_generateOTPAction}", [$this, "\137\x68\141\x6e\144\x6c\x65\x5f\x63\146\67\137\143\x6f\x6e\164\x61\x63\164\x5f\146\x6f\x72\155"]);
    }
    function _handle_cf7_contact_form()
    {
        $FA = $_POST;
        $this->validateAjaxRequest();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (MoUtility::sanitizeCheck("\x75\163\x65\162\137\x65\155\141\151\154", $FA)) {
            goto Pr;
        }
        if (MoUtility::sanitizeCheck("\x75\163\145\162\x5f\x70\150\x6f\156\x65", $FA)) {
            goto p3;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto C5;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto FB;
        C5:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        FB:
        goto Va;
        p3:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($FA["\x75\163\x65\162\137\x70\150\x6f\156\x65"]));
        $this->sendChallenge("\x74\x65\163\164", '', null, trim($FA["\x75\163\x65\162\x5f\x70\x68\x6f\156\145"]), VerificationType::PHONE);
        Va:
        goto j_;
        Pr:
        SessionUtils::addEmailVerified($this->_formSessionVar, $FA["\165\x73\x65\162\137\145\155\x61\151\154"]);
        $this->sendChallenge("\164\x65\x73\x74", $FA["\x75\x73\x65\162\137\145\x6d\x61\x69\x6c"], null, $FA["\x75\163\145\162\137\x65\x6d\141\151\x6c"], VerificationType::EMAIL);
        j_:
    }
    function validateFormPost($s_, $yn)
    {
        $yn = new WPCF7_FormTag($yn);
        $ZC = $yn->name;
        $qL = isset($_POST[$ZC]) ? trim(wp_unslash(strtr((string) $_POST[$ZC], "\xa", "\40"))) : '';
        if (!("\145\x6d\x61\x69\154" == $yn->basetype && $ZC == $this->_emailKey && strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto rn;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, $qL);
        rn:
        if (!("\164\145\154" == $yn->basetype && $ZC == $this->_phoneKey && strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto HY;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, $qL);
        HY:
        if (!("\164\145\x78\x74" == $yn->basetype && $ZC == "\145\155\x61\x69\154\137\x76\145\x72\151\146\171" || "\x74\145\x78\164" == $yn->basetype && $ZC == "\x70\x68\x6f\156\145\137\x76\x65\x72\x69\x66\x79")) {
            goto Qk;
        }
        $this->checkIfVerificationCodeNotEntered($ZC, $s_, $yn);
        $this->checkIfVerificationNotStarted($s_, $yn);
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto bi;
        }
        $this->processEmail($s_, $yn);
        bi:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto zx;
        }
        $this->processPhoneNumber($s_, $yn);
        zx:
        if (!empty($s_->get_invalid_fields())) {
            goto Um;
        }
        if ($this->processOTPEntered($ZC)) {
            goto xo;
        }
        $s_->invalidate($yn, MoUtility::_get_invalid_otp_method());
        xo:
        Um:
        Qk:
        return $s_;
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    function processOTPEntered($ZC)
    {
        $Bs = $this->getVerificationType();
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs)) {
            goto sZ;
        }
        $this->validateChallenge($Bs, $ZC, NULL);
        sZ:
        return SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs);
    }
    function processEmail(&$s_, $yn)
    {
        if (SessionUtils::isEmailSubmittedAndVerifiedMatch($this->_formSessionVar)) {
            goto zB;
        }
        $s_->invalidate($yn, mo_(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH)));
        zB:
    }
    function processPhoneNumber(&$s_, $yn)
    {
        if (Sessionutils::isPhoneSubmittedAndVerifiedMatch($this->_formSessionVar)) {
            goto by;
        }
        $s_->invalidate($yn, mo_(MoMessages::showMessage(MoMessages::PHONE_MISMATCH)));
        by:
    }
    function checkIfVerificationNotStarted(&$s_, $yn)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto c1;
        }
        $s_->invalidate($yn, mo_(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE)));
        c1:
    }
    function checkIfVerificationCodeNotEntered($ZC, &$s_, $yn)
    {
        if (MoUtility::sanitizeCheck($ZC, $_REQUEST)) {
            goto TD;
        }
        $s_->invalidate($yn, wpcf7_get_message("\151\x6e\166\x61\154\151\x64\137\162\x65\161\165\151\162\x65\144"));
        TD:
    }
    function _cf7_email_shortcode($GC)
    {
        $vH = MoUtility::sanitizeCheck("\153\x65\x79", $GC);
        $B_ = MoUtility::sanitizeCheck("\x62\165\x74\x74\x6f\156\151\x64", $GC);
        $Xf = MoUtility::sanitizeCheck("\155\x65\163\163\141\x67\x65\x64\151\166", $GC);
        $vH = $vH ? "\x23" . $vH : "\x69\x6e\160\x75\x74\x5b\156\141\x6d\x65\x3d\47" . $this->_emailKey . "\47\x5d";
        $B_ = $B_ ? $B_ : "\155\x69\x6e\x69\157\162\x61\156\x67\145\x5f\x6f\x74\160\137\164\x6f\x6b\x65\156\x5f\163\x75\x62\x6d\x69\x74";
        $Xf = $Xf ? $Xf : "\x6d\157\137\155\145\x73\163\141\x67\145";
        $Ev = "<div style='display:table;text-align:center;'>".
                    "<img decoding='async' src='".MOV_URL. "includes/images/loader.gif'>".
                  "</div>";
        $Ev = str_replace('"', "'", $Ev);
        $Ua = "\x3c\163\143\x72\151\160\x74\x3e" . "\x6a\121\x75\x65\162\x79\x28\144\x6f\x63\165\x6d\145\x6e\164\x29\x2e\x72\x65\141\144\171\x28\x66\165\156\x63\x74\151\157\156\50\x29\173" . "\x24\x6d\157\75\152\121\165\145\x72\x79\73" . "\x24\x6d\157\50\x20\42\43" . $B_ . "\42\x20\x29\56\145\141\143\150\50\x66\165\x6e\143\164\151\157\x6e\x28\151\156\144\x65\x78\51\x20\x7b" . "\x24\x6d\x6f\50\164\x68\x69\x73\51\56\157\156\50\42\x63\x6c\151\x63\x6b\x22\x2c\x20\x66\165\156\143\x74\x69\157\156\50\51\173" . "\x76\141\x72\x20\164\40\x3d\40\44\x6d\157\50\164\150\x69\x73\x29\x2e\x63\154\x6f\163\145\x73\x74\50\42\x66\157\x72\155\x22\51\73" . "\x76\x61\162\40\145\x20\75\x20\164\x2e\146\x69\x6e\144\50\42" . $vH . "\x22\51\x2e\x76\141\154\50\x29\x3b" . "\166\141\x72\40\x6e\x20\x3d\x20\164\56\x66\x69\x6e\144\50\42\x69\156\x70\x75\x74\133\x6e\141\x6d\145\75\x27\145\x6d\x61\151\x6c\137\x76\145\162\151\146\x79\47\x5d\42\51\x3b" . "\166\x61\x72\40\144\x20\x3d\x20\164\56\146\151\x6e\x64\50\42\x23" . $Xf . "\x22\x29\x3b" . "\x64\x2e\x65\x6d\x70\x74\x79\50\x29\x3b" . "\144\56\x61\x70\160\145\156\x64\x28\x22" . $Ev . "\x22\51\x3b" . "\x64\56\163\150\157\x77\x28\51\73" . "\44\155\x6f\x2e\x61\152\141\170\50\173" . "\x75\x72\x6c\72\42" . wp_ajax_url() . "\42\54" . "\x74\x79\160\x65\72\x22\x50\x4f\123\x54\x22\x2c" . "\144\x61\x74\141\72\x7b" . "\x75\x73\145\x72\137\145\155\x61\x69\x6c\72\x65\54" . "\x61\143\x74\x69\157\x6e\72\42" . $this->_generateOTPAction . "\42\x2c" . $this->_nonceKey . "\72\x22" . wp_create_nonce($this->_nonce) . "\x22" . "\175\54" . "\143\x72\157\x73\163\104\x6f\155\x61\151\156\x3a\41\60\54" . "\144\141\x74\x61\124\171\x70\145\x3a\42\152\x73\157\x6e\x22\x2c" . "\163\165\143\x63\145\x73\x73\72\146\165\156\x63\164\x69\157\156\x28\157\51\x7b\x20" . "\151\146\x28\157\56\x72\145\x73\x75\154\164\75\75\x22\x73\165\143\x63\x65\x73\x73\42\x29\173" . "\x64\x2e\x65\155\160\164\171\x28\51\54" . "\x64\56\x61\160\160\x65\156\144\50\157\x2e\x6d\145\x73\163\141\x67\x65\51\x2c" . "\144\56\x63\x73\163\50\42\x62\157\x72\x64\145\162\55\164\157\160\42\54\x22\x33\x70\170\x20\163\157\x6c\x69\144\x20\147\x72\x65\145\x6e\x22\51\x2c" . "\x6e\56\x66\x6f\143\x75\163\x28\x29" . "\x7d\x65\154\x73\x65\x7b" . "\144\56\145\x6d\x70\164\x79\50\x29\x2c" . "\x64\x2e\x61\x70\x70\145\x6e\x64\x28\157\56\x6d\145\163\x73\141\147\145\51\54" . "\x64\x2e\x63\163\163\x28\42\x62\157\162\x64\x65\x72\x2d\164\157\x70\x22\x2c\42\x33\160\170\x20\163\x6f\154\x69\x64\40\x72\145\x64\42\x29" . "\175" . "\175\x2c" . "\145\x72\x72\x6f\162\72\146\x75\x6e\143\x74\151\x6f\x6e\50\157\54\145\54\156\51\x7b\x7d" . "\x7d\51" . "\x7d\x29\73" . "\175\x29\73" . "\x7d\x29\73" . "\74\x2f\x73\143\x72\151\x70\164\76";
        return $Ua;
    }
    function _cf7_phone_shortcode($GC)
    {
        $oL = MoUtility::sanitizeCheck("\x6b\145\171", $GC);
        $B_ = MoUtility::sanitizeCheck("\x62\x75\x74\164\x6f\x6e\151\x64", $GC);
        $Xf = MoUtility::sanitizeCheck("\x6d\x65\x73\x73\141\147\x65\144\x69\x76", $GC);
        $oL = $oL ? "\43" . $oL : "\151\x6e\x70\165\164\133\x6e\141\x6d\145\75\x27" . $this->_phoneKey . "\x27\135";
        $B_ = $B_ ? $B_ : "\155\x69\x6e\151\157\162\x61\156\147\145\137\x6f\164\x70\x5f\x74\157\153\x65\156\137\163\165\142\x6d\x69\164";
        $Xf = $Xf ? $Xf : "\x6d\x6f\137\x6d\x65\163\163\141\147\145";
        $Ev = "<div style='display:table;text-align:center;'>".
                    "<img decoding='async' src='".MOV_URL. "includes/images/loader.gif'>".
                  "</div>";
        $Ev = str_replace('"', "'", $Ev);
        $Ua = "\x3c\x73\143\162\x69\160\x74\76" . "\x6a\121\165\145\162\x79\50\144\x6f\143\x75\155\145\x6e\164\x29\56\162\145\141\x64\x79\50\146\x75\x6e\x63\164\151\x6f\156\50\51\x7b" . "\x24\x6d\x6f\75\152\x51\165\145\x72\x79\x3b\x24\155\157\50\40\x22\x23" . $B_ . "\x22\x20\51\x2e\145\141\143\150\50\146\165\156\x63\164\x69\157\156\50\x69\156\x64\145\170\x29\x20\173" . "\44\x6d\x6f\50\164\x68\151\163\51\x2e\157\x6e\50\42\143\154\151\143\153\x22\54\40\x66\x75\x6e\143\164\151\157\156\50\x29\173" . "\166\141\x72\x20\x74\40\x3d\x20\44\155\157\x28\164\x68\x69\163\51\56\143\154\x6f\x73\x65\x73\x74\50\x22\146\157\162\155\x22\x29\x3b" . "\166\141\162\x20\145\x20\x3d\x20\x74\56\x66\x69\x6e\x64\x28\x22" . $oL . "\42\x29\x2e\166\x61\x6c\50\x29\73" . "\166\141\162\x20\156\40\75\40\164\x2e\x66\151\x6e\x64\x28\42\151\x6e\x70\x75\x74\x5b\156\x61\x6d\x65\x3d\x27\160\150\157\156\145\137\x76\145\162\x69\146\171\47\135\x22\x29\73" . "\166\x61\162\x20\x64\40\x3d\x20\x74\56\x66\x69\156\144\x28\42\x23" . $Xf . "\42\x29\x3b" . "\x64\56\145\155\160\x74\x79\x28\51\73" . "\x64\x2e\x61\160\160\145\x6e\x64\50\x22" . $Ev . "\x22\x29\x3b" . "\144\x2e\x73\150\157\x77\50\x29\73" . "\44\155\x6f\x2e\141\152\141\x78\x28\x7b" . "\x75\x72\x6c\72\42" . wp_ajax_url() . "\x22\54" . "\x74\171\160\x65\x3a\42\120\x4f\123\x54\42\54" . "\144\141\164\x61\x3a\x7b" . "\165\x73\x65\x72\137\x70\150\x6f\x6e\145\72\x65\54" . "\x61\x63\x74\x69\x6f\x6e\72\x22" . $this->_generateOTPAction . "\x22\x2c" . $this->_nonceKey . "\x3a\42" . wp_create_nonce($this->_nonce) . "\42" . "\x7d\54" . "\x63\162\157\x73\163\x44\157\x6d\141\151\x6e\72\x21\x30\x2c" . "\x64\141\x74\141\124\171\x70\x65\72\x22\152\163\157\x6e\42\x2c" . "\x73\165\143\143\x65\x73\x73\72\146\x75\156\x63\164\x69\157\156\x28\x6f\x29\x7b\40" . "\151\146\50\157\x2e\x72\145\163\165\154\164\75\75\x22\163\x75\x63\x63\145\163\x73\x22\51\x7b" . "\x64\56\145\155\160\164\171\x28\x29\54" . "\x64\x2e\141\x70\160\145\x6e\x64\x28\x6f\56\155\x65\163\163\141\x67\145\51\54" . "\144\x2e\143\x73\x73\50\x22\142\x6f\x72\x64\145\162\55\x74\157\160\x22\x2c\x22\x33\160\x78\40\x73\157\x6c\151\x64\x20\147\162\x65\145\x6e\x22\x29\x2c" . "\x6e\56\146\157\x63\165\163\50\51" . "\175\x65\x6c\163\x65\x7b" . "\144\x2e\145\155\x70\x74\171\x28\51\x2c" . "\x64\x2e\141\x70\160\145\156\x64\50\x6f\56\155\145\163\x73\141\x67\x65\51\54" . "\144\56\x63\x73\x73\50\x22\x62\157\x72\x64\145\x72\x2d\164\x6f\x70\42\54\x22\x33\x70\170\40\163\x6f\x6c\x69\x64\x20\x72\x65\x64\42\x29" . "\175" . "\x7d\x2c" . "\x65\162\162\x6f\162\72\x66\x75\x6e\x63\x74\151\x6f\156\50\157\x2c\x65\x2c\156\51\x7b\175" . "\175\51" . "\x7d\51\73" . "\x7d\x29\73" . "\x7d\x29\73" . "\74\57\x73\x63\162\x69\x70\164\76";
        return $Ua;
    }
    public function unsetSession($s_)
    {
        $this->unsetOTPSessionVariables();
        return $s_;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->_isFormEnabled && $this->_otpType == $this->_typePhoneTag)) {
            goto MP;
        }
        $kp = array_merge($kp, $this->_phoneFormId);
        MP:
        return $kp;
    }
    private function emailKeyValidationCheck()
    {
        if (!($this->_otpType === $this->_typeEmailTag && MoUtility::isBlank($this->_emailKey))) {
            goto mt;
        }
        do_action("\x6d\157\137\162\145\147\x69\163\x74\162\x61\x74\x69\x6f\x6e\x5f\163\150\157\167\137\x6d\145\x73\163\x61\147\x65", MoMessages::showMessage(BaseMessages::CF7_PROVIDE_EMAIL_KEY), MoConstants::ERROR);
        return false;
        mt:
        return true;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto l8;
        }
        return;
        l8:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\143\146\67\137\143\157\x6e\164\141\143\164\137\145\x6e\x61\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\143\146\67\137\x63\x6f\156\164\x61\x63\164\137\x74\x79\160\x65");
        $this->_emailKey = $this->sanitizeFormPOST("\x63\x66\x37\x5f\145\155\x61\151\x6c\137\x66\x69\x65\x6c\144\x5f\153\145\x79");
        if (!($this->basicValidationCheck(BaseMessages::CF7_CHOOSE) && $this->emailKeyValidationCheck())) {
            goto dq;
        }
        update_mo_option("\x63\x66\67\137\143\157\156\164\141\143\164\x5f\x65\x6e\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\143\x66\67\x5f\x63\x6f\x6e\x74\141\x63\x74\137\x74\171\x70\145", $this->_otpType);
        update_mo_option("\x63\146\x37\137\145\155\x61\151\x6c\137\153\145\171", $this->_emailKey);
        dq:
    }
}
