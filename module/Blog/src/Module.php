<?php

namespace Blog;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\MvcEvent;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\IndexController::class => function ($container) {
                    return new Controller\IndexController(
                        $container->get(EntityManager::class)
                    );
                },
                Controller\CategoryController::class => function ($container) {
                    return new Controller\CategoryController(
                        $container->get(EntityManager::class)
                    );
                },
                Controller\ParticleController::class => function ($container) {
                    return new Controller\ParticleController(
                        $container->get(EntityManager::class)
                    );
                },
            ],
        ];
    }
}
