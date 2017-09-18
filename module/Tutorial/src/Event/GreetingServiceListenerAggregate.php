<?php

namespace Tutorial\Event;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Tutorial\Service\EventServiceInterface;
use Zend\EventManager\Event;

class GreetingServiceListenerAggregate implements ListenerAggregateInterface
{
    private $eventService;
    private $listeners = [];

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach('getGreeting', [$this, 'first'],  $priority);
        $this->listeners[] = $events->attach('getGreeting', [$this, 'second'], $priority);
        $this->listeners[] = $events->attach('getGreeting', [$this, 'third'],  $priority);
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    public function first(Event $e)
    {
        $params = $e->getParams();
        $this->getEventService()->onGetGreeting($params);
    }

    public function second(Event $e)
    {
        $params = $e->getParams();
        $this->getEventService()->onGetGreeting($params);
    }

    public function third(Event $e)
    {
        $params = $e->getParams();
        $this->getEventService()->onGetGreeting($params);
    }

    public function setEventService(EventServiceInterface $eventService)
    {
        $this->eventService = $eventService;
    }

    public function getEventService()
    {
        return $this->eventService;
    }
}
