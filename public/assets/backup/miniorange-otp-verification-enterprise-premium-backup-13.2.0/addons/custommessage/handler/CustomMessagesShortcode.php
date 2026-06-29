<?php


namespace OTP\Addons\CustomMessage\Handler;

use OTP\Traits\Instance;
class CustomMessagesShortcode
{
    use Instance;
    private $_adminActions;
    private $_nonce;
    public function __construct()
    {
        $Fl = CustomMessages::instance();
        $this->_nonce = $Fl->getNonceValue();
        $this->_adminActions = $Fl->_adminActions;
        add_shortcode("\155\x6f\x5f\143\165\163\164\x6f\x6d\137\163\155\163", array($this, "\x5f\143\165\163\x74\x6f\x6d\137\163\x6d\163\137\163\x68\157\162\164\143\x6f\x64\x65"));
        add_shortcode("\x6d\157\137\x63\165\x73\164\157\155\x5f\x65\155\x61\151\154", array($this, "\x5f\143\165\x73\x74\157\x6d\x5f\145\155\x61\151\154\137\163\x68\157\x72\x74\x63\x6f\x64\145"));
    }
    function _custom_sms_shortcode()
    {
        if (is_user_logged_in()) {
            goto Gk;
        }
        return;
        Gk:
        $RT = array_keys($this->_adminActions);
        include MCM_DIR . "\166\x69\145\167\x73\57\x63\165\163\x74\157\x6d\x53\115\123\102\x6f\x78\x2e\x70\x68\160";
        wp_register_script("\x63\x75\163\164\x6f\x6d\137\163\155\x73\137\155\x73\147\137\x73\x63\162\x69\x70\x74", MCM_SHORTCODE_SMS_JS, ["\152\161\165\x65\x72\x79"], MOV_VERSION);
        wp_localize_script("\x63\x75\163\164\x6f\x6d\x5f\x73\155\163\x5f\155\x73\x67\x5f\163\x63\162\151\160\164", "\155\157\166\x63\x75\x73\x74\x6f\155\163\155\163", ["\141\154\x74" => mo_("\x53\145\156\x64\151\x6e\147\56\x2e\x2e"), "\x69\x6d\x67" => MOV_LOADER_URL, "\x6e\157\156\x63\x65" => wp_create_nonce($this->_nonce), "\x75\162\154" => wp_ajax_url(), "\x61\143\164\x69\x6f\156" => $RT[0], "\142\x75\164\164\157\156\x54\145\x78\x74" => mo_("\x53\x65\x6e\144\x20\x53\115\x53")]);
        wp_enqueue_script("\x63\165\x73\164\157\155\x5f\x73\x6d\163\137\155\163\x67\137\163\x63\162\151\160\x74");
    }
    function _custom_email_shortcode()
    {
        if (is_user_logged_in()) {
            goto o0;
        }
        return;
        o0:
        $RT = array_keys($this->_adminActions);
        include MCM_DIR . "\166\x69\145\x77\163\57\143\165\163\x74\157\x6d\105\x6d\141\151\x6c\102\x6f\x78\56\160\150\160";
        wp_register_script("\143\165\x73\x74\x6f\x6d\137\x65\155\141\151\154\x5f\155\x73\147\x5f\x73\143\x72\151\160\164", MCM_SHORTCODE_EMAIL_JS, ["\152\161\x75\145\x72\171"], MOV_VERSION);
        wp_localize_script("\143\165\163\164\x6f\x6d\x5f\x65\155\141\x69\154\x5f\155\x73\x67\137\163\143\x72\151\x70\x74", "\x6d\157\x76\143\x75\x73\164\x6f\x6d\145\155\141\x69\154", ["\x61\x6c\164" => mo_("\123\145\x6e\144\151\x6e\147\x2e\x2e\x2e"), "\x69\155\x67" => MOV_LOADER_URL, "\x6e\157\156\143\145" => wp_create_nonce($this->_nonce), "\165\162\154" => wp_ajax_url(), "\141\143\x74\151\157\x6e" => $RT[1], "\142\x75\x74\164\x6f\156\124\x65\170\164" => mo_("\123\x65\156\144\x20\105\x6d\x61\x69\154")]);
        wp_enqueue_script("\x63\x75\x73\164\157\155\x5f\145\x6d\x61\151\154\137\x6d\163\x67\137\163\143\162\x69\160\x74");
    }
}
