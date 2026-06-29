<?php


namespace OTP\Objects;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
if (defined("\x41\102\123\x50\x41\x54\x48")) {
    goto IDw;
}
exit;
IDw:
abstract class Template extends BaseActionHandler implements MoITemplate
{
    protected $key;
    protected $templateEditorID;
    protected $nonce;
    protected $preview = FALSE;
    protected $jqueryUrl;
    protected $img;
    public $paneContent;
    public $messageDiv;
    protected $successMessageDiv;
    public static $templateEditor = array("\x77\x70\x61\x75\x74\157\160" => false, "\155\x65\144\x69\x61\137\142\x75\164\x74\157\x6e\x73" => false, "\164\x65\170\164\x61\x72\145\141\x5f\162\157\x77\x73" => 20, "\164\x61\x62\151\156\x64\x65\x78" => '', "\x74\x61\142\146\157\143\x75\163\137\x65\x6c\x65\155\x65\156\164\163" => "\x3a\x70\162\145\166\x2c\72\156\x65\170\164", "\x65\x64\x69\164\157\162\x5f\143\163\163" => '', "\145\144\151\x74\x6f\x72\x5f\143\154\x61\163\163" => '', "\164\x65\145\156\x79" => false, "\144\x66\x77" => false, "\164\x69\156\x79\155\143\145" => false, "\x71\165\151\x63\x6b\x74\x61\x67\x73" => true);
    protected $requiredTags = array("\173\x7b\x4a\x51\x55\105\122\x59\175\175", "\x7b\x7b\107\x4f\x5f\x42\x41\x43\113\x5f\101\x43\x54\111\117\x4e\137\103\x41\114\114\175\x7d", "\x7b\173\x46\117\122\x4d\x5f\x49\x44\175\175", "\173\173\x52\105\121\x55\111\x52\x45\x44\x5f\106\111\x45\114\104\123\x7d\x7d", "\173\173\122\105\121\125\x49\x52\105\x44\137\106\x4f\122\115\123\137\123\103\122\111\x50\124\123\175\175");
    protected function __construct()
    {
        parent::__construct();
        $this->jqueryUrl = '';
        $this->img = "\x3c\x64\151\x76\40\x73\x74\171\154\x65\75\x27\144\x69\163\160\154\141\x79\72\x74\141\142\x6c\x65\x3b\x74\x65\170\x74\x2d\141\x6c\151\x67\x6e\x3a\x63\x65\156\164\x65\x72\x3b\47\76" . "\74\151\x6d\x67\x20\163\162\x63\x3d\x27\173\173\114\x4f\x41\x44\x45\x52\137\103\x53\x56\175\175\x27\x3e" . "\x3c\x2f\x64\151\166\x3e";
        $this->paneContent = "\74\144\x69\166\40\163\x74\x79\154\x65\75\x27\x74\x65\170\164\x2d\141\x6c\151\x67\x6e\72\143\x65\156\x74\x65\162\73\x77\151\144\164\x68\x3a\x20\61\x30\x30\45\x3b\150\145\151\x67\150\164\72\40\64\65\x30\160\x78\73\144\x69\163\160\154\x61\171\x3a\x20\x62\x6c\157\143\153\x3b" . "\155\141\162\147\151\x6e\55\164\157\x70\x3a\x20\64\60\x25\x3b\166\145\162\x74\x69\x63\x61\154\x2d\141\x6c\x69\147\x6e\x3a\40\155\x69\x64\x64\x6c\145\x3b\x27\76" . "\x7b\x7b\103\x4f\116\124\x45\116\x54\175\175" . "\x3c\x2f\x64\x69\x76\76";
        $this->messageDiv = "\x3c\144\151\166\x20\163\x74\171\154\x65\x3d\47\146\x6f\156\x74\55\163\164\171\154\x65\x3a\x20\151\164\141\154\151\x63\73\146\x6f\156\164\55\x77\145\151\147\x68\164\x3a\x20\66\x30\x30\x3b\143\x6f\154\x6f\x72\x3a\40\x23\62\x33\62\x38\x32\x64\x3b" . "\146\x6f\x6e\164\x2d\x66\x61\x6d\x69\x6c\x79\72\123\x65\x67\x6f\x65\40\x55\111\54\x48\145\154\x76\145\164\x69\143\x61\40\116\145\x75\145\x2c\163\141\156\163\55\163\145\162\x69\146\73" . "\x63\x6f\154\157\162\x3a\43\x39\64\62\70\x32\70\73\x27\76" . "\173\x7b\115\x45\x53\123\x41\x47\x45\175\x7d" . "\74\x2f\144\x69\x76\x3e";
        $this->successMessageDiv = "\x3c\x64\x69\166\x20\163\164\x79\154\x65\x3d\x27\x66\157\156\x74\55\163\x74\171\x6c\x65\72\40\x69\164\141\x6c\x69\143\73\x66\x6f\x6e\x74\55\167\145\151\147\150\x74\x3a\x20\x36\60\x30\73\x63\x6f\154\157\162\72\40\43\62\x33\62\70\x32\144\73" . "\x66\x6f\156\x74\55\x66\x61\155\151\x6c\171\72\x53\x65\147\x6f\x65\x20\x55\111\54\x48\x65\x6c\x76\x65\x74\151\143\141\40\x4e\145\x75\x65\x2c\163\x61\156\x73\x2d\163\x65\x72\x69\146\73\x63\x6f\154\x6f\162\x3a\43\x31\63\x38\141\63\x64\x3b\x27\x3e" . "\x7b\x7b\x4d\105\x53\123\101\x47\x45\175\175" . "\74\57\x64\151\166\x3e";
        $this->img = str_replace("\x7b\173\114\x4f\101\104\x45\122\137\x43\x53\126\175\x7d", MOV_LOADER_URL, $this->img);
        $this->_nonce = "\x6d\157\x5f\x70\x6f\160\165\160\x5f\x6f\160\164\151\x6f\156\163";
        add_filter("\155\157\137\164\x65\x6d\160\x6c\x61\x74\x65\137\x64\145\146\141\x75\x6c\x74\163", array($this, "\147\145\x74\104\x65\x66\x61\165\154\x74\x73"), 1, 1);
        add_filter("\155\157\137\x74\145\x6d\x70\x6c\x61\x74\x65\137\142\x75\x69\154\x64", array($this, "\142\165\151\154\x64"), 1, 5);
        add_action("\141\x64\x6d\151\156\x5f\x70\157\x73\164\137\x6d\x6f\x5f\160\x72\x65\x76\151\x65\167\137\160\157\160\x75\x70", array($this, "\x73\150\x6f\x77\120\x72\x65\166\x69\x65\x77"));
        add_action("\x61\144\155\151\156\137\160\157\x73\x74\x5f\155\157\137\160\157\x70\165\x70\137\x73\141\166\145", array($this, "\x73\x61\x76\x65\120\157\160\x75\x70"));
    }
    public function showPreview()
    {
        if (!(array_key_exists("\x70\157\x70\165\160\164\171\160\145", $_POST) && $_POST["\160\157\x70\x75\160\x74\x79\160\x65"] != $this->getTemplateKey())) {
            goto ImY;
        }
        return;
        ImY:
        if ($this->isValidRequest()) {
            goto LB5;
        }
        return;
        LB5:
        $bC = "\x3c\x69\x3e" . mo_("\x50\157\160\125\160\40\115\x65\x73\x73\x61\147\x65\40\163\x68\x6f\167\x73\x20\165\x70\x20\150\x65\x72\x65\56") . "\74\57\x69\x3e";
        $CD = VerificationType::TEST;
        $Yc = stripslashes($_POST[$this->getTemplateEditorId()]);
        $this->validateRequiredFields($Yc);
        $kt = false;
        $this->preview = TRUE;
        wp_send_json(MoUtility::createJson($this->parse($Yc, $bC, $CD, $kt), MoConstants::SUCCESS_JSON_TYPE));
    }
    public function savePopup()
    {
        if (!(!$this->isTemplateType() || !$this->isValidRequest())) {
            goto J2l;
        }
        return;
        J2l:
        $Yc = stripslashes($_POST[$this->getTemplateEditorId()]);
        $this->validateRequiredFields($Yc);
        $JS = maybe_unserialize(get_mo_option("\143\x75\x73\x74\157\155\x5f\x70\x6f\160\x75\x70\x73"));
        $JS[$this->getTemplateKey()] = $Yc;
        update_mo_option("\143\165\x73\x74\157\x6d\x5f\x70\157\160\165\x70\x73", $JS);
        wp_send_json(MoUtility::createJson($this->showSuccessMessage(MoMessages::showMessage(MoMessages::TEMPLATE_SAVED)), MoConstants::SUCCESS_JSON_TYPE));
    }
    public function build($Yc, $i5, $bC, $CD, $kt)
    {
        if (!(strcasecmp($i5, $this->getTemplateKey()) != 0)) {
            goto Itt;
        }
        return $Yc;
        Itt:
        $JS = maybe_unserialize(get_mo_option("\x63\165\163\164\x6f\x6d\137\160\157\160\165\160\x73"));
        $Yc = $JS[$this->getTemplateKey()];
        return $this->parse($Yc, $bC, $CD, $kt);
    }
    protected function validateRequiredFields($Yc)
    {
        foreach ($this->requiredTags as $yn) {
            if (!(strpos($Yc, $yn) === FALSE)) {
                goto ZTw;
            }
            $bC = str_replace("\x7b\x7b\115\x45\123\123\x41\x47\105\x7d\x7d", MoMessages::showMessage(MoMessages::REQUIRED_TAGS, array("\124\101\x47" => $yn)), $this->messageDiv);
            wp_send_json(MoUtility::createJson(str_replace("\173\173\103\x4f\116\x54\x45\116\124\x7d\175", $bC, $this->paneContent), MoConstants::ERROR_JSON_TYPE));
            ZTw:
            vBl:
        }
        hsr:
        if (!MoUtility::checkForScriptTags($Yc)) {
            goto Rec;
        }
        $bC = str_replace("\173\x7b\115\105\123\x53\x41\107\x45\175\175", MoMessages::showMessage(MoMessages::INVALID_SCRIPTS), $this->messageDiv);
        wp_send_json(MoUtility::createJson(str_replace("\173\x7b\x43\117\116\124\105\x4e\x54\x7d\175", $bC, $this->paneContent), MoConstants::ERROR_JSON_TYPE));
        Rec:
    }
    protected function showSuccessMessage($bC)
    {
        $bC = str_replace("\x7b\x7b\x4d\105\123\123\x41\107\105\175\x7d", $bC, $this->successMessageDiv);
        return str_replace("\173\173\103\x4f\x4e\x54\105\x4e\124\x7d\x7d", $bC, $this->paneContent);
    }
    protected function showMessage($bC)
    {
        $bC = str_replace("\173\x7b\115\105\x53\123\x41\x47\105\x7d\x7d", $bC, $this->messageDiv);
        return str_replace("\173\x7b\103\x4f\x4e\124\105\x4e\124\x7d\x7d", $bC, $this->paneContent);
    }
    protected function isTemplateType()
    {
        return array_key_exists("\x70\157\x70\165\x70\x74\x79\x70\x65", $_POST) && strcasecmp($_POST["\160\x6f\x70\x75\x70\x74\x79\x70\x65"], $this->getTemplateKey()) == 0;
    }
    public function getTemplateKey()
    {
        return $this->key;
    }
    public function getTemplateEditorId()
    {
        return $this->templateEditorID;
    }
}
