<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\Article;
use Application\Entity\Category;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;

class CategoryController extends AbstractActionController
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
        $paginator = '';
        $categoryName = '';
        $categoryId = intval($this->getEvent()->getRouteMatch()->getParam('id', 0));

        $queryBuilder = $this->articleRepository->getQueryBuilderForCategory($categoryId);
        $adaptor = new DoctrinePaginator(new ORMPaginator($queryBuilder));
        $paginator = new Paginator($adaptor);

        if ($paginator) {
            $currentPageNumber = (int)$this->params()->fromRoute('page', 0);
            $paginator->setCurrentPageNumber($currentPageNumber);

            $itemCountPerPage = 10;
            $paginator->setItemCountPerPage($itemCountPerPage);
        }

        $category = $this->entityManager->getRepository(Category::class)->find($categoryId);
        if ($category) {
            $categoryName = $category->getName();
        }

        return new ViewModel([
            'articles'     => $paginator,
            'categoryName' => $categoryName,
        ]);
    }
}
