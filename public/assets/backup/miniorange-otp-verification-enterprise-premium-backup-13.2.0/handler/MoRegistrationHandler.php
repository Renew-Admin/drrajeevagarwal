<?php


namespace OTP\Handler;

if (defined("\x41\x42\x53\x50\101\x54\x48")) {
    goto Wha;
}
exit;
Wha:
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MocURLOTP;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseActionHandler;
use OTP\Traits\Instance;
class MoRegistrationHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\x6d\157\x5f\x72\x65\147\x5f\141\x63\164\151\157\156\163";
        add_action("\x61\144\x6d\151\156\x5f\151\x6e\x69\x74", array($this, "\150\x61\156\x64\154\x65\137\143\x75\163\x74\157\155\x65\x72\x5f\x72\x65\147\151\163\164\x72\141\164\x69\x6f\156"));
    }
    function handle_customer_registration()
    {
        if (current_user_can("\155\x61\156\x61\147\x65\x5f\157\160\164\151\157\156\x73")) {
            goto RFw;
        }
        return;
        RFw:
        if (isset($_POST["\157\x70\164\x69\157\x6e"])) {
            goto I3b;
        }
        return;
        I3b:
        $Tc = sanitize_text_field(trim($_POST["\157\x70\164\151\x6f\156"]));
        switch ($Tc) {
            case "\155\x6f\137\x72\x65\147\x69\163\x74\162\x61\164\x69\x6f\x6e\137\162\x65\147\x69\163\x74\145\x72\137\x63\x75\163\x74\x6f\x6d\145\162":
                $this->_register_customer($_POST);
                goto ji9;
            case "\x6d\157\137\162\145\147\x69\x73\164\162\x61\164\x69\157\x6e\137\143\157\156\x6e\145\143\164\137\x76\x65\x72\x69\146\171\x5f\x63\x75\163\164\157\155\x65\x72":
                $this->_verify_customer($_POST);
                goto ji9;
            case "\155\x6f\x5f\162\x65\x67\x69\x73\x74\x72\141\x74\x69\x6f\156\x5f\x76\x61\154\151\x64\x61\x74\x65\x5f\x6f\x74\160":
                $this->_validate_otp($_POST);
                goto ji9;
            case "\155\x6f\x5f\162\x65\x67\151\163\164\x72\141\164\x69\157\x6e\137\162\x65\x73\145\x6e\144\x5f\157\164\160":
                $this->_send_otp_token(get_mo_option("\141\144\x6d\x69\x6e\137\x65\x6d\x61\x69\154"), '', "\x45\115\x41\111\114");
                goto ji9;
            case "\x6d\x6f\137\x72\x65\147\x69\x73\164\x72\x61\164\x69\x6f\x6e\x5f\x70\150\157\x6e\145\x5f\x76\145\162\151\x66\x69\143\x61\164\151\157\x6e":
                $this->_send_phone_otp_token($_POST);
                goto ji9;
            case "\x6d\x6f\137\x72\x65\x67\151\x73\x74\x72\141\x74\x69\157\156\x5f\x67\x6f\137\x62\141\x63\x6b":
                $this->_revert_back_registration();
                goto ji9;
            case "\x6d\157\x5f\162\145\x67\x69\163\164\162\x61\x74\151\x6f\x6e\x5f\x66\x6f\x72\147\157\x74\x5f\x70\x61\x73\163\x77\157\162\144":
                $this->_reset_password();
                goto ji9;
            case "\x6d\157\x5f\147\x6f\137\x74\x6f\137\x6c\157\x67\151\x6e\x5f\160\x61\x67\x65":
            case "\x72\145\x6d\x6f\166\145\x5f\141\143\x63\157\165\156\164":
                $this->removeAccount();
                goto ji9;
            case "\155\157\x5f\162\x65\x67\151\163\164\x72\141\164\151\x6f\156\137\166\145\162\x69\x66\x79\x5f\154\151\x63\145\156\x73\x65":
                $this->_vlk($_POST);
                goto ji9;
        }
        gNL:
        ji9:
    }
    function _register_customer($post)
    {
        $this->isValidRequest();
        $mo = sanitize_email($_POST["\145\x6d\141\151\x6c"]);
        $Tf = sanitize_text_field($_POST["\x63\x6f\155\x70\141\x6e\x79"]);
        $a8 = sanitize_text_field($_POST["\x66\156\x61\155\x65"]);
        $Fz = sanitize_text_field($_POST["\154\156\x61\x6d\145"]);
        $iK = sanitize_text_field($_POST["\160\141\163\163\x77\x6f\162\144"]);
        $tn = sanitize_text_field($_POST["\x63\157\156\146\151\x72\x6d\x50\141\x73\x73\x77\157\x72\144"]);
        if (!(strlen($iK) < 6 || strlen($tn) < 6)) {
            goto hId;
        }
        do_action("\x6d\x6f\137\x72\145\147\151\163\164\162\141\164\x69\157\156\x5f\163\150\157\167\137\x6d\x65\x73\163\141\147\x65", MoMessages::showMessage(MoMessages::PASS_LENGTH), "\105\122\x52\117\x52");
        return;
        hId:
        if (!($iK != $tn)) {
            goto ws3;
        }
        delete_mo_option("\x76\145\162\151\146\171\137\x63\x75\163\164\x6f\155\x65\x72");
        do_action("\x6d\x6f\x5f\162\145\x67\x69\163\x74\162\x61\x74\x69\x6f\156\x5f\163\x68\157\167\x5f\155\145\163\163\141\x67\x65", MoMessages::showMessage(MoMessages::PASS_MISMATCH), "\105\122\122\x4f\x52");
        return;
        ws3:
        if (!(MoUtility::isBlank($mo) || MoUtility::isBlank($iK) || MoUtility::isBlank($tn))) {
            goto Q0_;
        }
        do_action("\155\x6f\137\162\145\147\151\163\x74\162\x61\x74\x69\157\156\137\163\150\157\167\x5f\155\145\163\x73\141\147\x65", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), "\105\x52\x52\x4f\122");
        return;
        Q0_:
        update_mo_option("\143\x6f\x6d\x70\x61\156\x79\x5f\x6e\141\155\145", $Tf);
        update_mo_option("\x66\x69\x72\163\x74\137\156\x61\x6d\145", $a8);
        update_mo_option("\154\x61\163\164\x5f\x6e\141\155\x65", $Fz);
        update_mo_option("\x61\x64\x6d\x69\156\x5f\145\x6d\x61\x69\154", $mo);
        update_mo_option("\x61\x64\155\151\156\137\160\x61\163\163\167\157\x72\x64", $iK);
        $zw = json_decode(MocURLOTP::check_customer($mo), true);
        switch ($zw["\x73\x74\x61\x74\x75\163"]) {
            case "\x43\x55\123\x54\117\x4d\x45\122\x5f\116\x4f\x54\x5f\x46\x4f\x55\x4e\104":
                $this->_send_otp_token($mo, '', "\x45\115\101\x49\114");
                goto Oh7;
            default:
                $this->_get_current_customer($mo, $iK);
                goto Oh7;
        }
        Pgp:
        Oh7:
    }
    function _send_otp_token($mo, $Dk, $bb)
    {
        $this->isValidRequest();
        $zw = json_decode(MocURLOTP::mo_send_otp_token($bb, $mo, $Dk), true);
        if (strcasecmp($zw["\x73\164\141\x74\165\x73"], "\x53\125\103\x43\x45\x53\123") == 0) {
            goto Zh6;
        }
        update_mo_option("\162\x65\x67\x69\x73\164\x72\141\x74\151\x6f\156\137\x73\x74\x61\164\x75\163", "\115\x4f\137\117\124\x50\137\x44\105\114\111\x56\105\x52\x45\104\137\x46\x41\x49\114\125\122\105");
        do_action("\x6d\157\x5f\x72\x65\x67\151\x73\164\162\141\x74\x69\157\x6e\137\163\x68\157\167\x5f\x6d\145\x73\x73\x61\x67\145", MoMessages::showMessage(MoMessages::ERR_OTP), "\105\x52\x52\117\x52");
        goto emn;
        Zh6:
        update_mo_option("\164\162\x61\156\x73\141\x63\164\151\157\156\111\144", $zw["\x74\170\111\144"]);
        update_mo_option("\162\145\x67\151\163\x74\x72\141\x74\151\x6f\x6e\137\163\x74\141\164\165\x73", "\x4d\x4f\137\117\124\120\x5f\104\105\114\x49\x56\x45\122\x45\x44\x5f\123\x55\103\x43\105\x53\123");
        if ($bb == "\x45\115\101\x49\114") {
            goto XE3;
        }
        do_action("\x6d\x6f\x5f\x72\145\x67\151\x73\164\162\141\x74\x69\x6f\x6e\137\x73\150\x6f\x77\137\155\x65\x73\163\x61\147\145", MoMessages::showMessage(MoMessages::OTP_SENT, array("\x6d\145\x74\150\x6f\x64" => $Dk)), "\123\x55\103\x43\105\x53\123");
        goto Vde;
        XE3:
        do_action("\x6d\x6f\137\162\x65\147\151\x73\164\x72\141\164\x69\157\x6e\x5f\x73\150\157\167\x5f\155\x65\163\163\x61\x67\x65", MoMessages::showMessage(MoMessages::OTP_SENT, array("\155\145\164\x68\157\x64" => $mo)), "\x53\125\103\103\105\123\x53");
        Vde:
        emn:
    }
    private function _get_current_customer($mo, $iK)
    {
        $zw = MocURLOTP::get_customer_key($mo, $iK);
        $Yw = json_decode($zw, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            goto jnV;
        }
        update_mo_option("\141\144\155\x69\156\137\145\x6d\141\151\x6c", $mo);
        update_mo_option("\166\x65\x72\151\146\x79\137\x63\x75\x73\164\157\x6d\x65\x72", "\x74\162\x75\145");
        delete_mo_option("\x6e\145\167\137\162\145\147\x69\163\164\x72\141\x74\151\x6f\x6e");
        do_action("\x6d\x6f\x5f\x72\145\x67\151\x73\164\x72\x61\x74\x69\x6f\156\x5f\x73\150\157\167\x5f\x6d\145\163\x73\x61\x67\x65", MoMessages::showMessage(MoMessages::ACCOUNT_EXISTS), "\105\122\122\x4f\122");
        goto JWN;
        jnV:
        update_mo_option("\141\x64\x6d\x69\156\x5f\145\x6d\141\151\x6c", $mo);
        update_mo_option("\x61\144\x6d\x69\156\x5f\160\150\x6f\156\x65", $Yw["\x70\150\x6f\x6e\145"]);
        $this->save_success_customer_config($Yw["\x69\x64"], $Yw["\x61\160\151\113\x65\x79"], $Yw["\x74\157\x6b\145\156"], $Yw["\x61\x70\x70\123\x65\x63\162\145\164"]);
        MoUtility::_handle_mo_check_ln(false, $Yw["\151\x64"], $Yw["\141\x70\x69\113\x65\x79"]);
        do_action("\155\x6f\x5f\162\x65\147\x69\x73\x74\162\141\164\151\x6f\156\137\163\150\x6f\x77\x5f\x6d\x65\163\x73\141\147\x65", MoMessages::showMessage(MoMessages::REG_SUCCESS), "\123\x55\x43\x43\x45\123\123");
        JWN:
    }
    function save_success_customer_config($j0, $B2, $ry, $lm)
    {
        update_mo_option("\141\144\155\x69\156\x5f\143\165\163\164\x6f\155\x65\162\x5f\153\145\171", $j0);
        update_mo_option("\x61\144\155\x69\x6e\137\141\160\x69\x5f\153\x65\x79", $B2);
        update_mo_option("\x63\x75\163\164\157\x6d\x65\162\137\164\157\153\x65\x6e", $ry);
        update_mo_option("\160\154\165\147\151\x6e\x5f\141\x63\164\x69\166\141\164\151\x6f\x6e\137\144\141\164\145", date("\x59\x2d\155\55\144\40\150\x3a\151\72\163\x61"));
        delete_mo_option("\x76\145\x72\151\x66\x79\x5f\143\x75\163\x74\157\155\x65\162");
        delete_mo_option("\x6e\145\x77\x5f\x72\x65\147\x69\x73\x74\x72\x61\x74\x69\157\156");
        delete_mo_option("\141\144\x6d\151\x6e\x5f\160\x61\163\x73\167\x6f\162\144");
    }
    function _validate_otp($post)
    {
        $this->isValidRequest();
        $ZI = sanitize_text_field($post["\x6f\x74\x70\x5f\x74\157\153\145\156"]);
        $mo = get_mo_option("\141\x64\x6d\151\x6e\x5f\x65\155\141\151\x6c");
        $Tf = get_mo_option("\143\x6f\155\160\141\x6e\171\137\156\x61\x6d\x65");
        $iK = get_mo_option("\x61\x64\155\x69\x6e\x5f\160\x61\x73\163\x77\157\x72\144");
        if (!MoUtility::isBlank($ZI)) {
            goto QDF;
        }
        update_mo_option("\162\145\147\151\x73\164\162\141\164\151\x6f\156\137\x73\164\141\x74\165\x73", "\115\x4f\137\117\x54\120\x5f\x56\x41\114\x49\104\x41\124\x49\x4f\x4e\x5f\106\x41\111\114\x55\122\105");
        do_action("\155\x6f\x5f\162\x65\147\x69\163\164\162\x61\164\151\x6f\x6e\x5f\163\150\157\167\x5f\x6d\x65\x73\163\141\147\145", MoMessages::showMessage(MoMessages::REQUIRED_OTP), "\x45\x52\122\x4f\122");
        return;
        QDF:
        $zw = json_decode(MocURLOTP::validate_otp_token(get_mo_option("\164\x72\x61\156\163\141\143\x74\151\157\x6e\x49\144"), $ZI), true);
        if (strcasecmp($zw["\x73\164\x61\164\x75\163"], "\x53\125\x43\103\105\123\123") == 0) {
            goto cCD;
        }
        update_mo_option("\x72\x65\x67\151\x73\164\x72\x61\164\151\157\156\x5f\x73\x74\141\x74\165\163", "\x4d\x4f\x5f\117\x54\x50\137\126\x41\114\111\x44\101\124\111\117\116\x5f\106\101\x49\114\125\122\x45");
        do_action("\155\x6f\x5f\162\x65\x67\151\x73\164\x72\141\164\x69\x6f\156\x5f\163\x68\x6f\x77\137\x6d\145\x73\x73\x61\147\145", MoUtility::_get_invalid_otp_method(), "\105\122\122\117\x52");
        goto nWB;
        cCD:
        $Yw = json_decode(MocURLOTP::create_customer($mo, $Tf, $iK, $Dk = '', $a8 = '', $Fz = ''), true);
        if (!(strcasecmp($Yw["\163\164\x61\x74\165\x73"], "\x49\116\126\101\114\x49\104\137\x45\x4d\101\x49\x4c\x5f\121\x55\111\103\x4b\x5f\x45\115\101\x49\x4c") == 0)) {
            goto pLS;
        }
        do_action("\x6d\157\x5f\x72\145\x67\151\163\164\x72\x61\x74\x69\157\x6e\137\x73\x68\157\167\x5f\155\x65\x73\x73\x61\147\x65", MoMessages::showMessage(MoMessages::ENTERPRIZE_EMAIL), "\105\x52\122\x4f\122");
        pLS:
        if (strcasecmp($Yw["\x73\164\x61\164\165\163"], "\103\x55\123\124\117\115\105\122\x5f\125\x53\105\122\x4e\101\115\x45\137\101\114\x52\105\101\x44\131\137\105\x58\111\123\124\x53") == 0) {
            goto lDU;
        }
        if (strcasecmp($Yw["\x73\x74\141\164\165\163"], "\105\115\x41\111\x4c\137\102\x4c\x4f\103\113\x45\104") == 0 && $Yw["\155\x65\x73\x73\141\147\x65"] == "\145\x72\x72\x6f\x72\56\145\x6e\x74\x65\x72\160\x72\151\x73\145\56\145\x6d\141\x69\154") {
            goto QbG;
        }
        if (strcasecmp($Yw["\x73\x74\141\x74\165\x73"], "\x46\101\x49\114\x45\104") == 0) {
            goto IXE;
        }
        if (!(strcasecmp($Yw["\x73\164\x61\164\165\x73"], "\123\125\103\x43\x45\123\x53") == 0)) {
            goto lov;
        }
        $this->save_success_customer_config($Yw["\151\144"], $Yw["\141\x70\x69\113\x65\171"], $Yw["\164\157\x6b\x65\x6e"], $Yw["\x61\160\160\123\x65\143\162\x65\164"]);
        update_mo_option("\x72\145\147\151\163\x74\x72\141\x74\x69\x6f\156\137\x73\x74\141\x74\x75\163", "\115\x4f\137\x43\x55\123\x54\117\115\x45\122\137\x56\x41\x4c\111\x44\101\x54\x49\x4f\x4e\x5f\x52\x45\x47\x49\123\124\122\101\x54\x49\117\116\137\x43\x4f\115\x50\x4c\x45\x54\105");
        update_mo_option("\x65\x6d\x61\151\154\x5f\x74\x72\x61\156\163\141\x63\x74\151\x6f\156\163\137\162\x65\155\141\x69\156\x69\156\147", MoConstants::EMAIL_TRANS_REMAINING);
        update_mo_option("\x70\150\x6f\156\x65\137\x74\162\x61\156\163\x61\x63\x74\x69\157\156\x73\137\x72\145\155\141\151\x6e\x69\156\147", MoConstants::PHONE_TRANS_REMAINING);
        do_action("\155\x6f\x5f\162\145\147\x69\x73\x74\162\141\x74\x69\x6f\156\x5f\x73\x68\157\167\137\155\145\163\163\x61\147\x65", MoMessages::showMessage(MoMessages::REG_COMPLETE), "\123\x55\103\x43\105\123\123");
        header("\x4c\x6f\x63\x61\x74\151\x6f\x6e\72\x20\141\x64\155\151\x6e\x2e\160\x68\160\x3f\160\141\147\x65\x3d\160\162\151\x63\151\156\x67");
        lov:
        goto eJf;
        IXE:
        do_action("\x6d\157\137\x72\x65\x67\x69\163\164\162\141\x74\151\157\156\137\x73\150\x6f\167\x5f\x6d\x65\x73\163\141\x67\145", MoMessages::showMessage(MoMessages::REGISTRATION_ERROR), "\x45\x52\x52\x4f\122");
        eJf:
        goto lIh;
        QbG:
        do_action("\x6d\157\137\x72\145\x67\151\163\x74\162\141\x74\151\x6f\156\x5f\x73\150\x6f\x77\x5f\x6d\x65\163\163\141\147\x65", MoMessages::showMessage(MoMessages::ENTERPRIZE_EMAIL), "\x45\x52\x52\117\x52");
        lIh:
        goto KZE;
        lDU:
        $this->_get_current_customer($mo, $iK);
        KZE:
        nWB:
    }
    function _send_phone_otp_token($post)
    {
        $this->isValidRequest();
        $Dk = sanitize_text_field($_POST["\x70\x68\x6f\156\145\x5f\156\x75\155\142\x65\x72"]);
        $Dk = str_replace("\40", '', $Dk);
        $su = "\57\133\134\x2b\135\133\x30\x2d\71\x5d\173\x31\54\63\x7d\133\x30\55\71\x5d\173\x31\x30\175\57";
        if (preg_match($su, $Dk, $W0, PREG_OFFSET_CAPTURE)) {
            goto kPh;
        }
        update_mo_option("\x72\x65\147\151\x73\x74\162\141\164\x69\x6f\x6e\x5f\163\164\x61\x74\165\x73", "\x4d\x4f\x5f\x4f\124\120\x5f\104\105\x4c\111\126\x45\122\105\104\x5f\x46\101\111\114\x55\122\x45");
        do_action("\x6d\157\x5f\x72\x65\147\x69\x73\x74\162\x61\164\151\x6f\x6e\x5f\163\150\157\x77\x5f\x6d\145\163\x73\x61\147\x65", MoMessages::showMessage(MoMessages::INVALID_SMS_OTP), "\x45\122\122\117\122");
        goto Q6a;
        kPh:
        update_mo_option("\141\144\155\x69\156\x5f\x70\x68\157\156\x65", $Dk);
        $this->_send_otp_token('', $Dk, "\123\x4d\x53");
        Q6a:
    }
    function _verify_customer($post)
    {
        $this->isValidRequest();
        $mo = sanitize_email($post["\145\x6d\x61\151\154"]);
        $iK = stripslashes($post["\x70\141\x73\x73\167\x6f\x72\x64"]);
        if (!(MoUtility::isBlank($mo) || MoUtility::isBlank($iK))) {
            goto W_E;
        }
        do_action("\x6d\157\137\x72\145\147\x69\163\164\x72\141\x74\x69\x6f\156\137\163\x68\157\x77\x5f\x6d\x65\163\x73\x61\147\145", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), "\x45\122\x52\x4f\x52");
        return;
        W_E:
        $this->_get_current_customer($mo, $iK);
    }
    function _reset_password()
    {
        $this->isValidRequest();
        $mo = get_mo_option("\x61\x64\155\x69\x6e\137\x65\x6d\141\x69\x6c");
        if (!$mo) {
            goto wrG;
        }
        $It = json_decode(MocURLOTP::forgot_password($mo));
        if ($It->status == "\x53\125\x43\103\105\x53\x53") {
            goto ei5;
        }
        do_action("\x6d\157\x5f\162\145\x67\151\x73\x74\x72\x61\164\x69\x6f\x6e\x5f\x73\x68\x6f\167\137\x6d\145\x73\163\x61\147\145", MoMessages::showMessage(MoMessages::UNKNOWN_ERROR), "\105\x52\122\x4f\122");
        goto eA8;
        ei5:
        do_action("\155\157\x5f\x72\x65\147\x69\x73\x74\x72\x61\x74\x69\x6f\156\x5f\163\x68\x6f\x77\x5f\155\145\x73\163\x61\147\x65", MoMessages::showMessage(MoMessages::RESET_PASS), "\x53\125\x43\103\x45\123\123");
        eA8:
        goto mqO;
        wrG:
        do_action("\x6d\x6f\137\x72\x65\147\151\x73\164\x72\x61\164\x69\157\156\x5f\x73\x68\157\167\x5f\155\145\x73\x73\x61\147\x65", MoMessages::showMessage(MoMessages::FORGOT_PASSWORD_MESSAGE), "\123\125\103\103\x45\123\123");
        mqO:
    }
    function _revert_back_registration()
    {
        $this->isValidRequest();
        update_mo_option("\162\x65\x67\151\x73\x74\x72\141\164\x69\x6f\156\137\163\164\x61\164\x75\163", '');
        delete_mo_option("\156\x65\x77\x5f\162\145\x67\151\x73\x74\162\x61\164\151\157\x6e");
        delete_mo_option("\166\145\162\151\x66\x79\x5f\x63\165\x73\164\x6f\155\145\162");
        delete_mo_option("\141\144\x6d\x69\156\137\x65\155\141\151\154");
        delete_mo_option("\163\x6d\x73\137\x6f\x74\x70\137\x63\x6f\x75\156\164");
        delete_mo_option("\145\x6d\x61\x69\154\137\x6f\164\x70\x5f\x63\x6f\165\x6e\164");
        delete_mo_option("\x70\x6c\165\147\x69\x6e\x5f\x61\x63\164\x69\166\141\x74\x69\157\156\x5f\x64\141\x74\x65");
    }
    function removeAccount()
    {
        $this->isValidRequest();
        $this->flush_cache();
        wp_clear_scheduled_hook("\150\157\165\162\154\x79\123\x79\x6e\x63");
        delete_mo_option("\164\x72\x61\156\x73\x61\x63\x74\x69\x6f\156\111\x64");
        delete_mo_option("\141\x64\155\151\x6e\137\160\x61\x73\163\167\157\162\144");
        delete_mo_option("\x72\145\147\151\x73\x74\162\x61\x74\x69\x6f\156\x5f\163\x74\x61\x74\165\x73");
        delete_mo_option("\141\144\x6d\151\156\x5f\160\x68\x6f\x6e\145");
        delete_mo_option("\156\x65\x77\137\x72\x65\x67\x69\x73\164\162\x61\x74\x69\x6f\x6e");
        delete_mo_option("\141\144\x6d\151\156\x5f\x63\165\x73\164\157\155\145\162\137\153\145\171");
        delete_mo_option("\x61\x64\x6d\151\x6e\x5f\141\160\151\x5f\x6b\145\x79");
        delete_mo_option("\x63\x75\x73\164\x6f\x6d\x65\x72\x5f\164\x6f\x6b\145\x6e");
        delete_mo_option("\x76\x65\162\x69\x66\x79\x5f\143\x75\163\164\157\x6d\145\x72");
        delete_mo_option("\155\145\x73\x73\141\147\145");
        delete_mo_option("\143\x68\145\143\153\x5f\x6c\156");
        delete_mo_option("\163\x69\x74\145\137\145\x6d\x61\151\x6c\x5f\x63\x6b\x6c");
        delete_mo_option("\x65\155\x61\x69\x6c\137\166\x65\162\x69\x66\x69\x63\x61\x74\151\x6f\x6e\x5f\x6c\153");
        update_mo_option("\x76\x65\x72\x69\x66\x79\x5f\143\165\x73\164\x6f\x6d\x65\x72", true);
        delete_mo_option("\x70\154\x75\x67\x69\156\137\141\x63\164\x69\166\141\164\151\157\x6e\137\x64\141\164\x65");
    }
    function flush_cache()
    {
        $ig = GatewayFunctions::instance();
        $ig->flush_cache();
    }
    function _vlk($post)
    {
        $ig = GatewayFunctions::instance();
        $ig->_vlk($post);
    }
}
