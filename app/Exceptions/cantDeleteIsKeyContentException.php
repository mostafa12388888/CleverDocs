<?php

namespace App\Exceptions;

use App\Enum\HttpStatusCodeEnum;
use Exception;

class cantDeleteIsKeyContentException extends Exception implements IApplicationException
{
    public function __construct($code = HttpStatusCodeEnum::UNAUTHORIZED)
    {
        $message = trans('validation.messages.cant_delete_is_key_content');
        parent::__construct($message, $code);
    }
}
