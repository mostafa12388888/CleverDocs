<?php

namespace App\Exceptions\Contact;

use App\Enum\HttpStatusCodeEnum;
use App\Exceptions\IApplicationException;
use Exception;

class CanDeleteContactHasUserOrKeyContactException extends Exception implements IApplicationException
{
    protected $errors;

    public function __construct($code = HttpStatusCodeEnum::UNAUTHORIZED, array $errors = [])
    {
        $message = trans('validation.messages.cant_delete_has_user_or_key_contact');
        $this->errors = $errors;
        parent::__construct($message, $code);

    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

