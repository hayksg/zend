<?php

namespace Application;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\MvcEvent;
use Zend\I18n\Translator\Translator;
use Zend\Http;
use Zend\Mvc\I18n\Translator as T;
use Zend\Session\Container;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Session\SessionManager;

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
            /*'aliases' => [
                'translator' => T::class,
            ],*/
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

    public function getControllerPluginConfig()
    {
        return [
            'invokables' => [
                'isObjectExists' => Controller\Plugin\IsObjectExists::class,
            ],
        ];
    }

    public function init(ModuleManagerInterface $moduleManager)
    {
        $moduleManager->getEventManager()->getSharedManager()->attach(
            __NAMESPACE__,
            'dispatch',
            function ($e) {
                $request = $e->getRequest();
                if (! $request instanceof Http\Request) {
                    return;
                }

                $translator = $e->getApplication()->getServiceManager()->get('translator');
                $container = new Container('language');
                $lang = $container->language;

                if (! $lang) {
                    $lang = 'en_US';
                }

                $translator->setLocale($lang);
                $e->getViewModel()->setVariable('language', $lang);
            },
            100
        );
    }

    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $serviceManager = $application->getServiceManager();

        // Следующая строка инстанцирует SessionManager и автоматически
        // делает его выбираемым 'по умолчанию'.
        $sessionManager = $serviceManager->get(SessionManager::class);
    }
}
