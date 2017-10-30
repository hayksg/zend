<?php

namespace Authentication\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DecryptLogin extends AbstractHelper
{
    public function __invoke($login = true, $role = false)
    {
        $filter = new \Zend\Filter\Decrypt();

        if ($login) {
            // For login
            $filter->setKey('tramvay');
            return $filter->filter($login) ?: false;
        }

        if (! $login && $role) {
            // For user
            $filter->setKey('geografiya');
            if ($filter->filter($role)) {
                return $filter->filter($role);
            }

            // For admin
            $filter->setKey('imeetvseprava');
            if ($filter->filter($role)) {
                return $filter->filter($role);
            }

            return false;
        }
    }
}
