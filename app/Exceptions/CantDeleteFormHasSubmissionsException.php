<?php

namespace App\Exceptions;

use App\Enum\HttpStatusCodeEnum;
use Exception;

class CantDeleteFormHasSubmissionsException  extends Exception implements  IApplicationException
{
    /**
     * ForbiddenAction constructor.
     * @param int $code
     */
    public function __construct($code = HttpStatusCodeEnum::UNAUTHORIZED)
    {
        $message = trans('validation.messages.cant_delete_has_submissions');
        parent::__construct($message, $code);
    }
}
