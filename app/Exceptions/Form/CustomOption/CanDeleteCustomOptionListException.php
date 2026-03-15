<?php

namespace App\Exceptions\Form\CustomOption;

use App\Enum\HttpStatusCodeEnum;
use App\Exceptions\IApplicationException;
use Exception;

class CanDeleteCustomOptionListException extends Exception implements IApplicationException
{
    public function __construct(array $formNames = [], int $code = HttpStatusCodeEnum::UNAUTHORIZED)
    {
        $message = trans('validation.messages.cannot_delete_custom_option_list', [
            'forms' => implode(', ', $formNames),
        ]);

        parent::__construct($message, $code);
    }
}
