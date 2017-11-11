<?php

namespace Admin\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class EditTheFieldRole extends AbstractPlugin
{
    public function __invoke($obj, $name, $role)
    {
        // For user name
        $filter = new \Zend\Filter\Decrypt();

        if ($name) {
            $filter->setKey('tramvay');
            $name = $filter->filter($name) ?: false;
        }

        // For role
        $filter = new \Zend\Filter\Encrypt();

        if ($role === 'user') {
            $filter->setKey('geografiya');
            $filter->setVector('05050694823123069261');

            $role = $name . '_user';
            $obj->setRole($filter->filter($role));
        }

        if ($role === 'admin') {
            $filter->setKey('imeetvseprava');
            $filter->setVector('36452049153098394715');

            $role = $name . '_admin';
            $obj->setRole($filter->filter($role));
        }
    }
}
