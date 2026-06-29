<?php


namespace OTP\Objects;

abstract class VerificationLogic
{
    public abstract function _handle_logic($iI, $p1, $NN, $CD, $kt);
    public abstract function _handle_otp_sent($iI, $p1, $NN, $CD, $kt, $zw);
    public abstract function _handle_otp_sent_failed($iI, $p1, $NN, $CD, $kt, $zw);
    public abstract function _get_otp_sent_message();
    public abstract function _get_otp_sent_failed_message();
    public abstract function _get_otp_invalid_format_message();
    public abstract function _get_is_blocked_message();
    public abstract function _handle_matched($iI, $p1, $NN, $CD, $kt);
    public abstract function _handle_not_matched($NN, $CD, $kt);
    public abstract function _start_otp_verification($iI, $p1, $NN, $CD, $kt);
    public abstract function _is_blocked($p1, $NN);
    public static function _is_ajax_form()
    {
        return (bool) apply_filters("\151\x73\137\141\x6a\x61\x78\137\146\x6f\x72\x6d", FALSE);
    }
}
