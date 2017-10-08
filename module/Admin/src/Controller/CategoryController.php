<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\Category;
use Application\Service\FormServiceInterface;

class CategoryController extends AbstractActionController
{
    private $entityManager;
    private $categoryRepository;
    private $formService;
    private $translator;

    public function __construct(
        EntityManagerInterface $entityManager,
        FormServiceInterface $formService,
        $translator
    ) {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $this->entityManager->getRepository(Category::class);
        $this->formService = $formService;
        $this->translator = $translator;
    }

    public function indexAction()
    {
        $category = new Category();
        $form = $this->formService->getAnnotationForm($category);

        $categories = $this->categoryRepository->findAll();

        return new ViewModel([
            'categories' => $categories,
            'cnt'        => 0,
            'form'       => $form,
        ]);
    }

    public function addAction()
    {
        $category = new Category();
        $form = $this->formService->getAnnotationForm($category);
        $form->setValidationGroup('csrf', 'name', 'parent');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $categoryName = $this->clearString($request->getPost('name'));

            if ($this->isObjectExists($this->categoryRepository, $categoryName, ['name'])) {
                $nameExists = sprintf($this->translator->translate('Category with name "%s" exists already'), $categoryName);
                $form->get('name')->setMessages(['nameExists' => $nameExists]);
            }

            $form->setData($request->getPost());

            if ($form->isValid() && empty($form->getMessages())) {
                $category = $form->getData();

                if ($category->getParent() == 0) {
                    $category->setParent(null);
                }

                $this->entityManager->persist($category);
                $this->entityManager->flush();

                $this->flashMessenger()->addSuccessMessage('Category added.');
                return $this->redirect()->toRoute('admin/category');
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
}
