<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceCutomerNoteNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x43\x75\x73\164\x6f\155\145\x72\x20\116\x6f\x74\x65";
        $this->page = "\167\143\137\x63\165\163\164\157\x6d\145\162\137\156\x6f\x74\x65\x5f\x6e\x6f\x74\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x43\x55\x53\124\117\x4d\x45\x52\137\116\x4f\124\x45\137\x4e\x4f\x54\111\x46\137\110\105\x41\x44\x45\122";
        $this->tooltipBody = "\x43\125\x53\124\x4f\115\x45\122\137\116\x4f\x54\x45\137\x4e\117\x54\x49\106\137\102\117\x44\131";
        $this->recipient = "\143\x75\163\164\157\155\145\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::CUSTOMER_NOTE_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::CUSTOMER_NOTE_SMS);
        $this->availableTags = "\x7b\x6f\x72\144\x65\x72\x2d\144\x61\x74\145\175\54\x7b\157\x72\x64\x65\162\x2d\156\165\x6d\x62\x65\162\175\54\x7b\x75\163\145\162\x6e\x61\155\x65\x7d\x2c\x7b\163\151\164\145\x2d\156\141\x6d\x65\175";
        $this->pageHeader = mo_("\x43\x55\x53\124\117\x4d\x45\122\40\x4e\117\x54\105\x20\116\x4f\124\111\x46\111\x43\101\124\x49\117\116\x20\x53\x45\x54\124\111\116\x47\123");
        $this->pageDescription = mo_("\123\x4d\x53\x20\156\157\x74\151\146\x69\x63\141\164\151\x6f\x6e\163\40\163\x65\x74\x74\x69\x6e\147\163\40\146\157\162\x20\x43\165\x73\x74\x6f\155\x65\x72\x20\x4e\157\x74\x65\x20\123\115\x53\x20\163\x65\156\164\x20\x74\x6f\x20\164\150\145\x20\165\163\x65\x72\x73");
        $this->notificationType = mo_("\103\165\x73\x74\x6f\155\x65\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto SA;
        }
        return;
        SA:
        $LE = $Tw["\x6f\x72\x64\145\x72\104\145\164\141\151\x6c\x73"];
        if (!MoUtility::isBlank($LE)) {
            goto NU;
        }
        return;
        NU:
        $this->setNotifInSession($this->page);
        $gL = get_userdata($LE->get_customer_id());
        $rQ = get_bloginfo();
        $zC = MoUtility::isBlank($gL) ? '' : $gL->user_login;
        $dI = MoWcAddOnUtility::getCustomerNumberFromOrder($LE);
        $yU = $LE->get_date_created()->date_i18n();
        $ZJ = $LE->get_order_number();
        $GO = ["\163\151\164\145\55\156\141\155\x65" => $rQ, "\x75\163\x65\162\156\141\x6d\145" => $zC, "\157\x72\x64\x65\x72\x2d\x64\141\x74\145" => $yU, "\x6f\x72\144\x65\162\55\x6e\165\155\142\145\162" => $ZJ];
        $GO = apply_filters("\155\157\137\x77\x63\x5f\143\x75\x73\x74\x6f\x6d\145\162\137\156\x6f\164\x65\x5f\x73\164\162\x69\156\x67\137\x72\x65\x70\x6c\141\x63\x65", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($dI)) {
            goto Xw;
        }
        return;
        Xw:
        MoUtility::send_phone_notif($dI, $mp);
    }
}
