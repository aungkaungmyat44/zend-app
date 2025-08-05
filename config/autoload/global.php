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
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\AdapterServiceFactory;

return [
    'service_manager' => [
        'factories' => [
            'Zend\Db\Adapter\AdapterInterface' => \Zend\Db\Adapter\AdapterServiceFactory::class,
        ],
    ],
    'db' => [
        'driver'   => 'Pdo',
        'dsn'      => 'mysql:dbname=albums;host=127.0.0.1',
        'username' => 'root',
        'password' => '12345',
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
        ],
    ]
];
