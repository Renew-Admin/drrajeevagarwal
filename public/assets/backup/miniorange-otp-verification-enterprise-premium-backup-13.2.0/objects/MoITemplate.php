<?php


namespace OTP\Objects;

interface MoITemplate
{
    public function build($Yc, $i5, $bC, $CD, $kt);
    public function parse($Yc, $bC, $CD, $kt);
    public function getDefaults($oQ);
    public function showPreview();
    public function savePopup();
    public static function instance();
    public function getTemplateKey();
    public function getTemplateEditorId();
}
