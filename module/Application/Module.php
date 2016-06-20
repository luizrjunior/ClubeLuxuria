<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

class Module implements ViewHelperProviderInterface {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'masterHelper' => function() {
                    $helper = new \Application\View\Helper\MasterHelper();
                    return $helper;
                },
                'pegarTpPlanoFundoPerfil' => function($sm) {
                    $helper = new \ConfigPaginaPerfil\View\Helper\PegarTpPlanoFundoPerfil($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'bannerPrincipalHelper' => function($sm) {
                    $helper = new \Banner\View\Helper\BannerPrincipalHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'bannerDestaquesHelper' => function($sm) {
                    $helper = new \Banner\View\Helper\BannerDestaquesHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'dadosAnuncianteHelper' => function($sm) {
                    $helper = new \Anunciante\View\Helper\DadosAnuncianteHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'mostrarFotoPerfilHelper' => function($sm) {
                    $helper = new \AlbumFoto\View\Helper\MostrarFotoPerfilHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                }
            )
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Cliente\Service\ClienteService' => function($em) {
                    return new Service\ClienteService($em->get('Doctrine\ORM\EntityManager'));
                },
            )
        );
    }

}
