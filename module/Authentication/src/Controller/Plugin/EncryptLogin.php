<?php

namespace Authentication\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class EncryptLogin extends AbstractPlugin
{
    public function __invoke($user)
    {
        $filter = new \Zend\Filter\Encrypt();

        // For login
        $filter->setKey('tramvay');
        $filter->setVector('28371420691402730623');

        $login = $user->getName();
        $user->setName($filter->filter($login));

        // For role
        $filter->setKey('geografiya');
        $filter->setVector('05050694823123069261');

        $role = $login . '_user';
        $user->setRole($filter->filter($role));
    }
}
