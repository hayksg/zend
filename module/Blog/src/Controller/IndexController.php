<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\Article;

class IndexController extends AbstractActionController
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
        $articles = $this->articleRepository->findAll();

        return new ViewModel([
            'articles' => $articles,
        ]);
    }
}
