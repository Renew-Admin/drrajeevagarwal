<?php


namespace OTP\Addons\UmSMSNotification\Helper;

use OTP\Helper\MoUtility;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
final class UltimateMemberSMSNotificationMessages extends BaseMessages
{
    use Instance;
    private function __construct()
    {
        define("\115\117\137\125\115\137\x41\104\x44\117\116\x5f\x4d\105\123\x53\101\x47\x45\123", serialize(array(self::NEW_UM_CUSTOMER_NOTIF_HEADER => mo_("\x4e\105\x57\40\101\x43\103\x4f\125\x4e\x54\x20\116\117\124\111\106\111\x43\x41\x54\x49\117\116"), self::NEW_UM_CUSTOMER_NOTIF_BODY => mo_("\x43\165\163\164\157\155\145\x72\163\40\141\162\145\40\x73\145\156\164\x20\141\40\x6e\145\x77\40\141\x63\x63\157\165\156\x74\40\123\x4d\x53\x20\156\x6f\x74\151\x66\151\x63\141\164\x69\x6f\156" . "\x20\x77\150\x65\156\40\164\x68\145\x79\x20\x73\151\x67\156\40\165\x70\40\x6f\156\x20\164\x68\x65\40\x73\x69\164\x65\x2e"), self::NEW_UM_CUSTOMER_SMS => mo_("\124\x68\x61\x6e\x6b\163\x20\x66\157\162\40\x63\x72\x65\141\164\151\156\147\x20\x61\x6e\x20\141\143\x63\x6f\165\156\x74\40\157\x6e\40\x7b\163\x69\x74\145\55\156\141\155\145\x7d\x2e\40\x59\157\165\162\40" . "\165\x73\x65\162\156\x61\155\145\40\151\163\x20\173\165\163\145\162\x6e\141\x6d\x65\175\56\40\114\157\x67\151\156\40\110\145\162\145\x3a\x20\x7b\x61\x63\x63\x6f\x75\x6e\164\160\141\147\x65\55\x75\x72\x6c\x7d"), self::NEW_UM_CUSTOMER_ADMIN_NOTIF_BODY => mo_("\x41\144\155\x69\156\163\x20\x61\162\145\x20\x73\145\156\x74\x20\x61\40\156\x65\x77\x20\x61\x63\x63\157\x75\156\x74\x20\x53\115\x53\x20\x6e\157\x74\x69\146\151\x63\x61\x74\151\157\x6e\40\x77\x68\x65\x6e" . "\40\141\40\x75\163\145\162\40\x73\151\x67\x6e\x73\x20\x75\160\40\x6f\x6e\x20\164\x68\145\x20\x73\x69\164\x65\56"), self::NEW_UM_CUSTOMER_ADMIN_SMS => mo_("\116\x65\x77\40\125\163\145\x72\40\103\x72\x65\141\164\145\x64\x20\157\x6e\x20\x7b\x73\151\164\145\x2d\156\141\x6d\x65\175\x2e\x20\125\x73\x65\x72\x6e\x61\x6d\x65\x3a\40" . "\x7b\165\163\145\162\x6e\x61\x6d\145\x7d\56\x20\x50\162\157\146\151\154\145\x20\120\x61\x67\x65\x3a\x20\173\x61\143\143\x6f\x75\x6e\164\x70\x61\x67\x65\55\x75\162\x6c\175"))));
    }
    public static function showMessage($xL, $FA = array())
    {
        $bm = '';
        $xL = explode("\x20", $xL);
        $Ps = unserialize(MO_UM_ADDON_MESSAGES);
        $Zz = unserialize(MO_MESSAGES);
        $Ps = array_merge($Ps, $Zz);
        foreach ($xL as $ke) {
            if (!MoUtility::isBlank($ke)) {
                goto Dl;
            }
            return $bm;
            Dl:
            $qV = $Ps[$ke];
            foreach ($FA as $j1 => $qL) {
                $qV = str_replace("\173\173" . $j1 . "\175\x7d", $qL, $qV);
                sx:
            }
            FR:
            $bm .= $qV;
            mU:
        }
        ON:
        return $bm;
    }
}
