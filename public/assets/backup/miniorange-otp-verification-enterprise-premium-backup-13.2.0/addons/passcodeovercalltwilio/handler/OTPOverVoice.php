<?php

namespace OTP\Addons\PasscodeOverCalltwilio\Handler;

use OTP\Addons\PasscodeOverCalltwilio\Helper\MoOtpOverCall;
use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\SMSNotification;
use OTP\Traits\Instance;
use OTP\Helper\MoOTPDocs;
use \WC_Emails;
use \WC_Order;


class OTPOverVoice extends BaseAddOnHandler
{
    use Instance;

    
    private $notificationSettings;

    
    function __construct()
    {
        parent::__construct();
        $addonActivationStatus = get_moc_option('moc_enabled');
        if(!$addonActivationStatus) return;
        if(!$this->moAddOnV()) return;
    }

    function setOTPOverCall($otp_type){
        return "PHONE VERIFICATION";
    }


    function setAddonKey()
    {
        $this->_addOnKey = 'otp_over_call_addon';
    }

    
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("Allows you to enable OTP over Call for your every OTP over SMS transaction.");
    }

    
    function setAddOnName()
    {
        $this->_addOnName = mo_("miniOrange OTP Over Call Addon");
    }

    
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg( array('addon'=> 'mo_otp_over_call'), $_SERVER['REQUEST_URI'] );
    }

    /** Set an Addon Docs link */
    function setAddOnDocs()
    {
        $this->_addOnDocs = "";
    }

     /** Set an Addon Video link */
    function setAddOnVideo()
    {
        $this->_addOnVideo = "";
    }

}