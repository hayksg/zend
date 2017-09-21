<?php

namespace Tutorial;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\Router\Http\Regex;
use Zend\Router\Http\Method;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'tutorial' => [
                'type' => Segment::class,
                'options' => [
                    'route'       => '/tutorial[/:action[/:id]]',
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
            /*'article' => [
                'type' => Regex::class,
                'options' => [
                    'regex' => '/article(/(?<action>[a-z]+)(/(?<id>[0-9]+))?)?',
                    'spec' => '/%action%/%id%',
                    'defaults' => [
                        'controller' => Controller\ArticleController::class,
                        'action'     => 'index',
                    ],
                ],
            ],*/
            'article' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/article[/:action[/:id]]',
                    'constraints'  => [
                        'action' => '[a-z-]+',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ArticleController::class,
                        //'action'     => rand(0, 1) ? 'add' : 'index',
                        'action'     => 'index',
                    ],
                ],
            ],
            'articleAction' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/article-action[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ArticleController::class,
                        'action'     => 'index',
                    ],
                ],
                'child_routes' => [
                    'get' => [
                        'type' => Method::class,
                        'options' => [
                            'verb' => 'get',
                            'defaults' => [
                                'controller' => Controller\ArticleController::class,
                                'action'     => 'add',
                            ],
                        ],
                    ],
                    'post' => [
                        'type' => Method::class,
                        'options' => [
                            'verb' => 'post',
                            'defaults' => [
                                'controller' => Controller\ArticleController::class,
                                'action'     => 'post',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            //Controller\IndexController::class => InvokableFactory::class,
            Controller\ArticleController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'tutorial/index/index' => __DIR__ . '/../view/tutorial/index/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
