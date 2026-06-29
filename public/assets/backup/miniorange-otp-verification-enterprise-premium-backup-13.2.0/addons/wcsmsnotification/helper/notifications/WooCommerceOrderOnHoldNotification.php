<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderOnHoldNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\x72\144\145\162\x20\x6f\156\x2d\150\x6f\x6c\x64";
        $this->page = "\x77\x63\137\x6f\162\144\145\x72\137\157\x6e\x5f\x68\157\154\x64\137\156\157\164\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\x52\104\x45\122\137\117\116\x5f\x48\117\x4c\104\137\x4e\x4f\x54\x49\106\137\x48\105\x41\104\105\122";
        $this->tooltipBody = "\x4f\122\x44\x45\122\137\x4f\116\137\110\117\x4c\104\137\x4e\117\124\111\106\x5f\102\x4f\104\131";
        $this->recipient = "\x63\165\163\x74\x6f\x6d\145\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_ON_HOLD_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_ON_HOLD_SMS);
        $this->availableTags = "\173\163\151\x74\145\55\x6e\x61\x6d\x65\175\54\173\157\162\144\x65\x72\55\156\x75\x6d\142\x65\162\x7d\54\x7b\165\x73\x65\162\x6e\141\x6d\x65\x7d\x7b\157\162\144\145\162\x2d\x64\141\x74\145\175";
        $this->pageHeader = mo_("\x4f\122\104\105\122\40\117\x4e\55\110\x4f\114\104\40\116\x4f\x54\111\x46\x49\103\101\x54\111\x4f\x4e\x20\123\105\124\124\x49\116\107\x53");
        $this->pageDescription = mo_("\123\x4d\123\40\156\157\164\151\x66\151\143\141\x74\151\157\156\163\x20\163\x65\x74\164\151\x6e\x67\x73\40\x66\157\x72\40\x4f\x72\144\x65\162\x20\157\x6e\55\150\157\154\144\40\123\115\x53\40\x73\x65\x6e\164\40\164\157\40\164\150\x65\x20\165\x73\x65\x72\x73");
        $this->notificationType = mo_("\x43\165\x73\x74\157\x6d\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto Id;
        }
        return;
        Id:
        $LE = $Tw["\x6f\162\x64\145\162\x44\145\x74\x61\151\x6c\x73"];
        if (!MoUtility::isBlank($LE)) {
            goto An;
        }
        return;
        An:
        $this->setNotifInSession($this->page);
        $gL = get_userdata($LE->get_customer_id());
        $rQ = get_bloginfo();
        $zC = MoUtility::isBlank($gL) ? '' : $gL->user_login;
        $dI = MoWcAddOnUtility::getCustomerNumberFromOrder($LE);
        $yU = $LE->get_date_created()->date_i18n();
        $ZJ = $LE->get_order_number();
        $GO = ["\163\151\x74\x65\x2d\156\x61\155\145" => $rQ, "\165\163\x65\x72\x6e\141\155\145" => $zC, "\x6f\162\x64\x65\162\x2d\x64\x61\x74\x65" => $yU, "\x6f\162\x64\x65\x72\x2d\156\165\x6d\142\x65\x72" => $ZJ];
        $GO = apply_filters("\155\x6f\137\x77\143\137\x63\x75\163\164\157\x6d\145\x72\x5f\x6f\x72\x64\145\x72\137\157\156\x68\x6f\x6c\x64\137\x6e\x6f\164\x69\146\137\x73\164\162\151\x6e\x67\x5f\x72\x65\x70\154\141\143\x65", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($dI)) {
            goto YO;
        }
        return;
        YO:
        MoUtility::send_phone_notif($dI, $mp);
    }
}
