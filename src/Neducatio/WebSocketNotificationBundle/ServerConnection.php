<?php
namespace Neducatio\WebSocketNotificationBundle;

use ZMQ, ZMQContext;
use Neducatio\WebSocketNotification\Common\JSON;

/**
 * WebSocket Notification Server Pusher
 */
class ServerConnection
{
  /**
   * @var array
   */
  protected $config;

  /**
   * @var ZMQContext
   */
  protected $context;

  /**
   * @var ZMQSocket
   */
  protected $notificationSocket;

  /**
   * @var ZMQSocket
   */
  protected $managamenetSocket;

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

    $this->context = new ZMQContext();
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
    if (null === $this->notificationSocket) {
      $this->notificationSocket = $this->context->getSocket(ZMQ::SOCKET_PUSH, 'wsn-server-push');
      $this->notificationSocket->connect(sprintf('tcp://%s:%d', $this->config['host'], $this->config['port']));
    }

    $this->notificationSocket->send(JSON::encode(['data' => $messageData, 'channel'=> $channel]));
  }

  public function manageSubscriberChannel($subscriber, $channel, $action)
  {
    if (null === $this->managamenetSocket) {
      $this->managamenetSocket = $this->context->getSocket(ZMQ::SOCKET_PUSH, 'wsn-server-management');
      $this->managamenetSocket->connect(sprintf('tcp://%s:%d', $this->config['host'], $this->config['port'] + 1));
    }

    $this->managamenetSocket->send(JSON::encode([ 'subscriber' => $subscriber, 'channel' => $channel, 'action' => $action]));
  }
}