<?php

namespace Cliente;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

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

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Cliente\Service\ClienteService' => function($em) {
                    return new Service\ClienteService($em->get('Doctrine\ORM\EntityManager'));
                },
                'Cliente\Service\ClienteUsuarioService' => function($sm) {
                    return new Service\ClienteUsuarioService($sm->get('Doctrine\ORM\EntityManager'), $sm);
                },
                'Cliente\Service\ClienteCaracteristicaService' => function($sm) {
                    return new Service\ClienteCaracteristicaService($sm->get('Doctrine\ORM\EntityManager'), $sm);
                },
            )
        );
    }

}
