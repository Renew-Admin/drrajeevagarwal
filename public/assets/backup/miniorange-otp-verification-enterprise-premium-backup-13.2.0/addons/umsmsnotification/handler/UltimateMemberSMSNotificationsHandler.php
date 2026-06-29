<?php


namespace OTP\Addons\UmSMSNotification\Handler;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberNotificationsList;
use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
use OTP\Helper\MoOTPDocs;
class UltimateMemberSMSNotificationsHandler extends BaseAddOnHandler
{
    use Instance;
    private $notificationSettings;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto DT;
        }
        return;
        DT:
        $this->notificationSettings = get_umsn_option("\156\157\164\x69\146\151\143\x61\164\x69\x6f\156\137\163\x65\x74\x74\x69\x6e\x67\163") ? get_umsn_option("\156\157\164\x69\146\151\x63\x61\x74\151\157\x6e\x5f\x73\145\164\164\151\x6e\147\x73") : UltimateMemberNotificationsList::instance();
        add_action("\x75\x6d\x5f\162\x65\147\151\163\x74\162\141\164\151\x6f\156\137\143\x6f\x6d\160\x6c\x65\x74\145", array($this, "\155\157\x5f\163\145\156\x64\x5f\x6e\x65\x77\137\x63\165\163\x74\x6f\155\145\162\x5f\163\155\x73\x5f\156\x6f\x74\x69\146"), 1, 2);
    }
    function mo_send_new_customer_sms_notif($nL, array $Tw)
    {
        $this->notificationSettings->getUmNewCustomerNotif()->sendSMS(array_merge(["\x63\165\x73\164\157\155\145\162\x5f\151\x64" => $nL], $Tw));
        $this->notificationSettings->getUmNewUserAdminNotif()->sendSMS(array_merge(["\143\x75\163\x74\x6f\155\x65\x72\137\x69\x64" => $nL], $Tw));
    }
    function unhook()
    {
        remove_action("\165\x6d\137\162\x65\147\x69\x73\164\x72\141\x74\x69\157\x6e\x5f\x63\x6f\x6d\x70\x6c\145\x74\x65", "\x75\x6d\x5f\163\x65\x6e\x64\137\162\x65\147\151\163\164\x72\141\164\151\157\x6e\137\156\x6f\164\x69\146\x69\143\141\x74\151\157\x6e");
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\x75\x6d\137\x73\x6d\x73\x5f\x6e\157\x74\151\146\x69\x63\141\x74\151\157\156\x5f\141\144\x64\x6f\x6e";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\101\x6c\154\157\x77\x73\x20\x79\157\165\x72\40\163\151\164\x65\40\x74\x6f\x20\163\145\x6e\144\x20\143\x75\163\164\x6f\x6d\x20\x53\115\x53\x20\x6e\x6f\164\151\146\x69\143\141\164\x69\157\x6e\163\x20\164\x6f\x20\x79\157\165\162\x20\x63\165\163\164\x6f\x6d\x65\x72\x73\x2e" . "\x43\x6c\151\143\153\x20\157\x6e\x20\164\x68\x65\x20\163\x65\x74\164\151\156\x67\163\x20\142\165\x74\164\x6f\156\40\164\x6f\x20\164\x68\145\40\162\151\x67\x68\164\x20\164\157\40\163\x65\x65\40\x74\150\145\x20\x6c\x69\x73\x74\x20\157\146\x20\156\157\x74\151\x66\151\143\141\x74\x69\x6f\x6e\163\x20\x74\150\141\164\40\x67\x6f\x20\x6f\165\x74\56");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\125\154\x74\x69\155\x61\164\x65\x20\115\x65\155\142\145\162\40\x53\x4d\123\x20\x4e\x6f\x74\151\146\x69\143\141\164\151\157\156");
    }
    function setAddOnDocs()
    {
        $this->_addOnDocs = MoOTPDocs::ULTIMATEMEMBER_SMS_NOTIFICATION_LINK["\147\165\151\x64\145\x4c\151\156\x6b"];
    }
    function setAddOnVideo()
    {
        $this->_addOnVideo = MoOTPDocs::ULTIMATEMEMBER_SMS_NOTIFICATION_LINK["\x76\151\144\145\157\x4c\x69\156\153"];
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\141\144\144\157\156" => "\x75\155\x5f\x6e\x6f\164\x69\146"), $_SERVER["\122\105\x51\x55\105\x53\124\x5f\125\x52\x49"]);
    }
}
