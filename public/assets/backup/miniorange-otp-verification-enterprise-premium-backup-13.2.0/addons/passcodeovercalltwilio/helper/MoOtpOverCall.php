<?php

namespace OTP\Addons\PasscodeOverCalltwilio\Helper;

use OTP\Helper\MoUtility;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;



class MoOtpOverCall
{
    use Instance;

    
    public static function is_addon_activated()
    {
        MoUtility::is_addon_activated();
    }
}