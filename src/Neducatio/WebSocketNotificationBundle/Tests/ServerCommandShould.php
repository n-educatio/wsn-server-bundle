<?php
namespace Neducatio\WebSocketNotificationBundle\Tests;

use Neducatio\WebSocketNotificationBundle\ServerCommand;
use Mockery as m;

/**
 * ServerCommandShould
 */
class ServerCommandShould extends \PHPUnit_Framework_TestCase
{

  private $serverCommand;

  /**
   * Test for __construct
   *
   * @test
   */
  public function beInstanceOfServerCommand()
  {
    $this->assertInstanceOf('Neducatio\WebSocketNotificationBundle\ServerCommand', $this->serverCommand);
  }

  /**
   * {@inheritdoc}
   */
  public function setUp()
  {
    $this->serverCommand = new ServerCommand();
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
