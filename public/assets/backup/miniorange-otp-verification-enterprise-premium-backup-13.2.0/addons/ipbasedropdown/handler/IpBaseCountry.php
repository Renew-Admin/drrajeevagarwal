<?php

namespace OTP\Addons\ipbasedropdown\Handler;

use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
use OTP\Helper\MoOTPDocs;



class IpBaseCountry extends BaseAddOnHandler
{
    use Instance;

     function __construct()
    {
        parent::__construct();
        if (!$this->moAddOnV()) return;
        EnableIpBaseCountryCode::instance();
    }
    
    function setAddonKey()
    {
        $this->_addOnKey = 'ip_base_country_code_addon';
    }

    
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("Allows to show the country code dropdown based on the user geolocation/Ip address.");
    }

    
    function setAddOnName()
    {
        $this->_addOnName = mo_("Geolocation/IP Base Country Code Dropdown.");
    }

    
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg( array('addon'=> 'enableipbasecountrycode'), $_SERVER['REQUEST_URI'] );
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