<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderPendingNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\x72\x64\x65\x72\40\120\x65\x6e\x64\151\x6e\147\40\120\141\x79\155\145\x6e\164";
        $this->page = "\x77\x63\137\157\162\x64\x65\162\137\160\x65\x6e\144\151\156\x67\137\x6e\157\x74\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4f\122\104\x45\122\x5f\x50\105\116\x44\x49\x4e\107\137\116\x4f\124\x49\x46\137\110\105\x41\104\x45\122";
        $this->tooltipBody = "\117\x52\x44\x45\122\x5f\120\x45\116\104\x49\116\107\137\116\117\124\x49\106\137\x42\117\x44\131";
        $this->recipient = "\x63\165\163\x74\x6f\155\x65\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_PENDING_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_PENDING_SMS);
        $this->availableTags = "\173\x73\151\x74\145\x2d\156\x61\155\x65\x7d\x2c\173\157\x72\144\145\x72\x2d\156\x75\155\142\145\162\x7d\54\173\x75\x73\145\162\x6e\x61\x6d\x65\175\x7b\157\162\144\x65\162\55\x64\141\x74\x65\x7d";
        $this->pageHeader = mo_("\117\122\x44\x45\122\x20\120\105\x4e\104\111\x4e\107\40\120\x41\131\115\x45\116\124\x20\x4e\x4f\124\x49\x46\111\103\101\x54\111\x4f\x4e\40\x53\x45\x54\x54\111\116\107\x53");
        $this->pageDescription = mo_("\x53\x4d\123\40\x6e\157\x74\x69\x66\151\143\x61\x74\151\x6f\x6e\163\40\163\x65\164\164\151\x6e\x67\163\x20\x66\x6f\x72\x20\x4f\x72\144\x65\162\40\120\x65\x6e\x64\151\156\x67\x20\x50\141\x79\155\x65\156\x74\40\123\x4d\123\x20\163\145\x6e\x74\40\x74\157\x20\164\150\145\x20\165\163\x65\162\163");
        $this->notificationType = mo_("\103\x75\163\x74\x6f\155\x65\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto DF;
        }
        return;
        DF:
        $LE = $Tw["\157\162\x64\x65\162\104\x65\164\141\151\x6c\163"];
        if (!MoUtility::isBlank($LE)) {
            goto mN;
        }
        return;
        mN:
        $this->setNotifInSession($this->page);
        $gL = get_userdata($LE->get_customer_id());
        $rQ = get_bloginfo();
        $zC = MoUtility::isBlank($gL) ? '' : $gL->user_login;
        $dI = MoWcAddOnUtility::getCustomerNumberFromOrder($LE);
        $yU = $LE->get_date_created()->date_i18n();
        $ZJ = $LE->get_order_number();
        $GO = ["\163\x69\164\145\x2d\156\141\x6d\145" => $rQ, "\x75\x73\145\162\x6e\141\x6d\x65" => $zC, "\157\x72\144\145\x72\55\x64\141\x74\145" => $yU, "\x6f\162\144\145\162\x2d\156\165\x6d\x62\145\162" => $ZJ];
        $GO = apply_filters("\x6d\157\x5f\x77\143\x5f\x63\x75\163\x74\x6f\155\145\162\137\x6f\162\x64\x65\162\137\160\x65\156\144\151\x6e\147\137\x6e\157\x74\x69\146\x5f\x73\x74\x72\x69\x6e\147\x5f\x72\x65\160\x6c\x61\143\x65", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($dI)) {
            goto RB;
        }
        return;
        RB:
        MoUtility::send_phone_notif($dI, $mp);
    }
}
