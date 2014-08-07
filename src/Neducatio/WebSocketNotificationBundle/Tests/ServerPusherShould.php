<?php
namespace Neducatio\WebSocketNotificationBundle\Tests;

use Neducatio\WebSocketNotificationBundle\ServerPusher;
use Mockery as m;

/**
 * ServerPusherShould
 */
class ServerPusherShould extends \PHPUnit_Framework_TestCase
{
  const HOST = 'localhost';
  const PORT = 8888;

  private $serverPusher;

  /**
   * Test for __construct
   *
   * @test
   */
  public function beInstanceOfServerCommand()
  {
    $this->assertInstanceOf('Neducatio\WebSocketNotificationBundle\ServerPusher', $this->serverPusher);
  }

  /**
   * {@inheritdoc}
   */
  public function setUp()
  {
    $this->serverPusher = new ServerPusher(['host' => self::HOST, 'port' =>  self::PORT]);
    parent::setUp();
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown()
  {
    m::close();
    parent::tearDown();
  }
}
