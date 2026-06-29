<?php


namespace OTP\Helper;

if (defined("\101\102\x53\x50\x41\124\x48")) {
    goto H6v;
}
exit;
H6v:
use OTP\MoOTP;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Traits\Instance;
final class MenuItems
{
    use Instance;
    private $_callback;
    private $_menuSlug;
    private $_menuLogo;
    private $_tabDetails;
    private function __construct()
    {
        $this->_callback = [MoOTP::instance(), "\x6d\x6f\x5f\x63\165\163\x74\157\x6d\x65\x72\137\x76\141\x6c\x69\144\x61\x74\151\157\x6e\137\157\x70\x74\151\x6f\156\163"];
        $this->_menuLogo = MOV_ICON;
        $ve = TabDetails::instance();
        $this->_tabDetails = $ve->_tabDetails;
        $this->_menuSlug = $ve->_parentSlug;
        $this->addMainMenu();
        $this->addSubMenus();
    }
    private function addMainMenu()
    {
        add_menu_page("\x4f\x54\120\40\x56\145\162\151\146\x69\x63\x61\164\151\x6f\156", "\x4f\x54\x50\x20\x56\145\x72\x69\x66\x69\x63\x61\x74\151\x6f\156", "\x6d\141\x6e\x61\x67\x65\137\x6f\x70\x74\x69\x6f\x6e\163", $this->_menuSlug, $this->_callback, $this->_menuLogo);
    }
    private function addSubMenus()
    {
        foreach ($this->_tabDetails as $e_) {
            add_submenu_page($this->_menuSlug, $e_->_pageTitle, $e_->_menuTitle, "\x6d\x61\156\141\147\145\137\x6f\160\164\151\157\156\163", $e_->_menuSlug, $this->_callback);
            cr6:
        }
        rKu:
    }
}
