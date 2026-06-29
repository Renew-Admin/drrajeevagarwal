<?php

use OTP\Addons\passwordresetwc\Handler\WCPasswordResetAddOnHandler;

/** @var WCPasswordResetAddOnHandler $handler */
$handler        = WCPasswordResetAddOnHandler::instance();
$registered 	= $handler->moAddOnV();
$disabled  	 	= !$registered ? "disabled" : "";
$current_user 	= wp_get_current_user();
$controller 	= WCPR_DIR . 'controllers/';
$addon          = add_query_arg( array('page' => 'addon'), remove_query_arg('addon',$_SERVER['REQUEST_URI']));

if(isset( $_GET[ 'addon' ]))
{
    switch($_GET['addon'])
    {
        case 'wcpr_notif':
            include $controller . 'WCPasswordReset.php'; break;
    }
}