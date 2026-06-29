<?php


namespace OTP\Helper\Gateway;

if (defined("\101\102\123\120\x41\x54\110")) {
    goto RIP;
}
exit;
RIP:
use OTP\Objects\IGatewayType;
use OTP\Traits\Instance;
use OTP\Helper\GatewayType;
use OTP\Helper\MocURLOTP;
use OTP\Helper\MoMessages;
use OTP\Helper\MoConstants;
use OTP\Objects\NotificationSettings;
class MoGateway implements IGatewayType
{
    use Instance;
    private $gateway_url;
    public $_gatewayName;
    public function __construct()
    {
        $this->_gatewayName = "\x6d\151\156\x69\x4f\162\141\x6e\x67\x65\40\x47\141\164\145\167\x61\x79";
    }
    public function sendOTPRequest($bC, $Dk)
    {
        $bC = str_replace("\x20", "\x2b", $bC);
        $P9 = MoConstants::HOSTNAME . '/moas/api/plugin/notify/send';
        $Yw = get_mo_option("\141\x64\x6d\x69\156\x5f\x63\x75\163\164\x6f\155\145\162\137\x6b\x65\x79");
        $B2 = get_mo_option("\x61\144\155\151\x6e\137\x61\x70\x69\x5f\x6b\x65\x79");
        $Xw = ["\x63\x75\x73\164\157\155\x65\162\113\x65\171" => $Yw, "\x73\x65\x6e\x64\105\x6d\x61\x69\x6c" => false, "\x73\145\x6e\x64\123\115\x53" => true, "\163\x6d\x73" => ["\143\165\x73\164\157\x6d\145\x72\x4b\x65\171" => $Yw, "\x70\x68\157\x6e\x65\116\165\155\x62\145\x72" => $Dk, "\155\145\x73\163\141\147\x65" => $bC]];
        $dx = json_encode($Xw);
        $Fg = MocURLOTP::createAuthHeader($Yw, $B2);
        $aU = MocURLOTP::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    public function sendEmailOTPRequest($bC, $mo, $G_, $kV, $U7)
    {
        $P9 = MoConstants::HOSTNAME . '/moas/api/plugin/notify/send';
        $Yw = get_mo_option("\x61\144\155\x69\156\x5f\x63\165\x73\x74\x6f\x6d\145\162\x5f\x6b\145\x79");
        $B2 = get_mo_option("\x61\144\155\151\156\x5f\141\x70\151\137\153\x65\x79");
        $Xw = ["\x63\165\163\164\x6f\x6d\x65\162\113\x65\x79" => $Yw, "\x73\145\156\x64\x45\x6d\x61\151\154" => true, "\x73\x65\x6e\144\x53\115\x53" => false, "\145\x6d\x61\151\x6c" => ["\143\x75\x73\x74\x6f\x6d\x65\162\x4b\145\171" => $Yw, "\x66\162\x6f\x6d\x45\x6d\141\x69\x6c" => $G_, "\142\143\x63\x45\155\x61\x69\154" => $OK, "\x66\162\x6f\x6d\x4e\x61\155\x65" => $U7, "\164\x6f\x45\155\141\x69\x6c" => $mo, "\x74\x6f\116\141\x6d\145" => $mo, "\x73\x75\142\152\x65\x63\164" => $kV, "\143\x6f\x6e\164\x65\156\164" => $bC]];
        $dx = json_encode($Xw);
        $Fg = MocURLOTP::createAuthHeader($Yw, $B2);
        $aU = MocURLOTP::callAPI($P9, $dx, $Fg);
        return $aU;
    }
    public function handleGatewayResponse($aU, $bC, $Dk)
    {
        return apply_filters("\155\157\137\143\x75\163\x74\x6f\x6d\x5f\147\141\x74\145\x77\141\x79\x5f\162\x65\x73\160\157\156\x73\145", $aU, $bC, $Dk);
    }
    public function getGatewayConfigView($m5, $j_)
    {
        return "\x3c\x64\x69\166\x20\143\154\141\x73\163\75\x22\155\x6f\137\x6f\164\x70\x5f\156\x6f\164\145\x22\x3e\xd\12\x20\x20\40\x20\x20\x20\40\x20\40\40\x20\40\40\40\x20\40\x20\x20\40\40\x3c\151\x3e\x3c\x73\x70\141\x6e\x20\x73\164\x79\154\145\x3d\42\x63\x6f\x6c\157\162\72\x67\162\145\171\73\42\x3e\106\157\162\x20\x6d\x6f\x72\145\40\151\156\x66\x6f\54\x20\160\x6c\145\x61\x73\x65\x20\x63\x6f\x6e\164\x61\143\164\40\74\141\x20\x73\164\x79\x6c\x65\x3d\42\143\x75\x72\163\157\x72\72\x70\x6f\x69\x6e\x74\x65\162\x3b\x22\40\157\156\x43\x6c\151\143\153\x3d\42\157\164\x70\x53\x75\160\x70\157\162\x74\x4f\x6e\103\x6c\151\143\x6b\50\x29\x3b\42\x3e\74\x75\76\x20\x6f\164\x70\163\165\160\160\x6f\x72\164\100\170\x65\143\165\x72\151\146\171\x2e\143\x6f\155\74\x2f\165\x3e\x3c\57\x61\76\74\57\x73\x70\x61\156\76\x3c\57\x69\x3e\xd\xa\x20\40\40\40\40\x20\x20\40\x20\x20\x20\x20\x20\x20\x20\40\x3c\x2f\144\x69\166\x3e";
    }
    public function saveGatewayDetails($kB)
    {
    }
}
