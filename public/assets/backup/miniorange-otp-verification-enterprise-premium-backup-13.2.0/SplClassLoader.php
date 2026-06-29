<?php


namespace OTP;

if (defined("\x41\x42\123\120\101\124\x48")) {
    goto QBP;
}
exit;
QBP:
final class SplClassLoader
{
    private $_fileExtension = "\x2e\160\x68\160";
    private $_namespace;
    private $_includePath;
    private $_namespaceSeparator = "\134";
    public function __construct($TX = null, $Bj = null)
    {
        $this->_namespace = $TX;
        $this->_includePath = $Bj;
    }
    public function register()
    {
        spl_autoload_register(array($this, "\x6c\157\141\x64\x43\154\141\x73\163"));
    }
    public function unregister()
    {
        spl_autoload_unregister(array($this, "\154\157\141\x64\103\x6c\x61\x73\x73"));
    }
    public function loadClass($XN)
    {
        if (!(null === $this->_namespace || $this->isSameNamespace($XN))) {
            goto HZq;
        }
        $Hm = '';
        $Me = '';
        if (!(false !== ($nS = strripos($XN, $this->_namespaceSeparator)))) {
            goto QVJ;
        }
        $Me = strtolower(substr($XN, 0, $nS));
        $XN = substr($XN, $nS + 1);
        $Hm = str_replace($this->_namespaceSeparator, DIRECTORY_SEPARATOR, $Me) . DIRECTORY_SEPARATOR;
        QVJ:
        $Hm .= str_replace("\x5f", DIRECTORY_SEPARATOR, $XN) . $this->_fileExtension;
        $Hm = str_replace("\157\x74\160", MOV_NAME, $Hm);
        require ($this->_includePath !== null ? $this->_includePath . DIRECTORY_SEPARATOR : '') . $Hm;
        HZq:
    }
    private function isSameNamespace($XN)
    {
        return $this->_namespace . $this->_namespaceSeparator === substr($XN, 0, strlen($this->_namespace . $this->_namespaceSeparator));
    }
}
