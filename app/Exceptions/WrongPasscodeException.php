<?php

namespace App\Exceptions;

class WrongPasscodeException extends \Exception
{
    public function __construct($message = 'Wrong passcode', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
