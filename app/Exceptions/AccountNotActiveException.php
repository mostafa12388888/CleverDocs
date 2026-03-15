<?php

namespace App\Exceptions;

use App\Enum\HttpStatusCodeEnum;
use Exception;

class AccountNotActiveException extends Exception implements IApplicationException
{
    /**
     * AccountNotActiveException constructor.
     *
     * @param int $code
     */
    public function __construct($code = HttpStatusCodeEnum::FORBIDDEN)
    {
        $message = trans('validation.messages.account_not_active');
        parent::__construct($message, $code);
    }
}
