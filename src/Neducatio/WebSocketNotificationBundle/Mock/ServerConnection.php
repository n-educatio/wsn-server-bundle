<?php
namespace Neducatio\WebSocketNotificationBundle\Mock;

use Neducatio\WebSocketNotificationBundle\ServerConnection as BaseServerConnection;

/**
 * Mock of ServerConnection for testing purposes
 */
class ServerConnection extends BaseServerConnection
{

  public function __construct()
  {
    // do nothing
  }

  public function push($channel, $messageData)
  {
    // do nothing
    $channel;
    $messageData;
  }

  public function manageSubscriberChannel($subscriber, $channel, $action)
  {
    // do nothing
    $subscriber;
    $channel;
    $action;
  }
}
