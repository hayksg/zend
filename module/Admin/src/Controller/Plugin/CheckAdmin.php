<?php

namespace Admin\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\User;

class CheckAdmin extends AbstractPlugin
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke($user)
    {
        if ($user && $user->getId()) {
            $admin = $this->entityManager->getRepository(User::class)->findBy(['id' => (int)$user->getId()]);
            $role = $admin[0]->getRole();

            if ($role === 'admin' || $role === 'superadmin') {
                return true;
            }
        }

        exit('Access denied');
    }
}
