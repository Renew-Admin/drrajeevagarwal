<?php


namespace OTP\Helper;

if (defined("\101\102\x53\x50\101\x54\110")) {
    goto HAZ;
}
exit;
HAZ:
use OTP\Objects\IGatewayFunctions;
use OTP\Objects\NotificationSettings;
use OTP\Traits\Instance;
class GatewayFunctions implements IGatewayFunctions
{
    use Instance;
    private $gateway;
    private $pluginTypeToClass = array("\115\x69\156\x69\x4f\162\141\x6e\x67\145\107\141\164\145\x77\x61\x79" => "\x4f\124\x50\134\110\x65\154\160\145\162\134\115\151\x6e\x69\117\x72\141\156\x67\x65\x47\141\164\x65\167\141\171", "\x43\x75\x73\164\157\x6d\x47\141\x74\145\167\x61\171\127\x69\x74\x68\x41\x64\144\x6f\156\x73" => "\x4f\x54\x50\134\110\145\154\160\x65\x72\x5c\103\165\163\x74\157\155\107\x61\x74\x65\x77\141\x79\x57\151\164\x68\x41\144\144\x6f\x6e\163", "\x43\x75\x73\x74\x6f\x6d\x47\141\x74\145\x77\141\171\x57\x69\164\x68\x6f\x75\x74\x41\144\x64\157\x6e\163" => "\117\124\x50\134\x48\x65\x6c\160\x65\162\x5c\103\x75\163\164\x6f\x6d\107\x61\x74\145\167\141\171\x57\151\x74\x68\157\x75\x74\101\x64\x64\157\x6e\x73", "\x54\x77\151\154\151\157\x47\x61\x74\145\167\141\x79\x57\151\x74\x68\x41\x64\x64\157\x6e\x73" => "\117\124\x50\x5c\110\x65\x6c\160\x65\162\134\124\167\151\x6c\151\x6f\107\x61\164\145\167\x61\171\127\151\164\150\x41\x64\144\157\x6e\163", "\105\x6e\164\x65\x72\x70\x72\151\163\x65\107\141\x74\145\167\x61\171\127\151\164\x68\x41\144\144\157\x6e\163" => "\117\x54\120\134\110\145\154\x70\x65\x72\134\105\x6e\164\145\162\160\162\151\163\145\107\x61\x74\145\x77\141\x79\x57\151\x74\150\x41\144\x64\x6f\156\x73");
    public function __construct()
    {
        $pR = $this->pluginTypeToClass[MOV_TYPE];
        $this->gateway = $pR::instance();
    }
    public function isMG()
    {
        return $this->gateway->isMG();
    }
    public function loadAddons($gX)
    {
        $this->gateway->loadAddons($gX);
    }
    function registerAddOns()
    {
        $this->gateway->registerAddOns();
    }
    public function showAddOnList()
    {
        $this->gateway->showAddOnList();
    }
    function hourlySync()
    {
        $this->gateway->hourlySync();
    }
    public function custom_wp_mail_from_name($BC)
    {
        return $this->gateway->custom_wp_mail_from_name($BC);
    }
    public function flush_cache()
    {
        $this->gateway->flush_cache();
    }
    public function _vlk($post)
    {
        $this->gateway->_vlk($post);
    }
    public function _mo_configure_sms_template($kB)
    {
        $this->gateway->_mo_configure_sms_template($kB);
    }
    public function _mo_configure_email_template($kB)
    {
        $this->gateway->_mo_configure_email_template($kB);
    }
    public function mo_send_otp_token($CV, $mo, $Dk)
    {
        return $this->gateway->mo_send_otp_token($CV, $mo, $Dk);
    }
    public function mclv()
    {
        return $this->gateway->mclv();
    }
    public function isGatewayConfig()
    {
        return $this->gateway->isGatewayConfig();
    }
    public function showConfigurationPage($m5)
    {
        $this->gateway->showConfigurationPage($m5);
    }
    public function mo_validate_otp_token($Ng, $ZI)
    {
        return $this->gateway->mo_validate_otp_token($Ng, $ZI);
    }
    public function mo_send_notif(NotificationSettings $CW)
    {
        return $this->gateway->mo_send_notif($CW);
    }
    public function getApplicationName()
    {
        return $this->gateway->getApplicationName();
    }
    public function getConfigPagePointers()
    {
        return $this->gateway->getConfigPagePointers();
    }
}
