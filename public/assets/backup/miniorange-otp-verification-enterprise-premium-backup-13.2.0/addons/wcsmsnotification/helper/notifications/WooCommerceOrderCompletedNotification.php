<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderCompletedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\x72\144\x65\162\x20\103\157\x6d\x70\154\145\x74\145\144";
        $this->page = "\167\143\137\157\x72\x64\145\x72\x5f\143\157\x6d\x70\x6c\x65\x74\145\x64\137\x6e\x6f\164\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\122\104\x45\x52\x5f\x43\x41\x4e\x43\105\x4c\x4c\105\104\x5f\x4e\117\x54\111\x46\x5f\110\105\101\104\105\x52";
        $this->tooltipBody = "\117\x52\104\x45\122\x5f\103\x41\116\x43\x45\x4c\114\x45\104\x5f\x4e\x4f\x54\x49\x46\x5f\102\117\104\131";
        $this->recipient = "\143\165\163\164\157\x6d\145\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_COMPLETED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_COMPLETED_SMS);
        $this->availableTags = "\x7b\163\x69\164\x65\x2d\x6e\x61\x6d\x65\175\54\173\x6f\x72\x64\145\x72\x2d\x6e\x75\x6d\142\145\162\175\54\x7b\165\163\145\162\156\x61\155\x65\175\173\157\162\144\145\x72\55\x64\141\x74\x65\175";
        $this->pageHeader = mo_("\117\122\104\105\x52\x20\x43\x4f\115\x50\x4c\x45\x54\105\104\40\116\x4f\124\x49\x46\x49\103\x41\x54\x49\117\116\40\x53\x45\x54\x54\x49\x4e\107\x53");
        $this->pageDescription = mo_("\123\115\123\40\156\x6f\x74\151\x66\151\x63\x61\x74\x69\x6f\156\163\40\x73\x65\164\164\x69\156\147\163\x20\x66\x6f\x72\40\x4f\162\x64\145\x72\x20\103\157\155\x70\154\145\x74\151\157\156\40\123\115\x53\x20\163\x65\156\x74\x20\164\x6f\40\x74\150\145\x20\x75\x73\145\162\x73");
        $this->notificationType = mo_("\x43\x75\x73\x74\x6f\155\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto at;
        }
        return;
        at:
        $LE = $Tw["\157\x72\x64\145\x72\104\x65\164\141\x69\x6c\163"];
        if (!MoUtility::isBlank($LE)) {
            goto Mh;
        }
        return;
        Mh:
        $this->setNotifInSession($this->page);
        $gL = get_userdata($LE->get_customer_id());
        $rQ = get_bloginfo();
        $zC = MoUtility::isBlank($gL) ? '' : $gL->user_login;
        $dI = MoWcAddOnUtility::getCustomerNumberFromOrder($LE);
        $yU = $LE->get_date_created()->date_i18n();
        $ZJ = $LE->get_order_number();
        $GO = ["\163\151\x74\x65\55\156\x61\155\145" => $rQ, "\x75\163\145\x72\x6e\x61\x6d\145" => $zC, "\x6f\162\144\145\x72\55\144\x61\x74\x65" => $yU, "\x6f\x72\x64\x65\x72\55\x6e\165\155\142\145\162" => $ZJ];
        $GO = apply_filters("\x6d\x6f\137\x77\x63\137\x63\x75\163\164\157\x6d\x65\162\137\x6f\162\144\145\162\x5f\x63\157\x6d\160\154\x65\164\145\144\x5f\156\x6f\x74\x69\x66\137\163\x74\x72\x69\156\147\137\x72\145\x70\154\x61\143\x65", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($dI)) {
            goto F5;
        }
        return;
        F5:
        MoUtility::send_phone_notif($dI, $mp);
    }
}
