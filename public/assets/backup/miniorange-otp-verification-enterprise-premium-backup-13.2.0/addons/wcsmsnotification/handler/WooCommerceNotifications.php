<?php


namespace OTP\Addons\WcSMSNotification\Handler;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Addons\WcSMSNotification\Helper\WcOrderStatus;
use OTP\Addons\WcSMSNotification\Helper\WooCommerceNotificationsList;
use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
use OTP\Helper\MoOTPDocs;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\SMSNotification;
use OTP\Traits\Instance;
use WC_Emails;
use WC_Order;
class WooCommerceNotifications extends BaseAddOnHandler
{
    use Instance;
    private $notificationSettings;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto UA;
        }
        return;
        UA:
        $this->notificationSettings = get_wc_option("\x6e\157\x74\x69\x66\151\x63\141\x74\151\x6f\x6e\137\163\145\164\x74\151\156\147\x73") ? get_wc_option("\x6e\157\164\151\146\x69\x63\x61\164\x69\x6f\156\137\163\145\x74\164\x69\x6e\147\163") : WooCommerceNotificationsList::instance();
        add_action("\167\x6f\x6f\143\x6f\155\x6d\145\x72\x63\145\x5f\x63\x72\145\141\x74\145\x64\137\x63\165\163\164\157\x6d\145\162\137\156\157\164\151\x66\151\143\141\x74\x69\157\156", array($this, "\155\x6f\137\x73\145\156\144\x5f\156\145\x77\137\x63\x75\x73\x74\157\155\x65\162\x5f\163\155\x73\x5f\156\x6f\164\x69\146"), 1, 3);
        add_action("\167\x6f\x6f\143\x6f\x6d\x6d\145\x72\x63\145\137\156\x65\x77\x5f\x63\165\x73\x74\157\155\145\x72\x5f\x6e\157\x74\145\137\x6e\157\x74\x69\x66\x69\143\x61\164\151\157\156", array($this, "\x6d\x6f\137\x73\145\156\x64\137\156\145\x77\x5f\x63\x75\x73\x74\x6f\x6d\x65\162\137\x73\x6d\x73\x5f\x6e\x6f\x74\145"), 1, 1);
        add_action("\x77\157\x6f\143\x6f\x6d\x6d\145\162\x63\x65\x5f\x6f\x72\144\x65\162\x5f\163\164\x61\x74\165\x73\x5f\x63\150\141\156\x67\145\x64", array($this, "\155\x6f\137\163\x65\x6e\x64\x5f\x61\x64\x6d\151\x6e\x5f\x6f\x72\144\x65\162\137\x73\x6d\163\x5f\x6e\157\x74\151\146"), 1, 3);
        add_action("\167\x6f\x6f\143\x6f\155\155\145\162\x63\145\x5f\x6f\x72\144\145\162\137\163\x74\x61\164\165\x73\137\x63\x68\x61\156\147\x65\x64", array($this, "\155\x6f\x5f\143\165\163\x74\x6f\x6d\145\162\137\157\162\x64\x65\x72\x5f\x68\x6f\154\x64\x5f\x73\x6d\x73\137\x6e\x6f\x74\x69\x66"), 1, 3);
        add_action("\141\144\x64\137\155\145\x74\x61\137\142\x6f\170\145\x73", array($this, "\141\144\x64\137\x63\165\x73\164\157\x6d\x5f\155\163\x67\x5f\155\x65\164\x61\137\x62\x6f\170"), 1);
        add_action("\x61\144\155\151\x6e\x5f\x69\x6e\x69\164", array($this, "\137\x68\x61\156\144\154\145\137\141\144\x6d\151\x6e\137\x61\143\164\151\157\156\x73"));
    }
    function _handle_admin_actions()
    {
        if (current_user_can("\x6d\141\x6e\141\x67\145\137\x6f\x70\x74\151\157\156\163")) {
            goto Wz;
        }
        return;
        Wz:
        if (!(array_key_exists("\x6f\x70\x74\151\x6f\156", $_GET) && sanitize_text_field($_GET["\x6f\x70\164\151\157\x6e"]) == "\155\157\137\163\145\156\144\x5f\x6f\x72\x64\x65\162\x5f\143\165\x73\x74\157\x6d\137\x6d\x73\x67")) {
            goto eJ;
        }
        $this->_send_custom_order_msg($_POST);
        eJ:
    }
    function mo_send_new_customer_sms_notif($RQ, $S0 = array(), $G5 = false)
    {
        $this->notificationSettings->getWcNewCustomerNotif()->sendSMS(array("\143\165\163\164\x6f\155\x65\162\137\151\144" => $RQ, "\156\145\x77\x5f\143\165\x73\x74\157\155\x65\x72\x5f\144\141\164\x61" => $S0, "\x70\141\163\x73\x77\x6f\x72\144\137\x67\145\156\x65\x72\141\164\x65\144" => $G5));
    }
    function mo_send_new_customer_sms_note($Tw)
    {
        $this->notificationSettings->getWcCustomerNoteNotif()->sendSMS(array("\157\x72\x64\x65\162\x44\145\x74\141\x69\x6c\163" => wc_get_order($Tw["\x6f\162\x64\x65\x72\x5f\151\144"])));
    }
    function mo_send_admin_order_sms_notif($pb, $kD, $D9)
    {
        $yr = new WC_Order($pb);
        if (is_a($yr, "\127\103\137\117\x72\x64\145\x72")) {
            goto NO;
        }
        return;
        NO:
        $this->notificationSettings->getWcAdminOrderStatusNotif()->sendSMS(array("\x6f\x72\144\x65\162\104\x65\x74\141\x69\154\163" => $yr, "\x6e\x65\167\137\x73\x74\x61\x74\165\163" => $D9, "\157\x6c\x64\x5f\163\x74\x61\x74\165\163" => $kD));
    }
    function mo_customer_order_hold_sms_notif($pb, $kD, $D9)
    {
        $yr = new WC_Order($pb);
        if (is_a($yr, "\127\x43\137\117\x72\x64\145\162")) {
            goto aG;
        }
        return;
        aG:
        if (strcasecmp($D9, WcOrderStatus::ON_HOLD) == 0) {
            goto Jw;
        }
        if (strcasecmp($D9, WcOrderStatus::PROCESSING) == 0) {
            goto J4;
        }
        if (strcasecmp($D9, WcOrderStatus::COMPLETED) == 0) {
            goto H4;
        }
        if (strcasecmp($D9, WcOrderStatus::REFUNDED) == 0) {
            goto bj;
        }
        if (strcasecmp($D9, WcOrderStatus::CANCELLED) == 0) {
            goto E4;
        }
        if (strcasecmp($D9, WcOrderStatus::FAILED) == 0) {
            goto cF;
        }
        if (strcasecmp($D9, WcOrderStatus::PENDING) == 0) {
            goto lJ;
        }
        return;
        goto Gg;
        Jw:
        $tK = $this->notificationSettings->getWcOrderOnHoldNotif();
        goto Gg;
        J4:
        $tK = $this->notificationSettings->getWcOrderProcessingNotif();
        goto Gg;
        H4:
        $tK = $this->notificationSettings->getWcOrderCompletedNotif();
        goto Gg;
        bj:
        $tK = $this->notificationSettings->getWcOrderRefundedNotif();
        goto Gg;
        E4:
        $tK = $this->notificationSettings->getWcOrderCancelledNotif();
        goto Gg;
        cF:
        $tK = $this->notificationSettings->getWcOrderFailedNotif();
        goto Gg;
        lJ:
        $tK = $this->notificationSettings->getWcOrderPendingNotif();
        Gg:
        $tK->sendSMS(array("\157\x72\x64\x65\x72\104\x65\x74\141\x69\154\x73" => $yr));
    }
    function unhook($g7)
    {
        $S1 = array($g7->emails["\127\x43\137\x45\155\141\x69\154\137\x4e\145\167\x5f\x4f\162\x64\145\162"], "\164\x72\151\x67\147\145\162");
        $MR = array($g7->emails["\127\103\137\105\155\141\151\x6c\x5f\103\x75\163\x74\157\155\x65\x72\137\120\x72\157\x63\145\163\163\x69\156\x67\x5f\117\162\144\145\x72"], "\x74\162\151\x67\x67\145\x72");
        $lU = array($g7->emails["\x57\x43\x5f\105\155\x61\151\x6c\x5f\103\x75\163\x74\x6f\155\x65\162\x5f\103\x6f\x6d\160\154\145\x74\x65\144\137\x4f\162\144\x65\x72"], "\x74\162\x69\147\x67\x65\x72");
        $vm = array($g7->emails["\127\103\x5f\x45\x6d\141\x69\154\x5f\x43\x75\163\164\x6f\155\145\162\137\116\157\164\x65"], "\x74\162\151\147\147\145\162");
        remove_action("\x77\x6f\157\x63\x6f\x6d\155\x65\x72\143\145\137\x6c\157\167\x5f\x73\164\x6f\x63\153\x5f\156\x6f\164\151\146\x69\143\141\164\x69\157\x6e", array($g7, "\154\157\167\x5f\x73\164\157\x63\153"));
        remove_action("\167\x6f\x6f\143\157\155\155\145\162\143\145\x5f\156\157\x5f\x73\x74\x6f\143\x6b\137\156\x6f\164\151\146\x69\x63\141\x74\x69\157\x6e", array($g7, "\x6e\157\137\x73\x74\157\x63\153"));
        remove_action("\167\x6f\x6f\143\157\x6d\x6d\145\162\143\145\137\x70\162\157\x64\165\x63\164\137\157\156\x5f\x62\141\x63\153\x6f\162\144\x65\162\137\x6e\x6f\164\151\x66\x69\143\x61\164\151\157\156", array($g7, "\142\141\x63\153\157\162\144\145\x72"));
        remove_action("\x77\x6f\x6f\143\x6f\x6d\x6d\x65\x72\143\x65\x5f\157\162\144\145\162\137\163\164\x61\x74\x75\x73\x5f\x70\145\156\144\x69\156\147\x5f\x74\157\137\x70\x72\x6f\x63\145\163\x73\151\x6e\x67\137\x6e\157\x74\151\x66\151\x63\141\x74\x69\x6f\156", $S1);
        remove_action("\167\157\157\x63\157\155\x6d\145\x72\143\145\x5f\x6f\x72\x64\145\x72\x5f\x73\x74\x61\164\165\x73\137\160\x65\x6e\144\151\156\x67\137\164\157\x5f\143\157\155\x70\154\x65\x74\x65\x64\137\156\x6f\164\x69\146\151\x63\x61\x74\151\x6f\156", $S1);
        remove_action("\x77\157\157\143\x6f\155\x6d\145\162\143\145\137\x6f\162\144\x65\162\137\163\164\x61\x74\x75\x73\x5f\x70\145\x6e\x64\x69\x6e\147\137\x74\x6f\x5f\x6f\x6e\55\x68\x6f\154\144\x5f\156\157\x74\x69\146\x69\143\x61\164\151\x6f\156", $S1);
        remove_action("\167\157\x6f\x63\x6f\155\x6d\x65\162\x63\x65\137\157\162\144\x65\x72\137\x73\164\141\164\x75\163\137\x66\141\151\x6c\145\144\137\x74\157\x5f\x70\x72\157\x63\145\x73\x73\x69\156\x67\x5f\x6e\157\164\151\x66\151\x63\141\164\151\x6f\156", $S1);
        remove_action("\167\x6f\157\143\x6f\x6d\155\x65\162\143\145\x5f\x6f\162\144\145\162\x5f\x73\164\x61\164\x75\x73\x5f\146\141\x69\154\145\144\x5f\164\157\x5f\143\157\x6d\160\154\145\x74\x65\144\137\156\157\164\151\x66\151\143\141\164\x69\157\x6e", $S1);
        remove_action("\167\x6f\x6f\143\x6f\x6d\x6d\145\x72\143\x65\x5f\157\162\x64\x65\162\x5f\x73\x74\141\164\x75\163\137\146\x61\x69\154\145\x64\x5f\164\157\137\x6f\x6e\55\150\x6f\154\x64\x5f\x6e\157\164\151\x66\x69\x63\x61\x74\151\x6f\156", $S1);
        remove_action("\167\157\157\143\157\x6d\x6d\x65\x72\x63\x65\137\x6f\162\144\145\162\x5f\x73\x74\x61\x74\165\x73\x5f\160\145\156\x64\151\x6e\x67\x5f\x74\157\137\x70\162\157\143\145\163\x73\x69\156\147\137\156\x6f\164\151\146\151\x63\x61\x74\151\157\156", $MR);
        remove_action("\x77\157\x6f\143\157\155\x6d\x65\162\x63\145\137\x6f\162\x64\145\162\x5f\163\164\141\x74\x75\163\137\x70\x65\x6e\144\151\x6e\x67\137\164\x6f\x5f\x6f\156\x2d\x68\x6f\x6c\x64\137\156\x6f\x74\x69\x66\x69\x63\x61\164\151\x6f\x6e", $MR);
        remove_action("\167\157\157\143\157\155\x6d\145\x72\x63\x65\137\x6f\x72\x64\145\162\x5f\163\x74\141\164\x75\163\137\143\157\x6d\x70\154\145\164\x65\x64\137\x6e\x6f\x74\151\146\151\143\x61\164\151\x6f\156", $lU);
        remove_action("\x77\157\157\x63\157\x6d\155\x65\162\x63\x65\x5f\156\145\167\137\143\x75\163\x74\157\155\x65\x72\x5f\156\157\x74\145\x5f\x6e\x6f\x74\151\146\151\x63\141\164\x69\157\156", $vm);
    }
    function add_custom_msg_meta_box()
    {
        add_meta_box("\155\x6f\137\x77\143\137\x63\x75\x73\x74\157\x6d\137\x73\155\163\137\155\x65\164\141\x5f\x62\157\170", "\103\165\x73\x74\x6f\155\40\123\115\123", array($this, "\x6d\157\x5f\163\150\x6f\167\x5f\x73\x65\x6e\x64\137\x63\x75\x73\x74\x6f\x6d\137\155\163\147\x5f\142\x6f\170"), "\163\150\x6f\160\x5f\157\162\144\x65\162", "\163\x69\x64\x65", "\x64\x65\x66\141\x75\x6c\164");
    }
    function mo_show_send_custom_msg_box($FA)
    {
        $LE = new WC_Order($FA->ID);
        $FS = MoWcAddOnUtility::getCustomerNumberFromOrder($LE);
        include MSN_DIR . "\x76\x69\145\x77\x73\57\143\x75\x73\x74\157\x6d\55\x6f\x72\x64\x65\162\55\x6d\x73\x67\x2e\x70\x68\160";
    }
    function _send_custom_order_msg($bh)
    {
        if (!array_key_exists("\x6e\x75\x6d\x62\x65\x72\x73", $bh) || MoUtility::isBlank(sanitize_text_field($bh["\x6e\x75\x6d\142\145\162\163"]))) {
            goto Ih;
        }
        foreach (explode("\x3b", $bh["\x6e\165\x6d\x62\145\162\163"]) as $fh) {
            if (MoUtility::send_phone_notif($fh, $bh["\155\163\x67"])) {
                goto kJ;
            }
            wp_send_json(MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ERROR_SENDING_SMS), MoConstants::ERROR_JSON_TYPE));
            goto kB;
            kJ:
            wp_send_json(MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::SMS_SENT_SUCCESS), MoConstants::SUCCESS_JSON_TYPE));
            kB:
            P3:
        }
        ru:
        goto Tf;
        Ih:
        MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::INVALID_PHONE), MoConstants::ERROR_JSON_TYPE);
        Tf:
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\x77\143\x5f\163\x6d\x73\137\x6e\157\164\151\146\x69\x63\x61\164\x69\x6f\x6e\x5f\x61\144\144\x6f\156";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\101\154\154\x6f\167\x73\40\x79\x6f\165\x72\40\163\x69\x74\x65\40\x74\x6f\40\163\145\156\144\40\157\x72\144\x65\x72\40\x61\x6e\x64\x20\x57\157\x6f\103\x6f\155\155\x65\162\x63\145\x20\156\157\164\x69\146\x69\x63\x61\x74\x69\157\156\x73\40\x74\157\40\142\165\171\145\162\x73\54\x20" . "\x73\145\x6c\x6c\145\x72\163\40\x61\x6e\144\40\x61\144\155\151\x6e\x73\56\40\103\154\x69\x63\x6b\x20\157\x6e\40\x74\150\x65\x20\x73\145\164\x74\x69\x6e\147\163\40\142\x75\164\x74\x6f\156\x20\x74\157\40\164\x68\145\x20\162\x69\x67\x68\x74\x20\x74\157\x20\x73\x65\145\40\x74\150\145\x20\154\151\163\x74\x20\x6f\x66\x20\156\x6f\164\x69\x66\x69\143\x61\164\151\x6f\156\163\x20" . "\x74\150\141\164\x20\147\x6f\x20\157\165\164\x2e");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\127\157\x6f\103\157\x6d\x6d\x65\162\143\145\40\123\x4d\123\x20\x4e\157\x74\151\x66\151\x63\141\164\151\x6f\156");
    }
    function setAddOnDocs()
    {
        $this->_addOnDocs = MoOTPDocs::WOCOMMERCE_SMS_NOTIFICATION_LINK["\147\x75\151\144\145\114\x69\156\153"];
    }
    function setAddOnVideo()
    {
        $this->_addOnVideo = MoOTPDocs::WOCOMMERCE_SMS_NOTIFICATION_LINK["\166\151\x64\145\157\x4c\x69\156\153"];
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\141\x64\144\157\x6e" => "\167\x6f\x6f\x63\x6f\x6d\x6d\145\162\x63\145\137\156\157\x74\151\146"), $_SERVER["\122\105\x51\x55\x45\123\x54\x5f\x55\x52\x49"]);
    }
}
