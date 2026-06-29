<?php


namespace OTP\Addons\UmSMSNotification;

use OTP\Addons\UmSMSNotification\Handler\UltimateMemberSMSNotificationsHandler;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberNotificationsList;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\101\x42\x53\x50\x41\x54\110")) {
    goto nG;
}
exit;
nG:
include "\x5f\x61\x75\164\x6f\154\x6f\141\144\56\x70\150\x70";
final class UltimateMemberSmsNotification extends BaseAddon implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\x61\144\x6d\151\x6e\x5f\145\x6e\161\165\145\x75\145\x5f\163\143\162\151\160\164\x73", array($this, "\165\155\x5f\x73\x6d\x73\137\156\x6f\x74\151\x66\x5f\163\x65\164\x74\151\x6e\147\163\x5f\x73\x74\x79\154\145"));
        add_action("\155\157\137\x6f\164\160\137\x76\x65\162\151\x66\x69\143\141\164\151\x6f\156\137\144\x65\x6c\145\x74\145\x5f\141\x64\144\x6f\x6e\x5f\x6f\160\164\x69\157\156\x73", array($this, "\165\x6d\x5f\163\155\163\x5f\x6e\157\164\x69\146\137\x64\x65\154\145\x74\145\x5f\157\160\x74\x69\157\156\x73"));
    }
    function um_sms_notif_settings_style()
    {
        wp_enqueue_style("\x75\x6d\x5f\163\x6d\163\137\x6e\157\x74\151\146\x5f\141\144\155\151\x6e\137\x73\x65\164\164\x69\156\x67\163\137\x73\164\x79\154\x65", UMSN_CSS_URL);
    }
    function initializeHandlers()
    {
        $h2 = AddOnList::instance();
        $C3 = UltimateMemberSMSNotificationsHandler::instance();
        $h2->add($C3->getAddOnKey(), $C3);
    }
    function initializeHelpers()
    {
        UltimateMemberSMSNotificationMessages::instance();
        UltimateMemberNotificationsList::instance();
    }
    function show_addon_settings_page()
    {
        include UMSN_DIR . "\x2f\143\x6f\156\x74\x72\157\x6c\154\x65\x72\163\x2f\155\141\151\156\55\x63\157\x6e\164\162\x6f\154\x6c\x65\x72\x2e\x70\x68\x70";
    }
    function um_sms_notif_delete_options()
    {
        delete_site_option("\155\x6f\137\165\x6d\137\x73\155\x73\x5f\156\x6f\x74\x69\146\151\x63\x61\164\x69\157\x6e\x5f\x73\145\x74\x74\x69\156\x67\163");
    }
}
