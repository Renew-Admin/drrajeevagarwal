<?php


namespace OTP\Addons\PasswordReset;

use OTP\Addons\PasswordReset\Handler\UMPasswordResetAddOnHandler;
use OTP\Addons\PasswordReset\Helper\UMPasswordResetMessages;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\x41\x42\x53\x50\x41\x54\110")) {
    goto Z0;
}
exit;
Z0:
include "\x5f\x61\x75\x74\x6f\154\x6f\x61\144\x2e\160\150\x70";
final class UltimateMemberPasswordReset extends BaseAddOn implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\x61\144\x6d\151\x6e\x5f\x65\156\x71\x75\145\165\145\x5f\x73\143\x72\x69\160\164\x73", array($this, "\x75\x6d\137\x70\162\x5f\156\x6f\x74\x69\146\137\163\x65\x74\164\151\x6e\147\163\137\163\164\x79\154\145"));
        add_action("\155\157\x5f\x6f\x74\160\137\166\x65\162\x69\x66\x69\x63\x61\164\x69\157\156\x5f\144\x65\x6c\x65\164\x65\137\x61\144\144\x6f\156\137\x6f\160\x74\151\157\156\163", array($this, "\x75\155\x5f\x70\x72\137\x6e\157\x74\151\x66\137\x64\145\154\145\x74\x65\137\157\160\x74\151\157\x6e\x73"));
    }
    function um_pr_notif_settings_style()
    {
        wp_enqueue_style("\165\x6d\137\160\162\x5f\x6e\157\x74\x69\x66\137\x61\144\155\x69\156\137\163\x65\x74\x74\x69\156\x67\163\x5f\163\164\x79\x6c\x65", UMPR_CSS_URL);
    }
    function initializeHandlers()
    {
        $h2 = AddOnList::instance();
        $C3 = UMPasswordResetAddOnHandler::instance();
        $h2->add($C3->getAddOnKey(), $C3);
    }
    function initializeHelpers()
    {
        UMPasswordResetMessages::instance();
    }
    function show_addon_settings_page()
    {
        include UMPR_DIR . "\x63\x6f\156\x74\x72\x6f\x6c\x6c\145\162\x73\x2f\x6d\141\151\156\55\x63\x6f\x6e\164\x72\x6f\154\154\x65\162\56\160\x68\x70";
    }
    function um_pr_notif_delete_options()
    {
        delete_site_option("\155\157\137\x75\x6d\137\160\x72\x5f\x70\x61\x73\163\x5f\x65\156\x61\142\154\x65");
        delete_site_option("\x6d\157\x5f\165\155\137\160\162\137\x70\141\163\163\x5f\142\165\164\x74\x6f\x6e\137\164\145\x78\164");
        delete_site_option("\155\157\137\x75\x6d\x5f\x70\162\137\145\156\x61\x62\154\145\x64\137\x74\171\x70\x65");
    }
}
