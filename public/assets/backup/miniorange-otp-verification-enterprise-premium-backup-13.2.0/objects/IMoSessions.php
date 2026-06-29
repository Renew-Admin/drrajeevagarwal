<?php


namespace OTP\Objects;

interface IMoSessions
{
    static function addSessionVar($j1, $H5);
    static function getSessionVar($j1);
    static function unsetSession($j1);
    static function checkSession();
}
