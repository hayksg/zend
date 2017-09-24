<?php

namespace Blog;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'blog' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/blog[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-z]+',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            //Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'blog/index/index' => __DIR__ . '/../view/blog/index/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
