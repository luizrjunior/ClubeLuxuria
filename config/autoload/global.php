<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array(
    //Zend_DB
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=clubeluxuria01;host=mysql.clubeluxuria.com.br',
        'username' => 'clubeluxuria01',
        'password' => 'prototipoclubeluxuria',
        'driver_options' => array(
           // PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => function ($serviceManager) {
        $adapterFactory = new Zend\Db\Adapter\AdapterServiceFactory();
        $adapter = $adapterFactory->createService($serviceManager);
        \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::setStaticAdapter($adapter);
        return $adapter;
    }
        ),
    ),
    'session' => array(
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                'name' => 'myapp',
            ),
        ),
        'storage' => 'Zend\Session\Storage\SessionArrayStorage',
        'validators' => array(
            array(
                'Zend\Session\Validator\RemoteAddr',
                'Zend\Session\Validator\HttpUserAgent',
            ),
        ),
    ), 
);
        