<?php

namespace App\Exceptions\Dashboard;

use App\Enum\HttpStatusCodeEnum;
use App\Exceptions\IApplicationException;
use Exception;

class InvalidColumnTypeException extends Exception implements IApplicationException
{
    protected array $errors;

    public function __construct(string $fieldName, int $code = HttpStatusCodeEnum::UNPROCESSABLE_ENTITY)
    {
        $message = trans('validation.messages.invalid_field', [
            'field' => $fieldName
        ]);

        $this->errors = [
            'field' => $fieldName,
        ];

        parent::__construct($message, $code);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
