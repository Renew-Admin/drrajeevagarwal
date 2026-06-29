<?php


namespace OTP\Handler;

if (defined("\101\102\123\120\101\124\x48")) {
    goto beu;
}
exit;
beu:
use OTP\Helper\CountryList;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MocURLOTP;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseActionHandler;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
use OTP\Traits\Instance;
class MoOTPActionHandlerHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\155\157\x5f\x61\144\x6d\151\x6e\x5f\x61\x63\x74\x69\x6f\x6e\x73";
        add_action("\x61\144\x6d\x69\x6e\x5f\151\156\151\x74", array($this, "\x5f\x68\141\156\x64\x6c\145\x5f\141\144\x6d\151\x6e\x5f\141\143\x74\151\x6f\x6e\x73"), 1);
        add_action("\x61\x64\155\151\x6e\137\x69\156\x69\x74", array($this, "\x6d\157\x53\x63\x68\145\x64\165\154\x65\124\162\141\156\163\141\x63\164\x69\x6f\x6e\x53\x79\x6e\143"), 1);
        add_action("\141\x64\155\x69\x6e\x5f\x69\x6e\x69\x74", array($this, "\x63\150\145\x63\153\x49\146\x50\157\160\x75\160\124\x65\155\160\x6c\141\x74\x65\101\162\145\123\x65\164"), 1);
        add_filter("\x64\141\163\150\x62\x6f\x61\x72\144\x5f\x67\x6c\x61\156\143\x65\137\x69\164\x65\155\x73", array($this, "\157\x74\160\x5f\x74\x72\x61\156\163\x61\x63\x74\x69\157\x6e\163\137\147\154\x61\x6e\x63\x65\x5f\143\x6f\x75\156\164\x65\x72"), 10, 1);
        add_action("\141\x64\x6d\x69\156\137\x70\x6f\163\164\x5f\155\x69\x6e\151\x6f\162\141\x6e\147\x65\137\x67\x65\x74\137\146\157\162\x6d\x5f\144\x65\x74\141\151\154\163", array($this, "\x73\150\x6f\x77\106\x6f\x72\155\110\124\115\x4c\104\x61\x74\x61"));
        add_action("\141\x64\x6d\x69\156\x5f\x70\x6f\x73\164\137\155\x69\156\x69\x6f\162\141\x6e\147\x65\137\x67\145\x74\137\x67\x61\x74\x65\167\x61\x79\137\143\x6f\x6e\x66\x69\147", array($this, "\163\x68\157\x77\107\x61\x74\x65\167\x61\171\103\157\x6e\146\x69\147"));
        add_action("\141\x64\155\x69\x6e\137\156\157\x74\x69\143\x65\x73", array($this, "\x73\x68\x6f\167\116\x6f\x74\151\143\145"));
        add_action("\x77\160\137\141\x6a\x61\170\x5f\x6d\157\x5f\x64\151\x73\x6d\151\x73\163\x5f\156\x6f\x74\x69\x63\x65", array($this, "\x64\x69\163\x6d\151\163\x73\x5f\156\x6f\164\151\x63\x65"));
    }
    function showNotice()
    {
        $Ux = admin_url() . "\141\144\155\151\156\x2e\160\150\160\77\x70\x61\147\x65\75\x70\x72\151\x63\151\x6e\147";
        $Tq = admin_url() . "\x61\x64\155\151\156\56\x70\x68\160\77\160\x61\147\x65\75\x61\x64\144\157\156";
        $mJ = admin_url() . "\x61\x64\155\151\156\x2e\x70\150\160\x3f" . $_SERVER["\x51\x55\105\122\x59\x5f\123\124\x52\111\116\x47"];
        $ES = get_mo_option("\x6d\157\137\x68\x69\x64\145\137\156\157\x74\151\x63\145");
        if (!($ES !== "\x6d\x6f\137\150\x69\144\145\137\156\x6f\164\151\x63\145")) {
            goto bNE;
        }
        if (!(!strcmp(MOV_TYPE, "\x45\156\164\x65\162\x70\162\151\163\x65\x47\x61\164\145\x77\141\171\127\x69\x74\150\101\x64\144\x6f\x6e\x73") !== 0 && $mJ !== $Ux)) {
            goto kTp;
        }
        echo "\x3c\144\x69\x76\40\x63\154\x61\x73\x73\x3d\x22\155\x6f\137\156\x6f\164\x69\143\145\40\x75\x70\144\141\164\145\x64\x20\x6e\157\x74\151\143\145\40\151\163\55\144\x69\x73\x6d\x69\x73\163\151\x62\x6c\x65\x22\40\163\x74\171\x6c\x65\x3d\x22\x70\141\144\144\x69\x6e\147\55\x62\157\164\164\157\155\x3a\40\67\160\170\x3b\142\x61\143\153\147\x72\x6f\165\156\144\55\x63\157\x6c\x6f\x72\72\x23\145\x30\x65\x65\x65\x65\71\71\x3b\42\76\15\12\40\x20\40\40\x20\x20\x20\40\74\x70\40\x73\164\171\154\x65\x20\75\42\146\157\156\x74\x2d\x73\x69\x7a\x65\72\x31\64\x70\x78\x3b\x22\76\74\151\155\x67\x20\163\162\x63\x3d\42" . MOV_FEATURES_GRAPHIC . "\42\x20\143\x6c\x61\x73\x73\75\x22\163\150\157\167\137\155\157\137\x69\143\x6f\x6e\x5f\146\x6f\162\155\42\40\163\164\x79\154\145\75\x22\x77\151\144\x74\x68\x3a\x20\x33\x25\73\155\x61\x72\147\x69\x6e\x2d\x62\x6f\x74\164\x6f\x6d\x3a\x20\55\x31\x25\73\x22\76\46\x65\156\x73\x70\x3b\74\142\x3e\x54\150\x61\156\x6b\40\171\157\165\x20\146\157\x72\x20\143\x68\x6f\x6f\163\x69\156\147\x20\x6d\151\156\151\x4f\x72\141\156\147\x65\40\117\124\120\40\126\145\162\x69\146\151\x63\x61\x74\x69\157\156\56\74\142\162\x3e\74\x62\162\76\x57\151\164\150\40\123\165\160\x70\157\162\x74\40\146\157\162\40\120\141\163\x73\167\x6f\x72\144\x6c\114\x65\x73\163\40\114\157\147\151\x6e\x2c\40\x41\154\160\x68\141\116\x75\155\x65\162\x69\x63\x20\x4f\x54\120\40\x2c\40\123\145\x6c\x65\143\164\145\x64\x20\103\157\x75\x6e\164\x72\x79\x20\126\145\x72\x69\x66\x69\x63\x61\x74\151\157\x6e\54\40\x50\x61\x73\163\x77\157\162\144\x20\122\x65\x73\x65\164\40\x76\151\141\x20\x4f\124\x50\40\141\156\x64\40\x6d\141\156\x79\x20\x6d\157\162\145\x2e\74\142\162\x3e\40\101\x72\145\x20\171\x6f\165\x20\154\157\157\x6b\x69\156\x67\40\146\x6f\162\x20\127\x6f\x6f\x43\157\155\x6d\x65\x72\x63\x65\x20\123\115\123\40\116\157\x74\151\146\151\143\141\x74\x69\157\156\163\40\146\157\x72\40\101\x64\155\151\x6e\x73\54\40\126\145\x6e\x64\x6f\x72\x73\40\x26\x20\x43\165\163\164\157\155\x65\162\163\x3f\40\x3c\x73\x74\162\157\156\x67\x3e\x43\x68\145\143\x6b\x20\x69\x74\x20\157\165\x74\x20\150\145\x72\145\40\x3c\141\x20\150\162\145\x66\75" . $Tq . "\x3e\127\157\157\x43\157\155\155\x65\162\143\x65\x20\117\x72\x64\145\x72\40\x53\x4d\123\x20\x4e\157\164\151\x66\x69\x63\x61\x74\x69\x6f\156\x73\x3c\x2f\141\x3e\56\x3c\57\163\x74\x72\157\156\x67\76\74\142\162\76\74\142\162\x3e\101\127\x53\x20\123\116\123\x2c\40\124\x77\x69\x6c\x69\x6f\x20\x47\141\x74\145\x77\x61\171\x20\46\x20\x6d\157\x72\145\x20\147\x61\x74\x65\167\x61\x79\x73\x20\x73\x75\x70\x70\x6f\x72\x74\x65\144\41\xd\xa\40\40\40\x20\x20\x20\40\40\74\x62\162\76\x57\141\156\x74\40\x74\x6f\40\x6b\156\157\167\40\155\157\162\x65\77\40\103\150\x65\143\153\40\151\164\40\157\165\x74\x20\x68\145\162\x65\x20\x3a\x20\74\141\40\x68\x72\145\146\75" . $Ux . "\x3e\120\154\141\156\40\104\x65\x74\141\151\x6c\x73\x3c\x2f\141\x3e\56\x3c\x2f\142\76\x3c\57\x70\x3e\xd\12\x20\x20\x20\x20\40\x20\40\x20\40\74\x2f\x64\x69\x76\76";
        kTp:
        bNE:
    }
    function dismiss_notice()
    {
        update_mo_option("\x6d\157\137\150\x69\x64\x65\x5f\x6e\157\x74\151\143\145", "\155\x6f\x5f\150\151\x64\145\137\x6e\157\164\151\143\145");
    }
    function _handle_admin_actions()
    {
        if (isset($_POST["\x6f\160\164\x69\157\156"])) {
            goto FA3;
        }
        return;
        FA3:
        switch ($_POST["\157\160\164\151\x6f\156"]) {
            case "\x6d\x6f\137\143\x75\x73\164\157\x6d\x65\162\137\166\141\x6c\x69\x64\141\164\x69\157\156\137\x73\x65\x74\x74\151\x6e\x67\x73":
                $this->_save_settings($_POST);
                goto vPh;
            case "\155\157\x5f\x63\165\x73\164\157\x6d\145\162\x5f\x76\x61\x6c\151\x64\141\164\x69\157\x6e\x5f\x6d\145\x73\x73\141\x67\x65\x73":
                $this->_handle_custom_messages_form_submit($_POST);
                goto vPh;
            case "\155\157\137\166\x61\154\x69\144\141\x74\151\157\x6e\137\143\157\156\x74\x61\x63\x74\137\x75\x73\x5f\161\165\x65\x72\171\137\x6f\x70\164\x69\x6f\156":
                $this->_mo_validation_support_query($_POST);
                goto vPh;
            case "\155\157\x5f\x6f\164\x70\x5f\x65\x78\164\x72\141\x5f\163\145\164\164\151\156\147\x73":
                $this->_save_extra_settings($_POST);
                goto vPh;
            case "\x6d\157\137\x6f\x74\x70\x5f\146\x65\145\x64\x62\141\143\153\137\x6f\160\164\151\x6f\x6e":
                $this->_mo_validation_feedback_query();
                goto vPh;
            case "\x63\x68\x65\x63\153\137\x6d\157\x5f\x6c\x6e":
                $this->_mo_check_l();
                goto vPh;
            case "\x6d\157\137\143\x68\x65\x63\x6b\137\x74\162\141\x6e\163\141\x63\164\151\x6f\x6e\163":
                $this->_mo_check_transactions();
                goto vPh;
            case "\x6d\x6f\137\143\x75\x73\164\x6f\x6d\x65\162\137\x76\141\x6c\151\x64\x61\x74\x69\157\x6e\137\x73\x6d\163\137\143\157\156\x66\x69\147\x75\x72\x61\x74\x69\x6f\x6e":
                $this->_mo_configure_sms_template($_POST);
                goto vPh;
            case "\x6d\x6f\137\x63\165\x73\164\157\x6d\145\162\137\x76\141\x6c\151\144\141\164\x69\157\156\137\x65\155\141\x69\x6c\x5f\x63\x6f\156\146\x69\x67\x75\x72\x61\x74\151\x6f\x6e":
                $this->_mo_configure_email_template($_POST);
                goto vPh;
            case "\155\157\x5f\x63\165\x73\164\x6f\x6d\145\x72\137\143\165\163\164\157\155\151\x7a\x61\x74\x69\x6f\x6e\x5f\x66\x6f\162\x6d":
                $this->_mo_configure_custom_form($_POST);
                goto vPh;
        }
        smS:
        vPh:
    }
    function _mo_configure_custom_form($post)
    {
        $this->isValidRequest();
        update_mo_option("\x63\146\137\x73\165\x62\x6d\151\164\137\x69\x64", MoUtility::sanitizeCheck("\143\146\137\163\x75\x62\155\151\x74\x5f\151\x64", $post), "\x6d\157\x5f\157\x74\160\x5f");
        update_mo_option("\x63\x66\137\x66\151\x65\x6c\144\137\x69\144", MoUtility::sanitizeCheck("\143\146\137\146\151\145\x6c\x64\137\151\144", $post), "\155\x6f\x5f\x6f\x74\160\137");
        update_mo_option("\x63\x66\x5f\x65\x6e\x61\142\x6c\145\137\x74\171\x70\x65", MoUtility::sanitizeCheck("\143\x66\137\x65\156\x61\x62\x6c\x65\137\164\171\160\x65", $post), "\x6d\x6f\137\x6f\164\x70\x5f");
        update_mo_option("\143\146\x5f\x62\x75\x74\x74\157\156\x5f\x74\145\170\164", MoUtility::sanitizeCheck("\143\146\137\x62\x75\164\x74\x6f\156\137\164\145\x78\164", $post), "\x6d\x6f\137\x6f\164\x70\137");
    }
    function _handle_custom_messages_form_submit($post)
    {
        $this->isValidRequest();
        update_mo_option("\x73\x75\143\x63\x65\x73\163\x5f\x65\155\141\x69\154\137\x6d\145\163\x73\141\147\x65", MoUtility::sanitizeCheck("\157\164\160\x5f\163\x75\143\143\x65\163\x73\x5f\145\155\x61\151\x6c", $post), "\155\x6f\x5f\x6f\164\160\x5f");
        update_mo_option("\x73\x75\143\143\145\x73\163\x5f\x70\x68\x6f\156\145\x5f\155\145\163\163\141\x67\x65", MoUtility::sanitizeCheck("\x6f\x74\160\137\x73\165\143\x63\x65\163\163\x5f\x70\x68\157\x6e\x65", $post), "\x6d\157\137\157\164\160\x5f");
        update_mo_option("\145\162\x72\x6f\x72\137\160\150\157\156\145\x5f\155\145\x73\x73\x61\147\145", MoUtility::sanitizeCheck("\157\x74\x70\x5f\x65\x72\x72\x6f\162\137\x70\150\157\156\145", $post), "\155\x6f\x5f\157\164\160\x5f");
        update_mo_option("\x65\x72\x72\x6f\162\x5f\x65\x6d\141\x69\x6c\x5f\x6d\x65\163\163\x61\147\x65", MoUtility::sanitizeCheck("\157\x74\160\x5f\x65\162\x72\x6f\x72\137\145\155\141\151\154", $post), "\x6d\157\137\x6f\164\x70\x5f");
        update_mo_option("\x69\156\x76\141\154\151\144\137\160\x68\157\156\145\137\155\145\163\x73\141\x67\145", MoUtility::sanitizeCheck("\x6f\164\x70\137\151\156\166\x61\x6c\151\144\137\x70\150\157\x6e\145", $post), "\x6d\x6f\x5f\x6f\x74\x70\137");
        update_mo_option("\151\156\x76\x61\154\x69\144\x5f\x65\155\141\151\154\x5f\155\145\x73\163\141\147\145", MoUtility::sanitizeCheck("\157\x74\160\x5f\x69\x6e\166\x61\154\151\144\137\145\155\x61\x69\x6c", $post), "\x6d\157\x5f\157\164\160\x5f");
        update_mo_option("\151\156\x76\x61\x6c\151\x64\137\x6d\145\x73\x73\141\147\145", MoUtility::sanitizeCheck("\x69\156\166\141\154\151\x64\137\157\x74\160", $post), "\155\x6f\137\x6f\164\160\137");
        update_mo_option("\142\154\157\x63\153\145\x64\x5f\145\155\x61\151\x6c\x5f\x6d\x65\x73\163\141\x67\145", MoUtility::sanitizeCheck("\x6f\164\x70\x5f\x62\154\x6f\x63\x6b\145\144\137\145\155\x61\x69\154", $post), "\x6d\x6f\x5f\157\x74\x70\x5f");
        update_mo_option("\x62\x6c\157\143\x6b\145\144\137\x70\150\157\x6e\145\137\x6d\145\x73\163\141\147\x65", MoUtility::sanitizeCheck("\x6f\164\160\x5f\x62\154\x6f\143\153\x65\x64\137\x70\x68\157\x6e\x65", $post), "\155\157\x5f\157\x74\160\x5f");
        do_action("\155\157\137\x72\145\147\151\163\x74\x72\141\164\151\x6f\156\137\x73\x68\x6f\167\x5f\155\145\163\x73\x61\x67\145", MoMessages::showMessage(MoMessages::MSG_TEMPLATE_SAVED), "\123\x55\x43\103\105\x53\123");
    }
    public function _mo_configure_whatsapp($kB)
    {
        if (empty($kB["\x6d\x6f\137\x77\x68\x61\164\163\141\160\x70\x5f\x63\x6f\144\x65"]) || empty($kB["\155\157\137\167\x68\x61\x74\163\x61\160\x70\x5f\x69\x6e\x73\164\141\x6e\143\145"])) {
            goto jVC;
        }
        update_mo_option("\155\x6f\x5f\x77\x68\x61\164\163\141\160\160\x5f\x63\157\144\145", MoUtility::sanitizeCheck("\x6d\157\137\x77\x68\141\x74\x73\x61\160\160\x5f\143\x6f\x64\145", $kB));
        update_mo_option("\x6d\x6f\137\167\150\141\x74\163\x61\x70\160\137\151\156\163\164\141\156\x63\145", MoUtility::sanitizeCheck("\x6d\x6f\x5f\x77\150\141\x74\163\141\x70\160\x5f\151\x6e\x73\164\141\156\x63\x65", $kB));
        $aU = MocURLOTP::mo_whatsapp_create_instance($kB["\x6d\157\137\167\150\141\x74\x73\x61\160\160\x5f\143\154\x69\145\x6e\x74\x49\104"], $kB["\x6d\x6f\137\167\150\x61\x74\x73\141\x70\x70\x5f\143\x6f\144\x65"], $kB["\155\x6f\x5f\x77\x68\141\x74\163\141\x70\160\x5f\151\x6e\163\164\x61\156\x63\x65"]);
        if ($aU->status == "\x66\x61\x6c\163\145") {
            goto ppY;
        }
        update_mo_option("\x6d\x6f\x5f\x77\x68\141\x74\x73\x61\160\x70\x5f\151\156\x73\x74\x61\156\x63\x65\x5f\151\144", $aU->data);
        do_action("\155\x6f\x5f\162\x65\x67\x69\x73\164\x72\x61\x74\x69\157\156\137\163\150\x6f\167\x5f\155\145\163\x73\141\x67\x65", $aU->message, "\123\x55\x43\103\105\x53\123");
        return;
        goto tEm;
        ppY:
        do_action("\155\x6f\137\x72\x65\x67\151\163\164\162\141\164\151\x6f\x6e\x5f\163\150\x6f\x77\x5f\x6d\x65\163\163\x61\147\145", $aU->message, "\105\x52\122\117\122");
        return;
        tEm:
        goto lHx;
        jVC:
        do_action("\155\x6f\137\x72\145\147\151\163\164\162\141\x74\151\x6f\156\137\163\x68\157\x77\x5f\155\145\x73\x73\x61\147\x65", "\120\x6c\145\x61\163\x65\x20\145\156\x74\x65\162\x20\164\150\145\40\166\x61\x6c\151\x64\40\127\150\141\x74\x73\141\160\160\x20\x43\157\144\145\x20\141\x6e\144\40\111\156\163\164\x61\156\x63\x65\40\x4e\141\155\145\x2e", "\105\x52\x52\117\x52");
        return;
        lHx:
    }
    public function _mo_whatsapp_status($kB)
    {
        $kY = get_mo_option("\x6d\x6f\137\x77\x68\141\164\163\141\x70\160\137\151\x6e\x73\x74\141\156\143\x65\x5f\151\144");
        $aU = MocURLOTP::mo_whatsapp_check_status($kB["\x6d\157\x5f\167\150\x61\164\163\141\160\x70\137\x63\154\x69\x65\156\164\x49\104"], $kY);
        do_action("\x6d\x6f\x5f\x72\145\x67\151\x73\x74\162\141\164\x69\157\156\x5f\x73\150\x6f\167\x5f\155\x65\163\163\141\x67\145", $aU->message, "\116\117\124\111\103\105");
        return;
    }
    public function _mo_whatsapp_reconnect($kB)
    {
        $kY = get_mo_option("\155\157\x5f\167\x68\141\x74\x73\141\160\160\x5f\151\x6e\x73\x74\x61\x6e\x63\x65\137\x69\144");
        $aU = MocURLOTP::mo_whatsapp_reconnect($kB["\x6d\x6f\x5f\167\x68\x61\164\x73\141\160\160\x5f\x63\154\x69\145\156\164\111\x44"], $kY);
        do_action("\155\x6f\x5f\x72\x65\147\x69\163\x74\x72\x61\164\151\157\x6e\x5f\163\x68\x6f\x77\x5f\155\145\163\163\141\x67\145", $aU->message, "\x4e\x4f\x54\x49\x43\x45");
        return;
    }
    function _save_settings($kB)
    {
        $ve = TabDetails::instance();
        $yO = $ve->_tabDetails[Tabs::FORMS];
        $this->isValidRequest();
        if (!(MoUtility::sanitizeCheck("\160\x61\x67\x65", $_GET) !== $yO->_menuSlug && sanitize_text_field($kB["\145\162\x72\x6f\x72\x5f\155\x65\163\163\141\147\145"]))) {
            goto NEA;
        }
        do_action("\155\x6f\x5f\162\145\x67\151\163\x74\162\x61\x74\151\157\x6e\137\x73\150\x6f\x77\x5f\155\145\x73\163\x61\x67\x65", MoMessages::showMessage(sanitize_text_field($kB["\x65\162\162\x6f\162\137\x6d\145\x73\x73\x61\x67\x65"])), "\105\122\x52\117\x52");
        NEA:
    }
    function _save_extra_settings($kB)
    {
        $this->isValidRequest();
        delete_site_option("\x64\x65\x66\x61\x75\x6c\164\x5f\143\x6f\x75\x6e\164\x72\x79\137\143\157\x64\x65");
        $y5 = isset($kB["\x64\145\146\x61\165\x6c\x74\x5f\x63\x6f\165\x6e\x74\x72\171\x5f\143\x6f\x64\x65"]) ? sanitize_text_field($kB["\x64\145\146\x61\x75\x6c\164\x5f\143\157\x75\x6e\164\162\x79\x5f\143\x6f\144\x65"]) : '';
        update_mo_option("\x64\x65\x66\x61\x75\x6c\164\137\x63\x6f\x75\x6e\x74\162\171", maybe_serialize(CountryList::$countries[$y5]));
        update_mo_option("\x62\154\x6f\x63\153\145\x64\137\144\x6f\x6d\x61\151\156\x73", MoUtility::sanitizeCheck("\155\x6f\x5f\157\x74\x70\137\x62\x6c\157\143\x6b\145\x64\137\145\155\141\151\x6c\137\x64\x6f\155\x61\x69\156\163", $kB));
        update_mo_option("\x62\x6c\x6f\x63\x6b\145\144\137\160\x68\157\156\145\137\x6e\165\x6d\x62\145\x72\x73", MoUtility::sanitizeCheck("\x6d\x6f\x5f\157\164\x70\x5f\142\154\x6f\143\x6b\145\x64\x5f\x70\x68\x6f\x6e\145\x5f\156\165\x6d\x62\x65\162\163", $kB));
        update_mo_option("\163\x68\157\167\137\x72\x65\x6d\x61\151\156\x69\x6e\147\x5f\164\x72\x61\x6e\163", MoUtility::sanitizeCheck("\155\157\137\163\150\x6f\x77\137\162\145\x6d\141\151\156\x69\156\147\x5f\x74\x72\x61\x6e\163", $kB));
        update_mo_option("\x73\150\157\167\x5f\144\x72\x6f\160\144\x6f\167\x6e\137\x6f\x6e\x5f\146\157\162\x6d", MoUtility::sanitizeCheck("\163\150\x6f\x77\137\144\x72\157\160\144\x6f\x77\156\x5f\157\156\x5f\x66\157\x72\155", $kB));
        update_mo_option("\x6f\x74\x70\137\x6c\x65\x6e\x67\164\150", MoUtility::sanitizeCheck("\x6d\x6f\137\157\x74\x70\x5f\154\x65\x6e\147\164\x68", $kB));
        update_mo_option("\x6f\x74\160\137\x76\141\x6c\151\144\151\x74\171", MoUtility::sanitizeCheck("\x6d\157\137\x6f\x74\x70\x5f\x76\141\154\151\144\151\164\x79", $kB));
        update_mo_option("\147\145\x6e\145\x72\x61\164\145\x5f\x61\x6c\160\x68\x61\x6e\x75\155\x65\162\151\143\x5f\157\x74\x70", MoUtility::sanitizeCheck("\x6d\x6f\x5f\147\145\x6e\x65\162\x61\x74\145\x5f\x61\x6c\x70\150\x61\x6e\165\155\x65\162\151\x63\x5f\x6f\164\x70", $kB));
        update_mo_option("\147\x6c\157\142\x61\154\x6c\171\x5f\x62\x61\x6e\156\145\144\x5f\160\x68\x6f\156\x65", MoUtility::sanitizeCheck("\155\157\137\x67\x6c\x6f\x62\141\154\154\171\137\x62\x61\x6e\156\x65\144\x5f\x70\x68\157\156\145", $kB));
        update_mo_option("\x6d\141\x73\164\145\162\157\x74\160\x5f\x76\141\154\x69\x64\151\164\x79", MoUtility::sanitizeCheck("\155\x6f\137\x6d\141\x73\x74\145\x72\157\x74\160\137\x76\141\x6c\x69\x64\x69\164\x79", $kB));
        update_mo_option("\155\141\163\164\x65\x72\157\x74\x70\137\141\x64\155\x69\x6e", MoUtility::sanitizeCheck("\155\157\137\155\141\x73\x74\x65\x72\157\164\x70\x5f\x61\x64\x6d\151\156", $kB));
        update_mo_option("\155\x61\163\164\145\162\x6f\x74\x70\x5f\x75\x73\145\162", MoUtility::sanitizeCheck("\x6d\157\x5f\155\141\163\x74\x65\x72\x6f\164\x70\137\165\x73\145\162", $kB));
        update_mo_option("\x6d\141\x73\164\x65\x72\x6f\164\x70\137\141\x64\155\x69\156\x73", MoUtility::sanitizeCheck("\155\157\x5f\155\141\x73\164\x65\162\x6f\x74\160\137\141\144\155\151\x6e\x73", $kB));
        update_mo_option("\x6d\x61\163\164\145\x72\157\x74\x70\137\163\x70\x65\x63\x69\146\x69\x63\137\x75\163\145\x72", MoUtility::sanitizeCheck("\x6d\157\137\155\x61\x73\164\145\162\x6f\x74\160\137\x73\x70\145\x63\x69\146\151\143\137\x75\163\x65\x72", $kB));
        update_mo_option("\x6d\141\x73\164\145\162\157\164\x70\137\x73\160\x65\x63\x69\146\151\143\137\x75\x73\x65\x72\x5f\144\x65\x74\x61\151\x6c\x73", MoUtility::sanitizeCheck("\155\141\x73\164\x65\x72\157\164\160\137\163\x70\x65\x63\x69\x66\x69\143\137\165\x73\x65\162\x5f\x64\145\x74\141\151\x6c\x73", $kB));
        do_action("\x6d\157\137\162\145\x67\151\x73\x74\x72\x61\164\x69\x6f\156\137\163\x68\x6f\167\x5f\x6d\x65\163\163\141\x67\x65", MoMessages::showMessage(MoMessages::EXTRA_SETTINGS_SAVED), "\x53\125\103\x43\105\123\123");
    }
    function _mo_validation_support_query($r9)
    {
        $mo = MoUtility::sanitizeCheck("\x71\165\x65\x72\171\137\x65\155\141\151\x6c", $r9);
        $KI = MoUtility::sanitizeCheck("\161\x75\145\162\171", $r9);
        $Dk = MoUtility::sanitizeCheck("\x71\x75\145\162\171\137\x70\150\x6f\x6e\145", $r9);
        if (!(!$mo || !$KI)) {
            goto Vgx;
        }
        do_action("\x6d\x6f\x5f\162\x65\x67\151\x73\x74\162\141\164\x69\x6f\156\x5f\163\150\157\x77\137\x6d\145\x73\x73\141\147\x65", MoMessages::showMessage(MoMessages::SUPPORT_FORM_VALUES), "\x45\x52\x52\x4f\x52");
        return;
        Vgx:
        $Dd = MocURLOTP::submit_contact_us($mo, $Dk, $KI);
        if (!(json_last_error() == JSON_ERROR_NONE && $Dd)) {
            goto a8P;
        }
        do_action("\x6d\157\x5f\x72\x65\147\x69\x73\164\x72\x61\x74\151\x6f\156\x5f\163\150\157\x77\x5f\x6d\x65\x73\x73\x61\x67\x65", MoMessages::showMessage(MoMessages::SUPPORT_FORM_SENT), "\x53\125\x43\103\105\x53\x53");
        return;
        a8P:
        do_action("\x6d\157\x5f\x72\x65\147\151\163\164\162\141\x74\x69\157\x6e\137\163\x68\157\x77\137\x6d\x65\163\x73\x61\147\x65", MoMessages::showMessage(MoMessages::SUPPORT_FORM_ERROR), "\105\x52\x52\x4f\122");
    }
    public function otp_transactions_glance_counter()
    {
        if (!(!MoUtility::micr() || !MoUtility::isMG())) {
            goto ea5;
        }
        return;
        ea5:
        $mo = get_mo_option("\145\x6d\x61\x69\x6c\x5f\x74\162\x61\x6e\163\141\x63\164\151\157\x6e\x73\x5f\x72\145\155\141\x69\x6e\x69\156\x67");
        $Dk = get_mo_option("\x70\x68\x6f\x6e\x65\x5f\x74\x72\x61\156\163\x61\143\x74\151\x6f\x6e\163\x5f\x72\x65\155\x61\x69\156\x69\x6e\147");
        echo "\74\x6c\x69\40\x63\x6c\x61\163\x73\75\x27\x6d\157\55\x74\162\141\x6e\163\x2d\143\x6f\165\x6e\164\47\76\x3c\x61\x20\x68\162\x65\146\x3d\47" . admin_url() . "\141\x64\x6d\151\x6e\56\160\150\160\x3f\160\x61\x67\x65\75\155\157\163\145\164\164\x69\156\147\x73\x27\76" . MoMessages::showMessage(MoMessages::TRANS_LEFT_MSG, array("\145\155\x61\151\154" => $mo, "\x70\150\157\x6e\145" => $Dk)) . "\x3c\57\x61\x3e\x3c\57\x6c\x69\76";
    }
    public function checkIfPopupTemplateAreSet()
    {
        $JS = maybe_unserialize(get_mo_option("\x63\x75\x73\164\x6f\155\137\160\157\160\x75\x70\x73"));
        if (!empty($JS)) {
            goto Zt7;
        }
        $oQ = apply_filters("\x6d\x6f\137\164\x65\x6d\x70\154\141\164\x65\137\144\x65\x66\141\x75\154\164\x73", array());
        update_mo_option("\x63\165\163\164\157\x6d\137\160\157\x70\x75\160\163", maybe_serialize($oQ));
        Zt7:
    }
    public function showFormHTMLData()
    {
        $this->isValidRequest();
        $Jy = sanitize_text_field($_POST["\146\x6f\x72\155\137\156\x61\x6d\145"]);
        $eL = MOV_DIR . "\143\157\x6e\x74\x72\157\x6c\x6c\145\162\163\x2f";
        $m5 = !MoUtility::micr() ? "\x64\x69\163\x61\142\x6c\x65\144" : '';
        $Mx = admin_url() . "\x65\144\x69\164\x2e\160\x68\160\x3f\x70\x6f\163\x74\137\x74\x79\x70\145\75\x70\141\x67\145";
        ob_start();
        include $eL . "\146\157\162\x6d\163\57" . $Jy . "\x2e\160\150\x70";
        $Dy = ob_get_clean();
        wp_send_json(MoUtility::createJson($Dy, MoConstants::SUCCESS_JSON_TYPE));
    }
    public function showGatewayConfig()
    {
        $this->isValidRequest();
        $jO = $_POST["\x67\141\x74\x65\x77\141\x79\x5f\x74\x79\x70\x65"];
        $nk = "\117\124\120\134\x48\x65\x6c\160\x65\x72\x5c\107\141\164\x65\167\141\x79\x5c" . $jO;
        $m5 = !MoUtility::micr() ? "\x64\x69\x73\x61\142\x6c\x65\x64" : '';
        $j_ = get_mo_option("\143\165\163\164\x6f\x6d\x5f\163\x6d\163\137\147\141\x74\145\x77\x61\x79") ? get_mo_option("\143\x75\x73\164\x6f\x6d\137\163\x6d\x73\137\x67\x61\x74\145\167\141\171") : '';
        $oj = $nk::instance()->getGatewayConfigView($m5, $j_);
        wp_send_json(MoUtility::createJson($oj, MoConstants::SUCCESS_JSON_TYPE));
    }
    function moScheduleTransactionSync()
    {
        if (!(!wp_next_scheduled("\150\x6f\165\x72\154\171\x53\x79\156\x63") && MoUtility::micr())) {
            goto ZxX;
        }
        wp_schedule_event(time(), "\144\141\x69\154\171", "\x68\157\x75\x72\154\171\123\x79\x6e\143");
        ZxX:
    }
    function _mo_validation_feedback_query()
    {
        $this->isValidRequest();
        $yq = sanitize_text_field($_POST["\155\151\x6e\151\x6f\x72\141\156\147\x65\x5f\x66\145\x65\144\x62\x61\x63\x6b\x5f\x73\165\142\155\151\x74"]);
        if (!($yq === "\123\x6b\151\160\40\46\x20\104\145\x61\143\x74\x69\166\141\164\145")) {
            goto FFU;
        }
        deactivate_plugins([MOV_PLUGIN_NAME]);
        delete_mo_option("\155\x6f\137\150\151\x64\145\137\156\x6f\x74\151\x63\145");
        return;
        FFU:
        $PG = strcasecmp(sanitize_text_field($_POST["\160\154\x75\147\151\156\x5f\144\145\x61\x63\164\151\x76\x61\164\145\x64"]), "\x74\162\x75\145") == 0;
        $uO = !$PG ? mo_("\x5b\40\x50\154\x75\x67\151\x6e\40\x46\145\x65\144\x62\x61\x63\x6b\x20\x5d\x20\x3a\40") : mo_("\x5b\40\120\x6c\165\147\x69\x6e\40\104\x65\141\143\164\x69\x76\141\x74\145\144\40\135");
        $No = sanitize_text_field($_POST["\161\165\x65\162\171\137\x66\x65\145\x64\142\x61\x63\153"]);
        $Br = file_get_contents(MOV_DIR . "\x69\x6e\143\x6c\165\144\145\163\x2f\x68\x74\155\x6c\x2f\x66\145\x65\144\x62\x61\x63\153\56\x6d\151\156\56\150\x74\x6d\x6c");
        $current_user = wp_get_current_user();
        $nu = MoUtility::micv() ? "\x50\x72\x65\x6d\151\x75\x6d" : "\106\x72\145\x65";
        $mo = get_mo_option("\141\x64\155\x69\156\x5f\145\155\x61\151\x6c");
        $Wd = get_mo_option("\x70\x6c\165\x67\x69\x6e\x5f\141\143\164\151\166\x61\164\151\x6f\156\137\x64\141\164\x65");
        $tF = round((strtotime(date("\x59\55\x6d\x2d\144\40\150\x3a\x69\x3a\163\141")) - strtotime($Wd)) / (60 * 60 * 24));
        $CM = "\x3c\142\162\x3e\x3c\142\162\x3e\x44\x61\x79\x73\40\x73\x69\x6e\x63\x65\40\x41\143\x74\x69\166\141\x74\145\x64\x3a\40" . $tF;
        $Br = str_replace("\173\173\x46\111\x52\x53\x54\x5f\116\x41\115\105\175\x7d", $current_user->first_name, $Br);
        $Br = str_replace("\x7b\173\x4c\101\123\124\x5f\116\101\x4d\105\175\x7d", $current_user->last_name, $Br);
        $Br = str_replace("\173\x7b\x50\x4c\x55\107\x49\116\x5f\124\x59\x50\x45\x7d\x7d", MOV_TYPE . "\x3a" . $nu . $CM, $Br);
        $Br = str_replace("\173\173\123\105\x52\126\105\x52\x7d\175", $_SERVER["\x53\x45\x52\x56\105\x52\x5f\x4e\x41\115\x45"], $Br);
        $Br = str_replace("\x7b\173\105\x4d\101\111\114\175\x7d", $mo, $Br);
        $Br = str_replace("\x7b\173\120\114\125\x47\x49\x4e\175\175", MoConstants::AREA_OF_INTEREST, $Br);
        $Br = str_replace("\173\173\126\105\x52\x53\111\117\x4e\x7d\175", MOV_VERSION, $Br);
        $Br = str_replace("\173\173\x54\x59\x50\105\x7d\x7d", $uO, $Br);
        $Br = str_replace("\x7b\173\x46\105\105\x44\102\101\x43\113\x7d\175", $No, $Br);
        $Tl = MoUtility::send_email_notif($mo, "\130\x65\143\165\162\x69\146\171", MoConstants::FEEDBACK_EMAIL, "\x57\x6f\x72\x64\120\x72\x65\163\163\x20\x4f\124\120\x20\x56\145\x72\x69\146\x69\143\x61\x74\151\157\x6e\x20\120\154\165\x67\151\156\x20\x46\145\x65\144\x62\141\143\x6b", $Br);
        if ($Tl) {
            goto W3w;
        }
        do_action("\155\x6f\x5f\x72\145\x67\x69\x73\164\x72\141\x74\x69\157\x6e\x5f\163\150\x6f\x77\137\x6d\145\x73\163\141\147\x65", MoMessages::showMessage(MoMessages::FEEDBACK_ERROR), "\105\x52\x52\x4f\122");
        goto xKj;
        W3w:
        do_action("\x6d\157\x5f\162\145\x67\x69\x73\164\x72\141\x74\151\157\x6e\137\163\150\157\x77\137\x6d\x65\x73\163\141\x67\x65", MoMessages::showMessage(MoMessages::FEEDBACK_SENT), "\123\125\103\103\105\123\x53");
        xKj:
        if (!$PG) {
            goto EsS;
        }
        deactivate_plugins([MOV_PLUGIN_NAME]);
        EsS:
        delete_mo_option("\x6d\x6f\137\150\151\144\145\x5f\x6e\157\164\151\143\145");
    }
    function _mo_check_transactions()
    {
        if (!(!empty($_POST) && check_admin_referer("\x6d\157\137\x63\x68\x65\x63\153\x5f\x74\x72\141\x6e\x73\141\x63\x74\x69\157\x6e\163\x5f\146\x6f\162\x6d", "\137\x6e\x6f\156\x63\145"))) {
            goto Pcx;
        }
        MoUtility::_handle_mo_check_ln(true, get_mo_option("\141\144\155\x69\156\137\x63\x75\x73\164\x6f\155\x65\x72\x5f\153\145\x79"), get_mo_option("\x61\144\155\x69\156\137\141\x70\x69\x5f\x6b\145\171"));
        Pcx:
    }
    function _mo_check_l()
    {
        $this->isValidRequest();
        MoUtility::_handle_mo_check_ln(true, get_mo_option("\141\144\155\x69\x6e\x5f\143\x75\x73\x74\x6f\155\145\162\x5f\x6b\145\171"), get_mo_option("\141\x64\155\151\x6e\137\141\x70\x69\137\x6b\x65\x79"));
    }
    function _mo_configure_sms_template($kB)
    {
        if (isset($kB["\x6d\157\137\143\165\x73\x74\x6f\x6d\145\x72\x5f\x76\141\x6c\151\144\x61\x74\151\157\156\137\143\165\x73\x74\x6f\155\x5f\x73\155\x73\x5f\x67\x61\x74\x65\x77\141\171"]) && empty(sanitize_text_field($kB["\155\157\137\143\165\x73\164\157\155\x65\x72\137\166\x61\x6c\151\x64\x61\164\x69\157\156\x5f\x63\x75\x73\164\157\x6d\x5f\163\x6d\163\137\x67\x61\164\x65\x77\x61\x79"]))) {
            goto KC7;
        }
        do_action("\155\x6f\137\x72\x65\147\x69\163\164\x72\x61\164\x69\x6f\x6e\x5f\x73\150\x6f\167\137\155\x65\163\163\141\147\x65", MoMessages::showMessage(MoMessages::SMS_TEMPLATE_SAVED), "\x53\125\103\103\x45\x53\x53");
        goto wGu;
        KC7:
        do_action("\155\157\137\162\x65\147\151\x73\164\162\141\x74\x69\x6f\x6e\x5f\x73\x68\157\167\x5f\x6d\145\x73\x73\141\x67\x65", MoMessages::showMessage(MoMessages::SMS_TEMPLATE_ERROR), "\105\x52\122\117\122");
        wGu:
        $ig = GatewayFunctions::instance();
        $ig->_mo_configure_sms_template($kB);
    }
    function _mo_configure_email_template($kB)
    {
        $ig = GatewayFunctions::instance();
        $ig->_mo_configure_email_template($kB);
    }
}
