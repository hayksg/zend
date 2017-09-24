<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\Article;

class ArticleController extends AbstractActionController
{
    private $entityManager;
    private $articleRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->articleRepository = $this->entityManager->getRepository(Article::class);
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
        return new ViewModel();
    }

    public function editAction()
    {
        return new ViewModel();
    }
}
