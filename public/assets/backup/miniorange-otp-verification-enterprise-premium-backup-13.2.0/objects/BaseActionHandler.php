<?php


namespace OTP\Objects;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
class BaseActionHandler
{
    protected $_nonce;
    protected function __construct()
    {
    }
    protected function isValidRequest()
    {
        if (!(!current_user_can("\x6d\x61\156\141\x67\145\x5f\x6f\x70\164\x69\157\156\x73") || !check_admin_referer($this->_nonce))) {
            goto jCm;
        }
        wp_die(MoMessages::showMessage(MoMessages::INVALID_OP));
        jCm:
        return true;
    }
    protected function isValidAjaxRequest($j1)
    {
        if (check_ajax_referer($this->_nonce, $j1)) {
            goto iNa;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::INVALID_OP), MoConstants::ERROR_JSON_TYPE));
        iNa:
    }
    public function getNonceValue()
    {
        return $this->_nonce;
    }
}
