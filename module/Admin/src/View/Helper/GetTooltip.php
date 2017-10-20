<?php

namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;

class GetTooltip extends AbstractHelper
{
    public function __invoke($value, $cnt = 10)
    {
        $output = '';

        if (mb_strlen($value) <= $cnt) {
            $output .= $value;
        } else {
            $output .= '<span data-toggle="tooltip" data-placement="top" title="' . $value . '">';
            $output .= substr($value, 0, $cnt) . '...';
            $output .= '</span>';
        }

        return $output;
    }
}
