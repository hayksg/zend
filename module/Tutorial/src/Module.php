<?php

namespace Tutorial;

use Tutorial\Controller\IndexController;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Mvc\MvcEvent;

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
                'eventService' => Service\EventService::class,
            ],
            'factories' => [
                'getGreeting'       => Service\GreetingServiceFactory::class,
                'greetingAggregate' => Event\GreetingServiceListenerAggregateFactory::class,
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

    /*public function init(ModuleManagerInterface $moduleManager)
    {
        $moduleManager->getEventManager()->getSharedManager()->attach(
            __NAMESPACE__,
            'dispatch',
            [$this, 'onInit'],
            100
        );
    }

    public function onInit()
    {
        echo "Hello, I am init";
    }*/

    /*public function onBootstrap(MvcEvent $event)
    {
        $event->getApplication()->getEventManager()->getSharedManager()->attach(
            __NAMESPACE__,
            'dispatch',
            function ($event) {
                $controller = $event->getTarget();
                $controller->layout('layout/layoutDefault');
            },
            100
        );
    }*/
}
