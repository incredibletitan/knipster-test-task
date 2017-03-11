<?php

namespace App\Http\Validators;

use App\User;

/**
 * Class MoneyOperationValidator
 *
 * @author Yuriy Stos
 */
class MoneyOperationValidator
{
    public function balanceMoreThanWithdrawAmount($attribute, $value, $parameters, $validator)
    {
        if (!isset($parameters[0]) ||
            !($userId = array_get($validator->getData(), $parameters[0]))
        ) {
            return false;
        }
        return ($user = User::find($userId)) ? $user->balance > $value : false;
    }
}
