<?php


namespace OTP\Objects;

if (defined("\101\102\123\x50\101\x54\110")) {
    goto bbS;
}
exit;
bbS:
class NotificationSettings
{
    public $sendSMS;
    public $sendEmail;
    public $phoneNumber;
    public $fromEmail;
    public $fromName;
    public $toEmail;
    public $toName;
    public $subject;
    public $bccEmail;
    public $message;
    public function __construct()
    {
        if (func_num_args() < 4) {
            goto hfR;
        }
        $this->createEmailNotificationSettings(func_get_arg(0), func_get_arg(1), func_get_arg(2), func_get_arg(3), func_get_arg(4));
        goto NVL;
        hfR:
        $this->createSMSNotificationSettings(func_get_arg(0), func_get_arg(1));
        NVL:
    }
    public function createSMSNotificationSettings($dI, $bC)
    {
        $this->sendSMS = TRUE;
        $this->phoneNumber = $dI;
        $this->message = $bC;
    }
    public function createEmailNotificationSettings($G_, $U7, $jz, $kV, $bC)
    {
        $this->sendEmail = TRUE;
        $this->fromEmail = $G_;
        $this->fromName = $U7;
        $this->toEmail = $jz;
        $this->toName = $jz;
        $this->subject = $kV;
        $this->bccEmail = '';
        $this->message = $bC;
    }
}
