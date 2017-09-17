<?php

namespace Tutorial\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tutorial\Service\GreetingServiceInterface;

class IndexController extends AbstractActionController
{
    private $greetingService;

    public function indexAction()
    {
        return new ViewModel([
            'greeting' => $this->getGreetingService()->getGreeting(),
        ]);
    }

    public function setGreetingService(GreetingServiceInterface $greetingService)
    {
        $this->greetingService = $greetingService;
    }

    public function getGreetingService()
    {
        return $this->greetingService;
    }
}
