<?php

namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\Category;

class GetParentCategoryName extends AbstractHelper
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke($category)
    {
        $output = '';
        $parentCategoryId = $category->getParent();

        if (! $parentCategoryId) {
            $output = 'Has not parent category';
        } else {
            $parentCategory = $this->entityManager->getRepository(Category::class)->find($parentCategoryId);
            $output = htmlentities($parentCategory->getName());
        }

        return $output;
    }
}
