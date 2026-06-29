<?php


namespace OTP\Addons\WcSMSNotification;

use OTP\Addons\WcSMSNotification\Handler\WooCommerceNotifications;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\WooCommerceNotificationsList;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\101\x42\x53\x50\x41\x54\110")) {
    goto jz;
}
exit;
jz:
include "\137\x61\165\x74\x6f\154\x6f\141\x64\x2e\160\x68\x70";
final class WooCommerceSmsNotification extends BaseAddon implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\x61\144\155\151\x6e\x5f\x65\x6e\161\165\x65\x75\145\137\163\143\x72\151\x70\x74\x73", array($this, "\x6d\157\x5f\x73\155\163\137\156\157\164\151\x66\x5f\163\x65\x74\164\x69\x6e\x67\163\137\163\164\x79\x6c\145"));
        add_action("\141\144\x6d\151\156\137\145\156\x71\x75\145\x75\x65\137\x73\143\162\x69\x70\164\x73", array($this, "\x6d\157\x5f\x73\x6d\x73\137\x6e\157\164\151\x66\x5f\x73\x65\x74\x74\151\156\147\163\137\x73\x63\162\151\x70\164"));
        add_action("\x6d\157\137\x6f\164\160\x5f\x76\x65\162\x69\x66\151\143\141\x74\x69\157\x6e\137\144\145\x6c\x65\164\x65\x5f\141\x64\x64\157\x6e\137\157\160\x74\x69\x6f\156\163", array($this, "\155\157\x5f\163\x6d\163\x5f\156\x6f\164\x69\x66\137\144\x65\x6c\145\164\x65\x5f\x6f\160\164\x69\157\156\163"));
    }
    function mo_sms_notif_settings_style()
    {
        wp_enqueue_style("\155\157\137\163\x6d\x73\x5f\156\x6f\x74\151\x66\137\141\144\x6d\151\156\137\x73\x65\164\164\151\156\147\163\x5f\x73\x74\x79\x6c\145", MSN_CSS_URL);
    }
    function mo_sms_notif_settings_script()
    {
        wp_register_script("\155\x6f\137\163\155\x73\137\156\x6f\164\151\x66\137\x61\x64\x6d\151\x6e\137\163\145\x74\x74\x69\x6e\x67\163\137\x73\143\162\x69\x70\x74", MSN_JS_URL, array("\x6a\x71\x75\145\x72\x79"));
        wp_localize_script("\155\157\x5f\163\x6d\x73\137\x6e\157\164\151\146\x5f\141\x64\x6d\x69\x6e\x5f\163\145\164\x74\151\x6e\x67\x73\137\x73\x63\162\x69\x70\x74", "\x6d\x6f\x63\165\x73\x74\x6f\155\155\x73\147", array("\x73\151\164\145\125\122\114" => admin_url()));
        wp_enqueue_script("\x6d\x6f\137\x73\x6d\x73\137\156\157\x74\x69\146\x5f\x61\x64\155\151\x6e\x5f\x73\x65\164\164\151\x6e\147\163\x5f\x73\x63\x72\x69\x70\164");
    }
    function initializeHandlers()
    {
        $h2 = AddOnList::instance();
        $C3 = WooCommerceNotifications::instance();
        $h2->add($C3->getAddOnKey(), $C3);
    }
    function initializeHelpers()
    {
        MoWcAddOnMessages::instance();
        WooCommerceNotificationsList::instance();
    }
    function show_addon_settings_page()
    {
        include MSN_DIR . "\57\x63\x6f\x6e\164\x72\157\154\x6c\145\162\x73\57\x6d\x61\151\156\55\x63\157\x6e\x74\162\157\x6c\154\x65\162\56\x70\x68\160";
    }
    function mo_sms_notif_delete_options()
    {
        delete_site_option("\x6d\x6f\137\x77\x63\x5f\x73\x6d\163\x5f\x6e\157\164\x69\146\x69\143\141\164\151\x6f\156\x5f\163\145\164\164\x69\156\x67\x73");
    }
}
