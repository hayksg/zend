<?php

namespace Tutorial;

use Tutorial\Controller\IndexController;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Mvc\MvcEvent;




use Zend\EventManager\EventInterface;
use Zend\I18n\Translator\Translator;
use Zend\Http;
use Zend\Mvc\I18n\Translator as T;
use Zend\Session\Container;
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
            'invokables' => [
                'eventService' => Service\EventService::class,
            ],
            'factories' => [
                'getGreeting'       => Service\GreetingServiceFactory::class,
                'greetingAggregate' => Event\GreetingServiceListenerAggregateFactory::class,
            ],
            /*'aliases' => [
                'translator' => T::class,
            ],*/
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

    public function getControllerPluginConfig()
    {
        return [
            'invokables' => [
                'getDate' => Controller\Plugin\GetDate::class,
                'clearString' => Controller\Plugin\ClearString::class,
            ],
        ];
    }

    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'getTime' => View\Helper\GetTime::class,
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

                $containerLanguage = new Container('language');
                $lang = $containerLanguage->language;

                if (! $lang) {
                    $lang = 'en_US';
                }

                $translator->setLocale($lang);
            },
            1000
        );

        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();

        // Следующая строка инстанцирует SessionManager и автоматически
        // делает его выбираемым 'по умолчанию'.
        $sessionManager = $serviceManager->get(SessionManager::class);
        //$sessionManager->regenerateId(true);
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
