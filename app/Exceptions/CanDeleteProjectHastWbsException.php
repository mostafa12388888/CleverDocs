<?php

namespace App\Exceptions;

use App\Enum\HttpStatusCodeEnum;
use Exception;

class CanDeleteProjectHastWbsException  extends Exception implements IApplicationException
{
    /**
     * ForbiddenAction constructor.
     * @param int $code
     */
    public function __construct($code = HttpStatusCodeEnum::UNAUTHORIZED)
    {
        $message = trans('validation.messages.cant_delete_has_Wbs');
        parent::__construct($message, $code);
    }
}
