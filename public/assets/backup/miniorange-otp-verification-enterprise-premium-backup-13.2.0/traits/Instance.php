<?php


namespace OTP\Traits;

trait Instance
{
    private static $_instance = null;
    public static function instance()
    {
        if (!is_null(self::$_instance)) {
            goto PRb;
        }
        self::$_instance = new self();
        PRb:
        return self::$_instance;
    }
}
