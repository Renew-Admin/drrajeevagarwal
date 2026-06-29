<?php


namespace OTP\Objects;

class TransactionSessionData
{
    private $emailTransactionId;
    private $phoneTransactionId;
    public function getEmailTransactionId()
    {
        return $this->emailTransactionId;
    }
    public function setEmailTransactionId($E0)
    {
        $this->emailTransactionId = $E0;
    }
    public function getPhoneTransactionId()
    {
        return $this->phoneTransactionId;
    }
    public function setPhoneTransactionId($BN)
    {
        $this->phoneTransactionId = $BN;
    }
}
