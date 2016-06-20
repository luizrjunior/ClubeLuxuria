<?php
namespace Cliente;

return array(
    'controllers' => array(
        'invokables' => array(
            'Cliente\Controller\Index' => 'Cliente\Controller\IndexController',
            'Cliente\Controller\ClienteUsuario' => 'Cliente\Controller\ClienteUsuarioController',
            'Cliente\Controller\ClienteCaracteristica' => 'Cliente\Controller\ClienteCaracteristicaController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'cliente' => array(
                'type' => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/cliente/[:controller[/:action]]',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Cliente\Controller',
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
                                '__NAMESPACE__' => 'Cliente\Controller',
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
            'layout/layout'             => __DIR__ . '/../../Application/view/layout/layout.phtml',
            'error/404'                 => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'               => __DIR__ . '/../../Application/view/error/index.phtml',
            'cad-cliente'               => __DIR__ . '/../view/cliente/partials/cad-cliente.phtml',
            'psq-cliente'               => __DIR__ . '/../view/cliente/partials/psq-cliente.phtml',
            'menu-vertical-cliente'         => __DIR__ . '/../view/cliente/partials/menu-vertical-cliente.phtml',
            'form-cad-cliente'              => __DIR__ . '/../view/cliente/partials/form-cad-cliente.phtml',
            'comp-clientes-destaque'          => __DIR__ . '/../view/cliente/partials/comp-clientes-destaque.phtml',
            'comp-clientes-novos'          => __DIR__ . '/../view/cliente/partials/comp-clientes-novos.phtml',
            'comp-clientes-favoritos'          => __DIR__ . '/../view/cliente/partials/comp-clientes-favoritos.phtml',
            'comp-psq-clientes'          => __DIR__ . '/../view/cliente/partials/comp-psq-clientes.phtml',
            'form-cad-dados-cadastrais'       => __DIR__ . '/../view/cliente/partials/dados-cadastrais/form-cad-dados-cadastrais.phtml',
            'form-cad-cliente-caracteristica' => __DIR__ . '/../view/cliente/partials/caracteristicas/form-cad-cliente-caracteristica.phtml',
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
            'Documento' => 'Application\Controller\Plugin\Documento',
            'Data' => 'Application\Controller\Plugin\Data'
        )
    ),
    'constsTpClientePsq' => array(
        'T' => '-- Todos --',
        '1' => 'Anunciantes',
        '2' => 'Sócios Clube Luxúria'
    ),
    'constsTpClienteCad' => array(
        '' => '-- Selecione --',
        '1' => 'Anunciante',
        '2' => 'Sócio Clube Luxúria'
    ),
    'constsStClientePsq' => array(
        'T' => '-- Todos --',
        '1' => 'Ativados',
        '2' => 'Desativados',
        '3' => 'Pré-cadastros'
    ),
    'constsStClienteCad' => array(
        '' => '-- Selecione --',
        '1' => 'Ativado',
        '2' => 'Desativado',
        '3' => 'Pré-cadastro'
    ),
    'constsTpSexoPsq' => array(
        'T' => ' - - Todos - - ',
        '1' => 'Masculinos',
        '2' => 'Femininos'
    ),
    'constsTpSexoCad' => array(
        '1' => 'Masculino;',
        '2' => 'Feminino;'
    ),
);