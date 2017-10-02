<?php

namespace Admin;

use Doctrine\ORM\EntityManager;
use Zend\Http\Header\Server;
use Zend\Mvc\MvcEvent;

use Zend\EventManager\EventInterface;
use Zend\I18n\Translator\Translator;
use Zend\Http;
use Zend\Mvc\I18n\Translator as T;
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
