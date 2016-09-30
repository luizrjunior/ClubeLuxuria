<?php
namespace Anunciante;

return array(
    'controllers' => array(
        'invokables' => array(
            'Anunciante\Controller\Index' => 'Anunciante\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'anunciante' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/anunciante/[:controller[/:action]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Anunciante\Controller',
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
                                '__NAMESPACE__' => 'Anunciante\Controller',
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
            'layout/layout'              => __DIR__ . '/../../Application/view/layout/layout.phtml',
            'error/404'                  => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'                => __DIR__ . '/../../Application/view/error/index.phtml',
            'comp-anunciantes-novidades' => __DIR__ . '/../view/anunciante/partials/comp-anunciantes-novidades.phtml',
            'form-cad-anunciante'        => __DIR__ . '/../view/anunciante/partials/form-cad-anunciante.phtml',
            'psq-anunciante-home'        => __DIR__ . '/../view/anunciante/partials/psq-anunciante-home.phtml',
            'psq-anunciante'             => __DIR__ . '/../view/anunciante/partials/psq-anunciante.phtml',
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
    'constsTpAnunciantePsq' => array(
        'T' => ' - - Todos - - ',
        '1' => 'Acompanhantes de Luxo',
        '2' => 'Garotas de Programa',
        '3' => 'Garotos de Programa',
        '4' => 'Travestis',
        '5' => 'Outros'
    ),
    'constsTpAnuncianteCad' => array(
        '' => ' - - Selecione - - ',
        '1' => 'Acompanhante de Luxo',
        '2' => 'Garota de Programa',
        '3' => 'Garoto de Programa',
        '4' => 'Travesti',
        '5' => 'Outro'
    ),
    'constsStAnuncianteCad' => array(
        '' => ' - - Selecione - - ',
        '1' => 'Ativado',
        '2' => 'Desativado',
        '3' => 'Viajando',
        '4' => 'Férias'
    ),
    'constsStAnunciantePsq' => array(
        'T' => ' - - Todas - - ',
        '1' => 'Ativadas',
        '2' => 'Desativadas',
        '3' => 'Viajando',
        '4' => 'Férias'
    ),
    'constsTpCabeloCorCad' => array(
        '1' => 'Loira',
        '2' => 'Morena',
        '3' => 'Negra',
        '4' => 'Ruiva'
    ),
    'constsTpCabeloCorPsq' => array(
        '' => '-- Todos --',
        '1' => 'Loiras',
        '2' => 'Morenas',
        '3' => 'Negras',
        '4' => 'Ruivas'
    ),
);