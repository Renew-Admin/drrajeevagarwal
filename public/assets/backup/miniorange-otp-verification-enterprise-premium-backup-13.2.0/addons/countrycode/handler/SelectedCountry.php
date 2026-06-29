<?php

namespace OTP\Addons\CountryCode\Handler;

use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
use OTP\Helper\MoOTPDocs;



class SelectedCountry extends BaseAddOnHandler
{
    use Instance;

     function __construct()
    {
        parent::__construct();
        if (!$this->moAddOnV()) return;
        SelectedCountryCode::instance();
    }
    
    function setAddonKey()
    {
        $this->_addOnKey = 'selected_country_addon';
    }

    
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("Allows your site to send One Time Passcode to selected countries only.");
    }

    
    function setAddOnName()
    {
        $this->_addOnName = mo_("Allow OTP To Only Selected Countries");
    }

    
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg( array('addon'=> 'selectedcountrycode'), $_SERVER['REQUEST_URI'] );
    }
     function setAddOnDocs()
    {
       $this->_addOnDocs = MoOTPDocs::SELECTED_COUNTRY_CODE_ADDON_LINK['guideLink'];
    }

     /** Set an Addon Video link */
    function setAddOnVideo()
    {
        $this->_addOnVideo = MoOTPDocs::SELECTED_COUNTRY_CODE_ADDON_LINK['videoLink'];
    }
}