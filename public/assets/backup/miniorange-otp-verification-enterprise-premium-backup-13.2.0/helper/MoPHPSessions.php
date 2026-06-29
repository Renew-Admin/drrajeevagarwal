<?php


namespace OTP\Helper;

use OTP\Objects\IMoSessions;
if (defined("\x41\102\123\120\x41\x54\110")) {
    goto lGA;
}
exit;
lGA:
class MoPHPSessions implements IMoSessions
{
    static function addSessionVar($j1, $H5)
    {
        switch (MOV_SESSION_TYPE) {
            case "\103\x4f\x4f\113\111\x45":
                setcookie($j1, maybe_serialize($H5));
                goto L2M;
            case "\123\x45\x53\123\111\117\x4e":
                self::checkSession();
                $_SESSION[$j1] = maybe_serialize($H5);
                goto L2M;
            case "\103\x41\x43\110\105":
                if (wp_cache_add($j1, maybe_serialize($H5))) {
                    goto naE;
                }
                wp_cache_replace($j1, maybe_serialize($H5));
                naE:
                goto L2M;
            case "\x54\x52\x41\116\123\111\105\x4e\x54":
                if (!isset($_COOKIE["\x74\162\x61\x6e\x73\151\x65\x6e\x74\137\x6b\x65\x79"])) {
                    goto z6p;
                }
                $Vt = sanitize_text_field($_COOKIE["\164\x72\x61\156\x73\151\x65\156\164\137\153\x65\x79"]);
                goto ukI;
                z6p:
                if (!wp_cache_get("\164\x72\x61\156\x73\x69\x65\x6e\x74\x5f\x6b\145\x79")) {
                    goto vr0;
                }
                $Vt = wp_cache_get("\x74\162\141\x6e\x73\x69\x65\x6e\x74\x5f\153\x65\171");
                goto qPf;
                vr0:
                $Vt = MoUtility::rand();
                if (!ob_get_contents()) {
                    goto jQw;
                }
                ob_clean();
                jQw:
                setcookie("\x74\162\141\156\163\151\145\156\x74\x5f\153\145\171", $Vt, time() + 12 * HOUR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
                wp_cache_add("\x74\162\141\156\x73\x69\x65\156\164\137\x6b\145\x79", $Vt);
                qPf:
                ukI:
                set_site_transient($Vt . $j1, $H5, 12 * HOUR_IN_SECONDS);
                goto L2M;
        }
        JIq:
        L2M:
    }
    static function getSessionVar($j1)
    {
        switch (MOV_SESSION_TYPE) {
            case "\103\117\x4f\x4b\111\105":
                return maybe_unserialize(sanitize_text_field($_COOKIE[$j1]));
            case "\x53\x45\123\x53\111\117\x4e":
                self::checkSession();
                return maybe_unserialize(MoUtility::sanitizeCheck($j1, $_SESSION));
            case "\x43\101\x43\110\105":
                return maybe_unserialize(wp_cache_get($j1));
            case "\x54\x52\x41\x4e\x53\x49\x45\116\x54":
                $Vt = isset($_COOKIE["\x74\x72\141\156\163\151\145\x6e\x74\137\153\145\x79"]) ? sanitize_text_field($_COOKIE["\164\x72\x61\156\163\x69\x65\156\164\137\153\145\171"]) : wp_cache_get("\164\x72\x61\x6e\x73\x69\145\156\x74\137\153\145\171");
                return get_site_transient($Vt . $j1);
        }
        esG:
        ZtG:
    }
    static function unsetSession($j1)
    {
        switch (MOV_SESSION_TYPE) {
            case "\x43\x4f\117\x4b\111\105":
                unset($_COOKIE[$j1]);
                setcookie($j1, '', time() - 15 * 60);
                goto h4b;
            case "\123\x45\x53\x53\x49\117\116":
                self::checkSession();
                unset($_SESSION[$j1]);
                goto h4b;
            case "\x43\101\103\x48\105":
                wp_cache_delete($j1);
                goto h4b;
            case "\x54\122\x41\116\123\111\105\x4e\x54":
                $Vt = isset($_COOKIE["\164\162\141\x6e\163\151\145\x6e\x74\x5f\153\x65\x79"]) ? sanitize_text_field($_COOKIE["\164\x72\141\156\x73\x69\x65\156\x74\x5f\x6b\145\x79"]) : wp_cache_get("\x74\x72\x61\156\163\151\145\x6e\x74\137\x6b\145\171");
                if (MoUtility::isBlank($Vt)) {
                    goto TrM;
                }
                delete_site_transient($Vt . $j1);
                TrM:
                goto h4b;
        }
        PpR:
        h4b:
    }
    static function checkSession()
    {
        if (!(MOV_SESSION_TYPE == "\x53\105\123\123\111\x4f\116")) {
            goto a9h;
        }
        if (!(session_id() == '' || !isset($_SESSION))) {
            goto Ash;
        }
        session_start();
        Ash:
        a9h:
    }
}
