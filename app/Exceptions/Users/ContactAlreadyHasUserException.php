<?php

namespace App\Exceptions\Users;

use App\Enum\HttpStatusCodeEnum;
use App\Exceptions\IApplicationException;
use Exception;

class ContactAlreadyHasUserException  extends Exception implements  IApplicationException
{
    /**
     * ForbiddenAction constructor.
     * @param int $code
     */
    public function __construct($code = HttpStatusCodeEnum::UNAUTHORIZED)
    {
        $message = trans('validation.messages.this_contact_already_has_users');
        parent::__construct($message, $code);
    }
}
