<?php


namespace OTP\Addons\PasswordReset\Helper;

use OTP\Helper\MoUtility;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
final class UMPasswordResetMessages extends BaseMessages
{
    use Instance;
    private function __construct()
    {
        define("\115\x4f\137\x55\x4d\x50\122\x5f\x41\x44\104\x4f\x4e\137\x4d\x45\x53\123\101\107\x45\x53", serialize(array(self::USERNAME_MISMATCH => mo_("\x55\163\x65\162\x6e\x61\x6d\x65\40\164\150\141\164\40\164\x68\x65\40\117\124\120\x20\x77\141\163\40\x73\145\x6e\164\x20\164\157\40\x61\x6e\144\x20\164\150\145\x20\165\163\145\x72\156\x61\155\145\x20\x73\x75\142\155\x69\x74\164\145\x64\40\x64\157\x20\156\x6f\164\x20\155\141\x74\x63\x68"), self::USERNAME_NOT_EXIST => mo_("\127\x65\40\143\x61\x6e\47\x74\x20\146\151\x6e\144\x20\141\x6e\x20\141\143\143\x6f\x75\156\164\x20\x72\x65\x67\x69\163\x74\x65\x72\145\x64\40\x77\x69\x74\150\x20\x74\150\x61\x74\x20\141\x64\144\162\145\163\x73\x20\157\x72\x20" . "\165\163\145\162\156\x61\x6d\145\40\x6f\x72\40\x70\150\157\x6e\145\x20\x6e\165\155\142\145\x72"), self::RESET_LABEL => mo_("\x54\x6f\x20\162\145\163\x65\x74\40\171\x6f\165\x72\x20\x70\141\x73\163\x77\x6f\x72\x64\x2c\x20\x70\x6c\x65\x61\163\145\x20\x65\x6e\164\145\162\40\x79\157\165\162\x20\x65\x6d\x61\x69\x6c\40\141\144\x64\162\x65\x73\163\x2c\40\165\163\145\x72\156\x61\x6d\x65\x20\x6f\x72\40\160\150\157\x6e\x65\40\156\x75\x6d\142\x65\x72\40\x62\x65\x6c\x6f\x77"), self::RESET_LABEL_OP => mo_("\124\157\40\162\145\163\145\x74\40\171\x6f\x75\x72\40\160\x61\163\x73\x77\157\162\x64\54\40\160\x6c\145\141\163\x65\x20\145\x6e\x74\x65\162\40\171\x6f\x75\x72\40\162\145\147\151\x73\164\145\162\145\144\40\160\150\157\x6e\145\40\156\165\x6d\x62\145\162\40\x62\x65\154\x6f\167"))));
    }
    public static function showMessage($xL, $FA = array())
    {
        $bm = '';
        $xL = explode("\x20", $xL);
        $Ps = unserialize(MO_UMPR_ADDON_MESSAGES);
        $Zz = unserialize(MO_MESSAGES);
        $Ps = array_merge($Ps, $Zz);
        foreach ($xL as $ke) {
            if (!MoUtility::isBlank($ke)) {
                goto Fu;
            }
            return $bm;
            Fu:
            $qV = $Ps[$ke];
            foreach ($FA as $j1 => $qL) {
                $qV = str_replace("\173\173" . $j1 . "\175\x7d", $qL, $qV);
                CT:
            }
            RA:
            $bm .= $qV;
            zm:
        }
        Vz:
        return $bm;
    }
}
