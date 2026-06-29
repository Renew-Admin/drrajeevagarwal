<?php


namespace OTP\Helper;

if (defined("\x41\x42\x53\x50\101\124\x48")) {
    goto KaL;
}
exit;
KaL:
use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
final class AddOnList
{
    use Instance;
    private $_addOns;
    private function __construct()
    {
        $this->_addOns = array();
    }
    public function add($j1, $form)
    {
        $this->_addOns[$j1] = $form;
    }
    public function getList()
    {
        return $this->_addOns;
    }
}
