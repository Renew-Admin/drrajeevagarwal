<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceNewCustomerNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4e\x65\x77\40\x41\143\x63\x6f\x75\x6e\x74";
        $this->page = "\167\143\137\x6e\145\x77\137\143\x75\163\x74\157\x6d\x65\162\x5f\x6e\157\164\x69\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4e\x45\x57\137\x43\x55\x53\x54\x4f\115\x45\122\x5f\116\x4f\x54\111\106\x5f\x48\105\x41\104\x45\122";
        $this->tooltipBody = "\116\x45\x57\137\103\x55\x53\124\x4f\x4d\105\122\137\116\117\124\x49\x46\x5f\102\x4f\x44\131";
        $this->recipient = "\x63\165\x73\164\157\155\145\162";
        $this->smsBody = get_wc_option("\x77\x6f\157\x63\x6f\155\x6d\x65\x72\143\145\137\x72\145\x67\x69\163\x74\x72\x61\x74\x69\157\x6e\x5f\x67\145\x6e\x65\x72\x61\164\x65\137\x70\x61\163\x73\x77\157\x72\x64", '') === "\171\x65\x73" ? MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS_WITH_PASS) : MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS);
        $this->defaultSmsBody = get_wc_option("\x77\x6f\x6f\x63\157\155\x6d\145\162\143\145\x5f\162\145\147\x69\x73\164\x72\x61\x74\x69\x6f\156\x5f\147\145\x6e\145\162\x61\164\x65\x5f\x70\x61\163\163\167\157\162\144", '') === "\171\145\163" ? MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS_WITH_PASS) : MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS);
        $this->availableTags = "\x7b\x73\151\x74\x65\x2d\156\x61\155\145\175\x2c\173\x75\163\x65\x72\x6e\x61\x6d\145\175\x2c\x7b\x61\143\143\x6f\x75\156\164\160\x61\x67\145\55\165\x72\154\x7d";
        $this->pageHeader = mo_("\x4e\105\x57\x20\101\103\103\x4f\125\x4e\124\x20\x4e\117\124\111\106\x49\103\101\x54\x49\117\x4e\40\x53\x45\124\x54\x49\x4e\107\123");
        $this->pageDescription = mo_("\x53\x4d\x53\40\156\157\x74\x69\146\x69\x63\141\164\x69\157\x6e\x73\x20\163\145\164\164\x69\x6e\147\163\x20\146\157\162\x20\116\x65\x77\40\x41\143\143\157\x75\x6e\164\x20\143\162\145\x61\x74\151\x6f\156\x20\x53\x4d\123\x20\163\145\156\164\40\164\x6f\x20\x74\150\x65\x20\165\x73\145\x72\163");
        $this->notificationType = mo_("\103\x75\x73\x74\x6f\155\145\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Tw)
    {
        if ($this->isEnabled) {
            goto hI;
        }
        return;
        hI:
        $this->setNotifInSession($this->page);
        $RQ = $Tw["\143\x75\163\x74\x6f\x6d\x65\x72\137\x69\144"];
        $Cj = $Tw["\x6e\x65\x77\137\143\165\x73\164\x6f\155\x65\162\137\x64\x61\x74\x61"];
        $rQ = get_bloginfo();
        $zC = get_userdata($RQ)->user_login;
        $dI = get_user_meta($RQ, "\142\x69\154\154\151\x6e\x67\137\x70\x68\157\156\x65", TRUE);
        $AH = MoUtility::sanitizeCheck("\142\151\154\154\151\156\147\137\160\x68\x6f\156\x65", $_POST);
        $dI = MoUtility::isBlank($dI) && $AH ? $AH : $dI;
        $M8 = wc_get_page_permalink("\x6d\x79\x61\143\x63\157\165\156\x74");
        $GO = ["\163\151\x74\145\x2d\x6e\141\155\x65" => get_bloginfo(), "\165\163\145\x72\156\141\155\145" => $zC, "\141\143\143\157\x75\156\x74\x70\x61\x67\x65\x2d\x75\162\154" => $M8];
        $GO = apply_filters("\x6d\157\137\x77\143\137\x6e\145\x77\137\x63\x75\163\x74\157\155\x65\162\137\156\157\164\151\146\x5f\x73\x74\x72\151\156\x67\137\x72\x65\160\154\141\143\145", $GO);
        $mp = MoUtility::replaceString($GO, $this->smsBody);
        if (!MoUtility::isBlank($dI)) {
            goto p4;
        }
        return;
        p4:
        MoUtility::send_phone_notif($dI, $mp);
    }
}
