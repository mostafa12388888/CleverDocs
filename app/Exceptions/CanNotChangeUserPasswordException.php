<?php

namespace App\Exceptions;

use App\Enum\HttpStatusCodeEnum;
use Exception;

class CanNotChangeUserPasswordException extends Exception implements IApplicationException
{
    //
    /**
     * __construct
     *
     * @param  mixed $code
     * @return void
     */
    public function __construct($code = HttpStatusCodeEnum::NOT_FOUND)
    {
        $message = trans('validation.messages.cant_change_user_password');
        parent::__construct($message, $code);
    }
}
