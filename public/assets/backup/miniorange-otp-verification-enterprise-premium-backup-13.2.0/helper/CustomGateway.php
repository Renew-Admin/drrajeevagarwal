<?php


namespace OTP\Helper;

if (defined("\x41\102\123\120\x41\x54\x48")) {
    goto p5Q;
}
exit;
p5Q:
use OTP\Handler\MoOTPActionHandlerHandler;
use OTP\Objects\NotificationSettings;
use OTP\Helper\GatewayType;
use OTP\SplClassLoader;
use OTP\Helper\MoSMSBackupGateway;
use OTP\Objects\Tabs;
class CustomGateway
{
    public function __construct()
    {
        $this->_loadHooks();
    }
    protected $applicationName;
    public function _loadHooks()
    {
        add_action("\x77\x70\137\x61\152\x61\x78\x5f\155\151\156\x69\157\x72\x61\156\147\145\137\147\145\x74\137\164\x65\163\x74\137\162\145\x73\x70\x6f\156\163\x65", array($this, "\147\145\164\x5f\x67\x61\x74\x65\x77\x61\171\x5f\x72\145\163\x70\157\x6e\x73\145"));
    }
    public function hourlySync()
    {
        if ($this->ch_xdigit()) {
            goto UZV;
        }
        $this->daoptions();
        UZV:
    }
    public function flush_cache()
    {
        if (MO_TEST_MODE) {
            goto O6J;
        }
        if (!$this->mclv()) {
            goto Xm6;
        }
        $this->mius();
        Xm6:
        goto OqB;
        O6J:
        delete_mo_option("\x73\151\x74\x65\x5f\x65\x6d\x61\x69\x6c\137\x63\153\154");
        delete_mo_option("\x65\x6d\141\x69\154\137\166\x65\162\151\146\151\x63\x61\x74\x69\x6f\x6e\137\x6c\x6b");
        OqB:
    }
    public function _vlk($post)
    {
        if (!MoUtility::isBlank($post["\x65\155\x61\151\154\137\x6c\153"])) {
            goto Bha;
        }
        do_action("\x6d\x6f\x5f\162\145\147\151\163\164\x72\x61\x74\151\157\156\x5f\163\150\157\x77\x5f\155\145\x73\163\x61\147\145", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), MoConstants::ERROR);
        return;
        Bha:
        $Rv = trim($_POST["\x65\x6d\141\x69\x6c\137\154\x6b"]);
        $s_ = json_decode($this->ccl(), true);
        switch ($s_["\163\164\141\164\x75\x73"]) {
            case "\x53\125\x43\103\x45\x53\x53":
                $this->_vlk_success($Rv);
                goto jEU;
            default:
                $this->_vlk_fail();
                goto jEU;
        }
        NWA:
        jEU:
    }
    public function mclv()
    {
        $j1 = get_mo_option("\143\165\163\164\157\x6d\145\x72\x5f\164\157\x6b\x65\156");
        $ww = isset($j1) && !empty($j1) ? AEncryption::decrypt_data(get_mo_option("\x73\x69\164\x65\137\x65\155\141\151\154\137\143\153\x6c"), $j1) : "\146\141\154\163\145";
        $Bw = get_mo_option("\x65\155\141\x69\x6c\137\x76\145\x72\151\x66\x69\143\141\x74\151\157\x6e\137\x6c\x6b");
        $mo = get_mo_option("\x61\x64\x6d\151\156\137\x65\155\141\x69\x6c");
        $Yw = get_mo_option("\x61\144\155\x69\x6e\137\x63\x75\163\x74\x6f\x6d\145\x72\x5f\x6b\145\x79");
        return $ww == "\164\162\165\x65" && $Bw && $mo && $Yw && is_numeric(trim($Yw));
    }
    public function isGatewayConfig()
    {
        if (!get_mo_option("\x63\x75\163\164\x6f\x6d\x65\137\147\141\164\x65\167\141\x79\137\164\x79\x70\145")) {
            goto kir;
        }
        return TRUE;
        kir:
        return FALSE;
    }
    public function isMG()
    {
        return FALSE;
    }
    public function getApplicationName()
    {
        return $this->applicationName;
    }
    private function ch_xdigit()
    {
        if (get_mo_option("\163\x69\164\145\x5f\145\x6d\141\x69\154\x5f\x63\x6b\154")) {
            goto lev;
        }
        return FALSE;
        lev:
        $j1 = get_mo_option("\x63\165\x73\x74\157\155\x65\x72\x5f\164\157\153\145\x6e");
        return AEncryption::decrypt_data(get_mo_option("\163\151\164\x65\137\145\x6d\x61\x69\154\137\x63\x6b\x6c"), $j1) == "\164\x72\x75\145";
    }
    private function daoptions()
    {
        delete_mo_option("\167\x70\137\144\x65\x66\141\x75\154\x74\137\x65\156\141\142\x6c\145");
        delete_mo_option("\167\x63\137\144\145\146\x61\x75\x6c\164\x5f\145\156\141\x62\154\145");
        delete_mo_option("\160\142\x5f\x64\x65\146\141\165\x6c\x74\137\x65\x6e\141\142\x6c\x65");
        delete_mo_option("\165\155\137\x64\x65\146\141\165\154\x74\137\145\156\141\x62\154\x65");
        delete_mo_option("\163\x69\x6d\160\x6c\162\137\x64\x65\x66\141\x75\x6c\164\137\145\156\x61\142\x6c\x65");
        delete_mo_option("\145\166\145\x6e\x74\137\144\x65\x66\x61\x75\x6c\164\137\x65\x6e\x61\142\154\145");
        delete_mo_option("\x62\142\x70\137\x64\x65\146\141\165\154\164\137\145\156\141\x62\x6c\145");
        delete_mo_option("\143\162\146\137\x64\145\x66\141\x75\154\x74\x5f\145\x6e\141\142\154\145");
        delete_mo_option("\165\x75\154\x74\x72\x61\137\144\145\x66\x61\165\154\x74\137\145\156\x61\142\154\145");
        delete_mo_option("\167\x63\x5f\x63\x68\x65\143\x6b\x6f\165\x74\137\145\156\x61\x62\x6c\145");
        delete_mo_option("\x75\x70\155\145\x5f\144\x65\146\x61\x75\x6c\164\x5f\x65\x6e\x61\x62\x6c\145");
        delete_mo_option("\x70\151\145\x5f\144\145\x66\x61\165\x6c\164\x5f\x65\x6e\x61\x62\x6c\x65");
        delete_mo_option("\x63\146\67\x5f\143\157\156\x74\141\x63\164\137\145\x6e\x61\x62\x6c\145");
        delete_mo_option("\143\154\x61\163\x73\151\146\x79\137\x65\x6e\x61\142\x6c\x65");
        delete_mo_option("\x67\146\x5f\x63\157\156\164\x61\143\x74\137\x65\156\x61\x62\x6c\145");
        delete_mo_option("\156\x6a\141\137\x65\156\x61\x62\x6c\x65");
        delete_mo_option("\156\151\x6e\x6a\141\x5f\x66\157\x72\155\x5f\145\x6e\x61\x62\154\x65");
        delete_mo_option("\x74\155\154\137\145\x6e\141\x62\154\x65");
        delete_mo_option("\165\154\x74\151\160\162\157\x5f\145\156\x61\x62\154\x65");
        delete_mo_option("\165\x73\145\x72\160\162\157\x5f\144\x65\x66\x61\x75\x6c\x74\x5f\145\x6e\141\x62\x6c\145");
        delete_mo_option("\x77\160\137\x6c\157\147\x69\156\x5f\x65\x6e\141\x62\154\145");
        delete_mo_option("\146\157\x72\x6d\x63\x72\141\146\x74\x5f\160\x72\x65\155\151\x75\155\137\145\156\x61\142\x6c\145");
        delete_mo_option("\167\x70\x5f\155\x65\x6d\x62\145\162\137\162\145\x67\137\145\x6e\141\142\154\145");
        delete_mo_option("\x67\x66\x5f\157\164\160\137\145\x6e\x61\x62\x6c\145\144");
        delete_mo_option("\167\143\x5f\163\x6f\x63\x69\x61\154\x5f\x6c\x6f\147\151\x6e\137\x65\x6e\141\x62\154\x65");
        delete_mo_option("\x66\157\x72\155\143\x72\x61\x66\164\137\145\156\141\142\154\145");
        delete_mo_option("\x6d\x6f\x5f\x63\x75\163\x74\x6f\x6d\x65\162\137\166\x61\154\151\x64\x61\164\151\x6f\156\x5f\x61\144\x6d\151\x6e\x5f\145\x6d\x61\x69\154");
        delete_mo_option("\167\160\143\157\155\x6d\x65\x6e\164\137\x65\x6e\x61\x62\x6c\145");
        delete_mo_option("\x64\157\x63\x64\x69\162\x65\143\x74\x5f\145\156\141\x62\x6c\145");
        delete_mo_option("\x77\160\146\x6f\x72\x6d\x5f\145\x6e\141\142\154\x65");
        delete_mo_option("\x63\x72\x66\x5f\x6f\164\160\137\x65\x6e\x61\x62\154\x65\144");
        delete_mo_option("\143\141\154\x64\145\162\x61\137\x65\x6e\141\142\x6c\145");
        delete_mo_option("\146\157\162\x6d\x6d\x61\x6b\145\x72\137\x65\156\141\142\154\145");
        delete_mo_option("\x75\155\x5f\160\x72\x6f\146\151\154\x65\137\x65\156\x61\142\154\145");
        delete_mo_option("\x76\151\163\165\x61\x6c\x5f\146\157\162\155\x5f\x65\x6e\x61\x62\x6c\x65");
        delete_mo_option("\x66\162\x6d\x5f\x66\157\162\155\x5f\145\x6e\141\142\x6c\x65");
        delete_mo_option("\167\x63\x5f\x62\x69\154\x6c\151\156\x67\137\145\x6e\141\142\x6c\x65");
        delete_mo_option("\x70\x6c\x75\x67\x69\156\x5f\x61\x63\x74\151\166\x61\164\151\x6f\x6e\137\x64\x61\164\145");
    }
    private function _vlk_success($Rv)
    {
        $zw = json_decode($this->vml($Rv), true);
        if (strcasecmp($zw["\x73\x74\x61\x74\165\x73"], "\x53\125\103\x43\105\x53\x53") == 0) {
            goto s0g;
        }
        if (strcasecmp($zw["\x73\x74\141\x74\x75\163"], "\106\x41\111\x4c\105\x44") == 0) {
            goto oHu;
        }
        do_action("\155\157\137\162\145\147\151\x73\164\162\x61\x74\x69\x6f\x6e\137\x73\x68\x6f\x77\x5f\x6d\x65\163\163\x61\147\145", MoMessages::showMessage(MoMessages::UNKNOWN_ERROR), "\x45\122\122\x4f\122");
        goto C0I;
        oHu:
        if (strcasecmp($zw["\x6d\x65\x73\x73\141\147\145"], "\x43\157\144\x65\x20\150\x61\163\x20\x45\x78\x70\x69\162\145\144") == 0) {
            goto oN0;
        }
        do_action("\x6d\x6f\137\x72\145\x67\x69\163\x74\162\141\164\151\157\156\x5f\163\150\x6f\167\x5f\155\x65\x73\163\141\x67\145", MoMessages::showMessage(MoMessages::INVALID_LK), "\x45\x52\122\x4f\122");
        goto h_A;
        oN0:
        do_action("\155\157\137\x72\x65\147\x69\163\164\x72\141\x74\151\x6f\x6e\x5f\x73\150\157\x77\x5f\x6d\145\x73\x73\x61\147\x65", MoMessages::showMessage(MoMessages::LK_IN_USE), "\105\122\122\x4f\122");
        h_A:
        C0I:
        goto K5F;
        s0g:
        $j1 = get_mo_option("\143\x75\x73\x74\x6f\x6d\x65\x72\x5f\164\157\153\145\x6e");
        update_mo_option("\x65\155\141\x69\154\x5f\x76\x65\x72\151\146\151\143\x61\x74\151\157\x6e\x5f\x6c\153", AEncryption::encrypt_data($Rv, $j1));
        update_mo_option("\163\151\164\x65\x5f\145\155\141\x69\154\137\143\x6b\154", AEncryption::encrypt_data("\164\162\x75\145", $j1));
        do_action("\155\x6f\x5f\162\x65\x67\151\x73\164\x72\141\164\151\x6f\156\137\163\x68\x6f\x77\137\155\x65\163\x73\x61\147\145", MoMessages::showMessage(MoMessages::VERIFIED_LK), "\123\125\103\x43\105\x53\x53");
        K5F:
    }
    private function _vlk_fail()
    {
        $j1 = get_mo_option("\143\165\163\x74\x6f\x6d\x65\162\x5f\164\x6f\153\x65\x6e");
        update_mo_option("\163\151\164\x65\x5f\x65\155\141\151\154\x5f\143\x6b\x6c", AEncryption::encrypt_data("\x66\141\x6c\163\145", $j1));
        do_action("\155\157\x5f\162\145\x67\x69\163\164\x72\x61\x74\151\157\156\137\x73\x68\x6f\167\x5f\155\145\x73\x73\x61\x67\x65", MoMessages::showMessage(MoMessages::NEED_UPGRADE_MSG), "\105\122\122\x4f\122");
    }
    private function vml($Rv)
    {
        $P9 = MoConstants::HOSTNAME . "\x2f\155\157\x61\163\57\141\160\151\x2f\x62\141\x63\x6b\x75\160\x63\x6f\144\x65\x2f\x76\x65\x72\x69\146\171";
        $Yw = get_mo_option("\x61\x64\x6d\151\156\137\143\x75\x73\x74\x6f\x6d\145\x72\137\x6b\x65\x79");
        $B2 = get_mo_option("\141\144\155\x69\x6e\x5f\x61\160\151\137\x6b\x65\x79");
        $Xw = array("\x63\157\x64\145" => $Rv, "\x63\x75\163\x74\x6f\x6d\145\x72\x4b\x65\x79" => $Yw, "\141\x64\x64\151\x74\151\x6f\x6e\141\x6c\106\151\x65\154\x64\x73" => array("\x66\x69\x65\x6c\x64\x31" => site_url()));
        $dx = json_encode($Xw);
        $Fg = MocURLOTP::createAuthHeader($Yw, $B2);
        $aU = MocURLOTP::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    private function ccl()
    {
        $P9 = MoConstants::HOSTNAME . "\57\155\157\141\163\x2f\162\145\163\x74\x2f\x63\165\163\164\x6f\x6d\x65\162\57\x6c\x69\143\x65\x6e\x73\x65";
        $Yw = get_mo_option("\141\x64\x6d\151\x6e\137\143\x75\163\x74\x6f\x6d\x65\162\137\x6b\145\171");
        $B2 = get_mo_option("\141\144\x6d\x69\156\137\141\160\x69\x5f\153\x65\171");
        $Xw = array("\143\165\x73\164\157\155\145\x72\x49\x64" => $Yw, "\141\x70\x70\x6c\x69\x63\141\164\151\157\x6e\116\x61\155\x65" => $this->applicationName);
        $dx = json_encode($Xw);
        $Fg = MocURLOTP::createAuthHeader($Yw, $B2);
        $aU = MocURLOTP::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    private function mius()
    {
        $P9 = MoConstants::HOSTNAME . "\x2f\155\x6f\141\x73\x2f\141\x70\151\57\142\x61\x63\x6b\165\x70\143\x6f\x64\145\57\165\x70\144\x61\x74\x65\x73\x74\141\164\x75\x73";
        $Yw = get_mo_option("\x61\x64\x6d\151\x6e\x5f\143\x75\x73\164\x6f\155\x65\162\137\153\x65\x79");
        $B2 = get_mo_option("\x61\144\155\151\156\137\x61\x70\151\137\153\145\x79");
        $j1 = get_mo_option("\x63\x75\163\164\x6f\x6d\x65\x72\137\x74\x6f\x6b\145\x6e");
        $Rv = AEncryption::decrypt_data(get_mo_option("\x65\155\x61\151\154\x5f\x76\x65\x72\151\146\151\143\x61\164\x69\157\156\137\154\153"), $j1);
        $Xw = array("\143\x6f\x64\145" => $Rv, "\143\165\x73\164\x6f\x6d\145\x72\113\145\171" => $Yw);
        $dx = json_encode($Xw);
        $Fg = MocURLOTP::createAuthHeader($Yw, $B2);
        $aU = MocURLOTP::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    public function custom_wp_mail_from_name($BC)
    {
        return get_mo_option("\143\165\163\164\x6f\155\137\145\x6d\x61\x69\x6c\137\146\x72\x6f\x6d\x5f\x6e\x61\155\145") ? get_mo_option("\x63\165\x73\x74\x6f\x6d\137\x65\155\141\x69\x6c\137\x66\162\157\x6d\x5f\156\x61\155\145") : $BC;
    }
    function _mo_configure_sms_template($kB)
    {
        if (!isset($kB["\x6d\x6f\x5f\143\x75\163\164\x6f\155\145\x72\x5f\x76\141\x6c\151\144\141\164\151\157\x6e\137\x63\x75\x73\x74\157\x6d\137\163\155\x73\x5f\x6d\x73\x67"])) {
            goto Ydx;
        }
        $hH = trim($kB["\155\x6f\137\143\165\163\x74\157\x6d\145\162\x5f\x76\141\x6c\x69\x64\141\164\x69\x6f\x6e\x5f\x63\x75\163\x74\x6f\x6d\x5f\163\x6d\x73\137\x6d\x73\147"]);
        $hH = str_replace(PHP_EOL, "\x25\60\141", $hH);
        update_mo_option("\143\x75\163\164\x6f\x6d\137\x73\155\x73\137\155\163\x67", $hH);
        Ydx:
        if (!isset($kB["\x6d\x6f\x5f\x63\165\x73\x74\x6f\x6d\145\x72\x5f\x76\x61\x6c\151\144\141\164\x69\x6f\156\x5f\143\165\163\x74\157\x6d\x5f\147\141\164\x65\x77\x61\x79\x5f\164\x79\160\x65"])) {
            goto Orh;
        }
        update_mo_option("\143\x75\163\x74\157\x6d\145\x5f\x67\141\x74\x65\x77\x61\171\137\x74\171\160\x65", $kB["\155\157\137\143\165\163\164\x6f\x6d\x65\162\x5f\x76\141\154\x69\x64\141\164\151\157\x6e\x5f\143\165\163\x74\x6f\155\137\147\x61\x74\145\x77\x61\171\x5f\164\171\160\x65"]);
        $jO = GatewayType::instance();
        $jO->saveGatewayDetails($kB);
        Orh:
    }
    function _mo_configure_email_template($kB)
    {
        update_mo_option("\143\165\x73\x74\x6f\x6d\137\x65\x6d\x61\x69\x6c\x5f\155\163\x67", wpautop($kB["\x6d\x6f\x5f\x63\165\x73\x74\x6f\155\145\x72\x5f\166\x61\x6c\151\x64\141\x74\151\157\x6e\137\x63\165\163\x74\x6f\x6d\x5f\145\x6d\141\151\x6c\137\x6d\x73\147"]));
        update_mo_option("\143\x75\163\x74\x6f\155\x5f\x65\155\141\151\x6c\x5f\x73\x75\142\152\x65\x63\x74", sanitize_text_field($kB["\155\157\x5f\x63\165\163\164\157\155\x65\x72\137\x76\x61\154\151\144\141\x74\151\157\x6e\137\143\x75\163\x74\x6f\x6d\x5f\x65\155\x61\x69\154\x5f\x73\165\x62\152\x65\143\x74"]));
        update_mo_option("\x63\x75\163\164\x6f\x6d\137\145\x6d\141\151\x6c\137\x66\162\157\155\x5f\151\x64", sanitize_text_field($kB["\155\157\137\x63\x75\163\x74\x6f\x6d\x65\x72\x5f\166\x61\154\x69\144\141\x74\151\x6f\x6e\x5f\143\x75\163\x74\x6f\x6d\x5f\145\x6d\x61\x69\154\x5f\146\162\x6f\x6d\x5f\151\144"]));
        update_mo_option("\143\165\163\164\x6f\x6d\x5f\145\155\x61\151\154\x5f\146\162\x6f\x6d\x5f\156\x61\155\145", sanitize_text_field($kB["\x6d\157\x5f\x63\165\163\164\x6f\155\145\x72\x5f\166\x61\x6c\151\144\141\x74\x69\x6f\x6e\137\x63\165\163\x74\157\155\137\145\155\141\151\154\137\x66\x72\157\x6d\137\156\141\x6d\x65"]));
    }
    public function showConfigurationPage($m5)
    {
        $tW = get_mo_option("\x63\x75\163\164\157\155\137\163\x6d\163\137\155\x73\147") ? get_mo_option("\143\165\163\x74\x6f\x6d\137\163\x6d\x73\137\x6d\x73\x67") : MoMessages::showMessage(MoMessages::DEFAULT_SMS_TEMPLATE);
        $tW = mo_($tW);
        $EG = get_mo_option("\x63\165\x73\x74\x6f\155\137\145\x6d\141\151\x6c\137\x73\165\142\152\145\x63\x74") ? get_mo_option("\143\x75\163\x74\157\155\x5f\145\x6d\x61\x69\154\x5f\163\165\x62\152\x65\143\164") : MoMessages::showMessage(MoMessages::EMAIL_SUBJECT);
        $WF = get_mo_option("\143\x75\x73\164\x6f\x6d\x5f\x65\x6d\141\x69\154\137\x66\x72\x6f\155\137\x69\x64") ? get_mo_option("\143\165\163\164\x6f\155\137\x65\x6d\x61\x69\154\137\x66\162\157\155\137\151\144") : get_mo_option("\141\x64\x6d\151\x6e\137\x65\x6d\141\151\x6c");
        $P3 = get_mo_option("\143\x75\x73\164\157\x6d\137\145\x6d\x61\x69\x6c\137\x66\162\157\155\x5f\x6e\141\x6d\x65") ? get_mo_option("\143\x75\x73\x74\x6f\155\137\145\x6d\141\x69\154\137\146\162\157\x6d\137\156\141\x6d\x65") : get_bloginfo("\156\141\x6d\x65");
        $zw = get_mo_option("\x63\165\163\x74\157\x6d\137\145\155\x61\151\x6c\137\155\163\x67") ? stripslashes(get_mo_option("\143\165\163\x74\x6f\x6d\137\x65\155\x61\151\154\x5f\155\x73\x67")) : MoMessages::showMessage(MoMessages::DEFAULT_EMAIL_TEMPLATE);
        $Fm = "\143\x75\x73\x74\157\155\x65\x6d\x61\151\x6c\x65\144\x69\x74\x6f\162";
        $vG = ["\155\x65\144\x69\141\x5f\x62\x75\x74\x74\x6f\156\x73" => false, "\164\145\170\x74\141\162\x65\141\137\156\141\x6d\x65" => "\x6d\157\x5f\x63\165\x73\x74\x6f\155\x65\x72\x5f\x76\141\154\x69\x64\x61\164\x69\x6f\156\137\x63\x75\x73\x74\x6f\155\137\145\155\141\x69\154\x5f\155\163\x67", "\x65\144\151\x74\x6f\162\137\x68\x65\x69\147\x68\164" => "\61\x37\60\160\x78", "\x77\x70\141\x75\x74\x6f\160" => false];
        $Zf = MoOTPActionHandlerHandler::instance();
        $fQ = $Zf->getNonceValue();
        $Lt = wp_nonce_field($fQ);
        $aE = mo_("\x53\115\x53\x20\124\105\x4d\x50\x4c\101\x54\x45\40\x43\117\116\x46\x49\x47\x55\x52\101\x54\111\x4f\x4e");
        $PL = mo_("\123\x4d\x53\40\107\101\x54\105\x57\x41\131\x20\x43\117\x4e\x46\x49\x47\x55\x52\x41\124\x49\x4f\x4e");
        $kh = mo_("\x53\115\x53\40\124\145\155\x70\154\141\x74\x65");
        $np = mo_("\x45\x6e\164\145\162\x20\117\124\x50\40\123\x4d\123\40\115\x65\163\x73\141\x67\145");
        $ok = mo_("\x59\x6f\x75\40\x6e\x65\x65\x64\x20\164\157\40\x77\162\x69\164\145\40\x23\43\x6f\164\160\43\x23\40\x77\150\145\x72\145\40\x79\x6f\x75\40\x77\151\163\x68\40\x74\157\40\160\x6c\141\x63\x65\x20\x67\145\x6e\x65\162\x61\x74\x65\x64\40\157\x74\160\40\151\x6e\40\164\150\x69\163\40\x74\145\155\x70\x6c\141\x74\x65\56");
        $y6 = mo_("\131\x6f\x75\x20\x77\151\154\154\x20\156\x65\145\144\x20\164\x6f\40\x70\x6c\x61\x63\145\40\171\157\x75\162\40\123\115\123\x20\147\x61\164\145\x77\141\x79\x20\125\122\114\x20\151\156\40\x74\x68\145\x20\x66\x69\x65\x6c\x64\40\141\142\157\x76\145\40\151\x6e\x20\157\x72\x64\145\162\40\x74\x6f\x20\142\x65\xd\xa\40\x20\40\40\40\40\40\40\40\x20\40\x20\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\40\40\40\x20\x20\x20\x20\40\40\x20\40\x20\40\x20\x20\x20\x20\x20\x20\x61\x62\154\x65\x20\164\157\40\x73\x65\x6e\x64\40\x4f\x54\120\163\x20\x74\157\40\x74\x68\x65\40\165\163\x65\x72\x27\163\x20\160\x68\x6f\x6e\x65\x2e") . "\74\142\162\57\x3e" . mo_("\131\x6f\x75\x20\x77\x69\154\154\40\142\145\40\141\x62\x6c\x65\x20\x74\157\x20\147\145\164\40\164\150\x69\x73\x20\x55\122\114\x20\x66\x72\157\x6d\x20\x79\157\165\162\x20\123\115\x53\40\147\x61\x74\145\167\141\171\x20\x70\162\x6f\x76\x69\144\x65\162\56");
        $dS = mo_("\x49\146\40\x79\157\165\x20\x61\x72\x65\x20\x68\x61\166\151\156\147\x20\x74\x72\x6f\x75\142\154\x65\40\151\156\40\146\x69\156\x64\151\156\x67\x20\171\x6f\x75\162\40\147\141\164\x65\x77\141\x79\x20\x55\122\x4c\40\164\150\145\x6e\x20\x79\157\165\x20\144\162\157\x70\x20\x75\163\40\141\156\15\xa\40\x20\40\x20\x20\40\40\x20\x20\x20\40\x20\x20\x20\x20\40\x20\40\x20\x20\x20\x20\40\40\x20\40\x20\40\40\x20\40\40\40\40\x20\40\40\40\x20\40\40\40\x20\x20\145\x6d\141\x69\x6c\x20\x61\x74\x20\x3c\x61\x20\163\164\x79\154\x65\75\x27\x63\165\x72\x73\x6f\162\72\x70\x6f\x69\156\164\145\x72\x3b\47\47\x20\x6f\x6e\x43\x6c\x69\143\153\x3d\x27\157\x74\x70\x53\x75\x70\160\x6f\162\164\x4f\156\103\154\151\x63\153\50\x29\73\x27\76\x6f\x74\160\163\165\160\160\x6f\162\164\x40\170\x65\x63\165\x72\x69\x66\171\x2e\143\157\x6d\74\x2f\141\76\x2e\x20\x57\x65\x20\x77\x69\x6c\154\40\x68\145\154\160\40\x79\x6f\x75\x20\x77\151\x74\150\x20\x74\150\x65\40\163\x65\x74\x75\160\56");
        $p_ = mo_("\x54\145\163\x74\x20\123\115\123\40\x47\141\x74\x65\167\141\x79\x20\103\157\156\146\x69\147\x75\162\141\x74\151\x6f\x6e\x73");
        $Sn = mo_("\124\145\x73\164\x20\x43\157\x6e\x66\x69\x67\165\x72\141\x74\x69\x6f\156");
        $C0 = mo_("\107\x61\164\145\x77\x61\x79\x20\x52\x65\x73\160\157\156\x73\x65");
        $Pw = "\x45\x78\x61\x6d\x70\x6c\x65\x3a\55\40\150\164\164\x70\x3a\57\57\141\x6c\x65\x72\x74\x73\x2e\x73\151\156\146\151\x6e\151\x2e\143\x6f\155\57\141\160\x69\x2f\167\145\x62\62\163\155\163\x2e\160\150\x70\x75\163\x65\x72\156\x61\155\145\x3d\130\131\x5a\x26\160\141\163\x73\x77\157\x72\x64\75\160\x61\x73\x73\167\x6f\x72\x64\46\x74\157\75\43\x23\160\150\157\156\145\x23\43\46\163\x65\x6e\x64\x65\x72\75\x73\145\x6e\x64\145\162\x69\144\x26\155\145\x73\163\x61\147\x65\75\43\x23\155\x65\163\163\x61\147\145\x23\43";
        $dT = mo_("\x43\101\x4e\116\x4f\x54\40\x46\111\116\104\40\124\110\105\x20\x47\x41\x54\105\127\x41\x59\40\x55\x52\x4c\x3f");
        $UB = mo_("\123\141\166\145\x20\x53\115\x53\x20\x43\157\156\x66\151\147\x75\x72\x61\164\x69\157\156\x73");
        $xP = mo_("\x53\x61\166\145\x20\x47\x61\x74\145\167\141\x79\x20\103\x6f\x6e\x66\x69\147\165\162\141\164\x69\x6f\156\x73");
        $kU = mo_("\x45\115\x41\x49\114\40\x43\x4f\x4e\106\x49\x47\x55\x52\x41\124\x49\x4f\x4e");
        $LM = mo_("\x59\157\x75\x20\x6e\x65\145\x64\x20\164\157\40\143\157\x6e\x66\151\147\x75\162\145\40\x79\157\x75\x72\x20\x70\150\160\x2e\151\156\x69\x20\146\151\154\x65\x20\167\x69\164\x68\40\x53\115\x54\x50\x20\163\x65\164\164\151\156\147\163\40\x74\x6f\x20\142\x65\x20\x61\x62\x6c\145\x20\x74\157\40\x73\145\x6e\x64\x20\x65\x6d\141\151\x6c\x73\x2e");
        $yS = mo_("\x53\x61\x76\x65\40\x45\x6d\x61\151\154\x20\103\x6f\156\146\151\147\165\x72\x61\x74\151\x6f\x6e\163");
        $WQ = mo_("\x45\x6e\164\x65\x72\x20\171\157\165\162\40\117\124\120\x20\105\x6d\x61\151\x6c\x20\123\165\142\x6a\x65\x63\x74");
        $mv = mo_("\x45\x6e\x74\x65\x72\x20\x4e\141\x6d\x65");
        $DR = mo_("\x45\156\x74\x65\162\40\x65\155\141\x69\154\x20\141\144\144\x72\145\163\x73");
        $lx = mo_("\x46\x72\157\x6d\x20\x49\x44");
        $to = mo_("\106\x72\x6f\x6d\x20\116\x61\x6d\145");
        $kV = mo_("\x53\165\x62\x6a\x65\x63\x74");
        $sM = mo_("\x42\157\x64\x79");
        $jO = GatewayType::instance();
        $j_ = get_mo_option("\x63\x75\x73\164\x6f\x6d\137\163\155\x73\137\x67\x61\x74\145\167\141\171") ? get_mo_option("\x63\x75\163\164\157\155\137\163\x6d\163\x5f\x67\141\x74\x65\167\x61\x79") : '';
        $nf = $jO->getGatewayConfigView($m5, $j_);
        $za = $this->get_gateway_list();
        $oC = get_mo_option("\x63\x75\x73\164\157\155\145\x5f\147\141\164\x65\x77\x61\171\137\164\x79\160\145") ? get_mo_option("\143\165\x73\x74\x6f\x6d\x65\137\147\141\x74\x65\x77\x61\171\137\164\171\x70\145") : "\x4d\157\x47\x61\x74\145\167\141\171\x55\122\114";
        include MOV_DIR . "\x76\x69\x65\x77\x73\57\143\x63\157\x6e\x66\151\x67\165\162\141\x74\x69\x6f\x6e\x2e\x70\150\160";
    }
    public function get_gateway_list()
    {
        $h2 = '';
        $HC = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(MOV_DIR . "\x68\145\154\x70\145\162\57\x67\x61\164\145\x77\141\171", \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($HC as $J3) {
            $xI = $J3->getFilename();
            $XN = "\117\124\x50\x5c\x48\145\154\x70\145\x72\x5c\107\141\164\x65\x77\x61\171\x5c" . str_replace("\x2e\160\x68\160", '', $xI);
            $ig = $XN::instance();
            $h2 .= $this->addOption($ig->_gatewayName, str_replace("\56\160\150\160", '', $xI));
            kVe:
        }
        RPF:
        return $h2;
    }
    public function get_gateway_response()
    {
        $xs = isset($_POST["\164\145\x73\x74\x5f\143\x6f\x6e\146\x69\147\137\156\165\155\142\x65\x72"]) ? $_POST["\164\145\x73\x74\x5f\143\x6f\156\x66\x69\147\x5f\x6e\165\155\x62\145\162"] : '';
        $ad = $this->mo_send_otp_token("\123\115\x53", '', $xs);
        print_r($ad);
        die;
    }
    private function addOption($ZC, $QK)
    {
        return "\x3c\157\x70\164\x69\157\156\x20\166\141\x6c\165\145\x3d\x22" . $QK . "\42\76" . $ZC . "\x3c\57\157\x70\164\151\157\x6e\x3e";
    }
    public function mo_send_otp_token($CV, $mo, $Dk)
    {
        if (MO_TEST_MODE) {
            goto GaP;
        }
        $zw = $this->send_otp_token($CV, $mo, $Dk);
        return json_decode($zw, TRUE);
        goto Xlc;
        GaP:
        return ["\x73\164\x61\x74\165\x73" => "\123\x55\103\x43\105\123\123", "\x74\x78\111\x64" => MoUtility::rand()];
        Xlc:
    }
    public function mo_send_notif(NotificationSettings $CW)
    {
        $aU = $CW->sendSMS ? self::send_sms_token($CW->message, $CW->phoneNumber) : self::send_email_token($CW->message, $CW->toEmail, $CW->fromEmail, $CW->subject);
        return !is_null($aU) ? json_encode(array("\x73\164\x61\164\x75\163" => "\123\x55\103\103\x45\x53\123")) : json_encode(array("\163\x74\141\x74\165\163" => "\x45\122\122\117\122"));
    }
    private function send_otp_token($CV, $mo = null, $Dk = null)
    {
        $Zk = get_mo_option("\x6f\164\x70\137\154\145\156\x67\164\150") ? get_mo_option("\x6f\164\160\x5f\154\145\156\147\x74\x68") : 5;
        $iF = wp_rand(pow(10, $Zk - 1), pow(10, $Zk) - 1);
        $iF = apply_filters("\155\157\x5f\x61\154\x70\x68\x61\x6e\165\x6d\145\162\151\143\137\157\x74\160\x5f\x66\x69\x6c\x74\x65\x72", $iF);
        $Yw = get_mo_option("\141\x64\155\151\156\x5f\143\165\x73\x74\157\155\x65\162\137\153\x65\171");
        $ZQ = $Yw . $iF;
        $oN = hash("\x73\150\x61\65\x31\x32", $ZQ);
        $aU = self::httpRequest($CV, $iF, $mo, $Dk);
        if ($aU) {
            goto iEh;
        }
        $zw = array("\x73\164\x61\164\x75\x73" => "\106\x41\111\x4c\125\122\105");
        goto poE;
        iEh:
        MoPHPSessions::addSessionVar("\x6d\157\x5f\x6f\x74\160\x74\x6f\x6b\145\156", true);
        MoPHPSessions::addSessionVar("\163\x65\x6e\x74\137\x6f\x6e", time());
        $zw = array("\x73\x74\x61\164\165\x73" => "\123\x55\103\103\x45\x53\123", "\164\170\x49\144" => $oN);
        poE:
        if (!(isset($_POST["\x61\x63\x74\151\x6f\156"]) && $_POST["\x61\x63\164\151\157\x6e"] == "\x6d\151\x6e\151\x6f\162\x61\x6e\x67\x65\137\x67\x65\x74\137\x74\x65\163\x74\x5f\x72\x65\163\160\157\x6e\163\x65")) {
            goto wBA;
        }
        return json_encode($aU);
        wBA:
        return json_encode($zw);
    }
    private function httpRequest($CV, $iF, $mo = null, $Dk = null)
    {
        $aU = null;
        switch ($CV) {
            case "\123\x4d\x53":
                $bC = get_mo_option("\x63\165\x73\x74\157\x6d\137\x73\155\x73\x5f\155\x73\147") ? mo_(get_mo_option("\143\165\163\164\157\x6d\x5f\163\x6d\x73\137\155\x73\147")) : mo_(MoMessages::showMessage(MoMessages::DEFAULT_SMS_TEMPLATE));
                $bC = mo_($bC);
                $bC = str_replace("\x23\43\157\164\160\x23\x23", $iF, $bC);
                $aU = $this->send_sms_token($bC, $Dk);
                goto uaB;
            case "\105\115\x41\x49\114":
                $bC = get_mo_option("\x63\165\x73\x74\157\155\137\x65\155\141\151\x6c\137\x6d\163\x67") ? mo_(get_mo_option("\143\x75\x73\x74\x6f\x6d\137\145\x6d\141\x69\x6c\137\155\x73\147")) : mo_(MoMessages::showMessage(MoMessages::DEFAULT_EMAIL_TEMPLATE));
                $bC = mo_($bC);
                $bC = stripslashes($bC);
                $bC = str_replace("\43\43\157\x74\x70\43\43", $iF, $bC);
                $G_ = get_mo_option("\x63\x75\163\x74\157\x6d\137\x65\x6d\x61\x69\x6c\x5f\x66\162\157\155\x5f\151\144");
                $kV = get_mo_option("\143\x75\x73\164\x6f\x6d\x5f\x65\155\141\151\x6c\x5f\163\x75\x62\x6a\145\143\x74");
                $U7 = get_mo_option("\x63\x75\x73\x74\157\x6d\x5f\x65\x6d\141\x69\154\137\146\x72\157\x6d\x5f\x6e\x61\x6d\145");
                $aU = $this->send_email_token($bC, $mo, $G_, $kV, $U7);
                goto uaB;
        }
        lzZ:
        uaB:
        return $aU;
    }
    private function send_sms_token($bC, $Dk)
    {
        $ig = GatewayType::instance();
        $aU = $ig->sendOTPRequest($bC, $Dk);
        return $ig->handleGatewayResponse($aU, $bC, $Dk);
    }
    private function send_email_token($bC, $mo, $G_ = null, $kV = null, $U7 = null)
    {
        $G_ = !MoUtility::isBlank($G_) ? $G_ : MoConstants::FROM_EMAIL;
        $kV = !MoUtility::isBlank($kV) ? $kV : MoMessages::showMessage(MoMessages::EMAIL_SUBJECT);
        $U7 = !MoUtility::isBlank($U7) ? $U7 : $G_;
        $BW = "\x46\x72\x6f\x6d\x3a" . $U7 . "\40\74" . $G_ . "\76\x20\xa";
        $BW .= MoConstants::HEADER_CONTENT_TYPE;
        $zw = $bC;
        return ini_get("\123\115\124\x50") != FALSE || ini_get("\x73\155\164\160\x5f\160\x6f\162\164") != FALSE ? wp_mail($mo, $kV, $zw, $BW) : false;
    }
    public function mo_validate_otp_token($Ng, $ZI)
    {
        return MO_TEST_MODE ? MO_FAIL_MODE ? ["\163\164\x61\164\165\163" => ''] : ["\163\164\x61\164\x75\163" => "\123\x55\x43\x43\105\123\x53"] : $this->validate_otp_token($Ng, $ZI);
    }
    private function validate_otp_token($oN, $U4)
    {
        $Yw = get_mo_option("\x61\x64\x6d\151\x6e\137\x63\165\x73\x74\x6f\x6d\145\162\x5f\153\x65\171");
        if (MoPHPSessions::getSessionVar("\155\157\x5f\x6f\164\x70\164\x6f\153\145\x6e")) {
            goto lX0;
        }
        $zw = array("\163\x74\x61\164\165\x73" => MoConstants::FAILURE);
        goto WWw;
        lX0:
        $N3 = $this->checkTimeStamp(MoPHPSessions::getSessionVar("\x73\x65\x6e\164\x5f\x6f\156"), time());
        $N3 = $this->checkTransactionId($Yw, $U4, $oN, $N3);
        if ($N3) {
            goto Mmb;
        }
        $zw = array("\163\x74\x61\164\165\163" => MoConstants::FAILURE);
        goto JSV;
        Mmb:
        $zw = array("\163\x74\x61\164\165\x73" => MoConstants::SUCCESS);
        JSV:
        MoPHPSessions::unsetSession("\44\x6d\157\137\x6f\164\160\164\x6f\153\145\156");
        WWw:
        return apply_filters("\x6d\157\x5f\x6d\141\x73\x74\x65\162\x5f\157\164\160\x5f\x66\151\154\x74\145\x72", $zw, $U4);
    }
    private function checkTimeStamp($Go, $k5)
    {
        $nD = get_mo_option("\x6f\x74\160\x5f\x76\x61\154\151\144\x69\164\x79") ? get_mo_option("\157\x74\x70\x5f\166\141\154\151\x64\151\164\171") : 5;
        $EF = round(abs($k5 - $Go) / 60, 2);
        return $EF > $nD ? false : true;
    }
    private function checkTransactionId($Yw, $U4, $oN, $N3)
    {
        if ($N3) {
            goto tEv;
        }
        return false;
        tEv:
        $ZQ = $Yw . $U4;
        $jS = hash("\163\150\x61\x35\61\x32", $ZQ);
        return $jS === $oN;
    }
}
