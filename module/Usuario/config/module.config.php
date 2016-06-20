<?php
namespace Usuario;

return array(
    'controllers' => array(
        'invokables' => array(
            'Usuario\Controller\Index' => 'Usuario\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'usuario' => array(
                'type' => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/usuario/[:controller[/:action]]',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Usuario\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:var][/:s]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'var' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                's' => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Usuario\Controller',
                                'controller' => 'Index',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'controlIndex' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/page/:page]',
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
                    'wildcard_rel' => array(
                        'type' => 'Zend\Mvc\Router\Http\Wildcard',
                        'options' => array(
                            'key_value_delimiter' => '/',
                            'param_delimiter' => '/',
                        ),
                        'may_terminate' => true,
                    ),
                ),
            ),
        ),
    ),
    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
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
            'layout/layout'           => __DIR__ . '/../../Application/view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'             => __DIR__ . '/../../Application/view/error/index.phtml',
            'cad-usuario'             => __DIR__ . '/../view/usuario/partials/cad-usuario.phtml',
            'psq-usuario'             => __DIR__ . '/../view/usuario/partials/psq-usuario.phtml',
            'form-cad-usuario'        => __DIR__ . '/../view/usuario/partials/form-cad-usuario.phtml',
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
    'constsTipoUsuarioCad' => array(
        '' => '-- Selecione --',
        '1' => 'Administrador',
        '2' => 'Funcionário',
        '3' => 'Anunciante',
        '4' => 'Sócio Clube Luxúria'
    ),
    'constsTipoUsuarioPsq' => array(
        'T' => '-- Todos --',
        '1' => 'Administradores',
        '2' => 'Funcionários',
        '3' => 'Anunciantes',
        '4' => 'Sócios Clube Luxúria'
    ),
    'constsTpUsuarioCad' => array(
        '' => '-- Selecione --',
        '1' => 'Administrador',
        '2' => 'Funcionário',
        '3' => 'Anunciante',
        '4' => 'Sócio'
    ),
    'constsTpUsuarioPsq' => array(
        'T' => '-- Todos --',
        '1' => 'Administradores',
        '2' => 'Funcionários',
        '3' => 'Anunciantes',
        '4' => 'Sócios'
    ),
    'constsStUsuarioCad' => array(
        '1' => 'Ativado',
        '2' => 'Desativado'
    ),
    'constsStUsuarioPsq' => array(
        'T' => '-- Todas --',
        '1' => 'Ativados',
        '2' => 'Desativados'
    ),
);