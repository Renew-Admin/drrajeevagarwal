<?php


namespace OTP\Addons\CustomMessage;

use OTP\Addons\CustomMessage\Handler\CustomMessages;
use OTP\Addons\CustomMessage\Handler\CustomMessagesShortcode;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\101\102\123\x50\x41\x54\110")) {
    goto hk;
}
exit;
hk:
include "\x5f\141\165\x74\x6f\154\157\x61\x64\x2e\160\150\160";
class MiniOrangeCustomMessage extends BaseAddOn implements AddOnInterface
{
    use Instance;
    function initializeHandlers()
    {
        $h2 = AddOnList::instance();
        $C3 = CustomMessages::instance();
        $h2->add($C3->getAddOnKey(), $C3);
    }
    function initializeHelpers()
    {
        CustomMessagesShortcode::instance();
    }
    function show_addon_settings_page()
    {
        include MCM_DIR . "\143\x6f\156\164\x72\x6f\x6c\x6c\145\162\x73\57\155\141\x69\x6e\55\x63\157\x6e\164\x72\157\x6c\154\145\x72\x2e\x70\x68\x70";
    }
}
