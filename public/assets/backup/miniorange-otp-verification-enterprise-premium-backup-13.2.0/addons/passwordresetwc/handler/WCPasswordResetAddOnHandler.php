<?php

namespace OTP\Addons\passwordresetwc\Handler;

use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
use OTP\Helper\MoOTPDocs;

/**
 * The class is used to handle all Ultimate Member Password Reset related functionality.
 * <br/><br/>
 * This class hooks into all the available notification hooks and filters of
 * Ultimate Member to provide the possibility of overriding the default password reset
 * behaviour of Ultimate Member and replace it with OTP.
 */
class WCPasswordResetAddOnHandler extends BaseAddOnHandler
{
    use Instance;

    /**
     * Constructor checks if add-on has been enabled by the admin and initializes
     * all the class variables. This function also defines all the hooks to
     * hook into to make the add-on functionality work.
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->moAddOnV()) return;
        WCPasswordResetHandler::instance();
    }

    /** Set a unique for the AddOn */
    function setAddonKey()
    {
        $this->_addOnKey = 'wc_pass_reset_addon';
    }

    /** Set a AddOn Description */
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("Allows your users to reset their password using OTP instead of email links."
            ."Click on the settings button to the right to configure settings for the same.");
    }

    /** Set an AddOnName */
    function setAddOnName()
    {
        $this->_addOnName = mo_("WooCommerce Password Reset Over OTP");
    }
    
    function setAddOnDocs()
    {
    $this->_addOnDocs = MoOTPDocs::WOOCOMMERCE_PASSWORD_RESET_ADDON_LINK['guideLink'];
    }

    /** Set an Addon Video link */
    function setAddOnVideo()
    {
    $this->_addOnVideo = MoOTPDocs::WOOCOMMERCE_PASSWORD_RESET_ADDON_LINK['videoLink'];
    }

    /** Set Settings Page URL */
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg( array('addon'=> 'wcpr_notif'), $_SERVER['REQUEST_URI']);
    }
}