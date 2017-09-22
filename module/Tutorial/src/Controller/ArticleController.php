<?php

namespace Tutorial\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\Http\Header\SetCookie;

class ArticleController extends AbstractActionController
{
    public function indexAction()
    {
        $message = '';

        /*$container = new Container('addArticle');
        $message = $container->message;
        $container->getManager()->getStorage()->clear('addArticle');*/

        $cookie = $this->getRequest()->getCookie('addArticle');
        if ($cookie->offsetExists('addArticle')) {
            $message = $cookie->offsetGet('addArticle');

            $cookie = new SetCookie('addArticle', '', strtotime('-1 day'), '/');
            $this->getResponse()->getHeaders()->addHeader($cookie);
        }

        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'message' => $message,
        ]);
        return $viewModel;
    }

    public function addAction()
    {
        return new ViewModel();
    }

    public function postAction()
    {
        $title = '';
        $id = intval($this->getEvent()->getRouteMatch()->getParam('id', 0));

        if ($this->request->isPost()) {
            $title = $this->clearString($this->request->getPost('title'));
            if (! empty($title)) {
                //$title = $title;
                $message = 'The article successfully added';
            } else {
                //$title = 'Empty result';
                $message = 'Empty result';
            }
        }

        /*$container = new Container('addArticle');
        $container->message = $message;*/

        $cookie = new SetCookie('addArticle', $message, strtotime('+1 day'), '/');
        $this->getResponse()->getHeaders()->addHeader($cookie);

        return $this->redirect()->toRoute('article');

        /*return new ViewModel([
            'id'    => $id,
            'title' => $title,
        ]);*/
    }
}
