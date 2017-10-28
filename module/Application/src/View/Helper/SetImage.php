<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class SetImage extends AbstractHelper
{
    public function __invoke($img)
    {
        if (is_file(getcwd() . '/public' . $img)) {
            return $img;
        } else {
            return '/img/home/no-image.jpg';
        }
    }
}
