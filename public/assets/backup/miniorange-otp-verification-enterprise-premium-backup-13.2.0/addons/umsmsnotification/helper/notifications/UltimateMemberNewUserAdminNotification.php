<?php


namespace OTP\Addons\UmSMSNotification\Helper\Notifications;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class UltimateMemberNewUserAdminNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\116\145\x77\40\x41\x63\143\x6f\165\156\164";
        $this->page = "\x75\x6d\x5f\156\x65\x77\137\143\165\x73\x74\157\x6d\x65\x72\x5f\141\x64\155\151\156\137\x6e\157\164\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4e\105\x57\x5f\x55\115\x5f\x43\x55\x53\124\x4f\x4d\105\122\137\116\117\x54\111\106\137\x48\105\101\x44\x45\x52";
        $this->tooltipBody = "\x4e\x45\x57\137\x55\x4d\x5f\x43\x55\123\x54\117\x4d\x45\122\x5f\x41\x44\x4d\111\116\x5f\116\117\124\111\106\137\x42\117\x44\x59";
        $this->recipient = UltimateMemberSMSNotificationUtility::getAdminPhoneNumber();
        $this->smsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_ADMIN_SMS);
        $this->defaultSmsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_ADMIN_SMS);
        $this->availableTags = "\173\163\x69\164\x65\x2d\x6e\141\155\145\x7d\54\x7b\x75\163\145\x72\156\141\155\x65\x7d\54\x7b\141\143\143\157\x75\156\164\160\x61\147\x65\x2d\165\x72\x6c\175\54\173\x65\x6d\141\151\x6c\175\x2c\x7b\146\x69\x72\x74\156\x61\155\x65\175\54\x7b\x6c\141\x73\164\156\x61\155\x65\x7d";
        $this->pageHeader = mo_("\x4e\105\x57\40\101\103\x43\x4f\125\116\x54\x20\x41\104\115\x49\x4e\40\116\117\x54\x49\106\111\x43\101\x54\111\x4f\116\40\x53\105\x54\124\111\x4e\107\123");
        $this->pageDescription = mo_("\123\x4d\x53\x20\x6e\157\164\x69\x66\x69\143\141\164\151\157\x6e\x73\x20\163\x65\x74\164\151\x6e\x67\163\x20\146\x6f\x72\40\x4e\145\167\x20\x41\x63\143\157\165\x6e\164\x20\x63\162\x65\x61\164\x69\x6f\x6e\x20\x53\x4d\x53\x20\163\x65\x6e\164\40\164\x6f\40\164\150\145\x20\x61\144\x6d\151\156\163");
        $this->notificationType = mo_("\101\x64\x6d\x69\156\x69\x73\164\162\x61\164\x6f\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto KL;
        }
        return;
        KL:
        $this->setNotifInSession($this->page);
        $hl = maybe_unserialize($this->recipient);
        $zC = um_user("\165\163\145\x72\x5f\154\x6f\147\151\x6e");
        $M2 = um_user_profile_url();
        $nx = um_user("\x66\x69\x72\x73\164\137\156\141\155\145");
        $ZK = um_user("\x6c\x61\x73\x74\x5f\156\141\x6d\x65");
        $mo = um_user("\x75\x73\145\x72\x5f\145\155\x61\x69\x6c");
        $GO = ["\x73\151\164\x65\55\x6e\141\155\145" => get_bloginfo(), "\x75\x73\145\162\x6e\x61\155\x65" => $zC, "\141\x63\143\x6f\x75\156\x74\160\141\147\145\55\165\x72\x6c" => $M2, "\x66\151\x72\163\x74\x6e\x61\155\x65" => $nx, "\x6c\x61\163\164\156\141\x6d\145" => $ZK, "\x65\x6d\141\151\154" => $mo];
        $GO = apply_filters("\x6d\x6f\137\165\155\137\156\145\167\137\x63\x75\x73\x74\x6f\x6d\x65\162\x5f\141\144\x6d\x69\156\x5f\x6e\157\164\151\146\137\x73\x74\x72\x69\x6e\x67\137\162\145\160\154\141\143\145", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($hl)) {
            goto S5;
        }
        return;
        S5:
        foreach ($hl as $dI) {
            MoUtility::send_phone_notif($dI, $mp);
            uQ:
        }
        ce:
    }
}
