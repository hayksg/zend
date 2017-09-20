<?php

namespace Tutorial\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ArticleController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
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
                $title = $title;
            } else {
                $title = 'Empty result';
            }

        }
        return new ViewModel([
            'id'    => $id,
            'title' => $title,
        ]);
    }
}
