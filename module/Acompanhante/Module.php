<?php

namespace Acompanhante;

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
                'mostrarFotoCapaHelper' => function($sm) {
                    $helper = new \AlbumFoto\View\Helper\MostrarFotoCapaHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'mostrarVisualizacaoPaginaHelper' => function($sm) {
                    $helper = new \Visualizacao\View\Helper\MostrarVisualizacaoPaginaHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'mostrarCurtidaPaginaHelper' => function($sm) {
                    $helper = new \Curtidas\View\Helper\MostrarCurtidaPaginaHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'VerificarCurtidaFotoUsuarioHelper' => function($sm) {
                    $helper = new \Curtidas\View\Helper\VerificarCurtidaFotoUsuarioHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                },
                'PegarQtdeCurtidaFotoHelper' => function($sm) {
                    $helper = new \Curtidas\View\Helper\PegarQtdeCurtidaFotoHelper($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                    return $helper;
                }
            )
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Curtidas\Service\CurtidasService' => function($em) {
                    return new Curtidas\Service\CurtidasService($em->get('Doctrine\ORM\EntityManager'));
                },
                'Favoritos\Service\FavoritosService' => function($em) {
                    return new Favoritos\Service\FavoritosService($em->get('Doctrine\ORM\EntityManager'));
                },
            )
        );
    }

}
