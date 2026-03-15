<?php

namespace App\Exceptions\Wbs;

use App\Exceptions\IApplicationException;
use App\Enum\HttpStatusCodeEnum;
use Exception;

class CantDeleteWpsHasChildrenException extends Exception implements IApplicationException
{
    public function __construct($code = HttpStatusCodeEnum::UNAUTHORIZED)
    {
        $message = trans('validation.messages.cant_delete_has_children');
        parent::__construct($message, $code);
    }
}
