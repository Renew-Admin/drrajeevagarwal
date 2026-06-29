<?php


namespace OTP\Handler\Forms;

use OTP\Handler\PhoneVerificationLogic;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
use BP_Signup;
use WP_User;
class BuddyPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::BUDDYPRESS_REG;
        $this->_typePhoneTag = "\x6d\157\x5f\x62\142\160\x5f\x70\x68\x6f\x6e\x65\x5f\145\156\141\x62\x6c\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\142\142\x70\137\145\155\141\x69\x6c\x5f\x65\156\141\142\x6c\x65";
        $this->_typeBothTag = "\155\x6f\x5f\142\x62\160\x5f\142\157\x74\150\x5f\x65\x6e\x61\x62\x6c\145\x64";
        $this->_formKey = "\x42\120\137\104\x45\106\101\125\114\x54\x5f\x46\x4f\x52\115";
        $this->_formName = mo_("\x42\165\144\144\x79\120\x72\145\x73\163\40\x2f\40\102\165\x64\144\171\102\157\x73\163\40\x52\x65\x67\151\x73\164\162\x61\x74\151\x6f\x6e\40\106\x6f\162\x6d");
        $this->_isFormEnabled = get_mo_option("\x62\x62\160\137\144\x65\146\x61\x75\x6c\x74\x5f\x65\156\141\142\154\145");
        $this->_formDocuments = MoOTPDocs::BBP_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_phoneKey = get_mo_option("\x62\142\160\137\160\150\157\156\145\137\x6b\145\x79");
        $this->_otpType = get_mo_option("\x62\142\160\x5f\145\156\x61\142\154\x65\137\164\x79\x70\145");
        $this->_disableAutoActivate = get_mo_option("\x62\x62\x70\x5f\144\x69\163\x61\142\154\145\137\141\143\164\x69\x76\x61\164\x69\157\x6e");
        $this->_phoneFormId = "\151\156\160\x75\164\x5b\156\141\x6d\145\75\x66\x69\x65\154\x64\x5f" . $this->moBBPgetphoneFieldId() . "\x5d";
        $this->_restrictDuplicates = get_mo_option("\142\142\x70\137\162\145\163\x74\x72\151\143\164\x5f\144\165\160\154\151\143\x61\164\x65\163");
        add_filter("\x62\160\x5f\162\x65\147\151\x73\x74\162\x61\x74\x69\157\156\x5f\156\145\x65\144\x73\137\x61\x63\164\151\x76\141\164\151\x6f\156", array($this, "\x66\151\x78\137\x73\x69\147\156\x75\160\x5f\146\157\x72\155\137\166\141\154\151\x64\141\x74\x69\157\x6e\x5f\164\x65\x78\164"));
        add_filter("\142\x70\x5f\x63\157\162\145\137\163\x69\147\x6e\x75\160\x5f\x73\x65\x6e\x64\137\x61\143\x74\x69\166\141\x74\x69\x6f\x6e\137\153\145\171", array($this, "\144\x69\x73\141\x62\x6c\145\x5f\141\x63\x74\151\166\x61\x74\151\157\156\137\145\x6d\141\x69\154"));
        add_filter("\x62\x70\x5f\163\151\147\156\165\160\x5f\165\x73\145\162\x6d\145\164\x61", array($this, "\x6d\151\156\151\157\x72\x61\x6e\x67\x65\x5f\x62\160\137\x75\163\145\162\137\162\145\x67\151\163\x74\x72\141\x74\151\157\156"), 1, 1);
        add_action("\142\x70\137\x73\151\147\156\x75\x70\x5f\x76\141\x6c\x69\144\141\x74\145", array($this, "\166\141\154\x69\144\x61\164\x65\117\124\x50\122\145\x71\x75\145\x73\164"), 99, 0);
        if (!$this->_disableAutoActivate) {
            goto aE;
        }
        add_action("\x62\160\137\143\x6f\x72\x65\137\x73\x69\x67\156\x75\160\x5f\165\163\x65\x72", array($this, "\x6d\x6f\137\141\143\164\151\166\141\x74\145\137\142\x62\160\137\x75\163\x65\x72"), 1, 5);
        aE:
    }
    function fix_signup_form_validation_text()
    {
        return $this->_disableAutoActivate ? FALSE : TRUE;
    }
    function disable_activation_email()
    {
        return $this->_disableAutoActivate ? FALSE : TRUE;
    }
    function isPhoneVerificationEnabled()
    {
        $tA = $this->getVerificationType();
        return $tA === VerificationType::PHONE || $tA === VerificationType::BOTH;
    }
    function validateOTPRequest()
    {
        global $bp, $phoneLogic;
        $ix = "\146\151\145\x6c\x64\137" . $this->moBBPgetphoneFieldId();
        if (isset($_POST[$ix]) && !MoUtility::validatePhoneNumber($_POST[$ix])) {
            goto PS;
        }
        if (!$this->isPhoneNumberAlreadyInUse(sanitize_text_field($_POST[$ix]))) {
            goto lB;
        }
        $bp->signup->errors[$ix] = mo_("\x50\x68\x6f\156\x65\40\156\165\x6d\x62\x65\162\40\x61\x6c\162\x65\x61\x64\171\x20\x69\x6e\x20\x75\x73\x65\56\40\120\154\x65\141\x73\145\x20\x45\156\164\x65\x72\x20\x61\40\x64\151\x66\146\x65\162\145\156\164\40\x50\150\157\x6e\x65\x20\x6e\x75\155\x62\145\162\56");
        lB:
        goto Pi;
        PS:
        $bp->signup->errors[$ix] = str_replace("\43\x23\160\x68\157\156\145\43\43", sanitize_text_field($_POST[$ix]), $phoneLogic->_get_otp_invalid_format_message());
        Pi:
    }
    function isPhoneNumberAlreadyInUse($Dk)
    {
        if (!$this->_restrictDuplicates) {
            goto L0;
        }
        global $wpdb;
        $Dk = MoUtility::processPhoneNumber($Dk);
        $ix = $this->moBBPgetphoneFieldId();
        $le = $wpdb->get_row("\123\105\114\105\103\x54\x20\x60\x75\x73\145\162\137\151\144\x60\40\106\x52\117\x4d\40\x60{$wpdb->prefix}\142\160\137\170\160\x72\157\x66\151\154\145\137\x64\141\x74\141\x60\40\x57\x48\x45\x52\x45\40\x60\x66\151\145\x6c\144\x5f\151\144\140\x20\75\40\x27{$ix}\x27\40\x41\116\x44\x20\140\166\141\154\x75\x65\x60\40\x3d\40\x20\47{$Dk}\x27");
        return !MoUtility::isBlank($le);
        L0:
        return false;
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto sl;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        sl:
        return FALSE;
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        $Bs = $this->getVerificationType();
        $MZ = VerificationType::BOTH === $Bs ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    function miniorange_bp_user_registration($wz)
    {
        if (!$this->checkIfVerificationIsComplete()) {
            goto Fm;
        }
        return $wz;
        Fm:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        $NN = NULL;
        foreach ($_POST as $j1 => $qL) {
            if ($j1 === "\163\151\147\x6e\x75\x70\137\165\x73\145\x72\156\x61\155\x65") {
                goto rX;
            }
            if ($j1 === "\x73\151\x67\156\x75\x70\x5f\145\x6d\141\x69\x6c") {
                goto r4;
            }
            if ($j1 === "\163\151\x67\x6e\x75\160\x5f\160\141\163\163\167\x6f\162\144") {
                goto cy;
            }
            $ck[$j1] = $qL;
            goto xy;
            rX:
            $zC = $qL;
            goto xy;
            r4:
            $mo = $qL;
            goto xy;
            cy:
            $iK = $qL;
            xy:
            p0:
        }
        J5:
        $xO = $this->moBBPgetphoneFieldId();
        if (!isset($_POST["\146\151\x65\154\144\137" . $xO])) {
            goto lg;
        }
        $NN = sanitize_text_field($_POST["\x66\151\145\x6c\x64\x5f" . $xO]);
        lg:
        $ck["\x75\x73\x65\x72\x6d\x65\x74\x61"] = $wz;
        $this->startVerificationProcess($zC, $mo, $errors, $NN, $iK, $ck);
        return $wz;
    }
    function startVerificationProcess($zC, $mo, $errors, $NN, $iK, $ck)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto CD;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto R_;
        }
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::EMAIL, $iK, $ck);
        goto rZ;
        R_:
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::BOTH, $iK, $ck);
        rZ:
        goto Fi;
        CD:
        $this->sendChallenge($zC, $mo, $errors, $NN, VerificationType::PHONE, $iK, $ck);
        Fi:
    }
    function mo_activate_bbp_user($B5, $iI)
    {
        $SR = $this->moBBPgetActivationKey($iI);
        bp_core_activate_signup($SR);
        BP_Signup::validate($SR);
        $QC = new WP_User($B5);
        $QC->add_role("\163\165\142\163\143\162\x69\142\145\162");
        return;
    }
    function moBBPgetActivationKey($iI)
    {
        global $wpdb;
        return $wpdb->get_var("\x53\x45\114\105\103\124\40\141\x63\164\x69\166\x61\164\151\157\x6e\x5f\x6b\145\171\40\106\122\x4f\x4d\40{$wpdb->prefix}\x73\151\x67\x6e\x75\160\163\x20\x57\110\105\x52\105\40\141\x63\x74\151\166\145\40\75\x20\47\60\47\40\x41\x4e\104\40\x75\163\x65\162\137\x6c\x6f\x67\151\x6e\40\75\x20\x27" . $iI . "\47");
    }
    function moBBPgetphoneFieldId()
    {
        global $wpdb;
        return $wpdb->get_var("\x53\x45\114\x45\x43\x54\40\x69\144\x20\x46\x52\x4f\x4d\40{$wpdb->prefix}\x62\160\137\170\160\162\x6f\146\151\154\145\137\x66\x69\145\154\x64\163\x20\167\x68\x65\162\x65\40\156\x61\x6d\x65\x20\x3d\47" . $this->_phoneKey . "\47");
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_formSessionVar, $this->_txSessionId]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto Wi;
        }
        array_push($kp, $this->_phoneFormId);
        Wi:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto wy;
        }
        return;
        wy:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\142\142\x70\137\x64\x65\x66\141\165\x6c\x74\x5f\x65\156\x61\x62\154\x65");
        $this->_disableAutoActivate = $this->sanitizeFormPOST("\142\x62\x70\x5f\x64\x69\x73\141\142\154\x65\137\x61\143\x74\x69\x76\x61\164\151\157\156");
        $this->_otpType = $this->sanitizeFormPOST("\x62\142\160\137\145\x6e\x61\142\154\145\x5f\x74\171\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\142\x62\x70\x5f\x70\150\157\156\145\137\x6b\x65\171");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x62\x62\160\x5f\162\145\x73\164\x72\x69\143\x74\x5f\144\x75\x70\x6c\151\x63\141\x74\145\x73");
        if (!$this->basicValidationCheck(BaseMessages::BP_CHOOSE)) {
            goto W9;
        }
        update_mo_option("\142\x62\x70\x5f\144\145\146\141\x75\154\x74\137\145\156\141\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\142\x62\x70\x5f\144\x69\163\141\142\154\145\x5f\x61\x63\x74\x69\x76\141\164\151\x6f\156", $this->_disableAutoActivate);
        update_mo_option("\x62\142\160\x5f\145\156\141\142\154\145\137\164\171\x70\145", $this->_otpType);
        update_mo_option("\x62\x62\160\x5f\162\145\x73\x74\162\x69\x63\164\137\144\x75\x70\x6c\x69\143\141\164\145\163", $this->_restrictDuplicates);
        update_mo_option("\x62\x62\x70\137\160\150\157\x6e\x65\137\153\x65\171", $this->_phoneKey);
        W9:
    }
}
