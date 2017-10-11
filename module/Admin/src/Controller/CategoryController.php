<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\Category;
use Application\Service\FormServiceInterface;
use Zend\I18n\Translator\TranslatorInterface;

class CategoryController extends AbstractActionController
{
    private $entityManager;
    private $categoryRepository;
    private $formService;
    private $translator;

    public function __construct(
        EntityManagerInterface $entityManager,
        FormServiceInterface $formService,
        TranslatorInterface $translator
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
        $form->setValidationGroup('csrf', 'name', 'parent', 'isPublic');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            $categoryName = $this->clearString($request->getPost('name'));

            if ($this->isObjectExists($this->categoryRepository, $categoryName, ['name'])) {
                $nameExists = sprintf($this->translator->translate('Category with name "%s" exists already'), $categoryName);
                $form->get('name')->setMessages(['nameExists' => $nameExists]);
            }

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
        $id = intval($this->getEvent()->getRouteMatch()->getParam('id', 0));
        $category = $this->categoryRepository->find($id);

        $form = $this->formService->getAnnotationForm($category);
        $form->setValidationGroup('csrf', 'name', 'parent', 'isPublic');

        /* Removes editing category from parents list */
        $this->clearCategory($form, 'parent', 'name');

        $request = $this->getRequest();

        if ($request->isPost() && empty($form->getMessages())) {
            $form->setData($request->getPost());

            /* In order not allow to repeat other existing category name */
            $categoryOldName = $this->clearString($category->getName());
            $categoryNewName = $this->clearString($form->get('name')->getValue());

            if ($this->categoryRepository->findOneBy(['name' => $categoryNewName]) && $categoryNewName != $categoryOldName) {
                $nameExists = sprintf($this->translator->translate('Category with name "%s" exists already'), $categoryNewName);
                $form->get('name')->setMessages(['nameExists' => $nameExists]);
            }
            /* End block */

            if ($form->isValid() && empty($form->getMessages())) {
                $category = $form->getData();

                // If user will choose category without parent
                if ($category->getParent() == 0) {
                    $category->setParent(null);
                }

                $this->entityManager->persist($category);
                $this->entityManager->flush();

                $this->flashMessenger()->addSuccessMessage('Category edited.');
                return $this->redirect()->toRoute('admin/category');
            }
        }

        return new ViewModel([
            'id'   => $id,
            'form' => $form,
        ]);
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $category = $this->categoryRepository->find($id);


        $request = $this->getRequest();
        if (! $category && ! $request->isPost()) {
            return $this->notFoundAction();
        }

        $form = $this->formService->getAnnotationForm($category);
        $form->setValidationGroup('csrf');

        $form->setData($request->getPost());

        if ($form->isValid()) {
            $category = $form->getData();







            $this->entityManager->remove($category);
            $this->entityManager->flush();

            $this->flashMessenger()->addSuccessMessage('Category deleted.');
        } else {
            $this->flashMessenger()->addSuccessMessage('Cannot delete category.');
        }

        return $this->redirect()->toRoute('admin/category');
    }

    /* Removes editing category from parents list */
    private function clearCategory($form, $field1, $field2)
    {
        $categories = $form->get($field1)->getValueOptions();
        $arr = [];

        if (is_array($categories)) {
            foreach ($categories as $category) {
                if (isset($category['label']) && $form->get($field2)->getValue()) {
                    if($category['label'] == $form->get($field2)->getValue()) {
                        unset($category);
                        continue;
                    }
                    $arr[] = $category;

                    $form->get($field1)->setValueOptions($arr);
                }
            }
        }
    }


}
