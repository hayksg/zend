<?php

namespace Authentication\Controller\Plugin;

use Zend\Crypt\BlockCipher;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class CryptData extends AbstractPlugin
{
    public function __invoke($value)
    {
        $cipher = BlockCipher::factory('mcrypt', array('algorithm' => 'blowfish'));
        $cipher->setKey('this is the encryption key');
        $text      = 'This is the message to encrypt';
        $encrypted = $cipher->encrypt($value);

        return $encrypted ?: false;
    }
}
