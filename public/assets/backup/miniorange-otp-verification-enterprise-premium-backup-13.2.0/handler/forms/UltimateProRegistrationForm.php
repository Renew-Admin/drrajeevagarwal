<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class UltimateProRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::ULTIMATE_PRO;
        $this->_phoneFormId = "\151\156\x70\x75\164\133\x6e\x61\x6d\x65\75\x70\150\157\156\x65\x5d";
        $this->_formKey = "\125\114\x54\111\x4d\101\124\x45\x5f\115\105\115\x5f\x50\122\x4f";
        $this->_typePhoneTag = "\x6d\x6f\137\165\154\164\x69\x70\x72\157\137\x70\150\157\x6e\x65\x5f\145\x6e\141\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\157\137\x75\x6c\164\x69\160\x72\157\x5f\145\x6d\x61\151\154\137\x65\156\x61\x62\x6c\145";
        $this->_formName = mo_("\x55\x6c\164\x69\155\x61\164\145\x20\115\x65\155\x62\145\x72\x73\150\151\x70\40\x50\x72\x6f\40\x46\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\165\154\x74\151\x70\162\x6f\x5f\x65\156\x61\142\x6c\x65");
        $this->_formDocuments = MoOTPDocs::UM_PRO_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x75\154\x74\x69\x70\x72\157\137\x74\x79\x70\x65");
        add_action("\167\160\x5f\141\x6a\141\x78\137\x6e\x6f\160\x72\x69\166\x5f\151\x68\x63\137\143\x68\x65\x63\153\x5f\162\145\147\x5f\x66\151\x65\154\144\x5f\141\152\x61\x78", array($this, "\x5f\165\154\164\x69\x70\x72\x6f\137\150\x61\x6e\144\x6c\145\x5f\163\x75\142\155\151\x74"), 1);
        add_action("\167\x70\137\141\x6a\x61\170\137\151\x68\x63\x5f\x63\150\145\x63\153\x5f\162\x65\x67\x5f\x66\x69\145\154\x64\137\x61\152\141\x78", array($this, "\137\165\x6c\x74\x69\160\x72\x6f\x5f\150\141\156\x64\154\x65\x5f\x73\165\x62\155\151\164"), 1);
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto tm;
        }
        add_shortcode("\155\x6f\x5f\x70\150\157\x6e\145", array($this, "\x5f\x70\x68\157\156\x65\x5f\x73\150\x6f\x72\164\x63\157\144\145"));
        tm:
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto wq;
        }
        add_shortcode("\x6d\157\x5f\x65\x6d\141\151\x6c", array($this, "\x5f\x65\x6d\141\151\154\137\163\150\x6f\x72\x74\143\x6f\x64\145"));
        wq:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\x70\164\x69\x6f\156", $_GET)) {
            goto DV;
        }
        return;
        DV:
        switch (trim($_GET["\x6f\160\164\x69\157\x6e"])) {
            case "\x6d\151\x6e\x69\x6f\162\x61\x6e\147\x65\x2d\x75\x6c\x74\151":
                $this->_handle_ulti_form($_POST);
                goto c8;
        }
        nX:
        c8:
    }
    function _ultipro_handle_submit()
    {
        $CK = array("\x70\x68\x6f\x6e\x65", "\x75\x73\x65\x72\x5f\x65\155\141\x69\154", "\166\141\x6c\151\144\141\164\145");
        $Rx = ihc_return_meta_arr("\162\x65\x67\x69\x73\164\145\162\x2d\155\163\147");
        if (isset($_REQUEST["\164\171\160\145"]) && isset($_REQUEST["\166\141\154\x75\x65"])) {
            goto Y0;
        }
        if (!isset($_REQUEST["\146\151\145\x6c\144\163\x5f\x6f\x62\152"])) {
            goto B3;
        }
        $PI = $_REQUEST["\x66\x69\145\154\144\163\x5f\157\142\x6a"];
        foreach ($PI as $Oq => $ul) {
            if (in_array($ul["\x74\171\x70\145"], $CK)) {
                goto LK;
            }
            $EJ[] = array("\164\171\160\x65" => $ul["\x74\x79\x70\145"], "\166\141\154\x75\145" => ihc_check_value_field($ul["\x74\x79\x70\145"], $ul["\x76\x61\x6c\165\x65"], $ul["\163\145\x63\157\156\144\137\166\141\x6c\165\x65"], $Rx));
            goto sy;
            LK:
            $EJ[] = $this->validate_umpro_submitted_value($ul["\x74\171\160\x65"], $ul["\166\x61\154\x75\145"], $ul["\163\145\143\x6f\156\x64\x5f\166\x61\154\165\x65"], $Rx);
            sy:
            ay:
        }
        jh:
        echo json_encode($EJ);
        B3:
        goto Us;
        Y0:
        echo ihc_check_value_field(sanitize_text_field($_REQUEST["\164\x79\x70\145"]), sanitize_text_field($_REQUEST["\166\x61\154\165\x65"]), sanitize_text_field($_REQUEST["\x73\x65\143\157\156\144\x5f\x76\x61\154\165\145"]), $Rx);
        Us:
        die;
    }
    function _phone_shortcode()
    {
        $Ev = "\x3c\144\151\x76\40\x73\x74\x79\x6c\x65\75\47\x64\x69\x73\160\x6c\141\171\x3a\164\141\142\x6c\145\x3b\x74\145\x78\164\x2d\x61\x6c\x69\x67\156\x3a\x63\145\156\x74\145\162\73\47\76\74\151\x6d\x67\40\x73\162\143\75\47" . MOV_URL . "\x69\x6e\x63\154\x75\x64\x65\163\x2f\151\155\141\147\x65\163\x2f\x6c\157\x61\144\145\x72\x2e\x67\151\146\x27\x3e\74\57\x64\151\166\76";
        $o_ = "\74\x64\x69\166\x20\x73\164\171\154\145\x3d\47\x6d\x61\x72\147\x69\x6e\x2d\164\x6f\160\72\40\62\45\x3b\x27\76\74\x62\x75\164\x74\x6f\156\40\x74\x79\160\145\x3d\x27\142\165\164\x74\x6f\156\47\x20\x64\x69\163\x61\x62\154\x65\144\75\x27\144\x69\x73\141\x62\154\145\144\47\x20\143\154\141\x73\x73\x3d\x27\142\x75\164\x74\157\x6e\40\141\154\164\47\x20\x73\x74\171\154\x65\x3d\47\167\x69\x64\x74\150\x3a\x31\x30\60\45\73\x68\145\x69\x67\150\164\72\63\60\160\170\73";
        $o_ .= "\146\157\156\164\x2d\146\141\x6d\x69\x6c\171\72\x20\122\157\x62\x6f\x74\x6f\73\x66\157\156\x74\x2d\x73\x69\x7a\x65\x3a\x20\61\x32\160\x78\40\41\151\x6d\160\157\162\x74\x61\x6e\164\x3b\47\x20\151\144\75\x27\x6d\151\156\x69\157\x72\141\156\147\x65\137\157\x74\x70\x5f\164\157\153\145\x6e\x5f\163\165\x62\x6d\x69\x74\x27\40\x74\x69\164\x6c\x65\75\x27\120\154\x65\141\x73\145\40\x45\156\164\145\x72\40\141\x6e\x20\x70\150\x6f\156\x65\x20\x74\x6f\40\145\x6e\x61\x62\x6c\x65\40\164\150\x69\x73\56\x27\x3e";
        $o_ .= "\103\154\x69\143\153\x20\x48\x65\x72\x65\x20\164\x6f\40\x56\145\162\151\146\x79\x20\x50\x68\x6f\156\x65\74\57\142\x75\x74\x74\x6f\x6e\x3e\x3c\57\x64\x69\166\76\x3c\x64\x69\166\40\x73\x74\x79\x6c\x65\75\47\x6d\x61\x72\x67\x69\x6e\55\x74\157\x70\x3a\62\45\47\76\x3c\x64\151\x76\40\151\x64\x3d\x27\155\157\x5f\155\x65\163\163\141\147\145\x27\40\x68\151\144\144\x65\156\75\x27\x27\40";
        $o_ .= "\163\164\x79\x6c\145\x3d\x27\x62\141\143\153\147\162\x6f\x75\156\144\x2d\143\157\154\x6f\x72\72\x20\x23\x66\67\x66\66\x66\67\73\x70\x61\144\144\151\x6e\x67\x3a\40\61\x65\x6d\x20\62\x65\155\40\61\x65\x6d\40\63\56\x35\145\155\73\x27\x27\x3e\74\x2f\144\151\x76\x3e\74\x2f\144\x69\166\x3e";
        $Ua = "\74\x73\x63\162\151\x70\164\76\152\x51\x75\145\x72\x79\x28\144\157\143\165\x6d\145\x6e\164\x29\56\x72\x65\141\144\171\50\x66\x75\x6e\x63\x74\151\157\156\50\x29\173\44\155\157\x3d\152\x51\x75\145\162\x79\73\40\x76\x61\x72\40\x64\x69\166\x45\x6c\145\155\x65\x6e\x74\40\75\40\42" . $o_ . "\42\x3b\x20";
        $Ua .= "\44\155\x6f\x28\42\151\156\x70\165\164\133\156\x61\155\145\75\x70\x68\157\x6e\145\x5d\x22\51\x2e\143\x68\141\156\x67\145\50\x66\x75\x6e\143\x74\151\x6f\x6e\50\x29\173\40\151\x66\50\41\x24\x6d\x6f\50\x74\x68\151\163\x29\56\x76\x61\154\x28\51\51\x7b\40\44\x6d\x6f\50\42\43\155\151\156\x69\157\162\141\156\x67\145\137\157\x74\160\137\164\157\153\145\x6e\x5f\x73\165\142\x6d\x69\164\42\51\56\160\x72\157\x70\50\42\x64\x69\163\141\x62\x6c\145\144\42\x2c\164\162\x75\x65\x29\73";
        $Ua .= "\x20\x7d\145\x6c\163\145\173\x20\x24\155\x6f\50\x22\43\155\x69\156\x69\157\162\x61\156\147\145\137\157\164\160\137\164\x6f\153\145\x6e\x5f\163\165\x62\155\x69\164\42\51\56\x70\162\157\x70\x28\42\144\x69\x73\141\x62\154\145\x64\x22\54\x66\141\x6c\x73\x65\51\x3b\40\175\40\175\x29\x3b";
        $Ua .= "\x20\x24\155\157\50\144\151\x76\105\x6c\145\x6d\x65\156\164\51\x2e\x69\156\163\x65\162\x74\x41\146\164\x65\x72\x28\44\155\157\x28\40\x22\151\x6e\160\x75\164\133\156\141\155\145\75\160\150\x6f\x6e\x65\x5d\x22\x29\51\x3b\40\44\x6d\x6f\x28\x22\43\155\x69\156\x69\x6f\x72\x61\156\147\145\137\157\164\x70\137\x74\x6f\x6b\x65\x6e\x5f\163\x75\142\x6d\151\x74\42\x29\x2e\x63\154\151\143\x6b\x28\146\x75\x6e\x63\164\151\x6f\156\50\x6f\51\x7b\40";
        $Ua .= "\x76\x61\162\40\145\x3d\x24\155\157\50\42\x69\x6e\x70\165\164\133\156\x61\155\x65\x3d\x70\150\157\156\145\135\x22\x29\x2e\166\x61\x6c\x28\x29\x3b\x20\x24\x6d\157\x28\x22\43\x6d\157\x5f\155\x65\x73\x73\141\147\145\x22\51\x2e\x65\155\160\x74\x79\50\x29\54\44\x6d\x6f\50\x22\x23\x6d\x6f\x5f\x6d\x65\163\x73\x61\x67\145\x22\x29\56\141\160\160\x65\156\x64\x28\x22" . $Ev . "\42\51\x2c";
        $Ua .= "\x24\x6d\157\x28\x22\43\155\x6f\137\155\x65\x73\x73\141\x67\x65\x22\51\56\163\x68\157\x77\x28\51\x2c\44\x6d\157\56\141\152\141\x78\50\x7b\165\162\x6c\x3a\42" . site_url() . "\x2f\77\x6f\160\x74\151\157\156\75\155\x69\x6e\151\157\162\141\x6e\147\x65\x2d\x75\x6c\x74\x69\x22\54\x74\171\160\145\x3a\x22\120\117\123\x54\42\54";
        $Ua .= "\144\x61\x74\141\x3a\x7b\x75\163\x65\x72\x5f\160\150\x6f\x6e\145\x3a\145\x7d\x2c\143\162\x6f\163\163\104\x6f\x6d\x61\x69\x6e\72\41\x30\x2c\x64\x61\x74\x61\x54\x79\x70\x65\72\x22\x6a\163\x6f\156\42\x2c\x73\x75\x63\143\145\x73\163\72\146\x75\x6e\143\164\151\x6f\156\50\157\x29\173\x20\x69\x66\x28\157\56\x72\145\x73\165\154\x74\x3d\75\42\x73\165\x63\143\x65\163\163\42\51\173\44\155\x6f\x28\x22\43\x6d\x6f\137\155\145\163\163\141\x67\x65\x22\51\x2e\145\x6d\160\164\171\50\x29\x2c";
        $Ua .= "\x24\155\157\x28\42\43\x6d\157\137\155\x65\x73\x73\141\x67\x65\x22\51\x2e\141\160\160\145\x6e\x64\50\x6f\56\x6d\145\x73\163\141\147\145\51\x2c\44\155\157\50\42\43\x6d\157\x5f\155\x65\x73\163\141\x67\x65\42\51\56\143\x73\x73\x28\42\142\157\162\144\x65\x72\x2d\164\x6f\160\42\x2c\42\x33\x70\x78\x20\x73\x6f\154\x69\144\x20\147\162\x65\145\156\x22\51\54";
        $Ua .= "\44\155\x6f\x28\x22\x69\156\160\x75\164\133\156\141\x6d\x65\x3d\x65\155\141\x69\x6c\137\x76\x65\162\x69\146\171\135\42\51\x2e\146\157\x63\165\x73\50\51\175\x65\x6c\163\145\173\x24\x6d\157\x28\x22\x23\x6d\x6f\137\x6d\145\163\163\x61\x67\145\42\x29\56\145\x6d\160\x74\x79\x28\51\54\x24\155\x6f\50\42\43\155\x6f\x5f\155\145\163\x73\x61\147\145\x22\51\56\x61\160\160\145\x6e\x64\50\x6f\56\x6d\x65\x73\163\x61\x67\145\x29\54";
        $Ua .= "\44\155\x6f\50\x22\43\x6d\x6f\x5f\155\x65\x73\163\x61\147\x65\x22\x29\56\143\x73\x73\50\x22\x62\x6f\x72\x64\145\x72\55\x74\x6f\160\x22\54\42\63\160\x78\40\x73\x6f\154\x69\144\40\162\145\144\42\x29\54\x24\x6d\157\x28\x22\151\x6e\x70\165\x74\133\x6e\x61\155\145\x3d\x70\x68\157\x6e\x65\137\x76\x65\162\x69\x66\171\135\42\x29\x2e\x66\157\x63\x75\x73\x28\51\x7d\x20\73\175\54";
        $Ua .= "\145\162\x72\157\x72\72\146\165\156\143\164\151\157\x6e\x28\x6f\x2c\x65\x2c\x6e\x29\x7b\175\175\51\x7d\x29\73\175\x29\x3b\74\x2f\163\x63\162\151\x70\164\76";
        return $Ua;
    }
    function _email_shortcode()
    {
        $Ev = "\74\x64\x69\x76\x20\x73\x74\x79\154\x65\x3d\x27\144\151\x73\x70\154\x61\171\x3a\164\x61\x62\x6c\x65\x3b\164\145\170\164\x2d\141\x6c\x69\147\x6e\72\x63\x65\x6e\164\x65\x72\x3b\x27\x3e\x3c\151\155\147\x20\x73\162\x63\x3d\47" . MOV_URL . "\x69\x6e\143\154\x75\144\x65\x73\57\x69\x6d\141\147\x65\163\57\x6c\157\141\x64\145\162\x2e\147\x69\x66\47\x3e\x3c\x2f\144\x69\x76\x3e";
        $o_ = "\74\144\x69\166\40\163\164\x79\154\145\75\x27\x6d\141\162\147\151\156\x2d\x74\157\x70\72\40\62\45\x3b\47\76\74\x62\165\164\164\x6f\156\40\164\171\160\x65\x3d\x27\142\x75\164\164\157\x6e\x27\40\144\151\163\x61\x62\154\x65\144\75\x27\x64\151\x73\x61\142\154\145\144\x27\x20\143\x6c\141\x73\x73\x3d\x27\142\165\164\164\157\x6e\40\141\x6c\x74\x27\x20";
        $o_ .= "\x73\x74\171\x6c\x65\75\47\x77\151\x64\164\150\72\61\60\x30\x25\x3b\150\x65\151\x67\x68\164\x3a\x33\x30\160\170\73\146\157\x6e\164\55\146\141\155\x69\x6c\171\72\x20\122\x6f\x62\157\x74\157\x3b\146\x6f\156\x74\55\163\151\x7a\x65\x3a\x20\x31\62\x70\x78\40\x21\151\x6d\160\157\x72\x74\x61\x6e\x74\73\47\40\151\x64\x3d\47\x6d\151\x6e\x69\x6f\x72\141\x6e\147\x65\x5f\x6f\x74\x70\x5f\x74\157\x6b\x65\x6e\x5f\163\x75\x62\155\x69\x74\x27\x20";
        $o_ .= "\x74\151\x74\154\x65\75\x27\x50\x6c\145\x61\x73\145\40\105\x6e\x74\x65\162\40\141\x6e\x20\x65\x6d\141\151\154\x20\x74\157\x20\x65\x6e\x61\142\x6c\145\x20\x74\150\x69\x73\56\47\76\x43\154\x69\143\x6b\40\x48\145\162\x65\40\x74\157\x20\126\145\x72\151\x66\171\40\171\x6f\x75\162\40\145\x6d\x61\151\154\74\57\x62\x75\x74\x74\157\156\76\x3c\x2f\x64\x69\x76\76\74\x64\151\x76\x20\163\164\171\x6c\145\75\x27\x6d\141\162\x67\x69\x6e\55\164\157\160\x3a\62\x25\47\76";
        $o_ .= "\74\144\x69\x76\x20\151\144\x3d\47\155\x6f\x5f\x6d\145\x73\x73\141\x67\145\47\x20\150\151\144\144\x65\x6e\75\x27\x27\40\163\x74\x79\154\145\x3d\x27\x62\x61\143\x6b\x67\x72\x6f\165\x6e\144\x2d\143\157\x6c\157\x72\x3a\x20\43\146\x37\146\66\146\x37\x3b\x70\141\144\x64\x69\x6e\147\x3a\40\x31\145\x6d\x20\x32\x65\155\x20\x31\x65\155\40\63\x2e\65\x65\155\x3b\x27\47\76\x3c\57\144\x69\x76\76\x3c\x2f\x64\151\166\x3e";
        $Ua = "\x3c\x73\x63\x72\151\160\164\x3e\152\x51\x75\x65\162\171\50\144\157\143\165\155\145\156\164\51\56\162\x65\141\144\171\x28\146\165\x6e\143\x74\x69\x6f\x6e\50\x29\173\x24\155\x6f\x3d\152\121\x75\145\x72\x79\x3b\x20\x76\x61\x72\x20\144\x69\166\105\154\145\x6d\145\156\164\40\x3d\x20\42" . $o_ . "\x22\73\x20";
        $Ua .= "\44\155\157\50\x22\x69\x6e\160\165\164\x5b\x6e\x61\x6d\x65\x3d\x75\x73\x65\162\137\x65\155\141\x69\154\135\42\x29\x2e\143\150\x61\156\147\145\50\x66\165\x6e\143\x74\151\157\x6e\x28\51\x7b\40\x69\x66\x28\41\44\155\157\50\164\x68\151\163\x29\56\x76\x61\154\50\x29\51\x7b\x20";
        $Ua .= "\x24\x6d\x6f\50\42\43\155\x69\156\x69\157\162\x61\x6e\147\145\137\x6f\164\160\137\x74\157\153\145\x6e\x5f\163\165\x62\155\151\164\x22\51\56\160\162\157\160\50\x22\144\x69\163\x61\x62\x6c\145\144\42\x2c\x74\162\x75\145\51\x3b\40\175\145\154\x73\x65\x7b\x20";
        $Ua .= "\44\155\x6f\x28\42\43\x6d\x69\x6e\151\x6f\x72\141\x6e\x67\145\x5f\x6f\x74\x70\137\164\x6f\x6b\145\x6e\x5f\163\x75\x62\x6d\151\164\x22\x29\x2e\160\x72\x6f\160\50\x22\144\x69\163\141\142\154\x65\x64\42\54\x66\141\x6c\x73\x65\x29\73\x20\x7d\40\175\x29\x3b\x20";
        $Ua .= "\x24\155\x6f\50\x64\151\166\x45\x6c\145\155\145\156\x74\x29\x2e\151\x6e\163\x65\162\164\x41\x66\x74\x65\162\50\44\x6d\157\50\x20\42\151\x6e\x70\x75\x74\x5b\156\x61\155\x65\75\x75\x73\145\x72\137\x65\155\x61\x69\154\135\x22\51\x29\x3b\40\44\x6d\x6f\x28\42\43\x6d\x69\156\151\x6f\162\141\x6e\x67\x65\137\157\164\x70\x5f\x74\157\x6b\145\x6e\x5f\x73\165\142\x6d\x69\x74\x22\51\x2e\143\154\x69\143\153\50\x66\165\x6e\x63\x74\151\157\x6e\x28\157\51\173\x20";
        $Ua .= "\166\x61\x72\40\145\x3d\x24\x6d\157\x28\42\x69\156\160\165\x74\x5b\156\141\x6d\x65\x3d\165\163\145\162\137\x65\x6d\x61\151\154\x5d\x22\x29\x2e\x76\x61\x6c\50\51\73\40\44\x6d\x6f\50\x22\x23\x6d\x6f\x5f\155\145\163\x73\141\x67\x65\x22\x29\x2e\145\x6d\x70\164\x79\x28\51\54\x24\x6d\x6f\50\x22\43\155\x6f\137\x6d\145\x73\x73\x61\147\145\42\x29\56\x61\x70\x70\x65\156\144\50\x22" . $Ev . "\42\x29\x2c";
        $Ua .= "\44\155\x6f\x28\x22\x23\x6d\x6f\x5f\x6d\145\x73\x73\x61\147\145\x22\51\x2e\x73\150\x6f\x77\x28\51\x2c\x24\155\157\56\141\x6a\x61\x78\x28\173\x75\x72\154\x3a\x22" . site_url() . "\57\77\x6f\x70\164\x69\157\x6e\75\155\x69\156\x69\x6f\162\141\x6e\147\145\55\x75\x6c\164\151\42\54\164\171\160\x65\x3a\42\x50\117\123\x54\42\x2c\x64\141\164\141\x3a\x7b\165\x73\145\162\137\x65\155\x61\151\x6c\x3a\x65\175\54\x63\x72\157\163\163\104\157\x6d\141\x69\156\72\41\x30\54\144\141\x74\x61\124\x79\160\x65\72\x22\x6a\x73\157\x6e\x22\54\163\165\143\x63\x65\163\163\72\146\165\156\x63\x74\x69\157\156\50\157\51\173\40\151\146\50\157\x2e\162\x65\163\x75\154\x74\75\75\42\163\165\143\x63\x65\x73\163\x22\x29\173\x24\x6d\157\50\42\x23\x6d\157\x5f\155\145\x73\x73\141\147\145\x22\x29\56\x65\155\x70\164\171\x28\x29\54\44\155\x6f\x28\x22\x23\155\157\137\x6d\x65\x73\x73\141\147\145\x22\x29\x2e\x61\x70\x70\145\x6e\x64\50\157\x2e\x6d\145\163\x73\x61\x67\x65\51\54\44\155\157\50\x22\x23\155\157\137\x6d\145\x73\163\x61\x67\x65\42\x29\x2e\x63\163\x73\x28\x22\x62\157\162\144\x65\x72\55\x74\157\160\42\54\42\x33\160\170\x20\x73\157\x6c\151\144\x20\147\x72\x65\x65\156\x22\x29\54\44\x6d\157\x28\x22\x69\x6e\x70\165\164\133\x6e\x61\x6d\x65\x3d\145\x6d\x61\151\x6c\137\x76\x65\x72\x69\x66\x79\x5d\42\x29\x2e\x66\157\x63\x75\x73\x28\x29\175\145\154\163\x65\x7b\44\155\x6f\x28\42\43\155\157\x5f\155\145\x73\x73\141\x67\145\x22\51\56\x65\x6d\x70\x74\x79\x28\51\x2c\44\155\157\x28\42\x23\x6d\157\137\155\145\163\x73\141\x67\x65\42\x29\56\x61\x70\x70\145\x6e\144\50\157\56\155\x65\163\163\141\147\x65\51\x2c\44\x6d\157\50\42\43\155\x6f\137\x6d\145\163\163\141\x67\145\x22\51\x2e\143\x73\x73\x28\x22\x62\157\162\144\x65\x72\55\x74\157\x70\42\54\x22\63\160\x78\x20\x73\157\154\151\x64\40\162\x65\144\42\51\54\x24\155\157\x28\42\x69\156\160\x75\x74\x5b\x6e\x61\x6d\145\75\x70\150\x6f\x6e\x65\x5f\x76\x65\x72\x69\x66\x79\135\x22\x29\56\x66\x6f\143\x75\163\50\x29\175\x20\x3b\x7d\54\x65\162\162\x6f\x72\72\x66\165\156\x63\x74\151\157\156\x28\x6f\54\x65\54\x6e\51\173\175\x7d\x29\175\51\x3b\x7d\51\x3b\x3c\57\163\143\x72\x69\x70\164\76";
        return $Ua;
    }
    function _handle_ulti_form($FA)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto lm;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $FA["\165\163\x65\x72\x5f\x65\x6d\x61\x69\154"]);
        $this->sendChallenge('', $FA["\165\163\x65\162\137\145\x6d\141\x69\x6c"], null, null, VerificationType::EMAIL);
        goto Gf;
        lm:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $FA["\x75\163\x65\x72\x5f\160\150\157\x6e\x65"]);
        $this->sendChallenge('', null, null, $FA["\165\x73\145\162\137\160\x68\157\x6e\145"], VerificationType::PHONE);
        Gf:
    }
    function validate_umpro_submitted_value($uO, $qL, $Pz, $Rx)
    {
        $pq = array();
        switch ($uO) {
            case "\160\x68\157\x6e\x65":
                $this->processPhone($pq, $uO, $qL, $Pz, $Rx);
                goto L8;
            case "\165\x73\x65\x72\137\x65\x6d\141\151\154":
                $this->processEmail($pq, $uO, $qL, $Pz, $Rx);
                goto L8;
            case "\x76\x61\154\x69\144\x61\x74\x65":
                $this->processOTPEntered($pq, $uO, $qL, $Pz, $Rx);
                goto L8;
        }
        YE:
        L8:
        return $pq;
    }
    function processPhone(&$pq, $uO, $qL, $Pz, $Rx)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) != 0) {
            goto tE;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto fH;
        }
        if (!SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $qL)) {
            goto xA;
        }
        $pq = array("\164\x79\160\x65" => $uO, "\166\x61\x6c\x75\145" => ihc_check_value_field($uO, $qL, $Pz, $Rx));
        goto FV;
        xA:
        $pq = array("\x74\171\160\145" => $uO, "\x76\x61\x6c\165\x65" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        FV:
        goto lc;
        fH:
        $pq = array("\164\x79\160\x65" => $uO, "\166\x61\x6c\165\x65" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        lc:
        goto JC;
        tE:
        $pq = array("\x74\171\160\x65" => $uO, "\166\x61\x6c\x75\145" => ihc_check_value_field($uO, $qL, $Pz, $Rx));
        JC:
    }
    function processEmail(&$pq, $uO, $qL, $Pz, $Rx)
    {
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) != 0) {
            goto Av;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Za;
        }
        if (!SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $qL)) {
            goto QQ;
        }
        $pq = array("\x74\171\x70\145" => $uO, "\x76\x61\x6c\x75\145" => ihc_check_value_field($uO, $qL, $Pz, $Rx));
        goto nS;
        QQ:
        $pq = array("\x74\x79\x70\145" => $uO, "\x76\141\x6c\165\x65" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        nS:
        goto V9;
        Za:
        $pq = array("\x74\171\x70\145" => $uO, "\166\x61\154\165\x65" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        V9:
        goto hs;
        Av:
        $pq = array("\x74\171\x70\145" => $uO, "\166\x61\x6c\165\145" => ihc_check_value_field($uO, $qL, $Pz, $Rx));
        hs:
    }
    function processOTPEntered(&$pq, $uO, $qL, $Pz, $Rx)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto wn;
        }
        $this->validateAndProcessOTP($pq, $uO, $qL);
        goto WP;
        wn:
        $pq = array("\x74\171\x70\145" => $uO, "\166\x61\154\x75\x65" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        WP:
    }
    function validateAndProcessOTP(&$pq, $uO, $U4)
    {
        $Bs = $this->getVerificationType();
        $this->validateChallenge($Bs, NULL, $U4);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Bs)) {
            goto k3;
        }
        $this->unsetOTPSessionVariables();
        $pq = array("\164\171\160\145" => $uO, "\166\x61\x6c\x75\x65" => 1);
        goto nx;
        k3:
        $pq = array("\164\171\x70\145" => $uO, "\166\x61\154\165\145" => MoUtility::_get_invalid_otp_method());
        nx:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $tA);
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
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto kW;
        }
        array_push($kp, $this->_phoneFormId);
        kW:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto ox;
        }
        return;
        ox:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\154\x74\151\160\162\157\x5f\145\156\x61\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x75\154\x74\151\160\x72\157\x5f\164\x79\160\145");
        update_mo_option("\165\x6c\164\151\x70\162\157\x5f\x65\156\141\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\x75\154\164\x69\160\162\157\x5f\x74\x79\x70\x65", $this->_otpType);
    }
}
