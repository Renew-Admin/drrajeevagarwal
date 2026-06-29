<?php

namespace OTP\Addons\ipbasedropdown\Handler;

use OTP\Addons\ipbasedropdown\Helper\IpBaseCountry;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoUtility;
use OTP\Helper\MoMessages;
use OTP\Helper\SessionUtils;
use OTP\Helper\CountryList;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use WP_User;
use OTP\MoOTP;

class EnableIpBaseCountryCode {

	use Instance;
	private $_getIsIpbaseAddonEnabled;

	protected function __construct()
	{   
		
		$this->_getIsIpbaseAddonEnabled = get_ipbase_option("ipbasecountry_enable");
		if($this->_getIsIpbaseAddonEnabled){
			add_filter('mo_get_default_country', array($this, 'getCountryCode'), 1, 1);
		}
		add_action( 'admin_init', array($this,'checkAddonEnabled') , 2 );
		$this->showDropdown();

	}

	function showDropdown(){
		$selector = apply_filters( 'mo_phone_dropdown_selector', array() );
		if (MoUtility::isBlank($selector)) return;
		$selector = array_unique($selector); 
		wp_localize_script('mo_customer_validation_dropdown_script', 'modropdownvars', array(
			'selector' =>  json_encode($selector),
			'defaultCountry' => $this->getCountryCode(),
			'onlyCountries' => CountryList::getOnlyCountryList(),
		));
	}
    
	function getCountryCode(){
		//use $userIP = gethostbyname("www.google.com"); to get Ipadd on local instance..
		$userIP = $this->get_the_user_ip();  
    
		$apiURL = 'http://ip-api.com/php/'.$userIP; 
		 
		$ch = curl_init($apiURL); 
		 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		 
		$apiResponse = unserialize(curl_exec($ch)); 
		 
		curl_close($ch); 
		
        $defaultCountry = $apiResponse["countryCode"];
		return $defaultCountry;
	}

	function get_the_user_ip() {
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			//to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public function checkAddonEnabled() {

		if(isset($_POST['option']) && $_POST['option'] == 'mo_ipbase_countrycode_value')
			$this->handleAddonOptions();
		}
    public function handleAddonOptions(){
	  $param = 'mo_customer_validation_ipbase_enable';
      $this->_getIsIpbaseAddonEnabled = MoUtility::sanitizeCheck($param,$_POST);
	  update_ipbase_option('ipbasecountry_enable' ,$this->_getIsIpbaseAddonEnabled);
	}
	public function getIsIpbaseAddonEnabled(){ return $this->_getIsIpbaseAddonEnabled; }

}