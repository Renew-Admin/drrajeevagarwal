<?php


namespace OTP\Objects;

class FormSessionData
{
    private $isInitialized = false;
    private $emailSubmitted;
    private $phoneSubmitted;
    private $emailVerified;
    private $phoneVerified;
    private $emailVerificationStatus;
    private $phoneVerificationStatus;
    private $fieldOrFormId;
    private $userSubmitted;
    function __construct()
    {
    }
    function init()
    {
        $this->isInitialized = true;
        return $this;
    }
    public function getIsInitialized()
    {
        return $this->isInitialized;
    }
    public function getEmailSubmitted()
    {
        return $this->emailSubmitted;
    }
    public function setEmailSubmitted($xT)
    {
        $this->emailSubmitted = $xT;
    }
    public function getPhoneSubmitted()
    {
        return $this->phoneSubmitted;
    }
    public function setPhoneSubmitted($lT)
    {
        $this->phoneSubmitted = $lT;
    }
    public function getEmailVerified()
    {
        return $this->emailVerified;
    }
    public function setEmailVerified($bQ)
    {
        $this->emailVerified = $bQ;
    }
    public function getPhoneVerified()
    {
        return $this->phoneVerified;
    }
    public function setPhoneVerified($oo)
    {
        $this->phoneVerified = $oo;
    }
    public function getEmailVerificationStatus()
    {
        return $this->emailVerificationStatus;
    }
    public function setEmailVerificationStatus($pl)
    {
        $this->emailVerificationStatus = $pl;
    }
    public function getPhoneVerificationStatus()
    {
        return $this->phoneVerificationStatus;
    }
    public function setPhoneVerificationStatus($ID)
    {
        $this->phoneVerificationStatus = $ID;
    }
    public function getFieldOrFormId()
    {
        return $this->fieldOrFormId;
    }
    public function setFieldOrFormId($TJ)
    {
        $this->fieldOrFormId = $TJ;
    }
    public function getUserSubmitted()
    {
        return $this->userSubmitted;
    }
    public function setUserSubmitted($bi)
    {
        $this->userSubmitted = $bi;
    }
}
