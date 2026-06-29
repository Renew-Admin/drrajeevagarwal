<?php


namespace OTP\Addons\CustomMessage\Handler;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoOTPDocs;
class CustomMessages extends BaseAddOnHandler
{
    use Instance;
    public $_adminActions = array("\x6d\x6f\137\x63\x75\163\x74\x6f\155\145\162\137\166\x61\x6c\x69\x64\x61\164\x69\157\156\137\x61\144\155\x69\x6e\137\143\x75\x73\x74\x6f\x6d\x5f\160\x68\x6f\156\x65\137\x6e\x6f\x74\151\x66" => "\137\x6d\157\x5f\166\x61\x6c\x69\x64\141\164\x69\157\x6e\137\163\x65\x6e\x64\x5f\163\155\163\x5f\x6e\x6f\x74\x69\x66\x5f\155\x73\147", "\155\157\x5f\143\165\x73\x74\157\155\x65\162\x5f\x76\x61\154\151\144\141\x74\x69\157\x6e\x5f\x61\x64\155\151\156\x5f\x63\x75\163\164\157\155\x5f\145\155\x61\x69\154\137\156\x6f\164\x69\x66" => "\137\155\x6f\x5f\166\x61\x6c\x69\x64\141\x74\151\157\x6e\137\163\145\156\x64\x5f\145\x6d\x61\151\x6c\137\x6e\x6f\x74\x69\146\137\155\163\x67");
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\x6d\157\137\141\144\155\151\x6e\137\141\x63\x74\x69\157\156\163";
        if ($this->moAddOnV()) {
            goto QS;
        }
        return;
        QS:
        $this->_addonSessionVar = "\x63\x75\163\x74\x6f\x6d\x5f\155\x65\x73\163\x61\147\x65\137\141\x64\x64\157\156";
        $this->send_admin_notification();
        foreach ($this->_adminActions as $V_ => $dD) {
            add_action("\x77\x70\x5f\141\x6a\141\170\x5f{$V_}", [$this, $dD]);
            add_action("\x61\x64\x6d\x69\156\137\160\157\163\164\137{$V_}", [$this, $dD]);
            Wd:
        }
        Jr:
    }
    public function send_admin_notification()
    {
        if (!MoPHPSessions::getSessionVar($this->_addonSessionVar)) {
            goto A2;
        }
        MoPHPSessions::getSessionVar($this->_addonSessionVar)["\162\145\163\165\x6c\164"] == MoConstants::SUCCESS_JSON_TYPE ? do_action("\x6d\x6f\137\162\145\x67\151\x73\164\x72\x61\x74\x69\157\156\x5f\x73\150\157\x77\137\155\x65\x73\163\141\x67\145", MoPHPSessions::getSessionVar($this->_addonSessionVar)["\x6d\145\x73\x73\141\x67\145"], MoConstants::CUSTOM_MESSAGE_ADDON_SUCCESS) : do_action("\155\157\137\x72\x65\147\x69\163\164\x72\x61\x74\x69\x6f\x6e\x5f\x73\150\157\167\137\x6d\x65\163\163\141\x67\145", MoPHPSessions::getSessionVar($this->_addonSessionVar)["\155\x65\163\x73\x61\147\145"], MoConstants::CUSTOM_MESSAGE_ADDON_ERROR);
        $this->unsetSessionVariables();
        A2:
    }
    public function unsetSessionVariables()
    {
        MoPHPSessions::unsetSession($this->_addonSessionVar);
    }
    public function _mo_validation_send_sms_notif_msg()
    {
        $Ni = MoUtility::sanitizeCheck("\141\152\x61\x78\137\155\x6f\144\x65", $_POST);
        $Ni ? $this->isValidAjaxRequest("\x73\145\143\165\162\x69\x74\x79") : $this->isValidRequest();
        $FS = explode("\x3b", MoUtility::sanitizeCheck("\155\157\x5f\160\x68\x6f\156\x65\137\156\165\155\x62\x65\162\x73", $_POST));
        $bC = MoUtility::sanitizeCheck("\155\157\x5f\143\165\x73\164\x6f\155\x65\162\137\166\x61\x6c\151\x64\x61\164\x69\157\156\x5f\x63\x75\x73\164\157\155\137\x73\x6d\163\x5f\x6d\x73\x67", $_POST);
        $zw = null;
        foreach ($FS as $Dk) {
            $zw = MoUtility::send_phone_notif($Dk, $bC);
            lO:
        }
        RK:
        $Ni ? $this->checkStatusAndSendJSON($zw) : $this->checkStatusAndShowMessage($zw);
    }
    public function _mo_validation_send_email_notif_msg()
    {
        $Ni = MoUtility::sanitizeCheck("\x61\152\x61\x78\137\155\x6f\x64\145", $_POST);
        $Ni ? $this->isValidAjaxRequest("\163\x65\x63\165\162\x69\x74\x79") : $this->isValidRequest();
        $Lz = explode("\x3b", MoUtility::sanitizeCheck("\x74\x6f\x45\155\x61\x69\x6c", $_POST));
        $zw = null;
        foreach ($Lz as $mo) {
            $zw = MoUtility::send_email_notif(sanitize_email($_POST["\x66\x72\157\x6d\x45\155\x61\x69\x6c"]), sanitize_text_field($_POST["\146\162\157\x6d\116\x61\x6d\x65"]), sanitize_email($mo), sanitize_text_field($_POST["\x73\165\x62\152\x65\143\x74"]), stripslashes(sanitize_text_field($_POST["\143\157\x6e\164\145\x6e\164"])));
            en:
        }
        my:
        $Ni ? $this->checkStatusAndSendJSON($zw) : $this->checkStatusAndShowMessage($zw);
    }
    private function checkStatusAndShowMessage($zw)
    {
        if (!is_null($zw)) {
            goto UM;
        }
        return;
        UM:
        $Fx = $zw ? MoConstants::SUCCESS : MoConstants::ERROR;
        if ($Fx == MoConstants::SUCCESS) {
            goto pQ;
        }
        MoPHPSessions::addSessionVar($this->_addonSessionVar, MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT_FAIL), MoConstants::ERROR_JSON_TYPE));
        goto qb;
        pQ:
        MoPHPSessions::addSessionVar($this->_addonSessionVar, MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT), MoConstants::SUCCESS_JSON_TYPE));
        qb:
        wp_safe_redirect(wp_get_referer());
    }
    private function checkStatusAndSendJSON($zw)
    {
        if (!is_null($zw)) {
            goto hG;
        }
        return;
        hG:
        if ($zw) {
            goto yi;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT_FAIL), MoConstants::ERROR_JSON_TYPE));
        goto Te;
        yi:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT), MoConstants::SUCCESS_JSON_TYPE));
        Te:
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\x63\x75\x73\164\x6f\155\x5f\x6d\x65\163\163\x61\147\x65\163\137\141\x64\144\157\x6e";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\x53\145\x6e\144\x20\x43\x75\163\x74\157\x6d\x69\172\x65\144\x20\x6d\x65\163\x73\141\x67\x65\40\164\157\x20\141\156\171\40\160\x68\157\156\x65\40\x6f\162\x20\x65\155\x61\151\154\40\144\x69\162\x65\x63\x74\x6c\x79\x20\146\x72\157\155\x20\x74\x68\x65\40\x64\x61\x73\150\142\157\141\162\x64\56");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\103\165\x73\x74\x6f\x6d\40\115\145\x73\x73\x61\x67\x65\x73");
    }
    function setAddOnDocs()
    {
        $this->_addOnDocs = MoOTPDocs::CUSTOM_MESSAGES_ADDON_LINK["\147\x75\151\144\145\114\151\x6e\x6b"];
    }
    function setAddOnVideo()
    {
        $this->_addOnVideo = MoOTPDocs::CUSTOM_MESSAGES_ADDON_LINK["\166\151\x64\x65\157\x4c\x69\x6e\153"];
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\x61\144\144\157\x6e" => "\x63\x75\163\x74\x6f\155"), $_SERVER["\122\105\x51\x55\x45\123\124\137\125\x52\x49"]);
    }
}
