<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Addons\WcSMSNotification\Helper\WcOrderStatus;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceAdminOrderstatusNotification extends SMSNotification
{
    public static $instance;
    public static $statuses;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\162\x64\x65\x72\x20\123\164\x61\164\x75\x73";
        $this->page = "\167\143\x5f\x61\144\x6d\151\x6e\137\157\x72\x64\145\162\137\163\164\x61\x74\165\163\137\x6e\157\x74\151\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4e\105\127\137\x4f\x52\x44\x45\122\x5f\116\117\124\x49\x46\137\110\x45\101\x44\105\122";
        $this->tooltipBody = "\116\105\x57\x5f\117\x52\104\x45\x52\137\x4e\x4f\124\x49\x46\x5f\x42\x4f\104\x59";
        $this->recipient = MoWcAddOnUtility::getAdminPhoneNumber();
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ADMIN_STATUS_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ADMIN_STATUS_SMS);
        $this->availableTags = "\x7b\163\x69\x74\x65\55\156\141\155\x65\175\54\173\x6f\x72\144\145\x72\55\156\165\x6d\x62\x65\162\x7d\54\173\157\162\144\x65\162\55\163\164\x61\164\x75\x73\x7d\x2c\173\x75\163\x65\x72\x6e\x61\155\145\x7d\173\x6f\162\x64\145\162\x2d\x64\x61\x74\x65\x7d";
        $this->pageHeader = mo_("\117\x52\104\x45\x52\40\x41\x44\115\111\x4e\40\x53\124\x41\124\125\123\x20\116\117\x54\111\106\111\103\x41\124\111\x4f\116\40\123\x45\x54\x54\111\x4e\x47\123");
        $this->pageDescription = mo_("\x53\x4d\123\x20\x6e\x6f\x74\151\146\151\143\x61\x74\x69\x6f\156\163\40\163\x65\x74\164\151\x6e\147\x73\40\x66\x6f\162\40\117\x72\144\x65\x72\x20\x53\x74\x61\x74\165\163\x20\x53\115\x53\40\163\x65\x6e\x74\40\164\x6f\40\x74\150\145\40\141\x64\155\x69\156\x73");
        $this->notificationType = mo_("\x41\x64\155\151\x6e\151\x73\x74\162\141\164\x6f\162");
        self::$instance = $this;
        self::$statuses = WcOrderStatus::getAllStatus();
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto OH;
        }
        return;
        OH:
        $LE = $Tw["\157\x72\144\145\162\104\x65\x74\141\x69\154\x73"];
        $D9 = $Tw["\x6e\x65\167\x5f\163\x74\x61\164\165\163"];
        if (!MoUtility::isBlank($LE)) {
            goto NM;
        }
        return;
        NM:
        if (in_array($D9, self::$statuses)) {
            goto vZ;
        }
        return;
        vZ:
        $this->setNotifInSession($this->page);
        $gL = get_userdata($LE->get_customer_id());
        $rQ = get_bloginfo();
        $zC = MoUtility::isBlank($gL) ? '' : $gL->user_login;
        $hl = maybe_unserialize($this->recipient);
        $yU = $LE->get_date_created()->date_i18n();
        $ZJ = $LE->get_order_number();
        $GO = ["\163\x69\164\x65\x2d\x6e\141\155\x65" => $rQ, "\165\x73\145\x72\x6e\141\x6d\145" => $zC, "\x6f\x72\x64\145\x72\x2d\x64\x61\x74\145" => $yU, "\x6f\x72\x64\145\x72\55\156\x75\x6d\142\x65\162" => $ZJ, "\x6f\162\144\145\x72\55\x73\x74\x61\x74\165\x73" => $D9];
        $GO = apply_filters("\155\157\137\167\x63\x5f\141\144\x6d\151\x6e\x5f\157\x72\144\145\162\x5f\156\157\x74\x69\146\137\x73\164\162\151\156\147\x5f\162\145\x70\154\141\x63\145", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($hl)) {
            goto gn;
        }
        return;
        gn:
        foreach ($hl as $dI) {
            MoUtility::send_phone_notif($dI, $mp);
            t_:
        }
        Cd:
    }
}
