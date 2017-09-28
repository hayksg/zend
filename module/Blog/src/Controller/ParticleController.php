<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\Article;

class ParticleController extends AbstractActionController
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
        $id = intval($this->getEvent()->getRouteMatch()->getParam('id', 0));
        $article = $this->articleRepository->find($id);

        if (! $id || ! $article) {
            return $this->notFoundAction();
        }

        return new ViewModel([
            'article' => $article,
        ]);
    }
}
