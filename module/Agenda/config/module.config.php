<?php
namespace Agenda;

return array(
    'controllers' => array(
        'invokables' => array(
            'Agenda\Controller\Index' => 'Agenda\Controller\IndexController',
            'Agenda\Controller\Configuracoes' => 'Agenda\Controller\ConfiguracoesController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'agenda' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/agenda',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Agenda\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                        //'controller' => 'Agenda\Controller\Index',
                        //'action'     => 'index',
                    ),                    
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(//Rota para Index Controller
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/]',
                            'constraints' => array(                                
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '\d+'
                            ),
                            'defaults' => array(
                               '__NAMESPACE__' => 'Agenda\Controller',
                               'controller'    => 'Index',
                               'action'        => 'index',
                            ),
                        ),
                    ),                   
                    'inicio' => array(//Rota para Index Controller
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/inicio[/][:action[/:id]]',
                            'constraints' => array(                                
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array(
                               'controller'    => 'Index',
                               'action'        => 'index',
                            ),
                        ),
                    ),                   
                    'configuracoes' => array(//Rota para Configuracoes Controller
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/configuracoes[/][:action[/:id]]',
                            'constraints' => array(                                
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[a-zA-Z0-9]*'
                            ),
                            'defaults' => array(
                                'controller'    => 'Configuracoes',
                                'action'        => 'index',
                            ),
                        ),
                    ),                   
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/pesquisar/page[/:page]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                'action' => 'pesquisar',
                                'page' => 1
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'             => __DIR__ . '/../../Application/view/layout/layout.phtml',
            'error/404'                 => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'               => __DIR__ . '/../../Application/view/error/index.phtml',
            
            //Partials
            'tela-inicio'  => __DIR__ . '/../view/agenda/partials/tela-inicio.phtml',
            'novo'         => __DIR__ . '/../view/agenda/partials/novo.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'Mkdir' => 'Application\Controller\Plugin\Mkdir'    
        )
    ),
);