<?php


namespace OTP\Helper;

if (defined("\101\x42\123\120\101\124\110")) {
    goto lCt;
}
exit;
lCt:
use OTP\Objects\FormSessionData;
use OTP\Objects\TransactionSessionData;
use OTP\Objects\VerificationType;
final class SessionUtils
{
    static function isOTPInitialized($j1)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto wVn;
        }
        return $zA->getIsInitialized();
        wVn:
        return FALSE;
    }
    static function addEmailOrPhoneVerified($j1, $H5, $tA)
    {
        switch ($tA) {
            case VerificationType::PHONE:
                self::addPhoneVerified($j1, $H5);
                goto WSD;
            case VerificationType::EMAIL:
                self::addEmailVerified($j1, $H5);
                goto WSD;
        }
        a8n:
        WSD:
    }
    static function addEmailSubmitted($j1, $H5)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto ApA;
        }
        $zA->setEmailSubmitted($H5);
        MoPHPSessions::addSessionVar($j1, $zA);
        ApA:
    }
    static function addPhoneSubmitted($j1, $H5)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto LMv;
        }
        $zA->setPhoneSubmitted($H5);
        MoPHPSessions::addSessionVar($j1, $zA);
        LMv:
    }
    static function addEmailVerified($j1, $H5)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto SEv;
        }
        $zA->setEmailVerified($H5);
        MoPHPSessions::addSessionVar($j1, $zA);
        SEv:
    }
    static function addPhoneVerified($j1, $H5)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto xF2;
        }
        $zA->setPhoneVerified($H5);
        MoPHPSessions::addSessionVar($j1, $zA);
        xF2:
    }
    static function addStatus($j1, $H5, $uO)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto ClR;
        }
        if ($zA->getIsInitialized()) {
            goto CFa;
        }
        return;
        CFa:
        if (!($uO === VerificationType::EMAIL)) {
            goto QId;
        }
        $zA->setEmailVerificationStatus($H5);
        QId:
        if (!($uO === VerificationType::PHONE)) {
            goto cv1;
        }
        $zA->setPhoneVerificationStatus($H5);
        cv1:
        MoPHPSessions::addSessionVar($j1, $zA);
        ClR:
    }
    static function isStatusMatch($j1, $z9, $uO)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto gyY;
        }
        switch ($uO) {
            case VerificationType::EMAIL:
                return $z9 === $zA->getEmailVerificationStatus();
            case VerificationType::PHONE:
                return $z9 === $zA->getPhoneVerificationStatus();
            case VerificationType::BOTH:
                return $z9 === $zA->getEmailVerificationStatus() || $z9 === $zA->getPhoneVerificationStatus();
        }
        UEx:
        znT:
        gyY:
        return FALSE;
    }
    static function isEmailVerifiedMatch($j1, $Dy)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto yCQ;
        }
        return $Dy === $zA->getEmailVerified();
        yCQ:
        return FALSE;
    }
    static function isPhoneVerifiedMatch($j1, $Dy)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto kDG;
        }
        return $Dy === $zA->getPhoneVerified();
        kDG:
        return FALSE;
    }
    static function setEmailTransactionID($Ng)
    {
        $qv = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if ($qv instanceof TransactionSessionData) {
            goto rg2;
        }
        $qv = new TransactionSessionData();
        rg2:
        $qv->setEmailTransactionId($Ng);
        MoPHPSessions::addSessionVar(FormSessionVars::TX_SESSION_ID, $qv);
    }
    static function setPhoneTransactionID($Ng)
    {
        $qv = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if ($qv instanceof TransactionSessionData) {
            goto Dpg;
        }
        $qv = new TransactionSessionData();
        Dpg:
        $qv->setPhoneTransactionId($Ng);
        MoPHPSessions::addSessionVar(FormSessionVars::TX_SESSION_ID, $qv);
    }
    static function getTransactionId($tA)
    {
        $qv = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if (!$qv instanceof TransactionSessionData) {
            goto mUN;
        }
        switch ($tA) {
            case VerificationType::EMAIL:
                return $qv->getEmailTransactionId();
            case VerificationType::PHONE:
                return $qv->getPhoneTransactionId();
            case VerificationType::BOTH:
                return MoUtility::isBlank($qv->getPhoneTransactionId()) ? $qv->getEmailTransactionId() : $qv->getPhoneTransactionId();
        }
        gcS:
        Jcy:
        mUN:
        return '';
    }
    static function unsetSession($iJ)
    {
        foreach ($iJ as $j1) {
            MoPHPSessions::unsetSession($j1);
            BnL:
        }
        Igy:
    }
    static function isPhoneSubmittedAndVerifiedMatch($j1)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto iHc;
        }
        return $zA->getPhoneVerified() === $zA->getPhoneSubmitted();
        iHc:
        return FALSE;
    }
    static function isEmailSubmittedAndVerifiedMatch($j1)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto Z1B;
        }
        return $zA->getEmailVerified() === $zA->getEmailSubmitted();
        Z1B:
        return FALSE;
    }
    static function setFormOrFieldId($j1, $H5)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto Pan;
        }
        $zA->setFieldOrFormId($H5);
        MoPHPSessions::addSessionVar($j1, $zA);
        Pan:
    }
    static function getFormOrFieldId($j1)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto dT3;
        }
        return $zA->getFieldOrFormId();
        dT3:
        return '';
    }
    static function initializeForm($form)
    {
        $zA = new FormSessionData();
        MoPHPSessions::addSessionVar($form, $zA->init());
    }
    static function addUserInSession($j1, $H5)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto y71;
        }
        $zA->setUserSubmitted($H5);
        MoPHPSessions::addSessionVar($j1, $zA);
        y71:
    }
    static function getUserSubmitted($j1)
    {
        $zA = MoPHPSessions::getSessionVar($j1);
        if (!$zA instanceof FormSessionData) {
            goto TCP;
        }
        return $zA->getUserSubmitted();
        TCP:
        return '';
    }
}
