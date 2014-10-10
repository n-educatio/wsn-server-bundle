<?php
namespace Neducatio\WebSocketNotificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * WebSocketNotificationExtension
 */
class NeducatioWebSocketNotificationExtension extends Extension
{

  public function load(array $configs, ContainerBuilder $container)
  {
    $config = $this->processConfiguration(new Configuration(), $configs);
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

    $loader->load('services.yml');
    $container
      ->getDefinition('neducatio_websocketnotification.wsn_server_connection')
      ->addArgument(['host' => $config['host'], 'port' => $config['port']]);

    $loader->load('commands.yml');

    $serverCommandDefinition = $container->getDefinition('neducatio_websocketnotification.wsn_server_command');

    $serverCommandDefinition->addMethodCall('setConfiguration', [$config]);

    if (null !== $config['session_handler']) {
      $serverCommandDefinition->addMethodCall('setSessionHandler', [new Reference($config['session_handler'])]);
    }

    if (null !== $config['logger']) {
      $serverCommandDefinition->addMethodCall('setLogger', [new Reference($config['logger'])]);
    }
  }
}
