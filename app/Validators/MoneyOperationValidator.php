<?php

namespace App\Validators;

use App\User;

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
        return ($balance = $this->getUserBalance($userId)) && $balance >= $value ;
    }

    /**
     * Compare user balance with amount which needed to be withdrawn.
     * If balance less than amount - returns false, else - true
     *
     * @inheritdoc
     */
    public function dateStartLessOrEqualThanEnd($attribute, $value, $parameters, $validator)
    {
        if (!isset($parameters[0]) ||
            !($comparedDate = array_get($validator->getData(), $parameters[0]))
        ) {
            return false;
        }
        return strtotime($value) <= strtotime($comparedDate);
    }

    /**
     * Returns user balance if
     *
     * @param $userId
     * @return null
     */
    protected function getUserBalance($userId)
    {
        return ($user = User::find($userId)) ? $user->balance : null;
    }
}
