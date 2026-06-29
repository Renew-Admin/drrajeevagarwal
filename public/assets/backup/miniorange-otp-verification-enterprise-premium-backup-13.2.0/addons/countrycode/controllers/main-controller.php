<?php

use OTP\Addons\CountryCode\Handler\SelectedCountry;

$handler        = SelectedCountry::instance();
$registerd 		= $handler->moAddOnV();
$disabled  	 	= !$registerd ? "disabled" : "";
$current_user 	= wp_get_current_user();
$controller 	= SC_DIR . 'controllers/';
$addon          = add_query_arg( array('page' => 'addon'), remove_query_arg('addon',$_SERVER['REQUEST_URI']));

if(isset( $_GET[ 'addon' ]))
{
    switch($_GET['addon'])
    {
        case 'selectedcountrycode':
            include $controller . 'CountryCode.php'; break;
    }
}