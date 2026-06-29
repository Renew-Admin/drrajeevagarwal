<?php


namespace OTP\Objects;

abstract class BaseAddOn implements AddOnInterface
{
    function __construct()
    {
        $this->initializeHelpers();
        $this->initializeHandlers();
        add_action("\155\157\137\x6f\164\160\137\166\145\x72\151\146\151\x63\x61\164\x69\x6f\x6e\137\141\144\x64\137\157\156\137\143\x6f\x6e\164\x72\x6f\x6c\x6c\x65\162", array($this, "\163\150\157\167\137\141\x64\x64\157\156\x5f\x73\x65\164\x74\151\156\x67\163\137\x70\141\x67\x65"), 1, 1);
    }
}
