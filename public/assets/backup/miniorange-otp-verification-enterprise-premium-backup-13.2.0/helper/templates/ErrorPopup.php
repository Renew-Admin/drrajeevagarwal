<?php


namespace OTP\Helper\Templates;

if (defined("\101\102\x53\120\101\124\110")) {
    goto IKO;
}
exit;
IKO:
use OTP\Objects\MoITemplate;
use OTP\Objects\Template;
use OTP\Traits\Instance;
class ErrorPopup extends Template implements MoITemplate
{
    use Instance;
    protected function __construct()
    {
        $this->key = "\105\122\122\x4f\122";
        $this->templateEditorID = "\x63\165\x73\x74\x6f\x6d\105\x6d\141\x69\x6c\x4d\163\x67\x45\144\151\x74\x6f\162\64";
        $this->requiredTags = array_diff($this->requiredTags, array("\173\x7b\106\117\122\115\x5f\x49\104\x7d\x7d", "\173\173\x52\105\x51\125\111\x52\x45\104\137\106\111\105\114\104\123\175\175"));
        parent::__construct();
    }
    public function getDefaults($oQ)
    {
        if (is_array($oQ)) {
            goto Ye5;
        }
        $oQ = array();
        Ye5:
        $oQ[$this->getTemplateKey()] = file_get_contents(MOV_DIR . "\x69\156\x63\154\165\144\x65\x73\57\x68\164\x6d\154\57\145\162\x72\x6f\x72\x2e\x6d\x69\156\56\150\164\x6d\x6c");
        return $oQ;
    }
    public function parse($Yc, $bC, $CD, $kt)
    {
        $kt = $kt ? "\x74\x72\165\x65" : "\146\141\154\163\x65";
        $po = $this->getRequiredFormsSkeleton($CD, $kt);
        $Yc = str_replace("\x7b\x7b\x4a\121\125\x45\122\x59\x7d\175", $this->jqueryUrl, $Yc);
        $Yc = str_replace("\x7b\x7b\x47\117\x5f\x42\101\x43\x4b\x5f\101\x43\x54\111\117\116\137\x43\101\114\114\x7d\x7d", "\155\x6f\137\166\x61\x6c\151\144\x61\x74\x69\157\156\137\x67\157\142\141\x63\x6b\50\x29\73", $Yc);
        $Yc = str_replace("\x7b\x7b\115\x4f\137\103\x53\123\x5f\x55\x52\x4c\x7d\x7d", MOV_CSS_URL, $Yc);
        $Yc = str_replace("\x7b\x7b\x52\105\x51\125\111\x52\105\x44\x5f\106\117\122\115\x53\x5f\x53\103\122\111\x50\124\x53\175\x7d", $po, $Yc);
        $Yc = str_replace("\173\173\110\x45\x41\x44\x45\x52\175\175", mo_("\x56\141\154\151\144\x61\x74\145\x20\x4f\x54\120\x20\50\117\156\145\40\x54\151\x6d\x65\x20\120\141\163\x73\143\x6f\x64\x65\x29"), $Yc);
        $Yc = str_replace("\x7b\x7b\107\x4f\x5f\102\x41\103\x4b\x7d\175", mo_("\46\x6c\141\162\162\x3b\x20\107\157\x20\102\141\143\153"), $Yc);
        $Yc = str_replace("\173\173\115\x45\x53\x53\x41\x47\105\175\x7d", mo_($bC), $Yc);
        return $Yc;
    }
    private function getRequiredFormsSkeleton($CD, $kt)
    {
        $cw = "\74\x66\x6f\x72\x6d\x20\x6e\x61\155\x65\75\42\x66\x22\x20\x6d\145\164\x68\x6f\144\75\42\160\x6f\x73\x74\x22\x20\x61\143\x74\151\157\156\75\x22\42\40\x69\x64\x3d\x22\x76\141\x6c\x69\x64\x61\164\x69\157\x6e\x5f\147\157\102\x61\143\153\137\146\157\x72\x6d\x22\76\xd\12\11\11\x9\74\x69\x6e\160\x75\164\40\x69\x64\x3d\42\x76\x61\x6c\151\x64\x61\x74\x69\157\x6e\x5f\147\157\x42\x61\143\153\42\x20\x6e\141\155\x65\x3d\x22\x6f\160\x74\x69\157\x6e\x22\40\166\x61\x6c\165\145\x3d\42\166\x61\x6c\151\x64\x61\164\x69\x6f\x6e\x5f\x67\x6f\x42\141\x63\x6b\x22\40\x74\171\x70\145\75\x22\150\151\144\144\145\x6e\x22\57\76\15\xa\11\x9\x3c\57\146\x6f\x72\x6d\x3e\173\173\x53\103\122\x49\120\124\x53\175\175";
        $cw = str_replace("\173\x7b\123\103\122\x49\120\x54\x53\x7d\x7d", $this->getRequiredScripts(), $cw);
        return $cw;
    }
    private function getRequiredScripts()
    {
        $dO = "\74\163\x74\x79\x6c\x65\76\56\x6d\157\x5f\x63\165\163\164\157\x6d\145\x72\x5f\x76\x61\154\x69\x64\x61\164\x69\x6f\x6e\55\x6d\x6f\144\x61\154\x7b\144\x69\x73\x70\x6c\141\x79\x3a\142\x6c\x6f\143\x6b\x21\151\155\160\x6f\162\x74\141\156\x74\x7d\x3c\57\163\x74\x79\x6c\145\x3e";
        $dO .= "\74\163\x63\x72\151\x70\164\x3e\146\165\156\143\x74\x69\x6f\x6e\40\x6d\157\137\x76\141\154\151\x64\x61\164\x69\157\156\x5f\x67\157\x62\141\143\x6b\x28\x29\173\x64\x6f\143\165\155\x65\x6e\164\56\x67\145\164\x45\154\145\x6d\x65\x6e\x74\x42\x79\111\x64\50\x22\166\x61\154\151\x64\x61\164\151\x6f\x6e\x5f\x67\x6f\102\x61\x63\x6b\137\146\157\x72\155\42\x29\x2e\x73\165\x62\155\x69\x74\x28\51\175\74\57\163\x63\162\x69\x70\x74\76";
        return $dO;
    }
}
