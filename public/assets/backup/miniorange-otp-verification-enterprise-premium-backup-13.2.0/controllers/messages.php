<?php


use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
$fQ = $Zf->getNonceValue();
$Vx = get_mo_option("\163\165\x63\143\145\x73\x73\137\x65\155\141\151\x6c\137\x6d\x65\x73\x73\x61\x67\145", "\155\x6f\x5f\x6f\x74\x70\137") ? get_mo_option("\x73\165\143\x63\145\163\163\137\x65\155\x61\x69\154\137\x6d\145\x73\163\x61\147\145", "\155\x6f\x5f\157\x74\160\137") : MoMessages::showMessage(MoMessages::OTP_SENT_EMAIL);
$So = get_mo_option("\x73\x75\143\143\x65\x73\163\x5f\x70\x68\x6f\x6e\145\137\155\x65\x73\163\141\x67\x65", "\155\x6f\137\157\x74\160\137") ? get_mo_option("\x73\165\143\143\145\163\163\137\x70\150\157\156\145\x5f\155\145\x73\163\x61\x67\145", "\155\157\137\x6f\x74\x70\x5f") : MoMessages::showMessage(MoMessages::OTP_SENT_PHONE);
$do = get_mo_option("\145\162\162\157\x72\137\160\150\x6f\x6e\x65\x5f\x6d\x65\163\163\141\x67\145", "\155\x6f\x5f\x6f\x74\160\137") ? get_mo_option("\x65\x72\x72\x6f\x72\x5f\160\150\157\x6e\145\137\x6d\145\163\x73\141\x67\145", "\x6d\x6f\x5f\x6f\164\x70\137") : MoMessages::showMessage(MoMessages::ERROR_OTP_PHONE);
$DW = get_mo_option("\x65\162\162\x6f\x72\x5f\145\x6d\x61\x69\x6c\x5f\x6d\x65\x73\x73\141\x67\145", "\x6d\x6f\137\157\x74\x70\x5f") ? get_mo_option("\x65\162\x72\x6f\162\x5f\145\155\141\x69\x6c\x5f\x6d\x65\x73\x73\141\x67\x65", "\155\157\x5f\157\x74\160\137") : MoMessages::showMessage(MoMessages::ERROR_OTP_EMAIL);
$v0 = get_mo_option("\151\156\166\x61\x6c\x69\x64\137\160\150\x6f\x6e\x65\x5f\x6d\145\163\163\x61\x67\145", "\155\x6f\x5f\x6f\164\x70\x5f") ? get_mo_option("\151\x6e\166\x61\x6c\151\144\x5f\160\x68\x6f\156\145\x5f\x6d\x65\x73\163\141\147\145", "\x6d\157\137\157\x74\160\x5f") : MoMessages::showMessage(MoMessages::ERROR_PHONE_FORMAT);
$mG = get_mo_option("\151\156\x76\141\154\151\144\x5f\145\155\x61\x69\154\137\x6d\x65\163\x73\141\147\145", "\x6d\x6f\137\157\164\160\137") ? get_mo_option("\151\156\166\141\154\x69\x64\x5f\x65\x6d\141\x69\154\x5f\155\145\x73\163\x61\x67\145", "\155\157\137\157\x74\x70\x5f") : MoMessages::showMessage(MoMessages::ERROR_EMAIL_FORMAT);
$TE = MoUtility::_get_invalid_otp_method();
$X6 = get_mo_option("\x62\x6c\157\x63\x6b\x65\144\x5f\x65\155\141\x69\x6c\x5f\155\145\163\163\x61\147\x65", "\155\x6f\137\157\164\x70\137") ? get_mo_option("\142\154\157\143\153\145\144\x5f\145\x6d\x61\151\154\137\x6d\x65\x73\x73\x61\x67\145", "\155\157\x5f\x6f\164\x70\x5f") : MoMessages::showMessage(MoMessages::ERROR_EMAIL_BLOCKED);
$wZ = get_mo_option("\x62\154\x6f\x63\x6b\145\x64\x5f\x70\x68\157\x6e\145\137\x6d\145\163\163\x61\x67\x65", "\155\157\x5f\x6f\x74\160\137") ? get_mo_option("\142\154\x6f\143\x6b\x65\144\x5f\x70\x68\157\x6e\145\x5f\x6d\x65\x73\163\x61\x67\x65", "\155\x6f\137\x6f\x74\x70\x5f") : MoMessages::showMessage(MoMessages::ERROR_PHONE_BLOCKED);
include MOV_DIR . "\166\x69\x65\167\163\x2f\155\145\x73\x73\x61\147\145\163\56\160\x68\x70";
