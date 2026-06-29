<?php


namespace OTP\Addons\WcSMSNotification\Helper;

use OTP\Helper\MoUtility;
use WC_Order;
use WP_User_Query;
class MoWcAddOnUtility
{
    public static function getAdminPhoneNumber()
    {
        $notification_settings =get_wc_option('notification_settings');
        if($notification_settings){
            $smsSettings    = $notification_settings->getWcAdminOrderStatusNotif();
            $recipientValue     = maybe_unserialize($smsSettings->recipient);
        }
         return ! empty( $recipientValue ) ? $recipientValue : "";
    }
    public static function getCustomerNumberFromOrder($yr)
    {
        $nL = $yr->get_user_id();
        $Dk = $yr->get_billing_phone();
        return !empty($Dk) ? $Dk : get_user_meta($nL, "\142\x69\x6c\x6c\151\x6e\147\137\x70\x68\x6f\x6e\x65", true);
    }
    public static function is_addon_activated()
    {
        MoUtility::is_addon_activated();
    }
}
