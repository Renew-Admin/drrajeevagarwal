<?php


namespace OTP\Helper;

use OTP\Objects\FormHandler;
use OTP\Traits\Instance;
if (defined("\x41\x42\x53\120\x41\124\110")) {
    goto eEl;
}
exit;
eEl:
final class FormList
{
    use Instance;
    private $_forms;
    private $enabled_forms;
    private function __construct()
    {
        $this->_forms = array();
    }
    public function add($j1, $form)
    {
        $this->_forms[$j1] = $form;
        if (!$form->isFormEnabled()) {
            goto od9;
        }
        $this->enabled_forms[$j1] = $form;
        od9:
    }
    public function getList()
    {
        return $this->_forms;
    }
    public function getEnabledForms()
    {
        return $this->enabled_forms;
    }
}
