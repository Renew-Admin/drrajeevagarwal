<?php


namespace OTP\Helper;

if (defined("\x41\x42\x53\x50\x41\124\x48")) {
    goto BSM;
}
exit;
BSM:
class MoException extends \Exception
{
    private $moCode;
    public function __construct($jA, $bC, $Rv)
    {
        $this->moCode = $jA;
        parent::__construct($bC, $Rv, NULL);
    }
    public function getMoCode()
    {
        return $this->moCode;
    }
}
