<?php


namespace OTP\Objects;

interface IGatewayType
{
    public function handleGatewayResponse($aU, $bC, $Dk);
    public function sendOTPRequest($bC, $Dk);
    public function getGatewayConfigView($m5, $j_);
    public function saveGatewayDetails($kB);
}
