<?php

namespace App\Exceptions;

use App\Enum\HttpStatusCodeEnum;
use Exception;

class CanDeleteMyAccountException extends Exception implements IApplicationException
{
    public function __construct($code = HttpStatusCodeEnum::UNAUTHORIZED)
    {
        $message = trans('validation.messages.cant_delete_has_Account');
        parent::__construct($message, $code);
    }
}
