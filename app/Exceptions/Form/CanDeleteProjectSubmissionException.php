<?php

namespace App\Exceptions\Form;

use App\Enum\HttpStatusCodeEnum;
use App\Exceptions\IApplicationException;
use Exception;

class CanDeleteProjectSubmissionException  extends Exception implements IApplicationException
{
    public function __construct(array $formNames = [], int $code = HttpStatusCodeEnum::UNAUTHORIZED)
    {
        $message = trans('validation.messages.cannot_delete_project_has_forms', [
            'forms' => implode(', ', $formNames),
        ]);

        parent::__construct($message, $code);
    }
}
