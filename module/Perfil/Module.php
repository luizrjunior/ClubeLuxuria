<?php

namespace Perfil;

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
                'mostrarQtdeContatosHelper' => function($sm) {
                    $helper = new \Contato\View\Helper\MostrarQtdeContatosHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'mostrarQtdeDepoimentosHelper' => function($sm) {
                    $helper = new \Depoimento\View\Helper\MostrarQtdeDepoimentosHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'mostrarQtdeClientesHelper' => function($sm) {
                    $helper = new \Cliente\View\Helper\MostrarQtdeClientesHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'mostrarQtdeFavoritosHelper' => function($sm) {
                    $helper = new \Favoritos\View\Helper\MostrarQtdeFavoritosHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'mostrarQtdeCurtidasHelper' => function($sm) {
                    $helper = new \Curtidas\View\Helper\MostrarQtdeCurtidasHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'pegarQtdeFotoSensualHelper' => function($sm) {
                    $helper = new \AlbumFoto\View\Helper\PegarQtdeFotoSensuallHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
            )
        );
    }

    public function getServiceConfig() {
        return array();
    }

}
