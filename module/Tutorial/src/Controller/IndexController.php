<?php

namespace Tutorial\Controller;

use Zend\Http\Headers;
use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Tutorial\Service\GreetingServiceInterface;

class IndexController extends AbstractActionController
{
    private $greetingService;

    /*public function onDispatch(MvcEvent $e)
    {
        $this->layout('layout/layoutDefault');
        return parent::onDispatch($e); // TODO: Change the autogenerated stub
    }*/

    public function indexAction()
    {
        if ($this->request->isPost()) {
            $this->prg();
        }

        return new ViewModel([
            'greeting' => $this->getGreetingService()->getGreeting(),
            'date'     => $this->getDate(),
            //'greeting' => 'Hello!!!',
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

    public function exampleAction()
    {
        //return $this->redirect()->toUrl('http://rambler.ru');
        //return $this->forward()->dispatch(\Application\Controller\IndexController::class, ['action' => 'index']);

        //$this->getEvent()->getRouteMatch()->getParam();
        //$this->layout('layout/layoutDefault');

        $successMessage = 'Success message';
        $errorMessage = 'Error message';

        //$this->flashMessenger()->addSuccessMessage($successMessage);
        //$this->flashMessenger()->addErrorMessage($errorMessage);
        //return $this->redirect()->toRoute('tutorial');

        //$widget = $this->forward()->dispatch(\Application\Controller\IndexController::class, ['action' => 'index']);

        $view = new ViewModel();
        //$view->addChild($widget, 'widget');
        //$view->setTemplate('tutorial/index/exampleTemplate');
        return $view;
    }

    public function downloadAction()
    {
        chdir(getcwd() . '/public/img/');
        $file = getcwd() . DIRECTORY_SEPARATOR . 'c.jpg';

        if (is_file($file)) {
            $fileName = basename($file);
            $fileSize = filesize($file);

            $stream = new Stream();
            $stream->setStream(fopen($file, 'r'));
            $stream->setStreamName($fileName);
            $stream->setStatusCode(200);

            $headers = new Headers();
            $headers->addHeaderLine('Content-Type: application/octet-stream');
            $headers->addHeaderLine('Content-Disposition: attachment; filename=' . $fileName);
            $headers->addHeaderLine('Content-Length: ' . $fileSize);
            $headers->addHeaderLine('Cache-Control: no-store, must-revalidate');

            $stream->setHeaders($headers);
            return $stream;
        }
    }
}
