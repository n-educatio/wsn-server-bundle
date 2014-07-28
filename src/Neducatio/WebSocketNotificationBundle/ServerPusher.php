<?php
namespace Neducatio\WebSocketNotificationBundle;

use ZMQ, ZMQContext;
use Neducatio\WebSocketNotification\Common\JSON;

/**
 * WebSocket Notification Server Pusher
 */
class ServerPusher
{
  /**
   * @var array
   */
  protected $config;

  /**
   * @var \ZMQSocket
   */
  protected $socket;

  /**
   * Constructs class instance
   *
   * @param array $config
   * @throws \InvalidArgumentException
   */
  public function __construct(array $config)
  {
    if (!array_key_exists('host', $config) || !array_key_exists('port', $config)) {
      throw new \InvalidArgumentException();
    }

    $this->config = $config;
  }

  /**
   * Pushes $messageData to $channel
   *
   * @param string $channel     channel
   * @param mixed  $messageData data
   */
  public function push($channel, $messageData)
  {
    if (null === $this->socket) {
      $this->initialize();
    }

    $this->socket->send(JSON::encode(['data' => $messageData, 'channel'=> $channel]));
  }

  protected function initialize()
  {
    $context = new ZMQContext();
    $this->socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'wsn-server-push');
    $this->socket->connect(sprintf('tcp://%s:%d', $this->config['host'], $this->config['port']));
  }
}