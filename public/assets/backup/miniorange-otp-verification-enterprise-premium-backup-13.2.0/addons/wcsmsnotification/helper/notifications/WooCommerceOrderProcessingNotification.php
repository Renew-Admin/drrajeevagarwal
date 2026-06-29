<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderProcessingNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\120\162\x6f\x63\145\x73\163\x69\x6e\147\x20\x4f\162\x64\x65\162";
        $this->page = "\167\143\x5f\x6f\162\x64\145\x72\137\x70\x72\x6f\143\x65\x73\x73\x69\x6e\x67\137\156\157\x74\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\x52\x44\x45\122\137\x50\122\117\x43\105\x53\x53\111\116\107\137\116\x4f\x54\111\106\137\110\105\101\104\105\x52";
        $this->tooltipBody = "\117\122\104\105\x52\137\120\122\117\103\105\123\x53\111\116\x47\x5f\x4e\117\124\x49\106\137\102\x4f\x44\131";
        $this->recipient = "\x63\165\163\164\157\x6d\x65\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::PROCESSING_ORDER_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::PROCESSING_ORDER_SMS);
        $this->availableTags = "\173\163\x69\x74\145\x2d\x6e\x61\155\145\175\54\x7b\157\x72\x64\145\162\x2d\156\165\x6d\142\x65\162\175\x2c\173\165\x73\145\162\156\141\155\145\x7d\173\x6f\162\144\145\162\55\x64\141\164\145\175";
        $this->pageHeader = mo_("\117\x52\104\x45\122\x20\x50\x52\117\x43\x45\x53\123\111\x4e\107\40\116\117\124\x49\106\111\x43\x41\124\111\x4f\116\40\123\x45\124\124\x49\x4e\x47\x53");
        $this->pageDescription = mo_("\123\115\x53\x20\x6e\157\164\151\x66\151\143\x61\x74\151\x6f\x6e\163\x20\x73\145\x74\x74\151\156\x67\x73\x20\x66\x6f\162\x20\x4f\162\144\x65\162\40\120\162\157\143\145\x73\x73\151\156\x67\x20\123\x4d\x53\40\163\145\x6e\164\x20\164\157\40\164\x68\145\x20\x75\x73\x65\162\163");
        $this->notificationType = mo_("\x43\x75\163\x74\x6f\x6d\145\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto Vp;
        }
        return;
        Vp:
        $LE = $Tw["\157\x72\144\145\162\104\x65\164\141\x69\x6c\163"];
        if (!MoUtility::isBlank($LE)) {
            goto dp;
        }
        return;
        dp:
        $this->setNotifInSession($this->page);
        $gL = get_userdata($LE->get_customer_id());
        $rQ = get_bloginfo();
        $zC = MoUtility::isBlank($gL) ? '' : $gL->user_login;
        $dI = MoWcAddOnUtility::getCustomerNumberFromOrder($LE);
        $yU = $LE->get_date_created()->date_i18n();
        $ZJ = $LE->get_order_number();
        $GO = ["\x73\151\x74\x65\55\156\x61\x6d\145" => $rQ, "\165\163\x65\162\x6e\141\x6d\x65" => $zC, "\x6f\x72\x64\x65\162\x2d\144\x61\x74\145" => $yU, "\157\x72\144\x65\162\x2d\x6e\x75\x6d\x62\x65\162" => $ZJ];
        $GO = apply_filters("\x6d\157\x5f\167\x63\137\x63\x75\x73\164\157\155\x65\x72\137\x6f\x72\144\145\x72\x5f\160\x72\x6f\143\145\x73\163\x69\x6e\x67\137\x6e\x6f\164\151\146\137\x73\x74\162\x69\156\147\x5f\x72\x65\x70\x6c\141\143\145", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($dI)) {
            goto c0;
        }
        return;
        c0:
        MoUtility::send_phone_notif($dI, $mp);
    }
}
