<?php

if(! defined( 'ABSPATH' )) exit;

define('MOC_DIR', plugin_dir_path(__FILE__));
define('MOC_URL', plugin_dir_url(__FILE__));
define('MOC_VERSION', '1.0.0');
define('MOC_CSS_URL', MOC_URL . 'includes/css/settings.min.css?version='.MOC_VERSION);
define('MOC_JS_URL', MOC_URL . 'includes/js/settings.min.js?version='.MOC_VERSION);






function get_moc_option($string,$prefix=null)
{
    $string = ($prefix===null ? "mo_otp_call_" : $prefix) . $string;
    return get_mo_option($string,'');
}



function update_moc_option($optionName,$value,$prefix=null)
{
    $optionName = ($prefix===null ? "mo_otp_call_" : $prefix) . $optionName;
    update_mo_option($optionName,$value,'');
}