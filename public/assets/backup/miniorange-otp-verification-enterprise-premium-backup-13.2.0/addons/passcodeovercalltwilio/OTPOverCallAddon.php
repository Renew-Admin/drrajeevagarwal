<?php

namespace OTP\Addons\PasscodeOverCalltwilio;

use OTP\Addons\PasscodeOverCalltwilio\Handler\OTPOverVoice;
use OTP\Addons\PasscodeOverCalltwilio\Helper\MoOtpOverCall;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;

if(! defined( 'ABSPATH' )) exit;
include '_autoload.php';

final class OTPOverCallAddon extends BaseAddon implements AddOnInterface
{
    use Instance;

    public function __construct()
	{
	    parent::__construct();
	    $this->updateValues();
		//add_action( 'admin_enqueue_scripts'					    , array( $this, 'mo_sms_notif_settings_style'   ) );
		//add_action( 'admin_enqueue_scripts'					    , array( $this, 'mo_sms_notif_settings_script' 	) );
        //add_action( 'mo_otp_verification_delete_addon_options'	, array( $this, 'mo_sms_notif_delete_options' 	) );
	}

	
	function mo_sms_notif_settings_style()
	{
		wp_enqueue_style( 'mo_sms_notif_admin_settings_style', MSN_CSS_URL);
	}


	
	function mo_sms_notif_settings_script()
	{
		wp_register_script( 'mo_sms_notif_admin_settings_script', MSN_JS_URL , array('jquery') );
		wp_localize_script( 'mo_sms_notif_admin_settings_script', 'mocustommsg', array(
			'siteURL' 		=> 	admin_url(),
		));
		wp_enqueue_script('mo_sms_notif_admin_settings_script');
	}

    
    function initializeHandlers()
    {
        
        $list = AddOnList::instance();
        $handler = OTPOverVoice::instance();
        $list->add($handler->getAddOnKey(),$handler);
    }

    
    function initializeHelpers()
    {
        MoOtpOverCall::instance();
    }


    
    function show_addon_settings_page()
    {
        include MOC_DIR . '/controllers/main-controller.php';
    }


    
	function mo_sms_notif_delete_options()
    {
        delete_site_option('mo_otp_call_notification_settings');
    }

    function updateValues(){
        $data = $_POST;
        // OTP RESEND LIMIT
        if(isset($data['option']) && $data['option']=='mo_passcode_over_voice_settings'){
            if($data['mo_customer_validation_otp_over_call'])
            	update_moc_option("moc_enabled",true);
            else
            	update_moc_option("moc_enabled",false);
        }

    }


}