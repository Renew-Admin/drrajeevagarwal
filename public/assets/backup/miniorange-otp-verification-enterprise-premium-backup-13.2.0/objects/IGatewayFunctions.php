<?php


namespace OTP\Objects;

interface IGatewayFunctions
{
    public function registerAddOns();
    public function showAddOnList();
    public function flush_cache();
    public function _vlk($post);
    public function hourlySync();
    public function mclv();
    public function isGatewayConfig();
    public function isMG();
    public function getApplicationName();
    public function custom_wp_mail_from_name($BC);
    public function _mo_configure_sms_template($kB);
    public function _mo_configure_email_template($kB);
    public function showConfigurationPage($m5);
    public function mo_send_otp_token($CV, $mo, $Dk);
    public function mo_send_notif(NotificationSettings $CW);
    public function mo_validate_otp_token($Ng, $ZI);
    public function getConfigPagePointers();
}
