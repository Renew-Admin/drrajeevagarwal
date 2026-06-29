<?php


namespace OTP\Objects;

use OTP\Helper\MoPHPSessions;
abstract class SMSNotification
{
    public $page;
    public $isEnabled;
    public $tooltipHeader;
    public $tooltipBody;
    public $recipient;
    public $smsBody;
    public $defaultSmsBody;
    public $title;
    public $availableTags;
    public $pageHeader;
    public $pageDescription;
    public $notificationType;
    function __construct()
    {
    }
    public abstract function sendSMS(array $Tw);
    public function setNotifInSession($KY)
    {
        MoPHPSessions::addSessionVar("\155\157\x5f\141\144\144\x6f\156\137\156\157\164\x69\x66\x5f\x74\x79\160\x65", $this->page);
    }
    public function setIsEnabled($EW)
    {
        $this->isEnabled = $EW;
        return $this;
    }
    public function setRecipient($Aj)
    {
        $this->recipient = $Aj;
        return $this;
    }
    public function setSmsBody($mp)
    {
        $this->smsBody = $mp;
        return $this;
    }
}
