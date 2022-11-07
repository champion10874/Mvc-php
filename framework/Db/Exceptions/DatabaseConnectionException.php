<?php

namespace Lora\Core\Framework\Db\Exceptions;

use Exception;

class DatabaseConnectionException extends Exception
{
  public function __construct($message, $code = 0, Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}