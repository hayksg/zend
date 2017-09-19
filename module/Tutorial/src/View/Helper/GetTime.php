<?php

namespace Tutorial\View\Helper;

use Zend\View\Helper\AbstractHelper;

class GetTime extends AbstractHelper
{
    public function __invoke()
    {
        $dt = new \DateTime();
        $dt->setTimezone(new \DateTimeZone('America/New_York'));
        $time = $dt->format('H:i:s a');

        return $time ?: false;
    }
}
