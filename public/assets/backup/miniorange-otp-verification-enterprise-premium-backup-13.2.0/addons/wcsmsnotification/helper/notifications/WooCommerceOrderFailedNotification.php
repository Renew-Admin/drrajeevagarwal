<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderFailedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\x72\x64\145\162\x20\x46\x61\151\154\145\144";
        $this->page = "\x77\143\137\x6f\x72\x64\x65\162\x5f\146\x61\x69\154\145\x64\137\x6e\157\164\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\x52\104\x45\x52\137\106\x41\111\x4c\105\x44\x5f\116\117\x54\x49\106\x5f\x48\x45\101\x44\x45\122";
        $this->tooltipBody = "\x4f\122\x44\x45\x52\x5f\x46\101\111\x4c\x45\104\x5f\x4e\117\x54\x49\106\137\102\117\x44\131";
        $this->recipient = "\x63\x75\x73\x74\x6f\155\145\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_FAILED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_FAILED_SMS);
        $this->availableTags = "\x7b\x73\151\164\145\x2d\x6e\x61\x6d\145\175\54\173\157\x72\144\145\x72\x2d\156\165\x6d\142\145\162\x7d\54\173\165\x73\x65\162\156\x61\x6d\145\175\x7b\157\162\144\x65\162\55\x64\x61\164\145\x7d";
        $this->pageHeader = mo_("\x4f\122\x44\x45\122\x20\106\101\111\114\x45\104\40\116\117\124\111\106\111\x43\101\x54\x49\117\x4e\x20\x53\x45\124\124\x49\116\107\x53");
        $this->pageDescription = mo_("\123\115\x53\40\156\x6f\164\x69\x66\x69\x63\x61\164\x69\157\x6e\163\x20\163\145\x74\164\151\156\147\x73\40\146\157\162\40\117\x72\144\145\x72\x20\x66\x61\151\154\x75\162\x65\x20\123\x4d\123\x20\x73\x65\156\164\40\164\x6f\40\x74\150\x65\x20\x75\163\145\x72\x73");
        $this->notificationType = mo_("\103\165\163\x74\x6f\x6d\145\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto WA;
        }
        return;
        WA:
        $LE = $Tw["\x6f\162\x64\145\162\104\145\x74\x61\151\x6c\x73"];
        if (!MoUtility::isBlank($LE)) {
            goto VX;
        }
        return;
        VX:
        $this->setNotifInSession($this->page);
        $gL = get_userdata($LE->get_customer_id());
        $rQ = get_bloginfo();
        $zC = MoUtility::isBlank($gL) ? '' : $gL->user_login;
        $dI = MoWcAddOnUtility::getCustomerNumberFromOrder($LE);
        $yU = $LE->get_date_created()->date_i18n();
        $ZJ = $LE->get_order_number();
        $GO = ["\x73\151\x74\x65\x2d\156\141\x6d\x65" => $rQ, "\165\x73\145\x72\156\x61\x6d\145" => $zC, "\x6f\x72\144\x65\162\x2d\144\141\164\145" => $yU, "\157\162\144\x65\x72\x2d\x6e\x75\x6d\142\145\162" => $ZJ];
        $GO = apply_filters("\155\157\x5f\167\x63\x5f\x63\165\163\164\157\x6d\145\x72\137\157\162\x64\145\x72\137\146\x61\151\154\x65\x64\x5f\156\x6f\164\151\146\x5f\x73\164\162\x69\x6e\x67\137\162\x65\x70\154\141\143\x65", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($dI)) {
            goto MH;
        }
        return;
        MH:
        MoUtility::send_phone_notif($dI, $mp);
    }
}
