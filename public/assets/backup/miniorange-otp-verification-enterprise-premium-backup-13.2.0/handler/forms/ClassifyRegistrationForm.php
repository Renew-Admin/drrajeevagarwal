<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Traits\Instance;
use ReflectionException;
class ClassifyRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::CLASSIFY_REGISTER;
        $this->_typePhoneTag = "\143\154\x61\x73\x73\x69\x66\x79\x5f\x70\150\157\156\x65\x5f\x65\x6e\x61\142\154\x65";
        $this->_typeEmailTag = "\143\x6c\x61\x73\x73\x69\146\171\x5f\145\155\141\151\x6c\137\145\156\x61\x62\x6c\145";
        $this->_formKey = "\103\114\x41\x53\123\x49\x46\131\x5f\x52\105\107\x49\x53\124\x45\122";
        $this->_formName = mo_("\x43\154\141\163\x73\x69\x66\171\40\124\150\145\155\145\40\122\x65\147\x69\163\x74\x72\x61\x74\x69\157\x6e\x20\x46\x6f\162\x6d");
        $this->_isFormEnabled = get_mo_option("\143\x6c\141\163\163\151\x66\x79\137\x65\156\x61\x62\x6c\145");
        $this->_phoneFormId = "\x69\x6e\160\x75\164\x5b\156\x61\x6d\145\x3d\160\150\157\x6e\145\135";
        $this->_formDocuments = MoOTPDocs::CLASSIFY_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x63\x6c\141\x73\x73\x69\146\171\x5f\164\171\x70\145");
        add_action("\167\x70\x5f\x65\x6e\161\x75\145\165\x65\x5f\x73\x63\x72\151\x70\x74\x73", array($this, "\x5f\x73\150\x6f\x77\x5f\160\150\x6f\x6e\x65\x5f\146\151\x65\x6c\x64\137\157\x6e\137\x70\141\x67\145"));
        add_action("\x75\163\145\162\x5f\162\145\147\151\x73\x74\x65\x72", array($this, "\163\x61\166\x65\137\160\x68\157\x6e\x65\x5f\156\165\x6d\142\x65\162"), 10, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto SR;
        }
        if (!(MoUtility::sanitizeCheck("\x6f\x70\164\x69\x6f\156", $_POST) === "\x76\x65\162\151\146\171\137\165\x73\145\x72\x5f\143\154\141\163\163\151\x66\171")) {
            goto Xh;
        }
        $this->_handle_classify_theme_form_post($_POST);
        Xh:
        goto nN;
        SR:
        $this->unsetOTPSessionVariables();
        nN:
    }
    function _show_phone_field_on_page()
    {
        wp_enqueue_script("\x63\154\x61\x73\163\151\146\171\x73\x63\162\x69\x70\164", MOV_URL . "\151\156\143\154\165\x64\145\163\57\152\x73\x2f\143\x6c\141\x73\x73\151\146\171\56\155\151\x6e\56\x6a\163\77\166\145\162\x73\x69\157\156\75" . MOV_VERSION, array("\152\x71\x75\x65\x72\171"));
    }
    function _handle_classify_theme_form_post($FA)
    {
        $zC = sanitize_text_field($FA["\165\x73\x65\162\x6e\x61\x6d\145"]);
        $HV = sanitize_email($FA["\x65\x6d\x61\151\154"]);
        $Dk = sanitize_text_field($FA["\x70\x68\x6f\x6e\x65"]);
        if (!(username_exists($zC) != FALSE)) {
            goto Kb;
        }
        return;
        Kb:
        if (!(email_exists($HV) != FALSE)) {
            goto eO;
        }
        return;
        eO:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto aV;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0) {
            goto Mn;
        }
        $this->sendChallenge(sanitize_text_field($_POST["\165\x73\145\162\156\141\x6d\145"]), $HV, null, $Dk, "\142\157\164\x68", null, null);
        goto Ta;
        Mn:
        $this->sendChallenge(sanitize_text_field($_POST["\x75\x73\x65\x72\156\141\x6d\145"]), $HV, null, null, "\145\155\141\151\154", null, null);
        Ta:
        goto hM;
        aV:
        $this->sendChallenge(sanitize_text_field($_POST["\165\x73\145\x72\156\x61\155\145"]), $HV, null, $Dk, "\x70\150\x6f\156\x65", null, null);
        hM:
    }
    function save_phone_number($nL)
    {
        $dI = MoPHPSessions::getSessionVar("\x70\x68\157\156\145\x5f\156\165\x6d\142\x65\162\x5f\x6d\x6f");
        if (!$dI) {
            goto y4;
        }
        update_user_meta($nL, "\x70\150\x6f\156\145", $dI);
        y4:
    }
    function handle_failed_verification($iI, $p1, $NN, $tA)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto MQ;
        }
        return;
        MQ:
        $Bs = strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\160\150\x6f\x6e\x65" : (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 ? "\x65\155\x61\x69\154" : "\x62\157\164\150");
        $MZ = strcasecmp($Bs, "\142\x6f\164\150") === 0 ? TRUE : FALSE;
        miniorange_site_otp_validation_form($iI, $p1, $NN, MoUtility::_get_invalid_otp_method(), $Bs, $MZ);
    }
    function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $tA);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_formSessionVar, $this->_txSessionId]);
    }
    public function getPhoneNumberSelector($kp)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto Jh;
        }
        array_push($kp, $this->_phoneFormId);
        Jh:
        return $kp;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto jO;
        }
        return;
        jO:
        $this->_otpType = $this->sanitizeFormPOST("\x63\x6c\141\x73\x73\x69\146\x79\137\x74\x79\x70\x65");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x63\154\x61\x73\x73\x69\x66\171\x5f\145\156\x61\142\154\x65");
        update_mo_option("\143\154\141\x73\163\151\146\x79\x5f\x65\156\x61\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\143\x6c\x61\163\x73\x69\x66\x79\x5f\164\171\160\145", $this->_otpType);
    }
}
