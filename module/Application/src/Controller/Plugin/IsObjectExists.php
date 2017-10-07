<?php

namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Validator\ObjectExists;

class IsObjectExists extends AbstractPlugin
{
    public function __invoke(ObjectRepository $repository, $value, $fields)
    {
        $object = new ObjectExists([
            'object_repository' => $repository,
            'fields' => $fields,
        ]);

        return $object->isValid($value);
    }
}
