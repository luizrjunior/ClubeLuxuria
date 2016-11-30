<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    'constsSgUfSessionPsq' => array(
        '' => ' - - SELECIONE - -',
        'DF' => 'DISTRITO FEDERAL',
        'MG' => 'MINAS GERAIS',
    ),
    'constsSituacaoCad' => array(
        '1' => 'Ativado',
        '2' => 'Desativado'
    ),
    'constsSituacaoPsq' => array(
        'T' => '-- Todas --',
        '1' => 'Ativados',
        '2' => 'Desativados'
    ),
    'constsSimNaoCad' => array(
        '1' => 'Sim',
        '2' => 'Não'
    ),
    'constsSimNaoPsq' => array(
        '' => '-- Todos --',
        '1' => 'Sim',
        '2' => 'Não'
    ),
    'constsSgUfCad' => array(
        '' => '-- Selecione --',
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AM' => 'Amazonas',
        'AP' => 'Amapá',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espirito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MG' => 'Minas Gerais',
        'MS' => 'Mato Grosso do Sul',
        'MT' => 'Mato Grosso',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'PR' => 'Paraná',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'RS' => 'Rio Grande do Sul',
        'SC' => 'Santa Catarina',
        'SE' => 'Sergipe',
        'SP' => 'São Paulo',
        'TO' => 'Tocantins'
    ),
    'constsSgUfPsq' => array(
        '' => '-- Todos --',
//        'AC' => 'Acre',
//        'AL' => 'Alagoas',
//        'AM' => 'Amazonas',
//        'AP' => 'Amapá',
//        'BA' => 'Bahia',
//        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
//        'ES' => 'Espirito Santo',
//        'GO' => 'Goiás',
//        'MA' => 'Maranhão',
        'MG' => 'Minas Gerais',
//        'MS' => 'Mato Grosso do Sul',
//        'MT' => 'Mato Grosso',
//        'PA' => 'Pará',
//        'PB' => 'Paraíba',
//        'PE' => 'Pernambuco',
//        'PI' => 'Piauí',
//        'PR' => 'Paraná',
//        'RJ' => 'Rio de Janeiro',
//        'RN' => 'Rio Grande do Norte',
//        'RO' => 'Rondônia',
//        'RR' => 'Roraima',
//        'RS' => 'Rio Grande do Sul',
//        'SC' => 'Santa Catarina',
//        'SE' => 'Sergipe',
//        'SP' => 'São Paulo',
//        'TO' => 'Tocantins'
    )
);
