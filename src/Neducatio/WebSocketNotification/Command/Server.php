<?php
namespace Neducatio\WebSocketNotification\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\DependencyInjection\Container,
    Symfony\Component\DependencyInjection\ContainerInterface;
use Ratchet\Http\HttpServer,
    Ratchet\Server\IoServer,
    Ratchet\Wamp\WampServer,
    Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory,
    React\Socket\Server as SocketServer,
    React\ZMQ\Context;
use Neducatio\WebSocketNotification\Server as RTNServer;

/**
 * Server
 */
class Server extends Command
{
  /**
   * @var Container
   */
  protected $container;

  /**
   *
   * @var logger
   */
  protected $logger;

  /**
   * Set container
   *
   * @param ContainerInterface $container
   */
  public function setContainer(ContainerInterface $container)
  {
    $this->container = $container;
  }

  protected function configure()
  {
    $this
      ->setName('neducatio:wsn-server:run')
      ->setDescription('Start websocket notification server')
      ->addOption(
        'port',
        'p',
        InputOption::VALUE_OPTIONAL
      )
      ->addOption(
        'host',
        'H',
        InputOption::VALUE_OPTIONAL
      )
      ->addOption(
        'websocket-port',
        'w',
        InputOption::VALUE_OPTIONAL
      );
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $configuration = $this->processConfiguration($input);

    $loop      = Factory::create();
    $rtnServer = new RTNServer($this->logger);
    $context   = new Context($loop);
    $pull      = $context->getSocket(\ZMQ::SOCKET_PULL);
    $pull->bind($pullAddress = sprintf('tcp://%s:%d', $configuration['host'], (int) $configuration['port']));
    $pull->on('message', array($rtnServer, 'onServerPush'));

    $webSocket = new SocketServer($loop);
    $webSocket->listen((int) $configuration['websocket-port'], '0.0.0.0');

    new IoServer(
      new HttpServer(
        new WsServer(
          new WampServer(
            $rtnServer
          )
        )
      ),
      $webSocket
    );

    $output->writeln("Pull server is running on <info>$pullAddress</info>");
    $output->writeln("WebSocket server is listening on port <info>${configuration['websocket-port']}</info>");
    $loop->run();
  }

  protected function getSessionHandler()
  {
    return $this->container->get('session_handler');
  }

  protected function processConfiguration($commandLineInput)
  {
    if (null === $this->container) {
      throw new \RuntimeException('No container was set, provide one.');
    }

    $this->logger = $this->container->get('logger');

    $config = [];

    foreach(['host', 'port', 'websocket-port'] as $paramaterName) {
      $config[$paramaterName] = (null !== ($parameter = $commandLineInput->getOption($paramaterName)))
        ? $parameter
        : $this->container->getParameter($paramaterName);
    }

    return $config;
  }
}