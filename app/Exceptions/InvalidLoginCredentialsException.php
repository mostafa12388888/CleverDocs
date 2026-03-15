<?php

namespace App\Exceptions;

use App\Enum\HttpStatusCodeEnum;
use Exception;

class InvalidLoginCredentialsException  extends Exception implements  IApplicationException
{
    /**
     * ForbiddenAction constructor.
     * @param int $code
     */
    public function __construct($code = HttpStatusCodeEnum::UNAUTHORIZED)
    {
        $message = trans('validation.messages.invalid_login_credentials');
        parent::__construct($message, $code);
    }
}
