<?php

namespace App\Exceptions\Distribution;

use App\Enum\HttpStatusCodeEnum;
use App\Exceptions\IApplicationException;
use Exception;

class CanDeleteDistributionInbox extends Exception implements IApplicationException
{
    protected $errors;

    public function __construct($code = HttpStatusCodeEnum::UNAUTHORIZED, array $errors = [])
    {
        $message = trans('validation.messages.distribution_list_has_inbox');
        $this->errors = $errors;
        parent::__construct($message, $code);

    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
