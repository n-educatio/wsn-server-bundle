<?php
namespace Neducatio\WebSocketNotificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle Configuration
 */
class Configuration implements ConfigurationInterface
{
  public function getConfigTreeBuilder()
  {
    $treeBuilder = new TreeBuilder();
    $rootNode = $treeBuilder->root('biera_rtnserver');

    $rootNode
      ->children()
        ->scalarNode('host')
          ->defaultValue('127.0.0.1')
          ->cannotBeEmpty()
        ->end()
        ->scalarNode('port')
          ->defaultValue(5555)
          ->cannotBeEmpty()
        ->end()
        ->scalarNode('websocket-port')
          ->defaultValue(8080)
          ->cannotBeEmpty()
        ->end()
        ->scalarNode('logger')
        ->end()
      ->end();

      return $treeBuilder;
    }
}