<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\Article;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Application\Service\FormServiceInterface;
use Zend\I18n\Translator\TranslatorInterface;

class ArticleController extends AbstractActionController
{
    private $entityManager;
    private $articleRepository;
    private $formService;
    private $translator;

    public function __construct(
        EntityManagerInterface $entityManager,
        FormServiceInterface $formService,
        TranslatorInterface $translator
    ) {
        $this->entityManager = $entityManager;
        $this->articleRepository = $this->entityManager->getRepository(Article::class);
        $this->formService = $formService;
        $this->translator = $translator;
    }

    public function indexAction()
    {
        $paginator = '';

        $article = new Article();
        $form = $this->formService->getAnnotationForm($article);

        $qb = $this->articleRepository->getQueryBuilder(false);
        $adapter = new DoctrinePaginator(new ORMPaginator($qb));
        $paginator = new Paginator($adapter);

        if ($paginator) {
            $currentPageNumber = intval($this->params()->fromRoute('page', 0));
            $paginator->setCurrentPageNumber($currentPageNumber);

            $itemCountPerPage = 2;
            $paginator->setItemCountPerPage($itemCountPerPage);

            if ($currentPageNumber && $itemCountPerPage) {
                $articleNumberInTable = ($currentPageNumber - 1) * $itemCountPerPage;
            } else {
                $articleNumberInTable = 0;
            }
        }

        return new ViewModel([
            'articles' => $paginator,
            'articleNumberInTable' => $articleNumberInTable,
            'form' => $form,
        ]);
    }

    public function addAction()
    {
        return new ViewModel();
    }

    public function editAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }
}
