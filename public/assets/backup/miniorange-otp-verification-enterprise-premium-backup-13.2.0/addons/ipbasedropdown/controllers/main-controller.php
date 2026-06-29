<?php

use OTP\Addons\ipbasedropdown\Handler\IpBaseCountry;

$handler        = IpBaseCountry::instance();
$registerd 		= $handler->moAddOnV();
$disabled  	 	= !$registerd ? "disabled" : "";
$current_user 	= wp_get_current_user();
$controller 	= IBC_DIR . 'controllers/';
$addon          = add_query_arg( array('page' => 'addon'), remove_query_arg('addon',$_SERVER['REQUEST_URI']));

if(isset( $_GET[ 'addon' ]))
{
    switch($_GET['addon'])
    {
        case 'enableipbasecountrycode':
            include $controller . 'IpBaseDropDown.php'; break;
    }
}