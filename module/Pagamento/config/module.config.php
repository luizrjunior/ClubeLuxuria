<?php
namespace Pagamento;

return array(
    'controllers' => array(
        'invokables' => array(
            'Pagamento\Controller\Index' => 'Pagamento\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'pagamento' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/pagamento/[:controller[/:action]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Pagamento\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
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
                                '__NAMESPACE__' => 'Pagamento\Controller',
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
            'layout/layout'         => __DIR__ . '/../../Application/view/layout/layout.phtml',
            'error/404'             => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'           => __DIR__ . '/../../Application/view/error/index.phtml',
            'form-cad-pagamento'    => __DIR__ . '/../view/pagamento/partials/form-cad-pagamento.phtml',
            'cad-pagamento'         => __DIR__ . '/../view/pagamento/partials/cad-pagamento.phtml',
            'psq-pagamento'         => __DIR__ . '/../view/pagamento/partials/psq-pagamento.phtml',
            'form-cad-pagamento-cliente' => __DIR__ . '/../view/pagamento/partials/form-cad-pagamento-cliente.phtml',
            'psq-pagamento-cliente'      => __DIR__ . '/../view/pagamento/partials/psq-pagamento-cliente.phtml'
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
    'constsStPagamentoCad' => array(
        '' => ' - - Selecione - - ',
        1 => 'Aguardando Pagamento',
        2 => 'Aguardando Depósito Bancário',
        3 => 'Aguardando Pagseguro',
        4 => 'Aguardando Pagamento Domicilio',
        5 => 'Pago',
        6 => 'Devolvido',
        7 => 'Cancelado',
    ),
    'constsStPagamentoPsq' => array(
        'T' => ' - - Todos - - ',
        1 => 'Aguardando Pagamento',
        2 => 'Aguardando Depósito Bancário',
        3 => 'Aguardando Pagseguro',
        4 => 'Aguardando Pagamento Domicilio',
        5 => 'Pago',
        6 => 'Devolvido',
        7 => 'Cancelado',
    ),
    'constsTpPagamentoCad' => array(
        '' => ' - - Selecione - - ',
        1 => 'Depósito Bancário',
        2 => 'Pagseguro',
        3 => 'Pagamento Domicilio'
    ),
    'constsTpPagamentoPsq' => array(
        'T' => ' - - Todos - - ',
        1 => 'Depósitos Bancários',
        2 => 'Pagseguros',
        3 => 'Pagamentos Domicilios'
    ),
);