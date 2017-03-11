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
    /**
     * Compare user balance with amount which needed to be withdrawn.
     * If balance less than amount - returns false, else - true
     *
     * @inheritdoc
     */
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
