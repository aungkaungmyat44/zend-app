<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Album;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    const VERSION = '3.1.4dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\AlbumTable::class => function($container) {
                    $tableGateway = $container->get(Model\AlbumGateway::class);
                    return new Model\AlbumTable($tableGateway);
                },
                Model\AlbumGateway::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album);
                    return new TableGateway('artists', $dbAdapter, null, $resultSetPrototype);
                },
            ]        
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                    \Album\Controller\AlbumController::class => function($container) {
                    return new \Album\Controller\AlbumController(
                        "Artist Album",
                        $container->get(Model\AlbumTable::class)
                    );
                },
            ],
        ];
    }
}
