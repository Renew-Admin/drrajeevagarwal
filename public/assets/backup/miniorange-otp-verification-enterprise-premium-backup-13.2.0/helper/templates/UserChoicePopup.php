<?php


namespace OTP\Helper\Templates;

if (defined("\101\102\123\x50\x41\124\110")) {
    goto JX9;
}
exit;
JX9:
use OTP\Objects\MoITemplate;
use OTP\Objects\Template;
use OTP\Traits\Instance;
class UserChoicePopup extends Template implements MoITemplate
{
    use Instance;
    protected function __construct()
    {
        $this->key = "\125\x53\105\x52\103\x48\117\x49\x43\105";
        $this->templateEditorID = "\x63\165\x73\164\157\155\x45\155\141\151\154\x4d\163\147\x45\x64\151\164\x6f\162\62";
        parent::__construct();
    }
    public function getDefaults($oQ)
    {
        if (is_array($oQ)) {
            goto Uti;
        }
        $oQ = array();
        Uti:
        $oQ[$this->getTemplateKey()] = file_get_contents(MOV_DIR . "\x69\x6e\x63\154\165\x64\145\163\57\x68\164\x6d\x6c\57\x75\163\145\162\x63\x68\157\151\143\x65\x2e\x6d\151\x6e\56\x68\x74\155\x6c");
        return $oQ;
    }
    public function parse($Yc, $bC, $CD, $kt)
    {
        $po = $this->getRequiredFormsSkeleton($CD, $kt);
        $gE = $this->preview ? '' : extra_post_data();
        $xV = "\x7b\173\105\130\x54\x52\101\x5f\120\x4f\x53\x54\x5f\104\101\124\x41\175\175\x3c\151\156\160\165\x74\x20\164\x79\160\145\x3d\42\x68\151\x64\x64\x65\x6e\x22\40\156\x61\155\145\x3d\x22\157\160\x74\151\157\x6e\42\40\x76\141\x6c\x75\145\75\42\155\x69\x6e\x69\157\x72\141\156\x67\x65\55\x76\x61\x6c\151\144\141\164\x65\55\157\x74\160\x2d\x63\x68\157\151\x63\x65\55\146\x6f\162\x6d\x22\x20\x2f\76";
        $Yc = str_replace("\173\173\x4a\x51\125\105\122\x59\x7d\175", $this->jqueryUrl, $Yc);
        $Yc = str_replace("\x7b\173\x46\x4f\122\115\x5f\111\104\x7d\175", "\155\157\137\x76\141\154\151\x64\x61\164\145\137\x66\x6f\162\x6d", $Yc);
        $Yc = str_replace("\x7b\x7b\107\x4f\x5f\x42\101\x43\113\137\x41\103\x54\111\x4f\116\x5f\103\101\114\114\x7d\x7d", "\x6d\157\x5f\x76\141\x6c\x69\x64\x61\164\151\157\x6e\x5f\147\x6f\142\141\x63\153\x28\51\73", $Yc);
        $Yc = str_replace("\173\x7b\115\x4f\x5f\103\x53\123\x5f\125\122\114\x7d\175", MOV_CSS_URL, $Yc);
        $Yc = str_replace("\x7b\173\x52\105\121\x55\x49\x52\x45\104\137\x46\117\x52\115\123\x5f\123\x43\122\x49\x50\124\x53\x7d\x7d", $po, $Yc);
        $Yc = str_replace("\x7b\x7b\110\x45\x41\x44\105\122\175\x7d", mo_("\126\141\154\151\x64\x61\164\x65\40\117\x54\x50\x20\50\117\x6e\145\x20\x54\x69\155\145\x20\x50\141\163\163\x63\x6f\144\x65\x29"), $Yc);
        $Yc = str_replace("\x7b\x7b\107\x4f\x5f\x42\x41\103\x4b\175\x7d", mo_("\46\154\141\x72\162\x3b\x20\x47\x6f\x20\102\x61\143\x6b"), $Yc);
        $Yc = str_replace("\x7b\x7b\115\x45\x53\123\x41\x47\x45\x7d\175", mo_($bC), $Yc);
        $Yc = str_replace("\x7b\x7b\x42\125\124\124\x4f\x4e\x5f\x54\x45\130\124\175\175", mo_("\x56\141\154\x69\144\x61\x74\145\x20\x4f\124\120"), $Yc);
        $Yc = str_replace("\173\x7b\122\x45\121\125\x49\122\105\104\x5f\106\111\x45\114\104\123\x7d\x7d", $xV, $Yc);
        $Yc = str_replace("\x7b\173\x45\130\x54\122\101\137\120\117\x53\x54\137\104\101\124\101\175\x7d", $gE, $Yc);
        return $Yc;
    }
    private function getRequiredFormsSkeleton($CD, $kt)
    {
        $cw = "\74\x66\x6f\x72\155\40\x6e\141\155\x65\x3d\42\x66\42\x20\x6d\145\x74\x68\x6f\x64\75\42\x70\x6f\x73\x74\42\40\141\x63\x74\x69\x6f\x6e\x3d\42\42\40\151\x64\75\42\166\141\154\x69\144\141\164\x69\157\156\137\147\x6f\102\141\x63\153\137\146\157\x72\x6d\42\76\xd\xa\11\x9\11\x9\74\151\156\x70\x75\x74\x20\151\144\x3d\42\166\x61\x6c\151\144\x61\164\x69\x6f\156\x5f\147\157\102\x61\x63\x6b\x22\x20\156\141\x6d\x65\x3d\42\157\x70\164\151\157\156\x22\40\166\141\154\165\x65\75\x22\166\141\x6c\x69\144\141\164\151\x6f\x6e\x5f\x67\x6f\x42\x61\143\x6b\42\x20\x74\171\x70\x65\75\42\x68\151\144\x64\145\x6e\42\x2f\76\15\xa\x9\x9\11\x3c\x2f\x66\x6f\x72\x6d\76\173\x7b\x53\x43\x52\x49\x50\x54\x53\x7d\x7d";
        $cw = str_replace("\173\x7b\123\103\122\x49\120\x54\x53\x7d\x7d", $this->getRequiredScripts(), $cw);
        return $cw;
    }
    private function getRequiredScripts()
    {
        $dO = "\x3c\x73\164\x79\154\x65\76\56\155\x6f\x5f\x63\x75\x73\x74\x6f\155\x65\162\x5f\166\x61\154\151\144\x61\164\x69\x6f\x6e\x2d\x6d\157\144\141\154\173\x64\151\163\160\154\x61\x79\x3a\142\154\157\x63\x6b\x21\x69\x6d\x70\x6f\x72\164\141\156\164\x7d\74\57\x73\x74\x79\x6c\x65\x3e";
        if (!$this->preview) {
            goto NVb;
        }
        $dO .= "\74\163\x63\x72\x69\x70\x74\x3e\x24\155\157\x3d\152\121\165\x65\162\x79\x3b\44\x6d\x6f\50\42\x23\x6d\x6f\137\166\141\x6c\x69\144\x61\x74\145\137\x66\x6f\162\155\42\x29\56\163\x75\142\x6d\x69\x74\50\x66\165\156\143\164\x69\157\x6e\x28\145\x29\x7b\x65\x2e\160\x72\145\x76\x65\x6e\x74\104\x65\x66\141\165\x6c\x74\50\x29\x3b\175\51\73\x3c\x2f\x73\143\162\151\160\164\76";
        goto I6E;
        NVb:
        $dO .= "\74\163\143\x72\x69\x70\164\76\x66\x75\x6e\143\164\151\x6f\156\40\x6d\x6f\x5f\x76\141\x6c\151\x64\x61\x74\x69\x6f\156\x5f\147\x6f\142\141\x63\153\50\51\x7b\144\157\x63\165\x6d\145\156\x74\56\x67\x65\164\x45\154\145\155\145\156\164\102\x79\x49\x64\x28\42\x76\x61\154\x69\x64\141\164\x69\x6f\x6e\137\147\x6f\x42\x61\x63\x6b\x5f\146\x6f\x72\155\42\51\56\163\x75\142\155\x69\x74\x28\51\73\x7d\74\57\x73\143\162\151\160\164\76";
        I6E:
        return $dO;
    }
}
