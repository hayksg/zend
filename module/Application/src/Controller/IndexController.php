<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function translateAction()
    {
        $query = $this->request->getQuery('language', 'en_US');

        $container = new Container('language');
        $container->language = $query;

        return $this->redirect()->toRoute('home');
    }
}
