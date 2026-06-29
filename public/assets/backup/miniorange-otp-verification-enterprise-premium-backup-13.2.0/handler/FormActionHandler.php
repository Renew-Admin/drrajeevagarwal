<?php


namespace OTP\Handler;

if (defined("\x41\x42\x53\x50\x41\x54\x48")) {
    goto cU;
}
exit;
cU:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoMessages;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseActionHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
class FormActionHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\x6d\x6f\x5f\146\x6f\162\155\137\x61\x63\164\x69\157\156\x73";
        add_action("\151\156\x69\x74", array($this, "\150\141\x6e\x64\x6c\x65\106\157\162\x6d\101\143\x74\151\157\x6e\163"), 1);
        add_action("\155\x6f\x5f\166\x61\154\151\x64\141\x74\x65\137\157\164\160", array($this, "\x76\x61\x6c\x69\x64\x61\164\x65\117\x54\120"), 1, 3);
        add_action("\155\157\137\147\x65\x6e\x65\162\141\x74\x65\137\x6f\x74\160", array($this, "\x63\x68\x61\x6c\154\x65\x6e\x67\x65"), 2, 8);
        add_filter("\x6d\x6f\x5f\x66\151\x6c\x74\x65\162\137\160\150\157\x6e\x65\137\x62\x65\x66\157\x72\145\x5f\141\x70\151\137\143\141\x6c\154", array($this, "\x66\151\154\x74\x65\162\x50\x68\x6f\x6e\145"), 1, 1);
    }
    public function challenge($iI, $p1, $errors, $NN = null, $CD = "\x65\x6d\x61\x69\154", $iK = '', $ck = null, $kt = false)
    {
        $NN = MoUtility::processPhoneNumber($NN);
        MoPHPSessions::addSessionVar("\x63\x75\162\162\x65\x6e\164\x5f\x75\x72\x6c", MoUtility::currentPageUrl());
        MoPHPSessions::addSessionVar("\165\x73\x65\x72\x5f\x65\155\x61\151\x6c", $p1);
        MoPHPSessions::addSessionVar("\165\x73\x65\162\x5f\x6c\157\147\x69\x6e", $iI);
        MoPHPSessions::addSessionVar("\x75\163\x65\x72\137\x70\141\x73\163\167\x6f\162\144", $iK);
        MoPHPSessions::addSessionVar("\160\150\157\156\x65\x5f\156\165\155\142\145\x72\x5f\x6d\x6f", $NN);
        MoPHPSessions::addSessionVar("\145\170\x74\162\x61\137\144\141\164\x61", $ck);
        $this->handleOTPAction($iI, $p1, $NN, $CD, $kt, $ck);
    }
    private function handleResendOTP($CD, $kt)
    {
        $p1 = MoPHPSessions::getSessionVar("\165\163\145\162\x5f\x65\155\x61\151\x6c");
        $iI = MoPHPSessions::getSessionVar("\x75\x73\145\x72\x5f\x6c\157\147\151\156");
        $NN = MoPHPSessions::getSessionVar("\x70\150\157\156\x65\x5f\156\165\155\x62\145\x72\137\x6d\157");
        $ck = MoPHPSessions::getSessionVar("\145\x78\164\162\141\x5f\144\141\164\x61");
        $this->handleOTPAction($iI, $p1, $NN, $CD, $kt, $ck);
    }
    function handleOTPAction($iI, $p1, $NN, $CD, $kt, $ck)
    {
        global $phoneLogic, $emailLogic;
        switch ($CD) {
            case VerificationType::PHONE:
                $phoneLogic->_handle_logic($iI, $p1, $NN, $CD, $kt);
                goto gz;
            case VerificationType::EMAIL:
                $emailLogic->_handle_logic($iI, $p1, $NN, $CD, $kt);
                goto gz;
            case VerificationType::BOTH:
                miniorange_verification_user_choice($iI, $p1, $NN, MoMessages::showMessage(MoMessages::CHOOSE_METHOD), $CD);
                goto gz;
            case VerificationType::EXTERNAL:
                mo_external_phone_validation_form($ck["\x63\x75\x72\x6c"], $p1, $ck["\x6d\x65\163\x73\x61\x67\x65"], $ck["\x66\x6f\162\x6d"], $ck["\144\x61\164\x61"]);
                goto gz;
        }
        XX:
        gz:
    }
    function handleGoBackAction()
    {
        $P9 = MoPHPSessions::getSessionVar("\143\165\x72\x72\145\x6e\164\137\x75\x72\x6c");
        do_action("\165\156\x73\145\x74\x5f\163\145\x73\x73\151\157\156\x5f\166\141\x72\151\141\142\154\x65");
        header("\154\157\143\x61\x74\x69\157\x6e\72" . $P9);
    }
    function validateOTP($tA, $bv, $iF)
    {
        $iI = MoPHPSessions::getSessionVar("\x75\x73\145\162\x5f\154\157\x67\151\156");
        $p1 = MoPHPSessions::getSessionVar("\165\163\145\162\137\x65\x6d\141\151\x6c");
        $NN = MoPHPSessions::getSessionVar("\x70\x68\157\156\x65\137\x6e\165\155\142\145\162\x5f\155\x6f");
        $iK = MoPHPSessions::getSessionVar("\165\163\x65\162\137\160\x61\163\x73\x77\157\162\x64");
        $ck = MoPHPSessions::getSessionVar("\145\170\164\162\x61\x5f\x64\141\x74\x61");
        $o3 = Sessionutils::getTransactionId($tA);
        $ry = MoUtility::sanitizeCheck($bv, $_REQUEST);
        $ry = !$ry ? $iF : $ry;
        if (is_null($o3)) {
            goto OO;
        }
        $ig = GatewayFunctions::instance();
        $zw = $ig->mo_validate_otp_token($o3, $ry);
        switch ($zw["\x73\164\x61\164\x75\163"]) {
            case "\x53\125\103\x43\x45\x53\123":
                $this->onValidationSuccess($iI, $p1, $iK, $NN, $ck, $tA);
                goto Y6;
            default:
                $this->onValidationFailed($iI, $p1, $NN, $tA);
                goto Y6;
        }
        wj:
        Y6:
        OO:
    }
    private function onValidationSuccess($iI, $p1, $iK, $NN, $ck, $tA)
    {
        $My = array_key_exists("\x72\x65\144\x69\x72\145\143\164\137\x74\x6f", $_POST) ? sanitize_text_field($_POST["\x72\145\144\151\162\x65\143\164\137\164\x6f"]) : '';
        do_action("\x6f\164\160\137\x76\145\162\x69\146\151\143\x61\x74\x69\x6f\156\137\x73\x75\143\x63\145\x73\163\146\x75\x6c", $My, $iI, $p1, $iK, $NN, $ck, $tA);
    }
    private function onValidationFailed($iI, $p1, $NN, $tA)
    {
        do_action("\157\164\160\x5f\x76\145\x72\x69\146\151\143\x61\x74\x69\x6f\156\137\x66\141\x69\154\x65\x64", $iI, $p1, $NN, $tA);
    }
    private function handleOTPChoice($r9)
    {
        $ef = MoPHPSessions::getSessionVar("\x75\x73\x65\162\x5f\154\157\147\x69\156");
        $BO = MoPHPSessions::getSessionVar("\165\163\145\x72\x5f\145\x6d\141\151\154");
        $Mg = MoPHPSessions::getSessionVar("\x70\x68\x6f\x6e\x65\x5f\156\165\155\142\145\162\137\x6d\157");
        $Mh = MoPHPSessions::getSessionVar("\165\163\145\x72\x5f\160\x61\x73\x73\167\157\162\144");
        $Oh = MoPHPSessions::getSessionVar("\145\x78\x74\x72\141\137\144\141\x74\141");
        $Bs = strcasecmp($r9["\x6d\157\137\143\165\163\x74\157\155\145\x72\x5f\166\x61\x6c\151\144\141\164\151\x6f\x6e\x5f\x6f\164\160\x5f\x63\x68\x6f\151\143\x65"], "\165\x73\x65\x72\x5f\145\x6d\x61\151\154\137\166\145\x72\x69\146\151\143\x61\x74\151\157\156") == 0 ? VerificationType::EMAIL : VerificationType::PHONE;
        $this->challenge($ef, $BO, null, $Mg, $Bs, $Mh, $Oh, true);
    }
    function filterPhone($Dk)
    {
        return str_replace("\53", '', $Dk);
    }
    function handleFormActions()
    {
        if (!(array_key_exists("\x6f\x70\x74\151\157\x6e", $_REQUEST) && MoUtility::micr())) {
            goto uL;
        }
        $kt = MoUtility::sanitizeCheck("\146\x72\157\155\137\142\x6f\x74\x68", $_POST);
        $tA = MoUtility::sanitizeCheck("\x6f\x74\160\x5f\164\x79\x70\145", $_POST);
        switch (trim($_REQUEST["\157\160\164\151\x6f\x6e"])) {
            case "\x76\x61\x6c\151\x64\141\x74\151\157\x6e\x5f\147\x6f\x42\141\143\153":
                $this->handleGoBackAction();
                goto Re;
            case "\155\x69\x6e\151\157\x72\141\x6e\x67\145\x2d\x76\x61\x6c\151\144\141\x74\x65\55\157\x74\x70\x2d\146\157\162\x6d":
                $this->validateOTP($tA, "\x6d\157\137\x6f\164\x70\x5f\x74\157\x6b\x65\156", null);
                goto Re;
            case "\166\x65\x72\x69\x66\x69\x63\x61\164\x69\x6f\156\x5f\x72\145\163\145\x6e\x64\x5f\157\164\x70":
                $this->handleResendOTP($tA, $kt);
                goto Re;
            case "\155\x69\156\151\x6f\x72\141\x6e\x67\145\55\x76\x61\x6c\151\x64\141\x74\x65\x2d\157\164\x70\55\x63\x68\157\x69\x63\x65\x2d\x66\x6f\x72\155":
                $this->handleOTPChoice($_POST);
                goto Re;
        }
        UK:
        Re:
        uL:
    }
}
