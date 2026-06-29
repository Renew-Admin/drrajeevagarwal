<?php


namespace OTP\Addons\UmSMSNotification\Helper\Notifications;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class UltimateMemberNewCustomerNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\116\x65\x77\x20\101\143\143\x6f\x75\156\164";
        $this->page = "\165\155\137\x6e\145\x77\137\143\x75\x73\x74\x6f\x6d\x65\162\x5f\x6e\157\164\151\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\116\x45\127\x5f\125\115\x5f\x43\x55\123\x54\117\x4d\105\122\137\x4e\x4f\x54\111\x46\137\x48\105\101\x44\105\x52";
        $this->tooltipBody = "\x4e\x45\x57\x5f\x55\115\x5f\x43\x55\123\124\x4f\115\105\x52\x5f\116\117\124\x49\106\137\x42\117\x44\x59";
        $this->recipient = "\x6d\157\142\151\154\x65\x5f\156\165\x6d\142\145\x72";
        $this->smsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_SMS);
        $this->defaultSmsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_SMS);
        $this->availableTags = "\x7b\x73\x69\x74\145\55\x6e\141\155\145\x7d\x2c\x7b\x75\163\x65\162\x6e\x61\155\145\175\x2c\173\x61\143\x63\157\165\156\164\x70\x61\147\145\x2d\165\162\x6c\x7d\x2c\173\154\x6f\147\151\x6e\x2d\x75\162\154\x7d\x2c\173\145\155\141\x69\x6c\175\x2c\x7b\x66\151\x72\x74\156\x61\x6d\145\x7d\x2c\x7b\x6c\x61\163\164\x6e\141\x6d\145\x7d";
        $this->pageHeader = mo_("\x4e\105\x57\x20\x41\103\x43\x4f\125\116\x54\40\x4e\x4f\x54\x49\x46\x49\103\x41\x54\x49\117\x4e\x20\x53\105\x54\124\111\116\107\123");
        $this->pageDescription = mo_("\123\x4d\x53\40\156\x6f\164\x69\x66\151\x63\141\164\151\157\156\163\40\163\x65\x74\x74\151\x6e\x67\163\40\x66\157\x72\40\116\x65\x77\40\x41\x63\x63\x6f\165\x6e\164\40\x63\162\145\x61\164\x69\x6f\156\40\123\115\123\40\x73\x65\x6e\164\40\164\157\40\164\150\x65\x20\x75\163\145\x72\163");
        $this->notificationType = mo_("\103\x75\163\164\x6f\155\145\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto zo;
        }
        return;
        zo:
        $this->setNotifInSession($this->page);
        $zC = um_user("\x75\x73\x65\x72\x5f\154\x6f\147\x69\156");
        $dI = $Tw[$this->recipient];
        $M2 = um_user_profile_url();
        $Fp = um_get_core_page("\154\157\147\x69\156");
        $nx = um_user("\x66\151\x72\x73\164\x5f\156\141\x6d\x65");
        $ZK = um_user("\x6c\x61\163\164\x5f\156\141\x6d\x65");
        $mo = um_user("\x75\163\145\x72\137\145\x6d\141\151\154");
        $GO = ["\163\x69\x74\x65\x2d\x6e\141\155\x65" => get_bloginfo(), "\x75\x73\145\x72\156\141\x6d\145" => $zC, "\x61\143\143\157\165\x6e\x74\x70\x61\x67\x65\x2d\165\x72\154" => $M2, "\154\x6f\147\x69\156\x2d\x75\162\154" => $Fp, "\x66\x69\x72\x73\164\156\141\x6d\145" => $nx, "\x6c\x61\163\164\156\141\x6d\145" => $ZK, "\x65\x6d\141\151\154" => $mo];
        $GO = apply_filters("\x6d\157\x5f\x75\x6d\x5f\x6e\x65\x77\x5f\x63\165\x73\x74\x6f\x6d\145\x72\x5f\156\x6f\x74\151\146\137\x73\164\x72\151\156\x67\137\162\145\160\x6c\141\143\145", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($dI)) {
            goto aY;
        }
        return;
        aY:
        MoUtility::send_phone_notif($dI, $mp);
    }
}
