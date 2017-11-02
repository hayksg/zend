<?php

namespace Admin;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/admin[/:action]',
                    'constraints' => [
                        'action' => '[a-z]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'category' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'       => '/category[/:action[/:id]]',
                            'constraints' => [
                                //'action' => '[a-z]+',
                                'action' => '(add|edit|delete)',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\CategoryController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'article' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'       => '/articles[/page/:page][/:action[/:id]]',
                            'constraints' => [
                                'page'   => '[0-9]+',
                                'action' => '[a-z]+',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\ArticleController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'client' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'       => '/client[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-z]+',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\ClientController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'admin' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'       => '/admin[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-z]+',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\AdminController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'admin/index/index' => __DIR__ . '/../view/admin/index/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'navigation' => [
        'admin_breadcrumbs' => [
            'admin' => [
                'label' => 'Admin',
                'route' => 'admin',
                'pages' => [
                    'users' => [
                        'label'  => 'Users',
                        'route'  => 'admin',
                        'action' => 'users',
                    ],
                    'category' => [
                        'label' => 'Categories',
                        'route' => 'admin/category',
                        'pages' => [
                            'add' => [
                                'label' => 'Add category',
                                'route' => 'admin/category',
                                'action' => 'add',
                            ],
                            'edit' => [
                                'label' => 'Edit category',
                                'route' => 'admin/category',
                                'action' => 'edit',
                            ],
                        ],
                    ],
                    'article' => [
                        'label' => 'Articles',
                        'route' => 'admin/article',
                        'pages' => [
                            'add' => [
                                'label' => 'Add article',
                                'route' => 'admin/article',
                                'action' => 'add',
                            ],
                            'edit' => [
                                'label' => 'Edit article',
                                'route' => 'admin/article',
                                'action' => 'edit',
                            ],
                        ],
                    ],
                    'client' => [
                        'label' => 'Clients',
                        'route' => 'admin/client',
                        'pages' => [
                            'add' => [
                                'label' => 'Add client',
                                'route' => 'admin/client',
                                'action' => 'add',
                            ],
                            'edit' => [
                                'label' => 'Edit client',
                                'route' => 'admin/client',
                                'action' => 'edit',
                            ],
                        ],
                    ],
                    'admin' => [
                        'label' => 'Admins',
                        'route' => 'admin/admin',
                        'pages' => [
                            'add' => [
                                'label' => 'Add admin',
                                'route' => 'admin/admin',
                                'action' => 'add',
                            ],
                            'edit' => [
                                'label' => 'Edit admin',
                                'route' => 'admin/admin',
                                'action' => 'edit',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
