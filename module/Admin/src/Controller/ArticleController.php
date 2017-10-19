<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\Article;
use Application\Entity\Category;
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
        $article = new Article();
        $form = $this->formService->getAnnotationForm($article);
        $form->setValidationGroup('csrf', 'title', 'shortContent', 'content', 'file', 'isPublic', 'category');

        if(! $this->getCategoryWhichHasNotParentCategory($form)) {
            return false;
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $files = $this->request->getFiles()->toArray();
            if ($files) { $fileName = $this->clearString($files['file']['name']); }

            $data = array_merge_recursive($request->getPost()->toArray(), $files);

            $form->setData($data);

            if ($form->isValid()) {
                $article = $form->getData();
                $fileDir = './public/img/blog/';

                if ($fileName && is_dir($fileDir)) {
                    /* block for images unique name in filesystem and database */
                    $uniqueId = uniqid();

                    $filter = new \Zend\Filter\File\Rename($fileDir . $uniqueId . $fileName);
                    $filter->filter($files['file']);

                    if ($fileName) $article->setImage('/img/blog/' . $uniqueId . $fileName);
                    /* end block */
                }

                $this->entityManager->persist($article);
                $this->entityManager->flush();

                $this->flashMessenger()->addSuccessMessage('Article added');
                return $this->redirect()->toRoute('admin/article');
            }
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function editAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }

    private function getCategoryWhichHasNotParentCategory($form)
    {
        $arr = [];
        $res = [];

        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        foreach ($categories as $category) {
            $arr[] = $category->getParent();
        }

        $categories = $form->get('category')->getValueOptions();
        foreach ($categories as $category) {
            foreach ($arr as $value) {
                if (isset($category['value']) && $category['value'] == $value) {
                    unset($category);
                    continue 2;
                }
            }

            $res[] = $category;

            $form->get('category')->setValueOptions($res);
        }

        $categories = $form->get('category')->getValueOptions();
        return $categories ?: false;
    }
}
