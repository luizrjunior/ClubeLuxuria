<?php
namespace AlbumFoto;

return array(
    'controllers' => array(
        'invokables' => array(
            'AlbumFoto\Controller\Index' => 'AlbumFoto\Controller\IndexController',
            'AlbumFoto\Controller\Album' => 'AlbumFoto\Controller\AlbumController',
            'AlbumFoto\Controller\Foto' => 'AlbumFoto\Controller\FotoController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'album-foto' => array(
                'type' => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/album-foto/[:controller[/:action]]',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'AlbumFoto\Controller',
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
                                '__NAMESPACE__' => 'AlbumFoto\Controller',
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
            'layout/layout'            => __DIR__ . '/../../Application/view/layout/layout.phtml',
            'error/404'                => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'              => __DIR__ . '/../../Application/view/error/index.phtml',
            'form-cad-album'           => __DIR__ . '/../view/album-foto/partials/form-cad-album.phtml',
            'form-cad-album-principal' => __DIR__ . '/../view/album-foto/partials/form-cad-album-principal.phtml',
            'cad-album'                => __DIR__ . '/../view/album-foto/partials/cad-album.phtml',
            'cad-album-principal'      => __DIR__ . '/../view/album-foto/partials/cad-album-principal.phtml',
            'cad-foto'                 => __DIR__ . '/../view/album-foto/partials/cad-foto.phtml',
            'cad-foto-perfil'          => __DIR__ . '/../view/album-foto/partials/cad-foto-perfil.phtml',
            'cad-foto-capa'            => __DIR__ . '/../view/album-foto/partials/cad-foto-capa.phtml',
            'cad-foto-horizontal'      => __DIR__ . '/../view/album-foto/partials/cad-foto-horizontal.phtml',
            'cad-foto-vertical'        => __DIR__ . '/../view/album-foto/partials/cad-foto-vertical.phtml',
            'psq-album'                => __DIR__ . '/../view/album-foto/partials/psq-album.phtml',
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
    'constsTpAlbumPsq' => array(
        'T' => '-- Todos --',
        '1' => 'Ensaios Sensuais',
        '2' => 'Galerias de Fotos'
    ),
    'constsTpAlbumCad' => array(
        '' => '-- Selecione --',
        '1' => 'Ensaio Sensual',
        '2' => 'Galeria de Fotos'
    ),
    'constsStAlbumPsq' => array(
        'T' => '-- Todos --',
        '1' => 'Ativado',
        '2' => 'Desativado'
    ),
    'constsStAlbumCad' => array(
        '1' => 'Ativado',
        '2' => 'Desativado'
    ),
);