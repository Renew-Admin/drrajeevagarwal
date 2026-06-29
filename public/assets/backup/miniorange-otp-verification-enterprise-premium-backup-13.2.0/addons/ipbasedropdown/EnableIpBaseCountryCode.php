<?php

namespace OTP\Addons\ipbasedropdown;

use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
use OTP\Addons\ipbasedropdown\Handler\IpBaseCountry;

if(! defined( 'ABSPATH' )) exit;

include '_autoload.php';

final class EnableIpBaseCountryCode extends BaseAddOn implements AddOnInterface
{
    use Instance;


    public function __construct()
    {
        add_action('mo_otp_verification_delete_addon_options', array($this,'mo_sc_delete_addon') , 1);

        parent::__construct();
    }

	function initializeHandlers()
    {
        
        $list = AddOnList::instance();  
        $handler = IpBaseCountry::instance();
        $list->add($handler->getAddOnKey(),$handler);
    }

    
    function initializeHelpers()
    {
        IpBaseCountry::instance();
    }

    
    function show_addon_settings_page()
    {
        include IBC_DIR . 'controllers/main-controller.php';
    }

    function mo_sc_delete_addon()
    {
        delete_site_option('mo_sc_code_countrycode_enable');
        delete_site_option('mo_sc_code_selected_country_list');
    }
}