<?php

namespace TutorialMod;

use Zend\Router\Http\Literal;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return [
            'router' => [
                'routes' => [
                    'tutorial' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/welcome',
                        ],
                    ],
                ],
            ],
            'view_manager' => [
                'template_map' => [
                    'tutorial/index/index' => __DIR__ . '/../view/tutorial-mod/index/index.phtml',
                ],
            ],
        ];
    }
}
