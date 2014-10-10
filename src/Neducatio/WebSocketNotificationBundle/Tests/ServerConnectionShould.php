<?php
namespace Neducatio\WebSocketNotificationBundle\Tests;

use Neducatio\WebSocketNotificationBundle\ServerConnection;
use Mockery as m;

/**
 * ServerConnectionShould
 */
class ServerConnectionShould extends \PHPUnit_Framework_TestCase
{
  const HOST = 'localhost';
  const PORT = 8888;

  private $serverConnection;

  /**
   * Test for __construct
   *
   * @test
   */
  public function beInstanceOfServerCommand()
  {
    $this->assertInstanceOf('Neducatio\WebSocketNotificationBundle\ServerConnection', $this->serverConnection);
  }

  /**
   * {@inheritdoc}
   */
  public function setUp()
  {
    $this->serverConnection = new ServerConnection(['host' => self::HOST, 'port' =>  self::PORT]);
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
