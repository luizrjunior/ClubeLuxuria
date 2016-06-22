<?php

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => 'mysql02-farm68.kinghost.net',
                    'port' => '3306',
                    'user' => 'clubeluxuria',
                    'password' => 'clubeluxuria2016mysql',
                    'dbname' => 'clubeluxuria',
                )
            ),
        ),
        // now you define the entity manager configuration
        'entitymanager' => array(
            'orm_default' => array(
                'connection' => 'orm_default',
                'configuration' => 'orm_default'
            ),
            'configuration' => array(
                'orm_permissoes' => array(
                    'metadata_cache' => 'array',
                    'query_cache' => 'array',
                    'result_cache' => 'array',
                    'driver' => 'orm_alternative',
                    'generate_proxies' => true,
                    'proxy_dir' => 'data/DoctrineORMModule/Proxy',
                    'proxy_namespace' => 'DoctrineORMModule\Proxy',
                    'filters' => array()
                )
            ),
        ),
    )
);