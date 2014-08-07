<?php
namespace Neducatio\WebSocketNotificationBundle\Tests;

use Neducatio\WebSocketNotificationBundle\ServerCommand;
use Neducatio\WebSocketNotification\Common\Logger as SimpleLogger;
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
   * Test for ServerCommand::setConfiguration
   *
   * @test
   */
  public function setConfiguration()
  {
    $config = ['foo' => 'bar'];
    $this->serverCommand->setConfiguration($config);
    $this->assertSame($config, $this->getNonPublicProperty('bundleConfiguration'));
  }

  /**
   * Test for ServerCommand::setSessionHandler
   *
   * @test
   */
  public function setSessionHandler()
  {
    $sessionHandler = m::mock('SessionHandler');
    $this->serverCommand->setSessionHandler($sessionHandler);
    $this->assertSame($sessionHandler, $this->getNonPublicProperty('sessionHandler'));
  }

  /**
   * Test for ServerCommand::setLogger
   *
   * @test
   */
  public function setLogger()
  {
    $logger = new SimpleLogger();
    $this->serverCommand->setLogger($logger);
    $this->assertSame($logger, $this->getNonPublicProperty('logger'));
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

  private function getNonPublicProperty($name)
  {
    $propertyReflection = new \ReflectionProperty('Neducatio\WebSocketNotificationBundle\ServerCommand', $name);
    $propertyReflection->setAccessible(true);

    return $propertyReflection->getValue($this->serverCommand);
  }
}
