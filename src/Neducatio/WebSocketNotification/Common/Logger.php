<?php
namespace Neducatio\WebSocketNotification\Common;

/**
 * Simple logger that prints everything to STDOUT
 */
class Logger implements Loggable
{
  public function log($level, $message)
  {
    fprintf(STDOUT, "[%s][%s]\t%s\n", date('Y-d-m H:i:s'), $level, $message);
  }
}
