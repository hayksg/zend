<?php

namespace Application\Service;

use Doctrine\ORM\EntityManagerInterface;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Application\Service\FormServiceInterface;

class FormService implements FormServiceInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAnnotationForm($formObj)
    {
        if (is_object($formObj)) {
            $builder = new AnnotationBuilder($this->entityManager);
            $form = $builder->createForm($formObj);
            $form->setHydrator(new DoctrineObject($this->entityManager));
            $form->bind($formObj);

            return $form ?: false;
        }

        return false;
    }
}
