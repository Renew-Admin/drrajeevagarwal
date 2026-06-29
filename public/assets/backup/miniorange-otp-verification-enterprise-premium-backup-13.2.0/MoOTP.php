<?php


namespace OTP;

use OTP\Handler\EmailVerificationLogic;
use OTP\Handler\FormActionHandler;
use OTP\Handler\MoOTPActionHandlerHandler;
use OTP\Handler\MoRegistrationHandler;
use OTP\Handler\PhoneVerificationLogic;
use OTP\Helper\CountryList;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MenuItems;
use OTP\Helper\MoConstants;
use OTP\Helper\MoDisplayMessages;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\MOVisualTour;
use OTP\Helper\PolyLangStrings;
use OTP\Helper\Templates\DefaultPopup;
use OTP\Helper\Templates\ErrorPopup;
use OTP\Helper\Templates\ExternalPopup;
use OTP\Helper\Templates\UserChoicePopup;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
use OTP\Traits\Instance;
use OTP\Helper\MoAddonListContent;
use OTP\Helper\MoOffer;
use OTP\Handler\CustomForm;
use OTP\Helper\MocURLOTP;
use OTP\Objects\BaseMessages;
use OTP\Helper\MoVersionUpdate;
use OTP\Helper\MoOTPAlphaNumeric;
use OTP\Helper\MoSMSBackupGateway;
use OTP\Helper\MoGloballyBannedPhone;
use OTP\Helper\MoWhatsApp;
use OTP\Helper\MoMasterOTP;
if (defined("\101\102\x53\120\x41\124\110")) {
    goto CRA;
}
exit;
CRA:
final class MoOTP
{
    use Instance;
    private function __construct()
    {
        $this->initializeHooks();
        $this->initializeGlobals();
        $this->initializeHelpers();
        $this->initializeHandlers();
        $this->registerPolyLangStrings();
        $this->registerAddOns();
    }
    private function initializeHooks()
    {
        add_action("\160\x6c\x75\147\x69\x6e\x73\x5f\x6c\x6f\x61\x64\x65\x64", array($this, "\x6f\x74\160\137\x6c\x6f\141\144\137\x74\145\x78\x74\144\157\x6d\141\x69\x6e"));
        add_action("\x61\x64\x6d\x69\156\x5f\x6d\145\156\x75", array($this, "\x6d\151\156\151\x6f\x72\x61\156\147\x65\137\x63\x75\163\x74\157\155\x65\162\x5f\x76\x61\x6c\x69\x64\x61\164\x69\x6f\156\x5f\x6d\x65\x6e\165"));
        add_action("\141\144\155\x69\x6e\x5f\x65\x6e\x71\x75\145\165\145\x5f\x73\143\162\x69\x70\x74\163", array($this, "\x6d\x6f\137\162\x65\x67\x69\163\164\162\141\x74\x69\x6f\x6e\x5f\x70\154\x75\x67\151\156\x5f\163\x65\164\x74\x69\x6e\x67\163\137\163\164\171\154\x65"));
        add_action("\x61\x64\155\151\x6e\137\145\156\x71\x75\145\x75\x65\137\163\x63\x72\x69\160\164\x73", array($this, "\155\157\x5f\x72\x65\147\x69\163\164\x72\141\x74\151\157\x6e\137\x70\154\x75\147\x69\x6e\137\163\145\164\164\x69\x6e\147\163\x5f\163\x63\x72\x69\160\164"));
        add_action("\167\x70\x5f\145\x6e\x71\165\145\x75\x65\137\x73\x63\162\x69\160\x74\x73", array($this, "\155\x6f\137\162\x65\x67\151\163\x74\162\141\164\151\157\156\137\160\154\165\x67\151\156\137\146\162\x6f\156\164\145\x6e\x64\137\163\143\x72\x69\x70\164\x73"), 99);
        add_action("\x6c\157\x67\x69\156\137\145\156\161\165\145\165\145\137\x73\143\162\x69\x70\x74\x73", array($this, "\x6d\157\x5f\162\145\x67\x69\163\x74\x72\x61\164\x69\x6f\x6e\137\160\x6c\165\147\151\x6e\137\x66\x72\x6f\x6e\164\x65\x6e\144\x5f\163\x63\162\151\160\164\x73"), 99);
        add_action("\155\x6f\137\162\145\x67\151\x73\164\x72\141\164\151\157\156\x5f\163\x68\x6f\167\137\x6d\x65\x73\x73\141\147\x65", array($this, "\x6d\x6f\137\163\150\x6f\x77\x5f\x6f\x74\160\137\x6d\145\x73\163\x61\147\x65"), 1, 2);
        add_action("\x68\157\165\x72\154\171\123\x79\x6e\143", array($this, "\150\157\165\162\x6c\x79\123\171\x6e\x63"));
        add_action("\x61\144\155\x69\x6e\x5f\x66\157\157\x74\x65\x72", array($this, "\146\x65\145\144\142\x61\143\153\x5f\162\145\x71\165\x65\x73\164"));
        add_filter("\167\x70\137\155\141\x69\154\137\x66\162\x6f\155\x5f\x6e\x61\155\x65", array($this, "\143\165\x73\x74\x6f\x6d\137\x77\160\137\155\x61\151\x6c\137\x66\x72\157\155\x5f\156\x61\155\x65"));
        add_filter("\160\154\165\x67\151\156\x5f\x72\157\167\x5f\x6d\x65\164\x61", array($this, "\155\x6f\x5f\155\145\164\x61\x5f\x6c\151\x6e\x6b\x73"), 10, 2);
        add_action("\x77\x70\x5f\145\x6e\x71\165\145\165\x65\137\x73\143\x72\x69\x70\164\x73", array($this, "\x6c\157\141\144\x5f\152\x71\x75\x65\162\171\137\157\x6e\137\146\x6f\x72\155\163"));
        add_action("\160\x6c\165\x67\x69\x6e\x5f\141\x63\x74\151\157\156\137\x6c\151\x6e\x6b\x73\x5f" . MOV_PLUGIN_NAME, array($this, "\x70\x6c\x75\147\x69\x6e\x5f\x61\x63\164\151\x6f\x6e\137\x6c\x69\x6e\153\163"), 10, 1);
    }
    function load_jquery_on_forms()
    {
        if (wp_script_is("\152\x71\165\145\x72\171", "\145\x6e\161\165\145\x75\x65\144")) {
            goto YE2;
        }
        wp_enqueue_script("\152\x71\x75\145\x72\171");
        YE2:
    }
    private function initializeHelpers()
    {
        MoMessages::instance();
        MoAddonListContent::instance();
        MoOffer::instance();
        PolyLangStrings::instance();
        MOVisualTour::instance();
        if (!file_exists(MOV_DIR . "\150\x65\x6c\160\145\162\x2f\x4d\157\126\x65\x72\x73\151\157\156\125\x70\144\141\164\145\56\160\150\x70")) {
            goto xJP;
        }
        MoVersionUpdate::instance();
        xJP:
        if (!file_exists(MOV_DIR . "\x68\x65\x6c\x70\x65\x72\57\x4d\157\117\x54\x50\x41\x6c\x70\x68\141\116\165\155\x65\x72\151\143\56\x70\150\160")) {
            goto r4R;
        }
        MoOTPAlphaNumeric::instance();
        r4R:
        if (!file_exists(MOV_DIR . "\150\x65\x6c\160\145\x72\57\x4d\157\x53\x4d\123\x42\141\143\153\165\160\x47\141\164\145\x77\141\x79\56\x70\x68\x70")) {
            goto LLf;
        }
        MoSMSBackupGateway::instance();
        LLf:
        if (!file_exists(MOV_DIR . "\x68\145\154\x70\x65\162\x2f\x4d\157\x47\154\157\x62\141\x6c\154\171\102\x61\x6e\x6e\x65\x64\120\150\157\x6e\x65\56\160\150\160")) {
            goto jST;
        }
        MoGloballyBannedPhone::instance();
        jST:
        if (!file_exists(MOV_DIR . "\150\x65\154\160\145\162\x2f\115\157\x57\150\x61\164\x73\x41\x70\x70\x2e\x70\x68\160")) {
            goto PvW;
        }
        MoWhatsApp::instance();
        PvW:
        if (!file_exists(MOV_DIR . "\x68\x65\154\160\145\x72\57\x4d\157\x4d\141\163\164\145\x72\117\124\x50\56\160\150\160")) {
            goto sDt;
        }
        MoMasterOTP::instance();
        sDt:
    }
    private function initializeHandlers()
    {
        FormActionHandler::instance();
        MoOTPActionHandlerHandler::instance();
        DefaultPopup::instance();
        ErrorPopup::instance();
        ExternalPopup::instance();
        UserChoicePopup::instance();
        MoRegistrationHandler::instance();
        CustomForm::instance();
    }
    private function initializeGlobals()
    {
        global $phoneLogic, $emailLogic;
        $phoneLogic = PhoneVerificationLogic::instance();
        $emailLogic = EmailVerificationLogic::instance();
    }
    function miniorange_customer_validation_menu()
    {
        MenuItems::instance();
    }
    function mo_customer_validation_options()
    {
        include MOV_DIR . "\x63\157\156\164\162\x6f\x6c\154\145\162\163\57\155\x61\151\156\x2d\x63\x6f\x6e\x74\162\x6f\x6c\154\145\162\x2e\x70\150\160";
    }
    function mo_registration_plugin_settings_style()
    {
        wp_enqueue_style("\155\x6f\x5f\143\x75\x73\164\x6f\x6d\x65\x72\137\x76\x61\x6c\151\x64\x61\164\x69\157\x6e\x5f\141\x64\x6d\151\x6e\x5f\x73\x65\164\164\x69\x6e\147\x73\x5f\x73\164\171\154\x65", MOV_CSS_URL);
        wp_enqueue_style("\x6d\157\x5f\x63\165\x73\x74\157\x6d\145\x72\x5f\x76\141\154\x69\144\x61\164\x69\157\156\x5f\x69\156\164\x74\x65\x6c\x69\x6e\160\x75\x74\x5f\x73\x74\x79\154\x65", MO_INTTELINPUT_CSS);
    }
    function mo_registration_plugin_settings_script()
    {
        $c8 = [];
        wp_enqueue_script("\155\157\137\x63\165\163\x74\157\155\145\x72\x5f\166\141\x6c\151\144\141\164\x69\157\156\137\x61\x64\155\x69\x6e\x5f\163\x65\164\164\151\x6e\x67\163\x5f\x73\x63\x72\x69\x70\x74", MOV_JS_URL, array("\x6a\161\x75\x65\x72\171"));
        wp_localize_script("\155\x6f\x5f\x63\x75\x73\164\x6f\155\x65\162\137\x76\x61\x6c\151\144\x61\x74\151\157\156\x5f\141\144\155\x69\x6e\137\x73\x65\164\164\x69\x6e\147\x73\137\163\x63\x72\x69\x70\164", "\x73\x63\162\x69\x70\164\137\144\141\164\x61", array("\167\150\x61\x74\163\x61\x70\x70\150\157\x73\164" => MoConstants::WHATSAPP_HOST));
        wp_enqueue_script("\x6d\x6f\137\x63\x75\x73\164\x6f\x6d\x65\162\x5f\x76\x61\x6c\x69\144\141\x74\151\157\156\137\146\157\x72\x6d\x5f\166\141\x6c\151\144\x61\x74\151\x6f\156\x5f\x73\x63\x72\x69\160\164", VALIDATION_JS_URL, array("\152\161\x75\145\162\x79"));
        wp_register_script("\x6d\157\x5f\x63\x75\163\x74\157\x6d\145\162\137\166\141\x6c\x69\x64\141\164\x69\157\156\137\151\156\x74\x74\145\154\x69\x6e\160\165\164\137\163\143\x72\151\x70\164", MO_INTTELINPUT_JS, array("\152\x71\x75\x65\162\x79"));
        $D6 = CountryList::getCountryCodeList();
        $D6 = apply_filters("\x73\x65\x6c\145\143\x74\x65\x64\x5f\143\x6f\x75\156\x74\x72\151\145\x73", $D6);
        foreach ($D6 as $j1 => $qL) {
            array_push($c8, $qL);
            XUg:
        }
        lxs:
        wp_localize_script("\155\x6f\137\143\x75\163\164\157\x6d\x65\162\137\x76\141\154\x69\144\x61\164\x69\x6f\x6e\137\x69\x6e\164\x74\x65\x6c\x69\156\160\165\x74\137\163\143\x72\151\160\164", "\155\x6f\x73\x65\x6c\145\x63\164\145\144\x64\162\x6f\x70\144\157\x77\156", array("\x73\145\x6c\x65\x63\x74\x65\144\144\x72\x6f\x70\144\157\167\x6e" => $c8));
        wp_enqueue_script("\155\157\x5f\x63\x75\x73\164\157\x6d\145\x72\137\166\141\154\x69\144\x61\x74\x69\x6f\x6e\137\x69\x6e\164\x74\x65\x6c\151\156\160\x75\x74\x5f\163\143\162\x69\160\x74");
    }
    function mo_registration_plugin_frontend_scripts()
    {
        $c8 = [];
        if (get_mo_option("\163\150\157\167\137\144\162\157\160\144\x6f\167\x6e\137\x6f\156\137\146\x6f\162\x6d")) {
            goto sYz;
        }
        return;
        sYz:
        $kp = apply_filters("\x6d\x6f\x5f\160\150\157\x6e\x65\x5f\x64\x72\157\160\144\157\x77\x6e\x5f\x73\145\x6c\145\143\x74\157\162", array());
        if (!MoUtility::isBlank($kp)) {
            goto i_2;
        }
        return;
        i_2:
        $kp = array_unique($kp);
        $D6 = CountryList::getCountryCodeList();
        $D6 = apply_filters("\163\x65\x6c\x65\143\x74\145\x64\x5f\x63\x6f\165\156\x74\162\151\145\163", $D6);
        foreach ($D6 as $j1 => $qL) {
            array_push($c8, $qL);
            sws:
        }
        Eri:
        $y5 = CountryList::getDefaultCountryIsoCode();
        $Py = apply_filters("\x6d\x6f\x5f\147\145\x74\x5f\x64\145\x66\x61\165\154\164\x5f\x63\157\x75\x6e\x74\162\x79", $y5);
        wp_register_script("\155\x6f\137\x63\165\x73\x74\x6f\155\x65\x72\x5f\x76\x61\154\151\x64\141\164\x69\157\x6e\x5f\x69\x6e\x74\164\145\x6c\151\x6e\160\x75\x74\x5f\163\x63\x72\x69\x70\164", MO_INTTELINPUT_JS, array("\x6a\x71\x75\x65\x72\171"));
        wp_localize_script("\155\x6f\x5f\x63\165\x73\164\x6f\155\x65\x72\x5f\x76\x61\x6c\151\144\x61\x74\151\x6f\x6e\x5f\x69\x6e\164\x74\145\154\x69\156\x70\165\x74\x5f\x73\143\162\x69\x70\164", "\x6d\157\163\145\x6c\145\143\x74\145\144\144\x72\x6f\160\x64\x6f\x77\156", array("\x73\145\x6c\x65\x63\164\145\x64\144\162\157\160\x64\157\167\x6e" => $c8));
        wp_enqueue_script("\x6d\x6f\137\143\165\x73\164\x6f\x6d\145\162\137\x76\x61\x6c\151\144\x61\164\x69\157\156\137\x69\x6e\x74\x74\145\154\x69\x6e\x70\165\164\x5f\x73\x63\162\x69\160\164");
        wp_enqueue_style("\x6d\x6f\137\x63\x75\x73\x74\157\x6d\145\x72\137\166\141\154\x69\x64\141\x74\x69\x6f\156\137\151\156\x74\164\x65\x6c\x69\x6e\x70\165\164\x5f\163\164\171\x6c\145", MO_INTTELINPUT_CSS);
        wp_register_script("\x6d\x6f\x5f\143\x75\x73\164\x6f\155\145\162\137\x76\141\x6c\x69\144\x61\x74\x69\x6f\x6e\137\144\162\x6f\160\x64\157\167\x6e\137\x73\143\162\x69\x70\164", MO_DROPDOWN_JS, array("\152\161\165\x65\162\171"), MOV_VERSION, true);
        wp_localize_script("\155\x6f\x5f\x63\165\x73\164\x6f\x6d\145\x72\x5f\166\x61\154\x69\144\x61\x74\151\x6f\x6e\x5f\144\162\157\160\144\157\167\x6e\x5f\x73\143\x72\x69\x70\x74", "\x6d\157\x64\162\157\x70\x64\x6f\x77\156\166\141\x72\x73", array("\163\x65\x6c\145\x63\164\x6f\x72" => json_encode($kp), "\144\x65\146\x61\165\x6c\164\103\157\x75\156\164\162\x79" => $Py, "\157\x6e\154\x79\103\x6f\x75\156\x74\162\x69\145\x73" => CountryList::getOnlyCountryList()));
        wp_enqueue_script("\155\157\x5f\143\165\x73\164\x6f\155\x65\x72\137\x76\x61\154\x69\144\141\x74\x69\157\156\x5f\x64\162\157\x70\x64\x6f\167\156\137\163\143\162\x69\160\164");
    }
    function mo_show_otp_message($zw, $uO)
    {
        new MoDisplayMessages($zw, $uO);
    }
    function otp_load_textdomain()
    {
        load_plugin_textdomain("\x6d\151\x6e\x69\157\x72\x61\156\x67\145\x2d\x6f\164\160\x2d\166\145\162\151\x66\151\143\x61\x74\151\157\156", FALSE, dirname(plugin_basename(__FILE__)) . "\x2f\154\141\x6e\x67\x2f");
        do_action("\155\157\137\x6f\x74\x70\137\166\x65\162\151\x66\151\x63\x61\164\x69\157\x6e\x5f\141\144\x64\x5f\x6f\156\137\154\x61\x6e\x67\x5f\x66\x69\154\145\163");
    }
    private function registerPolylangStrings()
    {
        if (MoUtility::_is_polylang_installed()) {
            goto SCz;
        }
        return;
        SCz:
        foreach (unserialize(MO_POLY_STRINGS) as $j1 => $qL) {
            pll_register_string($j1, $qL, "\155\151\156\151\x6f\162\x61\156\147\145\55\157\164\160\55\x76\145\x72\151\146\151\x63\141\164\151\x6f\x6e");
            RZ0:
        }
        y4A:
    }
    private function registerAddOns()
    {
        $ig = GatewayFunctions::instance();
        $ig->registerAddOns();
    }
    function feedback_request()
    {
        include MOV_DIR . "\x63\157\156\164\x72\x6f\x6c\154\x65\162\x73\57\146\145\145\144\x62\x61\143\x6b\56\x70\150\x70";
    }
    function mo_meta_links($tV, $rf)
    {
        if (!(MOV_PLUGIN_NAME === $rf)) {
            goto aTh;
        }
        $tV[] = "\x3c\x73\x70\141\x6e\40\143\154\141\x73\163\x3d\x27\x64\141\x73\150\151\143\x6f\156\163\40\144\x61\163\x68\151\x63\x6f\x6e\163\x2d\x73\x74\151\143\153\x79\47\x3e\x3c\x2f\x73\x70\141\156\x3e\xd\12\40\x20\40\x20\40\x20\x20\40\x20\x20\40\x20\74\141\40\150\x72\145\146\x3d\47" . MoConstants::FAQ_URL . "\x27\40\x74\141\x72\x67\145\x74\75\x27\137\142\154\141\156\153\47\x3e" . mo_("\106\101\121\163") . "\x3c\57\141\x3e";
        aTh:
        return $tV;
    }
    function plugin_action_links($k3)
    {
        $ve = TabDetails::instance();
        $yO = $ve->_tabDetails[Tabs::FORMS];
        if (!is_plugin_active(MOV_PLUGIN_NAME)) {
            goto iy8;
        }
        $k3 = array_merge(["\x3c\141\x20\x68\162\145\x66\x3d\42" . esc_url(admin_url("\141\144\155\151\x6e\x2e\160\x68\160\77\160\x61\147\x65\x3d" . $yO->_menuSlug)) . "\42\76" . mo_("\123\145\164\x74\x69\x6e\147\163") . "\x3c\x2f\x61\x3e"], $k3);
        iy8:
        return $k3;
    }
    function hourlySync()
    {
        $ig = GatewayFunctions::instance();
        $ig->hourlySync();
    }
    function custom_wp_mail_from_name($BC)
    {
        $ig = GatewayFunctions::instance();
        return $ig->custom_wp_mail_from_name($BC);
    }
}
