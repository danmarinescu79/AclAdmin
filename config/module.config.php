<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 05:36:02
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:40:19
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'resource' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/resource',
                    'defaults' => [
                        'controller' => Controller\Resource::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                ],
            ],
            'role' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/role',
                    'defaults' => [
                        'controller' => Controller\Role::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'add' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'controller' => Controller\Role::class,
                                'action'     => 'manage',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/edit/:id',
                            'defaults' => [
                                'controller' => Controller\Role::class,
                                'action'     => 'manage',
                                'id'         => false,
                            ],
                            'constraints' => [
                                'id' => '[0-9]*',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/delete/:id',
                            'defaults' => [
                                'controller' => Controller\Role::class,
                                'action'     => 'delete',
                                'id'         => false,
                            ],
                            'constraints' => [
                                'id' => '[0-9]*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\Role::class     => Factory\Controller\Role::class,
            Controller\Resource::class => Factory\Controller\Resource::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\Acl::class      => Factory\Service\Acl::class,
            Service\Role::class     => Factory\Service\Role::class,
            Service\Resource::class => Factory\Service\Resource::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'RoleMultiCheckbox' => View\Helper\RoleMultiCheckbox::class,
        ]
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ],
        ]
    ]
];
