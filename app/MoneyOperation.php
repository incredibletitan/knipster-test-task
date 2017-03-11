<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MoneyOperation extends Model
{
    /**
     * Identify DEPOSIT operation
     */
    const TYPE_DEPOSIT = 1;

    /**
     * Identify WITHDRAW operation
     */
    const TYPE_WITHDRAW = 2;

    /**
     * @inheritdoc
     */
    protected $table = 'money_operation';

    /**
     * @inheritdoc
     */
    protected $fillable = ['type', 'user_id', 'amount'];

    /**
     * Creates deposit money operation
     *
     * @param array $params
     */
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

    /**
     * Creates withdraw money operation
     *
     * @param array $params
     */
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

    public static function report($dateStart, $dateEnd)
    {
        $query = <<< SQL
SELECT 
	CAST(created AS DATE) `date`, 
	COUNT(DISTINCT `user_id`) AS `unique_customers`, 
	country,
	IFNULL(SUM(`number_of_deposits`), "0") AS `number_of_deposits`, 
	IFNULL(SUM(`total_deposit_amount`), "0") AS `total_deposit_amount`,
	IFNULL(SUM(`number_of_withdraws`), "0") AS `number_of_withdraws`, 
	IFNULL(SUM(`total_withdraws_amount`), "0") AS `total_withdraws_amount`
FROM (
	(
		SELECT
			`u`.id AS `user_id`,
			`u`.`country` AS `country`,
			`mo`.`created_at` AS `created`,
			COUNT(`mo`.id)  AS `number_of_deposits`, 
			SUM(`mo`.amount) AS `total_deposit_amount`,
			NULL `number_of_withdraws`,
			NULL `total_withdraws_amount`
			FROM `money_operation` `mo`
			JOIN `user` `u`
				ON `u`.id = `mo`.user_id
				WHERE `mo`.type = 1
				GROUP BY `u`.`country`, CAST(created AS DATE)
	) 
	UNION
	(
		SELECT
			`u`.id AS `user_id`,
			`u`.`country` AS `country`,
			`mo`.`created_at` AS `created`,
			NULL `number_of_deposits`,
			NULL `total_deposit_amount`,
			COUNT(`mo`.id)  AS `number_of_withdraws`, 
			SUM(`mo`.amount) AS `total_withdraws_amount`
			FROM `money_operation` `mo`
			JOIN `user` `u`
				ON `u`.id = `mo`.user_id
				WHERE `mo`.type = 2
				GROUP BY `u`.`country`, CAST(created AS DATE)
	)
) `total`
WHERE CAST(created AS DATE) >=:date_start AND CAST(created AS DATE) <=:date_end
GROUP BY country, CAST(created AS DATE)
SQL;
        return DB::select(DB::raw($query), [':date_start' => $dateStart, ':date_end' => $dateEnd]);
    }
}
