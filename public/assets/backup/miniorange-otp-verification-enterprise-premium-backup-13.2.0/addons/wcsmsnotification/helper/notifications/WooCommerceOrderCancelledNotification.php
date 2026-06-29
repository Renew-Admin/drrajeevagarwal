<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderCancelledNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\x72\x64\x65\x72\40\x43\141\156\x63\x65\154\154\x65\144";
        $this->page = "\167\x63\x5f\157\162\x64\145\162\137\143\141\x6e\143\145\154\154\x65\144\x5f\x6e\157\x74\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\122\104\x45\x52\137\103\x41\x4e\x43\x45\114\x4c\x45\104\137\116\117\124\x49\x46\137\110\x45\101\104\105\122";
        $this->tooltipBody = "\x4f\122\104\x45\122\x5f\x43\x41\x4e\103\105\114\x4c\105\x44\x5f\116\x4f\124\x49\106\x5f\x42\x4f\104\x59";
        $this->recipient = "\143\165\x73\164\x6f\155\145\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_CANCELLED_SMS);
        $this->defaultSmsBodsy = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_CANCELLED_SMS);
        $this->availableTags = "\173\163\x69\164\145\x2d\x6e\141\155\x65\175\x2c\173\157\162\x64\145\162\x2d\x6e\x75\155\x62\145\162\175\54\173\165\x73\145\x72\x6e\141\x6d\145\175\173\157\x72\x64\145\x72\55\144\x61\164\145\x7d";
        $this->pageHeader = mo_("\x4f\x52\104\x45\x52\x20\103\x41\x4e\103\x45\x4c\114\105\x44\x20\116\117\124\111\106\111\x43\x41\124\111\x4f\116\40\123\x45\x54\x54\111\x4e\x47\x53");
        $this->pageDescription = mo_("\x53\x4d\123\x20\x6e\157\x74\x69\146\151\x63\x61\x74\151\x6f\156\163\40\x73\145\x74\164\151\x6e\147\x73\x20\x66\x6f\x72\40\x4f\x72\x64\x65\162\40\x43\x61\156\143\145\154\154\141\164\x69\x6f\156\40\123\x4d\x53\40\x73\145\156\164\40\x74\157\x20\x74\x68\145\x20\x75\163\x65\x72\x73");
        $this->notificationType = mo_("\x43\x75\163\164\x6f\155\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto t3;
        }
        return;
        t3:
        $LE = $Tw["\x6f\x72\144\x65\x72\104\x65\x74\141\x69\x6c\163"];
        if (!MoUtility::isBlank($LE)) {
            goto uu;
        }
        return;
        uu:
        $this->setNotifInSession($this->page);
        $gL = get_userdata($LE->get_customer_id());
        $rQ = get_bloginfo();
        $zC = MoUtility::isBlank($gL) ? '' : $gL->user_login;
        $dI = MoWcAddOnUtility::getCustomerNumberFromOrder($LE);
        $yU = $LE->get_date_created()->date_i18n();
        $ZJ = $LE->get_order_number();
        $GO = ["\x73\x69\164\x65\55\x6e\x61\x6d\145" => $rQ, "\165\163\x65\x72\156\x61\x6d\145" => $zC, "\157\x72\144\x65\162\x2d\x64\141\164\x65" => $yU, "\157\x72\144\145\162\x2d\x6e\165\155\x62\x65\x72" => $ZJ];
        $GO = apply_filters("\155\x6f\x5f\x77\143\137\x63\165\163\x74\157\155\145\x72\137\x6f\162\x64\145\162\137\143\x61\x6e\143\x65\154\x6c\145\x64\137\x6e\157\164\151\x66\137\163\x74\162\151\x6e\147\137\x72\x65\160\154\141\143\145", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($dI)) {
            goto u0;
        }
        return;
        u0:
        MoUtility::send_phone_notif($dI, $mp);
    }
}
