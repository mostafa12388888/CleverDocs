<?php

namespace App\Exceptions\Form;

use App\Enum\HttpStatusCodeEnum;
use App\Exceptions\IApplicationException;
use Exception;

class FormNotAttachedToProjectException extends Exception implements IApplicationException
{
    public function __construct($code = HttpStatusCodeEnum::NOT_FOUND)
    {
        $message = trans('validation.messages.form_not_attached_to_project');
        parent::__construct($message, $code);
    }
}
