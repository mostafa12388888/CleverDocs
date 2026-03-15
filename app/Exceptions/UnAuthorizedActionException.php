<?php

namespace App\Exceptions;

use Exception;

class UnAuthorizedActionException extends Exception
{
    /**
     * UnAuthorizedAction constructor.
     * @param string $message
     */
    public function __construct(string $message = "unAuthorized")
    {
        parent::__construct($message);
    }
}
