<?php

namespace Tutorial;

use Tutorial\Controller\IndexController;

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
            'invokables' => [
                'getGreeting' => Service\GreetingService::class,
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                //Controller\IndexController::class => Controller\IndexControllerFactory::class,
                IndexController::class => function ($container) {
                    $ctr = new IndexController();
                    $ctr->setGreetingService($container->get('getGreeting'));
                    return $ctr;
                },
            ],
        ];
    }
}
