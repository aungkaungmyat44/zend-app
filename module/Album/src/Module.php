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
use Album\Model\Album;
use Album\Model\AlbumTable;
use Album\Form\AlbumForm;
use Album\Controller\AlbumController;
use Zend\ServiceManager\Factory\InvokableFactory;

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
                AlbumTable::class => function($container) {
                    $tableGateway = $container->get(AlbumGateway::class);
                    return new AlbumTable($tableGateway);
                },
                AlbumGateway::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Album);
                    return new TableGateway('artists', $dbAdapter, null, $resultSetPrototype);
                },
                AlbumForm::class => InvokableFactory::class
            ]        
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                    AlbumController::class => function($container) {
                    return new AlbumController(
                        "Artist Album",
                        $container->get(AlbumTable::class),
                        $container->get(AlbumForm::class)
                    );
                },
            ],
        ];
    }
}
