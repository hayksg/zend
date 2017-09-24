<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\Category;

class CategoryController extends AbstractActionController
{
    private $entityManager;
    private $categoryRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $this->entityManager->getRepository(Category::class);
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
