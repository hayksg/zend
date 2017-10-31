<?php

namespace Admin\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class DecryptAdmin extends AbstractPlugin
{
    public function __invoke($role)
    {
        $filter = new \Zend\Filter\Decrypt();

        if ($role) {
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
