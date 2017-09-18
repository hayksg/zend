<?php

namespace Tutorial\Event;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class GreetingServiceListenerAggregateFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $greetingAggregate = new GreetingServiceListenerAggregate();
        $greetingAggregate->setEventService($container->get('eventService'));
        return $greetingAggregate;
    }
}
