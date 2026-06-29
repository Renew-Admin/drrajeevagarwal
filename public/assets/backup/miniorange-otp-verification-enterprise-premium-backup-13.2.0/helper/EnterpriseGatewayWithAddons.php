<?php


namespace OTP\Helper;

if (defined("\x41\102\123\120\x41\124\110")) {
    goto XVm;
}
exit;
XVm:
use OTP\Addons\CustomMessage\MiniOrangeCustomMessage;
use OTP\Addons\PasswordResetwc\WooCommercePasswordReset;
use OTP\Addons\WpSMSNotification\WordPressSmsNotification;
use OTP\Addons\regwithphone\RegisterWithPhoneOnly;
use OTP\Addons\PasswordReset\UltimateMemberPasswordReset;
use OTP\Addons\UmSMSNotification\UltimateMemberSmsNotification;
use OTP\Addons\WcSMSNotification\WooCommerceSmsNotification;
use OTP\Addons\ipbasedropdown\EnableIpBaseCountryCode;
use OTP\Addons\passwordresetwp\WordPressPasswordReset;
use OTP\Addons\CountryCode\SelectedCountryCode;
use OTP\Addons\APIVerification\APIAddon;
use OTP\Addons\ResendControl\MiniOrangeOTPControl;
use OTP\Addons\PasscodeOverCalltwilio\OTPOverCallAddon;
use OTP\Addons\MoBulkSMS\MoBulkSMSInit;
use OTP\Addons\CountryCodeDropdown\CountryCodeDropdownInit;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\IGatewayFunctions;
use OTP\Traits\Instance;
class EnterpriseGatewayWithAddons extends CustomGateway implements IGatewayFunctions
{
    use Instance;
    protected $applicationName = "\167\160\137\x65\x6d\141\x69\x6c\x5f\x76\x65\162\151\146\x69\x63\141\x74\151\x6f\x6e\137\151\156\164\162\x61\156\x65\164\x5f\145\x6e\x74\x65\x72\x70\162\x69\163\145";
    public function registerAddOns()
    { 
        OTPOverCallAddon::instance();
        $LX = MOV_DIR . "\141\144\144\157\156\x73\57\143\x75\163\164\157\x6d\x6d\145\163\x73\141\x67\x65";
        if (!file_exists($LX)) {
            goto ae2;
        }
        MiniOrangeCustomMessage::instance();
        ae2:
        $yp = MOV_DIR . "\x61\x64\x64\x6f\x6e\163\x2f\x70\x61\163\163\x77\x6f\162\144\x72\x65\163\x65\x74";
        if (!file_exists($yp)) {
            goto U5I;
        }
        UltimateMemberPasswordReset::instance();
        U5I:
        $c6 = MOV_DIR . "\141\144\x64\157\x6e\x73\x2f\165\155\x73\x6d\x73\156\157\164\151\x66\x69\143\141\x74\x69\157\156";
        if (!file_exists($c6)) {
            goto zGL;
        }
        UltimateMemberSmsNotification::instance();
        zGL:
        $nI = MOV_DIR . "\x61\x64\144\157\x6e\x73\x2f\167\143\x73\x6d\x73\x6e\x6f\x74\x69\x66\x69\x63\141\164\x69\x6f\x6e";
        if (!file_exists($nI)) {
            goto HmD;
        }
        WooCommerceSmsNotification::instance();
        HmD:
        $e3 = MOV_DIR . "\x61\x64\144\157\156\163\57\160\x61\163\x73\x77\157\162\x64\x72\x65\x73\145\x74\x77\143";
        if (!file_exists($e3)) {
            goto reu;
        }
        WooCommercePasswordReset::instance();
        reu:
        $Ad = MOV_DIR . "\141\x64\144\x6f\156\163\57\x70\141\163\x73\167\157\162\144\x72\145\163\145\x74\x77\160";
        if (!file_exists($Ad)) {
            goto mlS;
        }
        WordPressPasswordReset::instance();
        mlS:
        $nX = MOV_DIR . "\141\144\x64\157\x6e\163\x2f\162\x65\x67\167\x69\164\x68\160\x68\157\x6e\x65";
        if (!file_exists($nX)) {
            goto YTC;
        }
        RegisterWithPhoneOnly::instance();
        YTC:
        $O6 = MOV_DIR . "\x61\x64\144\157\x6e\x73\57\x77\160\x73\155\163\x6e\157\164\151\x66\151\143\141\x74\x69\x6f\x6e";
        if (!file_exists($O6)) {
            goto sbY;
        }
        WordPressSmsNotification::instance();
        sbY:
        if (!file_exists(MOV_DIR . "\x61\x64\x64\x6f\156\x73\57\141\x70\x69\x76\x65\162\x69\146\151\x63\x61\x74\151\157\156")) {
            goto tsB;
        }
        APIAddon::instance();
        tsB:
        if (!file_exists(MOV_DIR . "\141\144\144\157\156\163\x2f\162\x65\x73\145\x6e\144\x63\157\156\164\162\157\154")) {
            goto m10;
        }
        MiniOrangeOTPControl::instance();
        m10:
        if (!file_exists(MOV_DIR . "\141\144\x64\x6f\x6e\x73\57\x63\157\165\156\x74\162\171\143\157\144\x65")) {
            goto w5F;
        }
        SelectedCountryCode::instance();
        w5F:
        // if (!file_exists(MOV_DIR . "\x61\144\x64\x6f\x6e\163\57\160\x61\x73\163\x63\157\144\145\x6f\x76\x65\x72\x63\x61\154\154")) {
        //     goto Czi;
        // }
        // OTPOverCallAddon::instance();
        // Czi:
        if (!file_exists(MOV_DIR . "\141\144\x64\x6f\x6e\163\57\155\157\x62\165\x6c\x6b\x73\155\163")) {
            goto mux;
        }
        MoBulkSMSInit::instance();
        mux:
        if (!file_exists(MOV_DIR . "\x61\x64\x64\x6f\156\x73\57\x63\157\165\x6e\164\162\x79\143\x6f\x64\x65\144\162\x6f\x70\x64\157\167\156")) {
            goto AZO;
        }
        CountryCodeDropdownInit::instance();
        AZO:
        if (!file_exists(MOV_DIR . "\141\x64\144\x6f\156\x73\57\151\160\142\141\163\145\x64\x72\x6f\160\x64\x6f\x77\156")) {
            goto ra4;
        }
        EnableIpBaseCountryCode::instance();
        ra4:
    }
    public function showAddOnList()
    {
        $Xe = AddOnList::instance();
        $Xe = $Xe->getList();
        foreach ($Xe as $Wx) {
            echo "\x3c\x74\162\76\xd\12\x20\x20\40\x20\x20\40\40\40\40\x20\40\40\x20\x20\40\x20\x20\40\x20\x20\x3c\x74\144\x20\143\154\x61\x73\x73\75\42\141\x64\x64\157\156\x2d\164\141\x62\x6c\145\55\154\x69\x73\164\55\x73\x74\141\164\x75\x73\42\x3e\xd\12\40\40\40\40\40\x20\40\x20\x20\x20\40\40\x20\40\40\40\x20\x20\x20\x20\x20\40\x20\x20" . $Wx->getAddOnName() . "\15\12\x20\40\40\40\x20\40\40\x20\40\40\40\x20\40\x20\40\40\40\x20\x20\x20\x3c\57\164\144\x3e\15\12\x20\x20\40\x20\40\40\40\40\x20\40\40\40\40\40\x20\40\x20\x20\x20\40\74\x74\144\x20\143\x6c\141\x73\163\75\42\x61\x64\x64\157\x6e\55\x74\x61\142\154\145\55\x6c\x69\163\164\x2d\x6e\x61\155\x65\x22\76\15\xa\x20\40\x20\40\40\40\40\40\40\40\40\x20\40\40\x20\x20\x20\x20\40\x20\x20\x20\40\x20\74\151\x3e\15\xa\x20\x20\40\x20\x20\40\x20\40\x20\x20\40\40\x20\x20\40\40\40\x20\40\x20\40\x20\x20\x20\x20\x20\x20\x20" . $Wx->getAddOnDesc() . "\15\12\x20\40\40\x20\x20\40\x20\40\40\40\x20\x20\40\x20\x20\x20\x20\x20\40\40\x20\40\40\40\x3c\57\x69\x3e\xd\xa\x20\x20\40\x20\x20\40\x20\x20\40\40\x20\40\40\40\x20\x20\x20\x20\40\40\x3c\x2f\164\x64\x3e\xd\xa\x20\40\40\40\x20\40\x20\x20\40\40\x20\x20\40\40\x20\x20\x20\40\x20\x20\x3c\164\144\40\x63\x6c\x61\x73\x73\x3d\x22\141\x64\x64\157\x6e\55\x74\x61\142\154\x65\55\154\x69\163\164\55\141\x63\164\x69\157\x6e\x73\x22\x3e\xd\12\40\40\40\40\40\40\40\40\40\40\x20\40\40\40\40\40\x20\x20\x20\x20\40\x20\x20\x20\74\141\40\x20\143\x6c\141\x73\163\75\x22\142\x75\x74\164\157\x6e\55\x70\x72\151\x6d\x61\162\x79\x20\x62\x75\164\164\157\x6e\40\x74\x69\160\x73\x22\x20\xd\xa\x20\40\x20\x20\x20\x20\x20\40\x20\40\x20\x20\40\x20\x20\x20\40\40\x20\40\x20\x20\40\40\40\x20\x20\x20\x68\162\x65\146\x3d\x22" . $Wx->getSettingsUrl() . "\42\x3e\15\xa\40\40\x20\40\x20\x20\40\40\40\x20\x20\x20\40\40\x20\40\40\x20\40\40\x20\x20\40\x20\40\x20\x20\x20" . mo_("\x53\x65\x74\164\151\156\x67\163") . "\xd\xa\x20\x20\x20\x20\40\40\40\x20\x20\40\x20\40\40\40\x20\40\40\x20\x20\40\x20\x20\x20\x20\74\x2f\141\x3e\15\12\x20\x20\x20\x20\x20\40\40\x20\x20\40\40\x20\40\40\x20\x20\x20\40\40\40\x3c\x2f\x74\x64\76";
            echo "\15\xa\x20\40\x20\40\40\x20\40\40\x20\40\40\x20\40\40\x20\40\x3c\x2f\x74\x72\76";
            Cnv:
        }
        lIq:
    }
    public function getConfigPagePointers()
    {
        return [];
    }
}
