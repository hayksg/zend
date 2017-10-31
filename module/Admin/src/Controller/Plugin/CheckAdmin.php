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

    public function __invoke($user, $controller)
    {
        if ($user && $user->getId()) {
            $admin = $this->entityManager->getRepository(User::class)->findBy(['id' => (int)$user->getId()]);
            $role = $admin[0]->getRole();

            $userRole = $controller->decryptAdmin($role);

            if(substr($userRole, -4) == 'uper' || substr($userRole, -4) == 'dmin') {
                return true;
            }
        }

        exit('Access denied');
    }
}
