<?php

namespace Tutorial\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ClearString extends AbstractPlugin
{
    public function __invoke($value)
    {
        /*$stripTags = new \Zend\Filter\StripTags();
        $value = $stripTags->filter($value);

        $stringTrim = new \Zend\Filter\StringTrim();
        $value = $stringTrim->filter($value);*/

        $filterChain = new \Zend\Filter\FilterChain();
        $filterChain->attachByName('StripTags');
        $filterChain->attachByName('StringTrim');
        $value = $filterChain->filter($value);

        return $value ?: false;
    }
}
