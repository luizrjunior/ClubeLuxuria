<?php

namespace Application\Controller\Plugin;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Application\Controller\Plugin\Master;

class MasterFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $pluginManager) {
        $serviceManager = $pluginManager->getServiceLocator();
        return new Master($serviceManager);
    }

}