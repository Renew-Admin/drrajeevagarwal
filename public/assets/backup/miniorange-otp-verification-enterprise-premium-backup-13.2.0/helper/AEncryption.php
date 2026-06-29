<?php


namespace OTP\Helper;

if (defined("\x41\x42\123\120\101\x54\110")) {
    goto oUD;
}
exit;
oUD:
class AEncryption
{
    public static function encrypt_data($Dy, $N3)
    {
        $s_ = '';
        $tt = 0;
        E7E:
        if (!($tt < strlen($Dy))) {
            goto wEY;
        }
        $wP = substr($Dy, $tt, 1);
        $mu = substr($N3, $tt % strlen($N3) - 1, 1);
        $wP = chr(ord($wP) + ord($mu));
        $s_ .= $wP;
        KrP:
        $tt++;
        goto E7E;
        wEY:
        return base64_encode($s_);
    }
    public static function decrypt_data($Dy, $N3)
    {
        $s_ = '';
        $Dy = base64_decode($Dy);
        $tt = 0;
        Mhk:
        if (!($tt < strlen($Dy))) {
            goto Jtz;
        }
        $wP = substr($Dy, $tt, 1);
        $mu = substr($N3, $tt % strlen($N3) - 1, 1);
        $wP = chr(ord($wP) - ord($mu));
        $s_ .= $wP;
        fvJ:
        $tt++;
        goto Mhk;
        Jtz:
        return $s_;
    }
}
