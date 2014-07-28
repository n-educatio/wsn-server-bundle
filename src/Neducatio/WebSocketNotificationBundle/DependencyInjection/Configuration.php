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
    $rootNode = $treeBuilder->root('neducatio_wsnserver');

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
            ->defaultValue(null)
        ->end()
        ->scalarNode('session_handler')
            ->defaultValue(null)
        ->end()
      ->end();

      return $treeBuilder;
    }
}
