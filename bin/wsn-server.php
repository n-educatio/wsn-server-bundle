<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Symfony\Component\Console\Application,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\Config\FileLocator,
    Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Neducatio\WebSocketNotification\Command\Server;

$container = new ContainerBuilder();
$configurationLoader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__)));
$configurationLoader->load('config.yml');
$container->compile();

$serverCommand = new Server();
$serverCommand->setContainer($container);
//
$application = new Application();
$application->add($serverCommand);
$application->run();