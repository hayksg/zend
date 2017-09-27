<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\Category;

class GetCategories extends AbstractHelper
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke()
    {
        /*$result = $this->entityManager
                       ->createQuery('SELECT c FROM Application\Entity\Category AS c WHERE c.isPublic = 1')
                       ->getResult();*/

        $result = $this->entityManager->getRepository(Category::class)->findBy(['isPublic' => 1]);

        $categories = [];
        foreach ($result as $category) {
            $categories[$category->getParent()][] = $category;
        }

        return $this->buildTree($categories, null);
    }

    private function buildTree($categories, $catId)
    {
        $output = '';

        if (is_array($categories) && isset($categories[$catId])) {
            $output .= '<ul class="menu_vert">';
            foreach ($categories[$catId] as $category) {
                $output .= '<li><a href="/blog/category/' . (int)$category->getId() . '">' . $category->getName() . '</a>';
                $output .= $this->buildTree($categories, $category->getId());
                $output .= '</li>';
            }
            $output .= '</ul>';
        }

        return $output;
    }
}
