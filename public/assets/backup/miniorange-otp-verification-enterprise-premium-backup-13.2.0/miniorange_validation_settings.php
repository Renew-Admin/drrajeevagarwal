<?php
/**
 * Plugin Name: Email Verification / SMS verification / Mobile Verification
 * Plugin URI: http://miniorange.com
 * Description: Email & SMS OTP Verification for all forms. WooCommerce SMS Notification. PasswordLess Login. External Gateway for OTP Verification. 24/7 support.
 * Version: 13.2.0
 * Author: miniOrange
 * Author URI: http://miniorange.com
 * Text Domain: miniorange-otp-verification
 * Domain Path: /lang
 * WC requires at least: 2.0.0
 * WC tested up to: 5.6.0
 * License: miniOrange
 * License URI: https://miniorange.com/usecases/miniOrange_User_Agreement.pdf
 */


use OTP\MoOTP;
if (defined("\x41\102\x53\120\x41\x54\x48")) {
    goto OC9;
}
exit;
OC9:
define("\x4d\x4f\x56\x5f\120\x4c\125\107\111\x4e\137\x4e\x41\115\x45", plugin_basename(__FILE__));
$TW = substr(MOV_PLUGIN_NAME, 0, strpos(MOV_PLUGIN_NAME, "\x2f"));
define("\115\117\126\137\116\101\x4d\105", $TW);
include "\x5f\141\x75\x74\157\x6c\x6f\141\144\56\x70\150\160";
MoOTP::instance();
