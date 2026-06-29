<?php


namespace OTP\Addons\PasswordReset\Handler;

use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
use OTP\Helper\MoOTPDocs;
class UMPasswordResetAddOnHandler extends BaseAddOnHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto NV;
        }
        return;
        NV:
        UMPasswordResetHandler::instance();
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\165\155\x5f\160\x61\163\163\137\x72\x65\163\x65\x74\137\x61\x64\x64\x6f\156";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\101\154\154\157\x77\163\x20\x79\157\x75\162\40\x75\163\x65\162\x73\x20\x74\157\40\162\x65\x73\145\x74\40\x74\x68\x65\151\x72\40\160\x61\163\163\x77\x6f\x72\144\40\x75\x73\151\x6e\147\40\117\124\x50\40\x69\x6e\x73\x74\x65\141\144\40\x6f\146\40\x65\x6d\x61\x69\x6c\40\x6c\151\x6e\x6b\163\x2e" . "\x43\x6c\x69\143\153\x20\157\x6e\40\164\x68\145\40\163\x65\x74\164\x69\156\x67\x73\x20\x62\x75\164\164\157\156\40\164\157\x20\164\x68\x65\40\162\x69\147\x68\x74\x20\x74\157\x20\x63\157\x6e\x66\x69\147\x75\162\x65\x20\x73\145\x74\164\x69\x6e\147\163\x20\146\x6f\x72\x20\164\150\145\x20\x73\x61\x6d\x65\x2e");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\x55\x6c\x74\151\x6d\141\x74\x65\x20\x4d\145\x6d\x62\145\162\x20\120\x61\x73\163\167\x6f\x72\x64\x20\122\x65\163\145\164\40\x4f\x76\x65\162\40\x4f\x54\x50");
    }
    function setAddOnDocs()
    {
        $this->_addOnDocs = MoOTPDocs::ULTIMATEMEMBER_PASSWORD_RESET_ADDON_LINK["\x67\165\x69\144\145\114\x69\x6e\153"];
    }
    function setAddOnVideo()
    {
        $this->_addOnVideo = MoOTPDocs::ULTIMATEMEMBER_PASSWORD_RESET_ADDON_LINK["\x76\151\144\145\157\x4c\151\x6e\x6b"];
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\141\144\x64\x6f\156" => "\165\155\160\162\137\x6e\x6f\x74\x69\x66"), $_SERVER["\x52\105\121\125\105\123\x54\x5f\125\x52\x49"]);
    }
}
