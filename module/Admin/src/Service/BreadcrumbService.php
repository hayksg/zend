<?php

namespace Admin\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class BreadcrumbService extends DefaultNavigationFactory
{
    protected function getName()
    {
        return 'admin_breadcrumbs';
    }
}
