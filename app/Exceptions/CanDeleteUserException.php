<?php

namespace App\Exceptions;

use App\Enum\HttpStatusCodeEnum;
use Exception;

class CanDeleteUserException extends Exception implements IApplicationException
{
public function __construct( $code = HttpStatusCodeEnum::UNAUTHORIZED){
        $message=trans('validation.messages.cant_delete_update_has_user');
        parent::__construct($message,$code);
}
}
