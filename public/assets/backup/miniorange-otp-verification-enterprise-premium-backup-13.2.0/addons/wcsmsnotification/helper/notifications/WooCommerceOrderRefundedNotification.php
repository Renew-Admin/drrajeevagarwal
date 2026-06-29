<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderRefundedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\x72\144\x65\x72\40\x52\145\x66\165\x6e\x64\145\x64";
        $this->page = "\x77\x63\x5f\157\x72\x64\145\x72\x5f\x72\145\146\x75\x6e\x64\145\x64\137\156\157\164\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\122\x44\105\x52\137\122\x45\106\x55\x4e\x44\x45\x44\x5f\116\x4f\124\111\x46\x5f\110\105\x41\104\105\x52";
        $this->tooltipBody = "\117\x52\104\105\122\137\x52\105\x55\116\x44\105\x44\137\x4e\x4f\x54\111\106\x5f\x42\x4f\x44\131";
        $this->recipient = "\143\165\163\164\157\155\x65\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_REFUNDED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_REFUNDED_SMS);
        $this->availableTags = "\173\x73\151\x74\145\x2d\x6e\x61\x6d\x65\175\x2c\x7b\x6f\162\144\x65\162\55\156\x75\155\142\145\162\175\x2c\173\x75\163\x65\162\x6e\141\x6d\x65\175\x7b\157\x72\x64\145\162\55\x64\141\x74\x65\175";
        $this->pageHeader = mo_("\117\x52\104\x45\x52\40\122\105\x46\x55\x4e\x44\105\104\x20\x4e\117\x54\x49\106\111\x43\x41\124\x49\x4f\116\x20\x53\x45\x54\124\x49\x4e\107\x53");
        $this->pageDescription = mo_("\123\115\123\40\x6e\x6f\164\x69\146\x69\x63\x61\164\151\x6f\156\x73\x20\x73\145\x74\x74\151\x6e\x67\163\40\x66\157\162\x20\x4f\x72\144\145\x72\40\x52\x65\x66\165\x6e\x64\x65\144\40\123\115\x53\40\163\x65\156\x74\40\x74\157\40\164\x68\145\40\165\163\x65\x72\163");
        $this->notificationType = mo_("\103\165\163\164\157\x6d\145\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto qH;
        }
        return;
        qH:
        $LE = $Tw["\x6f\162\x64\145\162\x44\145\164\x61\x69\x6c\x73"];
        if (!MoUtility::isBlank($LE)) {
            goto lw;
        }
        return;
        lw:
        $this->setNotifInSession($this->page);
        $gL = get_userdata($LE->get_customer_id());
        $rQ = get_bloginfo();
        $zC = MoUtility::isBlank($gL) ? '' : $gL->user_login;
        $dI = MoWcAddOnUtility::getCustomerNumberFromOrder($LE);
        $yU = $LE->get_date_created()->date_i18n();
        $ZJ = $LE->get_order_number();
        $GO = ["\x73\x69\x74\x65\x2d\x6e\x61\155\145" => $rQ, "\165\163\x65\x72\156\x61\155\x65" => $zC, "\157\162\144\145\x72\x2d\144\x61\x74\x65" => $yU, "\x6f\x72\x64\145\x72\55\x6e\x75\155\x62\x65\162" => $ZJ];
        $GO = apply_filters("\x6d\x6f\137\167\143\x5f\x63\165\163\x74\157\155\145\162\137\157\x72\x64\145\x72\137\x72\x65\x66\165\x6e\x64\x65\144\x5f\156\x6f\164\151\x66\137\x73\x74\162\151\x6e\147\137\x72\145\x70\154\x61\x63\x65", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($dI)) {
            goto GN;
        }
        return;
        GN:
        MoUtility::send_phone_notif($dI, $mp);
    }
}
