<?php


namespace OTP\Helper;

if (defined("\101\x42\123\x50\101\124\110")) {
    goto Ov6;
}
exit;
Ov6:
use OTP\Objects\IGatewayType;
use OTP\Traits\Instance;
class GatewayType implements IGatewayType
{
    use Instance;
    private $gatewayType;
    public function __construct()
    {
        $Ub = get_mo_option("\143\x75\x73\164\157\x6d\145\137\147\x61\x74\145\167\141\171\x5f\x74\x79\x70\145");
        $Ub = "\x4f\x54\120\x5c\x48\x65\x6c\160\x65\x72\x5c\x47\x61\x74\x65\x77\x61\171\134" . ($Ub ? $Ub : "\x4d\x6f\x47\x61\x74\145\x77\141\171\x55\122\x4c");
        $this->gatewayType = $Ub::instance();
    }
    public function handleGatewayResponse($aU, $bC, $Dk)
    {
        return $this->gatewayType->handleGatewayResponse($aU, $bC, $Dk);
    }
    public function sendOTPRequest($bC, $Dk)
    {
        return $this->gatewayType->sendOTPRequest($bC, $Dk);
    }
    public function getGatewayConfigView($m5, $j_)
    {
        return $this->gatewayType->getGatewayConfigView($m5, $j_);
    }
    public function saveGatewayDetails($kB)
    {
        $this->gatewayType->saveGatewayDetails($kB);
    }
}
