<?php


namespace OTP\Helper;

use OTP\Objects\NotificationSettings;
if (defined("\x41\x42\123\x50\101\124\110")) {
    goto sbU;
}
exit;
sbU:
class MocURLOTP
{
    public static function create_customer($mo, $Tf, $iK, $Dk = '', $a8 = '', $Fz = '')
    {
        $P9 = MoConstants::HOSTNAME . "\x2f\x6d\x6f\141\x73\57\x72\x65\x73\164\57\x63\x75\x73\x74\157\155\145\162\57\141\x64\x64";
        $Yw = MoConstants::DEFAULT_CUSTOMER_KEY;
        $B2 = MoConstants::DEFAULT_API_KEY;
        $Xw = array("\143\157\x6d\x70\x61\x6e\x79\116\x61\155\145" => $Tf, "\x61\162\145\141\117\x66\x49\156\x74\145\x72\x65\163\x74" => MoConstants::AREA_OF_INTEREST, "\146\151\162\163\164\x6e\141\x6d\x65" => $a8, "\x6c\x61\163\x74\156\141\155\145" => $Fz, "\145\155\x61\151\x6c" => $mo, "\160\x68\157\156\x65" => $Dk, "\x70\141\163\163\x77\x6f\162\144" => $iK);
        $dx = json_encode($Xw);
        $Fg = self::createAuthHeader($Yw, $B2);
        $aU = self::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    public static function get_customer_key($mo, $iK)
    {
        $P9 = MoConstants::HOSTNAME . "\57\155\157\141\x73\x2f\162\x65\x73\164\57\143\165\163\x74\157\x6d\145\162\57\153\145\x79";
        $Yw = MoConstants::DEFAULT_CUSTOMER_KEY;
        $B2 = MoConstants::DEFAULT_API_KEY;
        $Xw = array("\x65\x6d\x61\x69\x6c" => $mo, "\x70\141\163\x73\x77\x6f\x72\x64" => $iK);
        $dx = json_encode($Xw);
        $Fg = self::createAuthHeader($Yw, $B2);
        $aU = self::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    public static function check_customer($mo)
    {
        $P9 = MoConstants::HOSTNAME . "\x2f\155\x6f\141\x73\57\162\x65\x73\x74\57\x63\x75\x73\164\x6f\x6d\145\162\57\143\x68\x65\x63\x6b\55\x69\x66\55\145\170\151\163\x74\x73";
        $Yw = MoConstants::DEFAULT_CUSTOMER_KEY;
        $B2 = MoConstants::DEFAULT_API_KEY;
        $Xw = array("\x65\155\141\x69\x6c" => $mo);
        $dx = json_encode($Xw);
        $Fg = self::createAuthHeader($Yw, $B2);
        $aU = self::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    public static function mo_send_otp_token($bb, $mo = '', $Dk = '')
    {
        $mo = $bb == "\123\115\x53" ? NULL : $mo;
        $P9 = MoConstants::HOSTNAME . "\x2f\155\x6f\141\x73\x2f\141\x70\x69\x2f\x61\165\x74\x68\57\143\150\x61\154\154\x65\156\x67\x65";
        $Yw = !MoUtility::isBlank(get_mo_option("\x61\x64\155\x69\x6e\x5f\x63\165\x73\x74\x6f\x6d\145\162\x5f\x6b\145\x79")) ? get_mo_option("\141\x64\x6d\x69\156\137\143\165\163\164\157\x6d\x65\x72\137\x6b\x65\171") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $B2 = !MoUtility::isBlank(get_mo_option("\141\144\155\x69\x6e\x5f\x61\x70\x69\137\153\x65\x79")) ? get_mo_option("\x61\144\155\151\x6e\x5f\141\x70\151\137\153\x65\x79") : MoConstants::DEFAULT_API_KEY;
        $Xw = array("\x63\165\x73\164\157\x6d\x65\162\113\x65\x79" => $Yw, "\145\155\x61\151\x6c" => $mo, "\x70\150\x6f\156\145" => $Dk, "\141\x75\x74\x68\x54\171\x70\x65" => $bb, "\164\162\141\156\x73\x61\x63\x74\151\157\x6e\x4e\141\x6d\x65" => MoConstants::AREA_OF_INTEREST);
        $dx = json_encode($Xw);
        $Fg = self::createAuthHeader($Yw, $B2);
        $aU = self::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    public static function validate_otp_token($oN, $U4)
    {
        $P9 = MoConstants::HOSTNAME . "\x2f\x6d\x6f\x61\x73\57\x61\x70\x69\x2f\x61\x75\164\150\57\166\141\154\x69\x64\x61\x74\x65";
        $Yw = !MoUtility::isBlank(get_mo_option("\x61\x64\x6d\151\156\137\143\x75\x73\x74\157\x6d\145\162\x5f\x6b\145\x79")) ? get_mo_option("\141\x64\155\x69\156\x5f\x63\165\163\x74\x6f\x6d\x65\x72\x5f\x6b\145\171") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $B2 = !MoUtility::isBlank(get_mo_option("\x61\x64\155\x69\156\137\141\x70\x69\x5f\x6b\x65\x79")) ? get_mo_option("\141\x64\x6d\x69\x6e\x5f\x61\x70\x69\137\x6b\145\x79") : MoConstants::DEFAULT_API_KEY;
        $Xw = array("\x74\x78\111\144" => $oN, "\x74\x6f\153\x65\156" => $U4);
        $dx = json_encode($Xw);
        $Fg = self::createAuthHeader($Yw, $B2);
        $aU = self::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    public static function submit_contact_us($bA, $Xg, $KI)
    {
        $current_user = wp_get_current_user();
        $P9 = MoConstants::HOSTNAME . "\57\x6d\x6f\141\163\57\x72\145\x73\x74\57\143\165\x73\x74\157\x6d\x65\x72\x2f\143\x6f\x6e\164\141\143\164\x2d\x75\x73";
        $KI = "\133" . MoConstants::AREA_OF_INTEREST . "\40" . "\x28" . MoConstants::PLUGIN_TYPE . "\x29" . "\135\72\x20" . $KI;
        $Yw = !MoUtility::isBlank(get_mo_option("\x61\144\155\x69\x6e\137\143\x75\163\164\x6f\155\x65\162\137\x6b\x65\x79")) ? get_mo_option("\x61\x64\155\151\156\x5f\143\x75\x73\x74\x6f\155\145\x72\137\x6b\x65\171") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $B2 = !MoUtility::isBlank(get_mo_option("\141\144\155\151\156\x5f\x61\x70\x69\x5f\x6b\145\171")) ? get_mo_option("\141\144\155\151\156\137\x61\x70\151\x5f\153\x65\171") : MoConstants::DEFAULT_API_KEY;
        $Xw = array("\146\151\x72\x73\164\116\x61\155\x65" => $current_user->user_firstname, "\154\x61\x73\x74\116\141\155\145" => $current_user->user_lastname, "\x63\157\x6d\x70\141\x6e\x79" => $_SERVER["\x53\105\x52\126\x45\122\x5f\116\101\x4d\x45"], "\x65\155\141\151\154" => $bA, "\143\143\105\155\141\x69\x6c" => MoConstants::FEEDBACK_EMAIL, "\160\150\x6f\x6e\145" => $Xg, "\161\165\x65\162\171" => $KI);
        $H8 = json_encode($Xw);
        $Fg = self::createAuthHeader($Yw, $B2);
        $aU = self::callAPI($P9, $H8, $Fg);
        return true;
    }
    public static function forgot_password($mo)
    {
        $P9 = MoConstants::HOSTNAME . "\x2f\155\x6f\x61\x73\57\162\x65\x73\164\57\x63\x75\163\164\x6f\155\145\162\57\x70\141\163\163\167\157\162\144\x2d\162\145\163\145\x74";
        $Yw = get_mo_option("\141\x64\x6d\x69\156\137\x63\x75\163\x74\x6f\155\x65\162\x5f\153\x65\171");
        $B2 = get_mo_option("\x61\x64\155\x69\156\x5f\141\x70\x69\137\x6b\145\171");
        $Xw = array("\x65\155\141\x69\x6c" => $mo);
        $dx = json_encode($Xw);
        $Fg = self::createAuthHeader($Yw, $B2);
        $aU = self::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    public static function check_customer_ln($Yw, $B2, $Pp)
    {
        $P9 = MoConstants::HOSTNAME . "\x2f\x6d\x6f\x61\163\x2f\162\145\x73\x74\x2f\143\165\163\164\x6f\155\145\162\57\x6c\151\143\145\156\163\x65";
        $Xw = array("\143\x75\x73\x74\157\x6d\145\162\x49\x64" => $Yw, "\x61\160\x70\154\x69\x63\141\x74\151\157\x6e\x4e\141\155\x65" => $Pp, "\x6c\151\143\x65\x6e\163\145\124\171\x70\145" => !MoUtility::micr() ? "\x44\105\115\x4f" : "\120\x52\x45\115\111\x55\115");
        $dx = json_encode($Xw);
        $Fg = self::createAuthHeader($Yw, $B2);
        $aU = self::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    public static function createAuthHeader($Yw, $B2)
    {
        $Uf = self::getTimestamp();
        if (!MoUtility::isBlank($Uf)) {
            goto yvJ;
        }
        $Uf = round(microtime(true) * 1000);
        $Uf = number_format($Uf, 0, '', '');
        yvJ:
        $ZQ = $Yw . $Uf . $B2;
        $Fg = hash("\163\150\141\65\x31\62", $ZQ);
        $Nm = ["\103\157\x6e\164\x65\156\x74\55\x54\x79\160\145" => "\x61\160\x70\154\151\143\x61\164\151\x6f\156\x2f\152\x73\157\x6e", "\103\x75\163\164\x6f\155\145\x72\x2d\113\x65\x79" => $Yw, "\124\x69\155\x65\x73\164\141\x6d\x70" => $Uf, "\101\x75\164\x68\157\162\x69\172\x61\164\x69\157\x6e" => $Fg];
        return $Nm;
    }
    public static function getTimestamp()
    {
        $P9 = MoConstants::HOSTNAME . "\57\x6d\x6f\x61\x73\57\x72\x65\x73\164\57\155\x6f\142\151\154\x65\x2f\x67\145\x74\x2d\164\151\x6d\x65\163\x74\141\x6d\x70";
        return self::callAPI($P9, null, null);
    }
    public static function callAPI($P9, $Vi, $BW = array("\103\157\156\x74\x65\156\164\55\x54\x79\160\x65" => "\x61\160\x70\x6c\151\x63\x61\164\151\x6f\156\57\152\163\157\x6e"), $qP = "\x50\x4f\123\x54")
    {
        $Tw = ["\155\x65\x74\150\x6f\144" => $qP, "\142\157\144\x79" => $Vi, "\164\x69\x6d\145\157\165\x74" => "\x31\x30\60\x30\60", "\x72\145\x64\x69\162\145\x63\164\x69\x6f\x6e" => "\x31\x30", "\x68\164\x74\160\x76\145\162\163\151\x6f\156" => "\x31\56\60", "\142\x6c\x6f\x63\153\x69\x6e\147" => true, "\x68\x65\x61\144\x65\162\163" => $BW, "\163\163\x6c\166\145\162\151\146\x79" => MOV_SSL_VERIFY];
        $aU = wp_remote_post($P9, $Tw);
        if (!is_wp_error($aU)) {
            goto UdV;
        }
        wp_die("\123\157\x6d\145\x74\150\x69\x6e\147\40\167\145\156\164\40\167\x72\157\156\147\72\x20\x3c\x62\162\x2f\76\x20{$aU->get_error_message()}");
        UdV:
        return wp_remote_retrieve_body($aU);
    }
    public static function send_notif(NotificationSettings $CW)
    {
        $ig = GatewayFunctions::instance();
        return $ig->mo_send_notif($CW);
    }
    public static function mo_whatsapp_create_instance($sY, $Rv, $oe)
    {
        $P9 = MoConstants::WHATSAPP_HOST . "\x2f\x61\160\151\x2f\x63\x72\145\141\164\145\x69\x6e\x73\x74\x61\x6e\x63\x65\56\160\x68\160";
        $P9 = $P9 . "\x3f\143\x6c\151\145\x6e\164\137\x69\144\75" . $sY . "\46\x63\157\144\145\75" . $Rv . "\x26\151\156\163\x74\x61\156\x63\145\137\x6e\x61\x6d\x65\x3d" . $oe;
        $aU = self::callAPI($P9, NULL);
        return json_decode($aU);
    }
    public static function mo_whatsapp_check_status($sY, $YA)
    {
        $P9 = MoConstants::WHATSAPP_HOST . "\57\141\160\151\x2f\x63\150\145\x63\x6b\143\x6f\156\156\145\x63\x74\151\157\156\56\x70\x68\x70";
        $P9 = $P9 . "\x3f\143\154\151\145\156\164\137\151\144\x3d" . $sY . "\x26\151\x6e\163\164\141\x6e\x63\x65\x3d" . $YA;
        $aU = self::callAPI($P9, NULL);
        return json_decode($aU);
    }
    public static function mo_whatsapp_send_sms($sY, $YA, $Dk, $bC)
    {
        $P9 = MoConstants::WHATSAPP_HOST . "\x2f\x61\160\x69\x2f\163\x65\156\144\56\160\150\x70";
        $P9 = $P9 . "\x3f\x63\154\x69\x65\x6e\164\x5f\x69\144\75" . $sY . "\46\151\x6e\163\x74\x61\156\x63\x65\75" . $YA . "\46\x74\171\160\x65\75\x74\145\x78\x74" . "\46\x6e\165\x6d\142\x65\162\75" . $Dk . "\x26\x6d\x65\x73\x73\x61\x67\x65\75" . $bC;
        $aU = self::callAPI($P9, NULL);
        return json_decode($aU);
    }
    public static function mo_whatsapp_reconnect($sY, $YA)
    {
        $P9 = MoConstants::WHATSAPP_HOST . "\x2f\x61\x70\151\x2f\162\x65\x63\157\156\x6e\x65\x63\164\x2e\160\150\x70";
        $P9 = $P9 . "\77\143\154\151\x65\x6e\164\x5f\151\x64\75" . $sY . "\46\151\x6e\163\x74\141\156\143\145\75" . $YA;
        $aU = self::callAPI($P9, NULL);
        return json_decode($aU);
    }
}
