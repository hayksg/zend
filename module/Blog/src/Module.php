<?php

namespace Blog;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

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

    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getEventManager()->getSharedManager()->attach(
            __NAMESPACE__,
            MvcEvent::EVENT_DISPATCH,
            function ($e) {
                $translator = $e->getApplication()->getServiceManager()->get('translator');

                $container = new Container('language');
                $lang = $container->language;

                if (! $lang) {
                    $lang = 'en_US';
                }

                $translator->setLocale($lang);
            },
            1000
        );
    }
}
