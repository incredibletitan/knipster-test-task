<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MoneyOperation extends Model
{
    const TYPE_DEPOSIT = 1;
    const TYPE_WITHDRAW = 2;

    /**
     * @inheritdoc
     */
    protected $table = 'money_operation';

    protected $fillable = ['type', 'user_id', 'amount'];

    public static function deposit(array $params)
    {
        $mergedParams = array_merge(['type' => self::TYPE_DEPOSIT], $params);

        DB::transaction(function () use ($mergedParams) {
            $moneyOperationModel = self::create($mergedParams);
            $user = User::find($moneyOperationModel->user_id);
            $user->increment('balance', $moneyOperationModel->amount);
            $user->increment('bonus_balance', $moneyOperationModel->amount * $user->bonus_percentage / 100);

            return $moneyOperationModel;
        });
    }

    public static function withdraw(array $params)
    {
        $mergedParams = array_merge(['type' => self::TYPE_WITHDRAW], $params);

        DB::transaction(function () use ($mergedParams) {
            $moneyOperationModel = self::create($mergedParams);
            $user = User::find($moneyOperationModel->user_id);
            $user->decrement('balance', $moneyOperationModel->amount);

            return $moneyOperationModel;
        });
    }
}
