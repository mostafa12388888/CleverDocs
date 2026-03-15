<?php

namespace App\Exceptions\Users;
use App\Exceptions\IApplicationException;
use App\Enum\HttpStatusCodeEnum;
use Exception;

class CanNotChangeNewPasswordSameOldPasswordException extends Exception implements IApplicationException
{
    //
    /**
     * __construct
     *
     * @param  mixed $code
     * @return void
     */
    public function __construct($code = HttpStatusCodeEnum::NOT_FOUND)
    {
        $message = trans('validation.messages.can_not_change_new_password_same_old_password');
        parent::__construct($message, $code);
    }
}
