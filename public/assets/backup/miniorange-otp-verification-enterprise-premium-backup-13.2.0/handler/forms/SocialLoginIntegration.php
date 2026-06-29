<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class SocialLoginIntegration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::SOCIAL_LOGIN;
        $this->_phoneKey = "\x70\150\x6f\156\145";
        $this->_phoneFormId = "\43\160\x68\x6f\156\145\137\156\165\x6d\x62\145\x72\137\155\x6f";
        $this->_formKey = "\123\x4f\103\111\x41\x4c\137\114\117\107\111\x4e";
        $this->_typePhoneTag = "\x6d\x6f\x5f\163\157\x63\151\141\154\137\x6c\x6f\x67\x69\x6e\137\x70\x68\x6f\156\x65\137\145\x6e\141\142\154\x65";
        $this->_typeEmailTag = "\x6d\157\x5f\x77\x70\137\x64\145\x66\x61\165\x6c\164\137\145\x6d\x61\151\154\137\145\x6e\x61\142\x6c\145";
        $this->_typeBothTag = "\155\157\x5f\167\160\x5f\144\x65\146\x61\165\x6c\164\x5f\142\157\x74\x68\137\145\156\141\142\x6c\x65";
        $this->_formName = mo_("\x6d\x69\x6e\151\117\162\141\156\x67\x65\x20\x53\x6f\x63\x69\141\154\40\x4c\157\147\x69\x6e");
        $this->_isFormEnabled = get_mo_option("\155\157\x5f\x73\x6f\143\x69\x61\154\x5f\154\157\147\151\156\x5f\145\156\141\x62\x6c\x65");
        $this->_formDocuments = MoOTPDocs::SOCIAL_LOGIN;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = $this->_isFormEnabled ? $this->_typePhoneTag : '';
        add_action("\155\x6f\x5f\x62\145\x66\157\162\145\137\x69\156\x73\x65\162\164\x5f\x75\163\x65\162", [$this, "\x73\157\x63\151\141\x6c\x5f\154\x6f\147\x69\x6e\137\x76\x65\162\151\x66\151\x63\141\x74\151\157\156"], 1, 2);
        MoPHPSessions::checkSession();
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto EV;
        }
        $this->unsetOTPSessionVariables();
        $FA = $_POST;
        $pA = wp_generate_password(10, false);
        $gL = MoPHPSessions::getSessionVar("\165\163\145\x72\144\x65\164\141\151\x6c\x73");
        $in = MoPHPSessions::getSessionVar("\143\x75\x73\x74\137\162\x65\x67\x5f\166\141\154");
        $Y_ = array("\165\163\145\x72\x5f\x6c\157\x67\151\156" => $gL["\x75\163\x65\162\x5f\x6c\157\x67\x69\156"], "\165\x73\145\x72\x5f\145\x6d\141\x69\154" => $gL["\165\163\x65\162\x5f\x65\x6d\141\151\154"], "\165\x73\145\162\137\x70\141\x73\163" => $pA, "\x64\x69\x73\160\x6c\x61\x79\137\x6e\x61\155\145" => $gL["\x64\x69\163\160\154\x61\171\137\x6e\x61\x6d\x65"], "\146\151\x72\x73\164\x5f\156\141\x6d\x65" => $gL["\146\151\162\x73\164\137\x6e\141\x6d\145"], "\154\x61\x73\164\137\x6e\x61\x6d\x65" => $gL["\154\x61\163\x74\x5f\156\141\x6d\145"], "\165\x73\x65\162\137\x75\162\x6c" => $gL["\x75\x73\x65\162\x5f\165\x72\x6c"], "\x70\150\x6f\x6e\145" => sanitize_text_field($FA["\155\x6f\137\160\x68\x6f\156\145\x5f\156\165\x6d\142\145\x72"]));
        if (get_option("\x6d\157\137\x6f\160\145\x6e\151\144\x5f\162\145\163\x74\x72\x69\143\164\145\x64\137\144\157\155\141\151\156\163") == "\155\x6f\x5f\x6f\x70\x65\x6e\x69\144\137\x72\x65\x73\164\x72\x69\x63\164\x5f\144\157\x6d\141\151\x6e") {
            goto LB;
        }
        $this->allowed_domain($Y_["\x75\163\145\162\x5f\x65\x6d\x61\x69\154"]);
        goto xX;
        LB:
        $this->restricted_domain($Y_["\x75\x73\145\162\137\x65\155\141\x69\154"]);
        xX:
        $_SESSION["\x72\145\147\x69\x73\x74\x65\162\x65\144\x5f\165\x73\145\162"] = "\61";
        if (get_option("\x6d\x6f\x5f\157\160\145\x6e\x69\144\x5f\x65\x6e\141\x62\x6c\x65\x5f\x72\x65\147\x69\x73\x74\162\141\164\151\157\x6e\137\157\156\137\x70\141\x67\x65") == "\61") {
            goto wD;
        }
        $nL = wp_insert_user($Y_);
        goto C8;
        wD:
        $nL = $this->mo_openid_check_registration_block($Y_);
        C8:
        if (!($in != '')) {
            goto ec;
        }
        $this->update_custom_data($nL, $in);
        ec:
        if (!(get_option("\x6d\157\x5f\x6f\160\x65\x6e\151\x64\x5f\x75\x73\145\162\x5f\155\x6f\144\145\162\x61\x74\x69\157\x6e") == 1)) {
            goto xp;
        }
        add_user_meta($nL, "\141\x63\164\151\x76\x61\x74\x69\157\x6e\137\163\164\x61\x74\x65", "\x31");
        xp:
        if (!isset($_COOKIE["\x6d\157\x5f\157\x70\x65\x6e\151\x64\137\163\151\147\156\x75\x70\137\x75\162\154"])) {
            goto gg;
        }
        add_user_meta($nL, "\x72\145\x67\x69\163\x74\x65\162\x65\144\x5f\165\162\x6c", sanitize_text_field($_COOKIE["\155\157\x5f\x6f\x70\x65\x6e\x69\144\137\163\151\x67\x6e\x75\160\x5f\165\162\x6c"]));
        gg:
        $user = get_user_by("\145\155\x61\x69\154", $Y_["\x75\163\145\162\x5f\145\155\141\x69\154"]);
        if (!($nL && !is_wp_error($nL) && get_option("\155\x6f\x5f\x6f\x70\x65\156\151\144\x5f\145\x6d\x61\151\x6c\137\141\x63\x74\151\x76\141\x74\x69\157\x6e") == 1)) {
            goto iX;
        }
        $this->mo_send_activation_mail($user, $nL);
        $this->mo_openid_insert_query($gL["\163\x6f\143\x69\x61\x6c\137\141\x70\160\x5f\x6e\x61\x6d\x65"], $gL["\x75\x73\x65\162\x5f\145\x6d\141\x69\154"], $nL, $gL["\163\x6f\x63\151\141\154\x5f\165\x73\x65\x72\x5f\x69\x64"], $gL["\x75\163\x65\162\137\160\x69\x63\164\x75\x72\145"]);
        exit;
        iX:
        if (!is_wp_error($nL)) {
            goto uk;
        }
        print_r($nL);
        wp_die("\105\x72\162\x6f\x72\x20\x43\157\x64\145\40\x35\x3a\40" . get_option("\155\x6f\x5f\162\x65\x67\x69\x73\164\162\x61\x74\151\157\156\137\145\x72\x72\157\x72\x5f\155\x65\x73\163\x61\x67\145"));
        uk:
        update_option("\155\x6f\137\157\160\x65\x6e\x69\144\137\x75\x73\145\x72\137\143\157\x75\x6e\x74", get_option("\155\157\137\x6f\160\x65\156\x69\x64\x5f\x75\x73\x65\162\x5f\143\157\x75\156\164") + 1);
        $Hq = array("\165\163\145\x72\x6e\141\155\x65" => sanitize_text_field($gL["\165\x73\145\162\x5f\154\157\147\151\156"]), "\x75\x73\x65\162\x5f\x65\155\x61\151\154" => sanitize_email($gL["\x75\163\x65\162\137\145\155\x61\151\154"]), "\165\x73\145\162\137\146\x75\154\154\137\x6e\x61\x6d\145" => sanitize_text_field($gL["\144\x69\x73\160\154\141\171\x5f\x6e\141\x6d\x65"]), "\146\151\162\163\x74\137\156\x61\155\x65" => sanitize_text_field($gL["\x66\x69\162\163\164\x5f\156\x61\155\145"]), "\154\x61\163\x74\137\x6e\141\x6d\x65" => sanitize_text_field($gL["\x6c\x61\x73\x74\x5f\x6e\x61\x6d\x65"]), "\x75\x73\x65\162\137\165\x72\154" => sanitize_text_field($gL["\x75\x73\x65\162\x5f\x75\162\154"]), "\x75\163\145\162\137\160\151\143\164\165\x72\145" => sanitize_text_field($gL["\x75\163\145\x72\x5f\x70\x69\x63\x74\x75\162\x65"]), "\x73\157\x63\x69\141\x6c\137\x61\x70\160\x5f\156\x61\155\145" => sanitize_text_field($gL["\163\x6f\x63\x69\141\x6c\137\141\x70\160\x5f\x6e\141\155\145"]), "\x73\x6f\x63\x69\x61\154\137\165\163\x65\x72\137\x69\144" => sanitize_text_field($gL["\x73\x6f\143\x69\x61\154\x5f\165\x73\x65\x72\137\x69\x64"]));
        $this->mo_openid_start_session_login($Hq);
        $user = get_user_by("\x69\x64", $nL);
        update_user_meta($nL, "\x76\145\162\x69\146\151\x65\x64\x5f\156\x75\x6d\142\145\162", sanitize_text_field($FA["\x6d\157\x5f\x70\x68\x6f\x6e\145\x5f\x6e\x75\155\142\145\162"]));
        do_action("\x6d\157\137\x75\163\x65\x72\137\x72\x65\x67\x69\x73\164\x65\162", $nL, $gL["\165\163\x65\x72\137\160\162\x6f\x66\x69\154\x65\137\x75\162\x6c"]);
        $this->mo_openid_paid_membership_pro_integration($nL);
        $this->mo_openid_link_account($user->user_login, $user);
        global $wpdb;
        $US = $wpdb->prefix;
        $sI = $wpdb->get_var($wpdb->prepare("\x53\x45\114\x45\x43\x54\x20\x75\163\145\x72\137\151\144\x20\106\122\x4f\115\x20" . $US . "\x6d\157\x5f\x6f\x70\145\156\x69\144\x5f\x6c\151\156\153\145\144\137\165\x73\145\162\40\167\150\x65\162\x65\x20\x6c\x69\x6e\153\145\144\137\x73\157\x63\151\x61\x6c\x5f\141\160\160\x20\75\40\42\x25\163\x22\40\x41\116\104\x20\x69\144\x65\x6e\164\151\146\151\145\162\x20\75\40\x25\163", $gL["\163\x6f\143\x69\141\154\137\x61\x70\160\137\x6e\141\x6d\145"], $gL["\163\157\x63\151\141\x6c\137\x75\163\x65\162\137\151\x64"]));
        $this->mo_openid_login_user($sI, $nL, $user, $gL["\165\x73\x65\x72\137\160\x69\x63\164\x75\162\145"], 0);
        EV:
        $this->routeData();
    }
    function restricted_domain($p1)
    {
        $x6 = false;
        $Jk = get_option("\155\157\137\157\x70\x65\x6e\151\144\x5f\162\x65\x73\164\162\x69\x63\164\145\x64\137\x64\157\155\141\151\156\163\137\156\141\x6d\145");
        if (!(empty($Jk) || empty($p1))) {
            goto uX;
        }
        return;
        uX:
        $mo = explode("\x3b", $Jk);
        foreach ($mo as $qL) {
            $FA = explode("\x40", $p1);
            $hV = isset($FA[1]) ? $FA[1] : '';
            if (!($qL == $hV)) {
                goto o8;
            }
            $x6 = true;
            goto YR;
            o8:
            Q5:
        }
        YR:
        if (!$x6) {
            goto w5;
        }
        wp_die("\120\145\x72\x6d\151\163\x73\151\x6f\156\x20\x64\145\156\151\x65\144\56\40\131\x6f\x75\x20\x61\162\145\40\156\157\164\x20\x61\x6c\x6c\157\167\145\144\x20\164\157\x20\x72\145\147\x69\163\x74\145\x72\56\x20\120\x6c\145\x61\x73\145\x20\143\x6f\x6e\164\141\143\x74\40\x74\150\145\x20\141\144\155\x69\156\151\163\164\x72\x61\164\157\x72\x2e\40\x43\154\x69\x63\x6b\x20\x3c\x61\40\x68\x72\x65\146\x3d\x22" . get_site_url() . "\x22\x3e\150\145\162\x65\74\57\141\x3e\x20\164\x6f\40\x67\x6f\40\x62\x61\143\x6b\40\164\157\40\x74\x68\x65\40\167\145\x62\x73\x69\x74\x65\x2e");
        w5:
    }
    function allowed_domain($p1)
    {
        $x6 = false;
        $Jk = get_option("\x6d\157\x5f\157\160\x65\156\x69\144\x5f\x61\x6c\x6c\157\x77\145\x64\x5f\144\157\x6d\141\x69\x6e\x73\x5f\x6e\141\x6d\145");
        if (!(empty($Jk) || empty($p1))) {
            goto l9;
        }
        return;
        l9:
        $mo = explode("\x3b", $Jk);
        foreach ($mo as $qL) {
            $FA = explode("\100", $p1);
            $hV = isset($FA[1]) ? $FA[1] : '';
            if (!($qL == $hV)) {
                goto Ak;
            }
            $x6 = true;
            goto Xv;
            Ak:
            PN:
        }
        Xv:
        if ($x6) {
            goto KC;
        }
        wp_die("\120\x65\x72\x6d\151\x73\163\x69\157\x6e\x20\x64\145\x6e\151\145\144\x2e\40\x59\157\x75\x20\141\162\145\x20\x6e\157\164\40\141\154\x6c\x6f\167\145\144\x20\164\157\x20\162\x65\x67\x69\163\x74\x65\x72\x2e\x20\x50\x6c\145\141\163\x65\x20\143\157\x6e\x74\x61\x63\x74\x20\164\150\145\40\141\144\x6d\151\156\151\x73\164\x72\x61\164\x6f\162\56\40\103\154\x69\143\153\40\74\141\x20\x68\x72\145\146\75\x22" . get_site_url() . "\x22\x3e\150\145\x72\145\74\57\x61\x3e\x20\164\x6f\x20\x67\157\x20\x62\141\x63\x6b\x20\x74\x6f\40\x74\x68\145\x20\x77\145\x62\x73\x69\x74\x65\56");
        KC:
    }
    function mo_openid_check_registration_block($Y_)
    {
        $zE = explode("\x3b", get_option("\155\x6f\137\x6f\x70\x65\156\x69\144\x5f\162\x65\147\151\163\164\162\x61\164\151\x6f\x6e\x5f\x70\141\147\145\137\x75\x72\x6c\163"));
        foreach ($zE as $H5) {
            if (!(strpos($_COOKIE["\x6d\157\x5f\157\x70\x65\156\x69\144\x5f\x73\151\147\156\165\160\x5f\165\x72\x6c"], $H5) !== false)) {
                goto Jn;
            }
            $nL = wp_insert_user($Y_);
            return $nL;
            Jn:
            e6:
        }
        fF:
        wp_redirect(get_option("\x6d\157\137\x6f\160\145\x6e\x69\144\x5f\142\154\x6f\143\x6b\137\162\x65\147\x69\x73\x74\162\141\164\x69\157\x6e\137\x72\145\x64\x69\162\x65\143\x74\x5f\165\162\154"));
        exit;
    }
    function mo_openid_start_session_login($Hq)
    {
        mo_openid_start_session();
        $_SESSION["\x6d\157\137\x6c\157\x67\151\x6e"] = true;
        $_SESSION["\x75\x73\145\x72\156\x61\x6d\145"] = isset($Hq["\x75\163\x65\162\156\141\155\145"]) ? $Hq["\x75\163\x65\x72\x6e\x61\x6d\x65"] : '';
        $_SESSION["\x75\163\x65\x72\x5f\145\x6d\x61\x69\x6c"] = isset($Hq["\x75\163\x65\x72\137\145\155\x61\151\154"]) ? $Hq["\165\163\145\x72\x5f\x65\x6d\x61\151\154"] : '';
        $_SESSION["\165\x73\145\x72\137\146\x75\154\154\137\156\141\155\145"] = isset($Hq["\165\163\145\x72\x5f\x66\x75\154\154\x5f\156\x61\x6d\x65"]) ? $Hq["\165\x73\145\x72\137\146\x75\x6c\154\x5f\x6e\x61\155\x65"] : '';
        $_SESSION["\146\151\162\x73\164\x5f\156\x61\x6d\145"] = isset($Hq["\x66\x69\x72\163\x74\137\x6e\141\x6d\145"]) ? $Hq["\x66\x69\162\163\x74\137\156\141\x6d\145"] : '';
        $_SESSION["\x6c\141\x73\x74\x5f\x6e\x61\155\x65"] = isset($Hq["\154\x61\163\x74\137\x6e\141\155\145"]) ? $Hq["\154\x61\163\x74\137\156\141\155\x65"] : '';
        $_SESSION["\165\x73\145\x72\x5f\165\x72\x6c"] = isset($Hq["\x75\163\145\x72\137\x75\162\x6c"]) ? $Hq["\165\163\145\162\137\165\x72\x6c"] : '';
        $_SESSION["\165\x73\145\162\x5f\160\x69\143\x74\165\x72\145"] = isset($Hq["\x75\163\x65\x72\137\x70\x69\143\164\165\x72\145"]) ? $Hq["\x75\x73\x65\162\x5f\x70\x69\143\x74\x75\x72\145"] : '';
        $_SESSION["\x73\157\143\x69\x61\154\x5f\x61\x70\160\x5f\156\141\155\145"] = isset($Hq["\163\x6f\143\151\x61\x6c\137\x61\x70\x70\137\156\141\155\x65"]) ? $Hq["\163\157\143\151\x61\154\137\x61\x70\160\x5f\156\141\155\x65"] : '';
        $_SESSION["\163\157\143\x69\x61\x6c\x5f\x75\x73\x65\162\x5f\151\x64"] = isset($Hq["\x73\157\143\151\x61\154\137\x75\163\145\x72\137\151\x64"]) ? $Hq["\163\x6f\x63\151\x61\x6c\137\165\163\145\162\137\x69\x64"] : '';
    }
    function mo_openid_paid_membership_pro_integration($nL)
    {
        global $wpdb;
        if (!(get_option("\x6d\x6f\137\157\x70\x65\x6e\151\144\x5f\160\x61\151\x64\137\155\145\x6d\x62\x5f\144\x65\146\x61\x75\154\x74") == 1)) {
            goto Y5;
        }
        global $wpdb;
        $US = $wpdb->prefix;
        $j0 = $wpdb->get_var("\123\105\x4c\105\x43\124\40\x43\117\x55\x4e\x54\x28\x2a\51\40\x46\122\117\x4d\40\x77\160\x5f\x70\x6d\x70\x72\x6f\x5f\155\x65\x6d\x62\x65\162\x73\150\151\x70\x73\137\165\163\x65\162\163\40");
        $j0 = $j0 + 1;
        $gy = get_option("\155\157\x5f\157\x70\145\156\x69\144\137\x70\141\151\144\137\155\x65\x6d\x62\137\144\x65\146\141\165\154\x74\137\x6f\x70\x74");
        $ic = date("\x59\55\x6d\55\x64\40\110\x3a\151\72\x73");
        $WU = "\x69\x6e\163\145\162\x74\x20\151\x6e\x74\x6f\x20" . $US . "\155\145\155\x62\x65\x72\163\150\x69\x70\163\137\165\x73\x65\x72\x73\40\x76\x61\x6c\165\x65\163\40\50{$j0}\x2c\40{$nL}\x2c\x20{$gy}\x2c\x20\x30\x2c\x20\60\x2e\x30\60\x2c\40\60\56\x30\60\54\x20\x30\54\40\47\x27\x2c\x20\x30\x2c\40\x30\56\60\x30\x2c\40\60\54\40\x27\x61\x63\x74\151\166\145\47\x2c\40\x27{$ic}\47\x2c\40\x27\x30\x30\x30\x30\x2d\60\60\55\60\x30\x20\60\60\x3a\60\60\x3a\x30\60\x27\x2c\x20\47{$ic}\47\51";
        $Hb = $wpdb->query($WU);
        if (!($Hb === false)) {
            goto nd;
        }
        $wpdb->show_errors();
        $wpdb->print_error();
        wp_die("\105\x72\x72\x6f\x72\40\x69\x6e\x20\151\x6e\163\x65\162\164\x20\121\x75\145\x72\x79");
        exit;
        nd:
        Y5:
        if (!(get_option("\155\157\x5f\x6f\x70\x65\x6e\151\x64\x5f\x70\x61\x69\x64\137\155\145\x6d\142\x5f\x63\150\157\157\163\145") == 1)) {
            goto LE;
        }
        update_user_meta($nL, "\143\x68\x6f\x73\145\x6e\x5f\155\145\x6d\x62\145\x72\163\x68\151\160", 0);
        LE:
    }
    function mo_openid_link_account($zC, $user)
    {
        if (!$user) {
            goto tF;
        }
        $oV = $user->ID;
        tF:
        mo_openid_start_session();
        $p1 = isset($_SESSION["\165\x73\x65\x72\x5f\x65\x6d\141\151\154"]) ? sanitize_text_field($_SESSION["\165\x73\145\162\x5f\145\x6d\x61\x69\x6c"]) : '';
        $AS = isset($_SESSION["\x73\157\143\x69\x61\x6c\x5f\165\163\145\162\137\151\144"]) ? sanitize_text_field($_SESSION["\163\x6f\x63\x69\141\154\x5f\x75\x73\145\162\x5f\x69\x64"]) : '';
        $R8 = isset($_SESSION["\x73\157\143\151\141\154\x5f\x61\160\x70\x5f\156\x61\x6d\145"]) ? sanitize_text_field($_SESSION["\x73\157\x63\151\141\154\x5f\x61\160\x70\137\156\x61\x6d\145"]) : '';
        if (isset($oV) && empty($AS) && empty($R8)) {
            goto mQ;
        }
        if (!isset($oV)) {
            goto OY;
        }
        goto x9;
        mQ:
        return;
        goto x9;
        OY:
        return;
        x9:
        global $wpdb;
        $US = $wpdb->prefix;
        $sI = $wpdb->get_var($wpdb->prepare("\123\x45\114\x45\x43\x54\x20\165\163\x65\162\137\x69\144\40\x46\122\117\x4d\40" . $US . "\155\x6f\x5f\157\x70\145\156\151\144\137\154\x69\156\x6b\x65\144\x5f\x75\163\145\162\x20\x77\150\x65\162\145\40\154\x69\x6e\153\145\144\137\x65\155\141\x69\154\40\x3d\x20\x22\45\x73\42\x20\x41\x4e\x44\x20\x6c\151\x6e\x6b\x65\144\137\x73\157\143\x69\x61\154\137\x61\x70\x70\x20\75\x20\x22\45\x73\42", $p1, $R8));
        if (isset($sI)) {
            goto ro;
        }
        $this->mo_openid_insert_query($R8, $p1, $oV, $AS);
        ro:
    }
    function mo_openid_login_user($sI, $nL, $user, $Xr, $PJ)
    {
        if (!(get_option("\x6d\x6f\157\160\x65\156\x69\144\137\163\x6f\143\x69\x61\154\x5f\154\157\x67\x69\x6e\x5f\141\x76\141\164\x61\x72") && isset($Xr))) {
            goto FG;
        }
        update_user_meta($nL, "\155\157\157\x70\x65\x6e\x69\x64\x5f\165\x73\145\x72\137\141\166\141\164\x61\x72", $Xr);
        FG:
        if (!(get_option("\155\x6f\x5f\x6f\x70\145\156\x69\144\x5f\x65\x6d\141\x69\154\137\141\x63\164\151\x76\x61\x74\x69\157\x6e") == 1)) {
            goto V1;
        }
        mo_verify_activated_user($user, $user->ID);
        exit;
        V1:
        if (get_option("\x6d\157\x5f\x6f\160\145\156\151\144\x5f\x75\163\145\162\x5f\155\x6f\144\145\x72\141\164\x69\157\x6e") == 1) {
            goto pA;
        }
        $this->mo_openid_paid_membership_pro_integration($nL);
        goto Fl;
        pA:
        $Qu = get_user_meta($sI, "\x61\x63\x74\x69\x76\x61\164\x69\x6f\156\137\163\x74\x61\x74\x65");
        if ($Qu[0] != "\x31") {
            goto oK;
        }
        $this->mo_openid_paid_membership_pro_integration($nL);
        $this->mo_openid_link_account($user->user_login, $user);
        echo "\40\x20\x20\40\40\40\x20\40\x20\x20\40\40\40\x20\40\x20\74\163\x63\162\x69\x70\164\76\15\xa\40\40\x20\x20\x20\x20\x20\x20\40\40\x20\40\x20\40\40\x20\x20\40\x20\x20\166\x61\x72\40\160\157\x70\x5f\165\160\40\x3d\40\x27";
        echo get_option("\x6d\x6f\137\157\x70\145\156\151\x64\137\160\157\160\165\160\x5f\x77\x69\156\x64\x6f\x77");
        echo "\47\x3b\xd\12\40\x20\40\x20\x20\40\40\x20\x20\x20\40\x20\40\40\x20\40\x20\x20\x20\40\151\146\40\x28\x70\157\160\137\x75\160\x3d\x3d\40\47\x30\47\x29\40\173\15\xa\x20\x20\40\x20\x20\40\x20\40\x20\x20\40\x20\x20\x20\40\x20\40\x20\x20\40\40\40\x20\40\141\x6c\x65\162\x74\50\x22\x53\165\143\143\145\x73\163\x66\x75\154\x6c\171\x20\162\x65\147\x69\x73\164\145\x72\x65\144\x21\40\131\x6f\165\x20\167\151\x6c\x6c\40\x67\145\x74\40\156\x6f\x74\151\146\151\x63\141\x74\x69\157\x6e\40\141\x66\x74\145\x72\40\141\x63\164\151\166\x61\164\x69\157\x6e\40\x6f\x66\x20\171\157\x75\162\40\x61\x63\x63\x6f\165\156\164\x2e\x22\x29\73\xd\xa\x20\40\40\40\x20\x20\40\40\40\40\40\x20\x20\x20\40\x20\40\x20\40\x20\40\x20\x20\x20\167\151\x6e\x64\x6f\x77\56\x6c\x6f\x63\x61\164\151\x6f\x6e\x20\75\40\42";
        echo get_option("\163\x69\x74\145\x75\162\x6c");
        echo "\42\x3b\xd\xa\x20\40\40\40\x20\40\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\40\x20\175\40\x65\154\163\145\40\x7b\xd\12\40\40\x20\40\x20\x20\x20\x20\x20\40\40\x20\x20\40\x20\40\40\x20\x20\40\40\40\x20\40\141\154\145\162\164\x28\42\x53\165\x63\x63\145\x73\x73\146\x75\x6c\x6c\x79\40\162\145\147\x69\x73\164\x65\162\145\x64\x21\x20\x59\157\x75\x20\x77\151\x6c\x6c\40\x67\x65\164\40\156\x6f\x74\x69\146\151\x63\x61\164\x69\x6f\x6e\40\x61\146\164\x65\162\x20\141\143\x74\x69\x76\141\x74\151\157\156\x20\x6f\x66\40\x79\157\165\x72\40\141\x63\x63\x6f\x75\x6e\x74\x2e\42\51\x3b\xd\12\40\x20\40\x20\40\40\x20\40\x20\x20\x20\x20\40\40\40\40\x20\40\x20\40\40\40\40\x20\167\x69\x6e\144\157\167\x2e\x63\x6c\x6f\163\x65\50\51\73\15\xa\x20\40\x20\x20\x20\40\x20\x20\40\x20\x20\x20\x20\40\x20\40\x20\40\40\40\175\xd\12\x20\x20\x20\x20\40\40\40\x20\40\40\x20\40\40\40\40\40\74\57\163\143\162\x69\x70\164\76\xd\xa\x20\40\x20\x20\x20\40\x20\40\40\40\x20\x20\x20\x20\x20\x20";
        exit;
        goto OB;
        oK:
        $this->mo_openid_paid_membership_pro_integration($nL);
        do_action("\167\160\137\x6c\157\x67\151\x6e", $user->user_login, $user);
        OB:
        Fl:
        do_action("\x77\x70\x5f\154\157\x67\151\x6e", $user->user_login, $user);
        wp_set_auth_cookie($nL, true);
        $mD = mo_openid_get_redirect_url();
        wp_redirect($mD);
        exit;
    }
    function mo_openid_insert_query($R8, $p1, $oV, $AS)
    {
        if (!(!empty($R8) && !empty($p1) && !empty($oV) && !empty($AS))) {
            goto lr;
        }
        date_default_timezone_set("\101\x73\x69\x61\57\113\157\154\x6b\x61\x74\141");
        $Kb = date("\131\x2d\x6d\55\x64\x20\x48\72\151\72\163");
        global $wpdb;
        $US = $wpdb->prefix;
        $go = $US . "\155\157\137\157\160\145\156\x69\x64\x5f\154\x69\x6e\153\x65\144\137\x75\163\145\162";
        $s_ = $wpdb->insert($go, array("\x6c\151\156\153\x65\144\x5f\x73\157\143\x69\x61\154\x5f\x61\x70\x70" => $R8, "\x6c\151\156\x6b\x65\144\137\x65\155\x61\151\154" => $p1, "\x75\163\x65\x72\x5f\x69\x64" => $oV, "\151\144\x65\156\164\x69\x66\x69\x65\x72" => $AS, "\164\151\155\145\x73\164\141\x6d\x70" => $Kb), array("\45\x73", "\45\x73", "\45\144", "\45\x73", "\45\x73"));
        if (!($s_ === false)) {
            goto Qr;
        }
        wp_die("\x45\162\162\x6f\162\x20\x69\156\40\151\156\163\145\x72\x74\40\161\165\145\x72\171");
        Qr:
        lr:
    }
    function mo_send_activation_mail($user, $nL)
    {
        update_user_meta($nL, "\x6d\x6f\137\x75\163\145\x72\x5f\x73\164\x61\164\165\x73", "\x30");
        $g_ = wp_login_url();
        $er = $user->user_email;
        $OC = get_option("\x73\x69\164\145\x75\x72\154");
        $XD = base64_encode($nL . time());
        $kV = "\120\x6c\145\141\163\145\40\x56\145\162\x69\x66\171\x20\171\x6f\165\x72\40\141\x63\x63\x6f\165\x6e\x74";
        $B0 = base64_encode($nL);
        $Xc = "\74\150\164\x6d\154\76\74\x62\157\144\171\76\15\12\x20\x20\x20\x20\x20\40\x20\x20\40\40\40\x20\74\141\40\x68\x72\145\x66\75\x20{$g_}\x3f\x75\151\x64\x3d{$B0}\x26\141\x63\x74\137\x63\x6f\x64\x65\75{$XD}\76\126\105\122\x49\x46\131\40\131\x4f\x55\x52\x20\x41\x43\x43\117\125\x4e\124\x20\74\57\141\76\x3c\x62\162\x3e\x3c\142\x72\76\74\142\162\76\15\12\40\x20\40\x20\x20\x20\x20\x20\x20\x20\x20\x20\40\74\x2f\142\x6f\x64\x79\x3e\74\x2f\x68\x74\155\x6c\x3e";
        $xM = get_option("\x6d\x6f\x5f\157\160\x65\x6e\151\144\137\x61\143\164\151\x76\141\164\151\157\x6e\137\x65\155\x61\x69\x6c\137\155\145\x73\163\x61\147\x65");
        $xM = str_replace("\x23\43\x61\143\x74\151\166\141\164\x69\x6f\x6e\x5f\x6c\151\156\x6b\x23\x23", $Xc, $xM);
        $xM = str_replace("\x23\x23\x77\145\142\x73\x69\164\x65\137\x6e\141\155\145\x23\x23", $OC, $xM);
        $BW = "\103\157\156\x74\145\156\x74\55\124\171\160\x65\72\40\x74\x65\x78\164\57\150\164\155\x6c";
        wp_mail($er, $kV, $xM, $BW);
        update_user_meta($nL, "\x61\x63\164\151\166\x61\164\x69\x6f\x6e\137\x63\x6f\x64\145", $XD);
        echo "\x20\40\x20\40\x20\x20\x20\40\x3c\x73\143\162\x69\x70\164\x3e\15\12\x20\40\x20\40\x20\40\40\40\40\40\40\40\166\141\162\x20\160\x6f\160\137\165\x70\40\x3d\x20\x27";
        echo get_option("\155\157\x5f\x6f\x70\145\156\151\x64\137\x70\x6f\160\x75\160\137\x77\x69\156\144\x6f\167");
        echo "\47\73\15\xa\x20\40\x20\x20\40\x20\40\40\x20\x20\40\x20\x76\x61\162\40\162\145\144\151\162\145\x63\x74\x5f\x68\x6f\155\x65\x20\x3d\x20\40\47";
        echo get_option("\155\x6f\x5f\x6f\160\145\x6e\x69\x64\x5f\x61\x63\x74\151\x76\141\x74\x69\157\156\137\160\141\147\145\137\x75\x72\154\163");
        echo "\47\73\15\12\x20\40\40\40\x20\40\x20\40\40\x20\x20\40\x69\146\40\x28\160\157\x70\x5f\x75\x70\x3d\75\47\60\x27\x29\x20\173\xd\12\x20\x20\x20\x20\x20\40\40\x20\x20\40\40\40\x20\x20\40\x20\x77\x69\x6e\x64\x6f\x77\x2e\x6c\x6f\143\141\164\151\157\x6e\40\75\x20\162\145\144\151\x72\x65\x63\164\137\x68\157\155\145\73\xd\xa\40\x20\40\x20\x20\x20\40\40\40\x20\40\40\x7d\x65\x6c\x73\x65\x20\x7b\15\xa\x20\40\x20\x20\x20\x20\40\x20\x20\x20\40\40\x20\x20\40\x20\x77\151\156\144\x6f\x77\x2e\x63\154\x6f\x73\145\50\x29\73\xd\12\x20\x20\40\x20\40\x20\40\40\x20\x20\40\40\175\xd\12\x20\x20\x20\40\x20\x20\40\x20\x3c\57\163\143\x72\151\160\164\x3e\15\xa\40\40\x20\x20\x20\x20\40\40";
        do_action("\x6d\157\137\x75\163\145\x72\137\162\145\147\x69\x73\x74\145\x72", $nL, $user->user_profile_url);
        do_action("\x6d\x69\x6e\151\157\162\x61\x6e\x67\x65\x5f\143\157\154\154\x65\x63\x74\137\141\164\x74\162\151\142\x75\x74\145\x73\x5f\146\157\162\x5f\141\165\164\x68\x65\x6e\164\151\x63\x61\x74\x65\144\x5f\165\x73\145\x72", $user, mo_openid_get_redirect_url());
    }
    function update_custom_data($nL, $in)
    {
        foreach ($in as $Qu) {
            foreach ($Qu as $QO => $M9) {
                update_user_meta($nL, $QO, $M9);
                mE:
            }
            WZ:
            mY:
        }
        fs:
    }
    function routeData()
    {
        if (array_key_exists("\157\160\x74\151\x6f\x6e", $_REQUEST)) {
            goto UL;
        }
        return;
        UL:
        switch (trim($_REQUEST["\157\160\x74\x69\x6f\156"])) {
            case "\155\x69\x6e\x69\x6f\162\141\156\147\x65\x2d\141\152\141\x78\55\x6f\164\x70\x2d\x67\x65\156\145\162\x61\x74\x65":
                $this->_handle_social_login_ajax_send_otp();
                goto K0;
            case "\x6d\x69\x6e\x69\157\x72\x61\x6e\x67\145\x2d\141\152\x61\x78\x2d\x6f\164\160\x2d\x76\141\154\151\144\141\164\145":
                $this->_handle_social_login_ajax_form_validate_action();
                goto K0;
        }
        wQ:
        K0:
    }
    function _handle_social_login_ajax_send_otp()
    {
        $FA = $_POST;
        MoPHPSessions::checkSession();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto tk;
        }
        $this->sendChallenge("\x61\x6a\141\x78\137\x70\150\x6f\156\145", '', null, trim(sanitize_text_field($FA["\x75\x73\145\162\137\x70\150\x6f\156\145"])), VerificationType::PHONE, sanitize_text_field($FA["\165\x73\x65\x72\137\x70\141\163\163"]), $FA);
        tk:
    }
    function _handle_social_login_ajax_form_validate_action()
    {
        $FA = $_POST;
        MoPHPSessions::checkSession();
        $Dk = MoPHPSessions::getSessionVar("\x70\150\x6f\156\145\x5f\x6e\x75\x6d\x62\145\162\x5f\x6d\x6f");
        if (strcmp($Dk, MoUtility::processPhoneNumber(sanitize_text_field($FA["\165\163\145\162\x5f\x70\x68\x6f\156\145"])))) {
            goto lZ;
        }
        $this->validateChallenge($this->getVerificationType(), NULL, sanitize_text_field($FA["\155\x6f\137\x6f\x74\x70\137\164\x6f\x6b\x65\156"]));
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto Cy;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto sw;
        Cy:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        sw:
        goto Q2;
        lZ:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        Q2:
    }
    function isPhoneVerificationEnabled()
    {
        $tA = $this->getVerificationType();
        return $tA === VerificationType::PHONE || $tA === VerificationType::BOTH;
    }
    function social_login_verification($gL, $in)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        MoPHPSessions::addSessionVar("\143\165\163\x74\137\x72\x65\147\137\x76\141\154", $in);
        MoPHPSessions::addSessionVar("\x75\x73\x65\x72\144\145\x74\141\x69\x6c\163", $gL);
        $this->sendChallenge(NULL, null, NULL, NULL, "\x65\x78\x74\145\x72\x6e\141\x6c", $gL["\x75\163\x65\162\137\160\x61\163\x73"], ["\x64\141\164\x61" => $gL["\165\163\x65\162\137\160\141\163\x73"], "\x6d\145\163\163\x61\147\x65" => MoMessages::showMessage(MoMessages::REGISTER_PHONE_LOGIN), "\x66\157\x72\x6d" => $this->_phoneKey, "\x63\165\162\x6c" => MoUtility::currentPageUrl()]);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }
    public function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        MoPHPSessions::checkSession();
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    public function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        MoPHPSessions::checkSession();
        $Bs = $this->getVerificationType();
        $MZ = $Bs === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
    }
    public function getPhoneNumberSelector($kp)
    {
        MoPHPSessions::checkSession();
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto Cf;
        }
        array_push($kp, $this->_phoneFormId);
        Cf:
        return $kp;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto sR;
        }
        return;
        sR:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x6d\x6f\137\x73\157\x63\x69\x61\154\x5f\x6c\x6f\147\x69\x6e\137\145\x6e\x61\142\154\x65");
        update_mo_option("\155\x6f\x5f\x73\x6f\143\151\141\154\137\154\157\x67\x69\x6e\x5f\x65\x6e\141\142\154\145", $this->_isFormEnabled);
    }
}
