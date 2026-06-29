<?php


namespace OTP\Addons\WcSMSNotification\Helper;

use ReflectionClass;
final class WcOrderStatus
{
    const PROCESSING = "\x70\162\x6f\143\x65\163\163\x69\156\x67";
    const ON_HOLD = "\157\156\x2d\x68\157\x6c\144";
    const CANCELLED = "\143\141\156\x63\x65\154\154\x65\x64";
    const PENDING = "\x70\145\156\x64\151\156\x67";
    const FAILED = "\x66\141\151\154\x65\144";
    const COMPLETED = "\x63\x6f\155\x70\154\x65\164\x65\144";
    const REFUNDED = "\162\x65\x66\165\156\x64\x65\x64";
    public static function getAllStatus()
    {
        $VQ = new ReflectionClass(self::class);
        return array_values($VQ->getConstants());
    }
}
