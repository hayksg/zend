<?php

namespace Tutorial\Service;

use Tutorial\Service\EventServiceInterface;

class EventService implements EventServiceInterface
{
    public function onGetGreeting($params)
    {
        echo "Some event on 'getGreeting' service with param 'hour' = {$params['hour']}";
    }
}
