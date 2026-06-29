<?php


namespace OTP\Objects;

class PluginPageDetails
{
    function __construct($Kl, $gH, $hG, $Oa, $VI, $p9, $kO, $gu = '', $SF = true)
    {
        $this->_pageTitle = $Kl;
        $this->_menuSlug = $gH;
        $this->_menuTitle = $hG;
        $this->_tabName = $Oa;
        $this->_url = add_query_arg(["\x70\141\147\x65" => $this->_menuSlug], $VI);
        $this->_url = remove_query_arg(["\141\x64\144\x6f\156", "\x66\157\162\x6d", "\163\155\163", "\163\x75\x62\x70\141\147\x65"], $this->_url);
        $this->_view = $p9;
        $this->_id = $kO;
        $this->_showInNav = $SF;
        $this->_css = $gu;
    }
    public $_pageTitle;
    public $_menuSlug;
    public $_menuTitle;
    public $_tabName;
    public $_url;
    public $_view;
    public $_id;
    public $_showInNav;
    public $_css;
}
