<?php

namespace OTP\Addons\passwordresetwc\Handler;

use OTP\Addons\passwordresetwc\Helper\WCPasswordResetMessages;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use OTP\Helper\MoConstants;
use WC;
use wc\core\Form;
use wc\core\Options;
use wc\core\Password;
use wc\core\User;
use WP_User;
use \WP_Error;

/**
 * Password Reset Handler handles sending an OTP to the user instead of
 * the link that usually gets sent out to the user's email address.
 */
class WCPasswordResetHandler extends FormHandler implements IFormHandler
{
    use Instance;

    /** @var string $_fieldKey username field key */
    private $_fieldKey;

    /** @var boolean $_isOnlyPhoneReset if only phone allowed */
    private $_isOnlyPhoneReset;

    protected function __construct()
    {
        $this->_isAjaxForm = TRUE;
        $this->_isAddOnForm = TRUE;
        $this->_formOption = "wc_password_reset_handler";
        $this->_formSessionVar = FormSessionVars::WC_DEFAULT_PASS;
        $this->_typePhoneTag = 'mo_wc_phone_enable';
        $this->_typeEmailTag = 'mo_wc_email_enable';
        $this->_phoneFormId = "user_login";
        $this->_fieldKey = "user_login";
        $this->_formKey = 'WOOCOMMERCE_PASS_RESET';
        $this->_formName = mo_("WooCommerce Password Reset using OTP");
        $this->_isFormEnabled = get_wcpr_option('pass_enable') ? TRUE : FALSE ;
        $this->_generateOTPAction = 'mo_wcpr_send_otp';
        $this->_buttonText = get_wcpr_option("pass_button_text");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("Reset Password");
        $this->_phoneKey =  get_wcpr_option('pass_phoneKey');
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "billing_phone";
        $this->_isOnlyPhoneReset = get_wcpr_option('only_phone_reset');

        parent::__construct();
    }

    /**
     * Function checks if form has been enabled by the admin and initializes
     * all the class variables. This function also defines all the hooks to
     * hook into to make OTP Verification possible.
     */
    public function handleForm()
    {
        $this->isErrorExists=false;
        $this->_otpType = get_wcpr_option('enabled_type');
        if($this->_isOnlyPhoneReset) $this->_phoneFormId = 'input#user_login';
        add_action("wp_ajax_nopriv_".$this->_generateOTPAction,array($this,'sendAjaxOTPRequest'));
        add_action("wp_ajax_".$this->_generateOTPAction,array($this,'sendAjaxOTPRequest'));
        add_action('wp_enqueue_scripts',array($this, 'miniorange_register_wc_script'));
        add_action('lostpassword_post', array($this,'checkUser'),1,1);
        add_filter( 'allow_password_reset',[$this,'checkiferrors'],1,2 );
    }   



    public function checkiferrors($var,$vare){

        if($this->isErrorExists){
            return new WP_Error();
        }
        return $var;


    }
    public function checkUser($errors){
       $user = MoUtility::sanitizeCheck($this->_fieldKey,$_POST);
       if(isset($errors->errors)) 
       {
           if( strcasecmp($this->_otpType,$this->_typePhoneTag)==0 && MoUtility::validatePhoneNumber($user)) 
           {
               $user_id = $this->getUser($user);
               if(!$user_id) 
               {
                wc_add_notice(__( 'We are not able to find an account registered with that address or
                username or phone number.', 'woocommerce' ), 'error' );
                return false;
               } 
               else 
               {
                   unset($errors->errors);
                   // Reset attempt code goes here
                   
               }
           }
       }

       if(empty($errors->errors)) {
           $this->checkIntegrityAndValidateOTP($errors,MoUtility::sanitizeCheck('verify_field',$_POST),$_POST);
       }
    }
     


    /**
     * Send an OTP to the user's phone or email.
     * @throws \ReflectionException
     */
     public function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $username = MoUtility::sanitizeCheck('username',$_POST);
        SessionUtils::addUserInSession($this->_formSessionVar,$username);
        $user = $this->getUser($username);
       
        if(!$user)
        { 
         
          if($this->_isOnlyPhoneReset)
          {
           
             wp_send_json(MoUtility::createJson(WCPasswordResetMessages::showMessage(WCPasswordResetMessages::WCRESET_LABEL_OP),"error"));
          }
          else
          {
            wp_send_json(MoUtility::createJson(WCPasswordResetMessages::showMessage
            (WCPasswordResetMessages::WCUSERNAME_NOT_EXIST),"error"));
          }
        }
           else
          {
            $phone = get_user_meta($user->ID,$this->_phoneKey,true);
            $this->startOtpTransaction(null,$user->user_email,null,$phone,null,null);
          }
    }

    


    /**
     * Check Integrity of the email or phone number. i.e. Ensure that the Email or
     * Phone that the OTP was sent to is the same Email or Phone that is being submitted
     * with the form.
     * <br/<br/>
     * Once integrity check passes validate the OTP to ensure that the user has entered
     * the correct OTP.
     *
     * @param Form $form
     * @param $value
     * @param array $args
     */
    private function checkIntegrityAndValidateOTP(&$errors,$value,array $args)
    {
        
        $otpVerType = $this->getVerificationType();
        $this->checkIntegrity($errors,$args);
        $this->validateChallenge($otpVerType,NULL,$value);

        if(!SessionUtils::isStatusMatch($this->_formSessionVar,self::VALIDATED,$otpVerType)) 
        {
            wc_add_notice('Invalid one time passcode. Please enter a valid passcode.' , 'error' );            
            $this->isErrorExists = true;
            return $errors;
        }
             $username = $args['user_login']; 
             $user = $this->getUser($username);
             if($user===false){
                return;
               }
             $userId = $user->ID;
             $key = get_password_reset_key($user);
             if(!empty($key->errors))
            {
               return;
            }
            $current_url=$_SERVER['HTTP_ORIGIN'].$_SERVER['REQUEST_URI']."?key=".$key."&id=".$userId;
            wp_redirect($current_url);
            exit();
    }


    /**
     * This function checks the integrity of the phone or email value that was submitted
     * with the form. It needs to match with the email or value that the OTP was
     * initially sent to.
     *
     * @param Form $umForm
     * @param array $args
     */
    private function checkIntegrity($wcForm,array $args)
    {
        $sessionVar = SessionUtils::getUserSubmitted($this->_formSessionVar);
        if($sessionVar!==$args[$this->_fieldKey]) {
        wc_add_notice( __( 'Username that the OTP was sent to and the username submitted do not match.', 'woocommerce' ), 'error' );
        }
        return;
    }


    /**
     * Get UserId based on the username passed
     *
     * @param $user
     * @return bool|int
     */
    public function getUserId($user)
    {
        $user = $this->getUser($user);
        return $user ? $user->ID : false;
    }


    /**
     * Get User based on the username passed
     * @param $username
     * @return bool|WP_User
     */
    public function getUser($username)
    {
        if( strcasecmp($this->_otpType,$this->_typePhoneTag)==0
            && MoUtility::validatePhoneNumber($username)) {
            $username = MoUtility::processPhoneNumber($username);
            $user = $this->getUserFromPhoneNumber($username);
        } else if(is_email($username)) {
            $user = get_user_by("email",$username);
        } else {
            $user = get_user_by("login",$username);
        }
        return $user;
        
    }


    /**
     * This functions fetches the user associated with a phone number
     *
     * @param $username - the user's username
     * @return bool|WP_User
     */
    function getUserFromPhoneNumber($username)
    {
        global $wpdb;
        $results = $wpdb->get_row("SELECT `user_id` FROM `{$wpdb->prefix}usermeta` WHERE `meta_key` = '$this->_phoneKey' AND `meta_value` =  '$username'");
        return !MoUtility::isBlank($results) ? get_userdata($results->user_id) : false;
    }


    

    /**
     * The function is called to start the OTP Transaction based on the OTP Type
     * set by the admin in the settings.
     *
     * @param $username  	- the username passed by the registration_errors hook
     * @param $email 		- the email passed by the registration_errors hook
     * @param $errors 		- the errors variable passed by the registration_errors hook
     * @param $phone_number - the phone number posted by the user during registration
     * @param $password 	- the password submitted by the user during registration
     * @param $extra_data 	- the extra data submitted by the user during registration
     */
    private function startOtpTransaction($username,$email,$errors,$phone_number,$password,$extra_data)
    {
        if(strcasecmp($this->_otpType,$this->_typePhoneTag)==0)
            $this->sendChallenge($username,$email,$errors,$phone_number,VerificationType::PHONE,$password,$extra_data);
        else
            $this->sendChallenge($username,$email,$errors,$phone_number,VerificationType::EMAIL,$password,$extra_data);
    }


    /**
     * This function registers the js file for enabling OTP Verification
     * for Ultimate Member using AJAX calls.
     */
    public function miniorange_register_wc_script()
    {
        
        wp_register_script( 'mowcpr', WCPR_URL . 'includes/js/mowcpr.js',array('jquery') );
        wp_localize_script( 'mowcpr', 'mowcprvar', array(
            'siteURL' 		=> wp_ajax_url(),
            'nonce'         => wp_create_nonce($this->_nonce),
            'buttontext'    => mo_($this->_buttonText),
            'imgURL'        => MOV_LOADER_URL,
            'action'        => [ 'send' => $this->_generateOTPAction ],
            'fieldKey'      => $this->_fieldKey,
            'resetLabelText'    => $this->_otpType==$this->_typePhoneTag? $this->_isOnlyPhoneReset ? 
                                    WCPasswordResetMessages::showMessage(WCPasswordResetMessages::WCRESET_LABEL_OP)
                                    :WCPasswordResetMessages::showMessage(WCPasswordResetMessages::WCRESET_LABEL) :WCPasswordResetMessages::showMessage(WCPasswordResetMessages::WCRESET_LABEL_EMAIL_ONLY) ,
            'phText'            => $this->_isOnlyPhoneReset ? mo_('Enter Your Phone Number') : mo_('Enter Your Email, Username or Phone Number'),
        ));
        wp_enqueue_script( 'mowcpr' );
    }


    /**
     * Unset all the session variables so that a new form submission starts
     * a fresh process of OTP verification.
     */
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }


    /**
     * This function hooks into the otp_verification_successful hook. This function is
     * details what needs to be done if OTP Verification is successful.
     *
     * @param string $redirect_to the redirect to URL after new user registration
     * @param string $user_login the username posted by the user
     * @param string $user_email the email posted by the user
     * @param string $password the password posted by the user
     * @param string $phone_number the phone number posted by the user
     * @param string $extra_data any extra data posted by the user
     * @param string $otpType the verification type
     */
    public function handle_post_verification($redirect_to, $user_login, $user_email, $password, $phone_number, $extra_data, $otpType)
    {
        SessionUtils::addStatus($this->_formSessionVar,self::VALIDATED,$otpType);
    }


    /**
     * This function hooks into the otp_verification_failed hook. This function
     * details what is done if the OTP verification fails.
     *
     * @param string $user_login the username posted by the user
     * @param string $user_email the email posted by the user
     * @param string $phone_number the phone number posted by the user
     * @param string $otpType the verification type
     */
    public function handle_failed_verification($user_login, $user_email, $phone_number, $otpType)
    {
        SessionUtils::addStatus($this->_formSessionVar,self::VERIFICATION_FAILED,$otpType);
    }



    public function handleFormOptions()
    {
        if(!MoUtility::areFormOptionsBeingSaved($this->getFormOption())) return;

        $this->_isFormEnabled = $this->sanitizeFormPOST("wc_pr_enable");
        $this->_buttonText = $this->sanitizeFormPOST("wc_pr_button_text");
        $this->_buttonText = $this->_buttonText ? $this->_buttonText : "Reset Password";
        $this->_otpType = $this->sanitizeFormPOST("wc_pr_enable_type");
        $this->_phoneKey = $this->sanitizeFormPOST("wc_pr_phone_field_key");
        $this->_isOnlyPhoneReset = $this->sanitizeFormPOST("wc_pr_only_phone");

        update_wcpr_option('only_phone_reset',$this->_isOnlyPhoneReset);
        update_wcpr_option('pass_enable',$this->_isFormEnabled);
        update_wcpr_option("pass_button_text",$this->_buttonText);
        update_wcpr_option('enabled_type',$this->_otpType);
        update_wcpr_option('pass_phoneKey',$this->_phoneKey);
    }


    /**
     * This function is called by the filter mo_phone_dropdown_selector
     * to return the Jquery selector of the phone field. The function will
     * push the formID to the selector array if OTP Verification for the
     * form has been enabled.
     *
     * @param  array $selector - the Jquery selector to be modified
     * @return array
     */
    public function getPhoneNumberSelector($selector)
    {
        if($this->isFormEnabled() && strcasecmp($this->_otpType,$this->_typePhoneTag)==0) {
            array_push($selector, $this->_phoneFormId);
        }
        return $selector;
    }

    /** getter for $_isOnlyPhoneReset */
    public function getIsOnlyPhoneReset(){ return $this->_isOnlyPhoneReset; }

}