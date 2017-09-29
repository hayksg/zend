<?php

namespace Admin;

use Doctrine\ORM\EntityManager;
use Zend\Http\Header\Server;

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
                Controller\CategoryController::class => function ($container) {
                    return new Controller\CategoryController(
                        $container->get(EntityManager::class),
                        $container->get('formService')
                    );
                },
                Controller\ArticleController::class => function ($container) {
                    return new Controller\ArticleController(
                        $container->get(EntityManager::class)
                    );
                },
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'admin_breadcrumbs' => Service\BreadcrumbService::class,
            ],
        ];
    }
}
