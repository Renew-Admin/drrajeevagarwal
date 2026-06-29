<?php


namespace OTP\Objects;

interface IFormHandler
{
    public function unsetOTPSessionVariables();
    public function handle_post_verification($My, $iI, $p1, $iK, $NN, $ck, $tA);
    public function handle_failed_verification($iI, $p1, $NN, $tA);
    public function handleForm();
    public function handleFormOptions();
    public function getPhoneNumberSelector($kp);
    public function isLoginOrSocialForm($oy);
    public function is_ajax_form_in_play($S3);
    public function getPhoneHTMLTag();
    public function getEmailHTMLTag();
    public function getBothHTMLTag();
    public function getFormKey();
    public function getFormName();
    public function getOtpTypeEnabled();
    public function disableAutoActivation();
    public function getPhoneKeyDetails();
    public function isFormEnabled();
    public function getEmailKeyDetails();
    public function getButtonText();
    public function getFormDetails();
    public function getVerificationType();
    public function getFormDocuments();
}
