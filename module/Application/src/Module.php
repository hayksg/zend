<?php

namespace Application;

use Doctrine\ORM\EntityManager;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'top_navigation' => Service\TopNavigation::class,
                'formService'    => function ($container) {
                    return new Service\FormService(
                        $container->get(EntityManager::class)
                    );
                },
            ],
        ];
    }

    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'getYear' => View\Helper\GetYear::class,
            ],
            'factories' => [
                'getCategories' => function ($container) {
                    return new View\Helper\GetCategories(
                        $container->get(EntityManager::class)
                    );
                },
                'GetRouteParams' => function ($container) {
                    return new View\Helper\GetRouteParams(
                        $container->get('Application')
                    );
                },
            ],
        ];
    }
}
