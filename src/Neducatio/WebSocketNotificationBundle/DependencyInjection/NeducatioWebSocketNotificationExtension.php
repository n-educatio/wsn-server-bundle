<?php
namespace Neducatio\WebSocketNotificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

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
      ->getDefinition('neducatio_websocketnotification.wsn_server_pusher')
      ->addArgument(['host' => $config['host'], 'port' => $config['port']]);

    $loader->load('commands.yml');
    $container
      ->getDefinition('neducatio_websocketnotification.wsn_server_command')
      ->addMethodCall('setConfiguration', [$config]);
  }
}
