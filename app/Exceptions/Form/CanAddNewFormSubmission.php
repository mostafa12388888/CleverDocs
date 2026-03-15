<?php

namespace App\Exceptions\Form;

use App\Enum\HttpStatusCodeEnum;
use App\Exceptions\IApplicationException;
use Exception;

class CanAddNewFormSubmission extends Exception implements IApplicationException
{
    public function __construct($code = HttpStatusCodeEnum::NOT_FOUND)
    {
        $message = trans('validation.messages.cant_add_form_submission');
        parent::__construct($message, $code);
    }
}
