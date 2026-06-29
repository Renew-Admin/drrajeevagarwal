<?php

if(! defined( 'ABSPATH' )) exit;

define('SC_DIR', plugin_dir_path(__FILE__));
define('SC_URL', plugin_dir_url(__FILE__));
// define('SC_VERSION', '1.0.0');

function get_sc_option($string,$prefix=null)
{
    $string = ($prefix==null ? "mo_sc_code_" : $prefix) . $string;
    return get_mo_option($string,'');
}


function update_sc_option($optionName,$value,$prefix=null)
{
    $optionName = ($prefix===null ? "mo_sc_code_" : $prefix) . $optionName;
    update_mo_option($optionName,$value,'');
}