<?php

namespace App\Exceptions\Form;

use App\Enum\HttpStatusCodeEnum;
use App\Exceptions\IApplicationException;
use Exception;

class FormSubmissionHasVersionsException extends Exception implements IApplicationException
{
    public function __construct($code = HttpStatusCodeEnum::NOT_FOUND)
    {
        $message = trans('validation.messages.cant_delete_form_submission_with_versions');
        parent::__construct($message, $code);
    }
}
