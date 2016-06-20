<?php

namespace Cidade;

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
            'masterHelper' => function() {
                $helper = new \Application\View\Helper\MasterHelper();
                return $helper;
            },
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Cidade\Service\CidadeService' => function($em) {
                    return new Service\CidadeService($em->get('Doctrine\ORM\EntityManager'));
                },
            )
        );
    }

}
