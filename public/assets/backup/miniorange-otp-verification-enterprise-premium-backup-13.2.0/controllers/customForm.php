<?php


use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Handler\CustomForm;
$fQ = $Zf->getNonceValue();
$C3 = CustomForm::instance();
$o8 = $C3->getSubmitKeyDetails();
$WA = $o8 != '' || empty($o8) ? true : false;
$FJ = get_mo_option("\x63\x66\137\x65\x6e\141\142\154\145\x5f\x74\171\x70\145", "\155\x6f\137\x6f\164\160\x5f");
$Kg = $C3->getFieldKeyDetails();
$Nk = $C3->getPhoneHTMLTag();
$M5 = $C3->getEmailHTMLTag();
$jK = $C3->getButtonText();
include MOV_DIR . "\166\151\x65\167\163\x2f\x63\x75\163\x74\157\x6d\106\x6f\x72\x6d\56\x70\x68\160";
