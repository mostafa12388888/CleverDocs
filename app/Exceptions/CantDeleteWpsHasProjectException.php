<?php

namespace App\Exceptions;

use App\Enum\HttpStatusCodeEnum;
use Exception;

class CantDeleteWpsHasProjectException  extends Exception implements IApplicationException
{

    protected $errors;

    /**
     * ForbiddenAction constructor.
     * @param int $code
     */
    public function __construct($code = HttpStatusCodeEnum::UNAUTHORIZED, array $errors = [])
    {
        $message = trans('validation.messages.cant_delete_has_projects');
        $this->errors = $errors;
        parent::__construct($message, $code);

    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
