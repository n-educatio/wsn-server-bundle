<?php
namespace Neducatio\WebSocketNotificationBundle;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;
use Neducatio\WebSocketNotification\Command\Server as BaseCommand,
    Neducatio\WebSocketNotification\Common\Logger as SimpleLogger;

/**
 * WebSocket Notification Server Command
 */
class ServerCommand extends BaseCommand
{
  /**
   * @var array
   */
  protected $bundleConfiguration;

  /**
   * Sets configuration
   *
   * @param array $configuration
   */
  public function setConfiguration(array $configuration)
  {
    $this->bundleConfiguration = $configuration;
  }

  protected function processConfiguration($commandLineInput)
  {
    $config = [];

    $this->logger = new SimpleLogger();

    foreach(['host', 'port', 'websocket-port'] as $paramaterName) {
      $config[$paramaterName] = (null !== ($parameter = $commandLineInput->getOption($paramaterName)))
        ? $parameter
        : $this->bundleConfiguration[$paramaterName];
    }

    return $config;
  }
}
