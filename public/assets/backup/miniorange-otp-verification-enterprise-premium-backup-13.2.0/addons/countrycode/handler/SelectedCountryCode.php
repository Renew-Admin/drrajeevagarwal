<?php

namespace OTP\Addons\CountryCode\Handler;

use OTP\Addons\CountryCode\Helper\SelectedCountry;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoUtility;
use OTP\Helper\MoMessages;
use OTP\Helper\SessionUtils;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use WP_User;
use OTP\MoOTP;

class SelectedCountryCode {

	use Instance;

	protected function __construct()
	{
    $this->_selectedCountryType =  get_sc_option("select_country_type")?get_sc_option("select_country_type"):"";
    $this->_isCountryAllowed    =  get_sc_option('countrycode_enable') ? get_sc_option('selected_country_list') : "";
    $this->_isCountryBlocked    =  get_sc_option('block_selected_country_list') ? get_sc_option('block_selected_country_list') : "";
    $this->_scAllowTag          = "select_countries_to_show";
    $this->_scBlockTag          = "select_countries_to_block";
    
    add_action('admin_enqueue_scripts',array($this, 'miniorange_register_selectedCountry_script'));
    add_action( 'admin_init', array($this,'checkAddonOptions') , 2 );
    add_filter('selected_countries', array($this, 'selectedCountries'), 2, 1);
    add_filter('mo_blocked_phones', array($this, 'blockedNumbers'), 1, 2);

	}

  public function checkAddonOptions() {

  if(isset($_POST['option']) && MoUtility::sanitizeCheck('option',$_POST) == 'mo_selected_countrycode_value')
      $this->handleAddonOptions();
  }

   public function selectedCountries($countriesavail)
   	{
      unset($countriesavail[0]); 
      update_sc_option('allcountrywithcountrycode',$countriesavail);
     
      if($this->_selectedCountryType== $this->_scAllowTag){
         $selected_countries_list=explode(' ;',get_sc_option('selected_country_list') );
          $selected_countries=[];
          foreach ($selected_countries_list as $key1 => $value1) {
            
          foreach ($countriesavail as $key => $value) {   

                  if ($value1==$value['name']) {       
                     array_push($selected_countries, $value);
                  }

          }}
      $selected_countries = $selected_countries ? $selected_countries : $countriesavail;
      return $selected_countries;

      }
       
      elseif($this->_selectedCountryType== $this->_scBlockTag){
            
            $selected_countries_block_list=explode(' ;',get_sc_option('block_selected_country_list') );
            $selected_countries_block=$countriesavail;
              foreach ($selected_countries_block_list as $key1 => $value1) {   
                  foreach ($countriesavail as $key => $value) {
     
                      if ($value1==$value['name']) {
                       
                          unset($selected_countries_block[$key]);
                    
                      }

               }}
       $selected_countries_block = $selected_countries_block ? $selected_countries_block : $countriesavail;
       return $selected_countries_block;
        
      }    
 
      return $countriesavail;
   
   	}

   public function startsWith($string, $startString) { 
        $len = strlen($startString); 
        return (substr($string, 0, $len) === $startString); 
    }

    public function blockedNumbers($blocked_phone_numbers,$phone_number) {
        $numbers = explode('+',$phone_number);
          $selected_countries_code=explode(';',get_sc_option('selected_country_list') );

          foreach ($selected_countries_code as $key => $value) {
               if($this->startsWith($numbers[1],$value))  {
                  return $blocked_phone_numbers;
               }
               else
                continue;
         }
         array_push($blocked_phone_numbers, $phone_number);
         return $blocked_phone_numbers;
      }

    /**
     * This function registers the js file for changins selected countory textarea.
     */
    public function miniorange_register_selectedCountry_script()
    {   
        wp_register_script( 'moscountry', MOV_URL. 'addons/countrycode/includes/js/moscountry.min.js',array('jquery') );
        wp_localize_script( 'moscountry', 'moscountryvar', array(
                 'siteURL'      =>      wp_ajax_url(),
                 
        ));
        wp_enqueue_script( 'moscountry' );
    }


   public function handleAddonOptions() {

      $this->_selectedCountryType = MoUtility::sanitizeCheck('mo_customer_validation_sc_type',$_POST);  
      $this->_isCountryAllowed = MoUtility::sanitizeCheck('mo_selected_country_numbers',$_POST);
      $this->_isCountryBlocked = MoUtility::sanitizeCheck('mo_block_selected_country_numbers',$_POST);
      
      update_sc_option('select_country_type' ,$this->_selectedCountryType);
      update_sc_option('selected_country_list' ,$this->_isCountryAllowed);
      update_sc_option('block_selected_country_list' ,$this->_isCountryBlocked);
}

   public function getIsEnabled(){ return $this->_scAllowTag; }

   public function getIsBlockCountryEnabled(){ return $this->_scBlockTag; }

   public function getIsCountryAllowed(){ return  $this->_isCountryAllowed; }

   public function getIsCountryBlocked(){ return  $this->_isCountryBlocked; }

   public function getScType(){ return  $this->_selectedCountryType; }
}