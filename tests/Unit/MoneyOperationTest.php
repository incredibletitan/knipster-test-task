<?php

namespace Tests\Unit;

use App\MoneyOperation;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * Class MoneyOperationTest
 *
 * @author Yuriy Stos
 */
class MoneyOperationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @covers MoneyOperation::deposit()
     */
    public function testDeposit()
    {
        $user = User::create(['email' => 'fake1@gg.cc', 'country' => 'ua']);
        $amount = 100;
        $moneyOperation = MoneyOperation::deposit(['user_id' => $user->id, 'amount' => $amount]);
        $resultUser = User::find($user->id);

        $this->assertDatabaseHas(
            'money_operation',
            ['id' => $moneyOperation->id, 'type' => MoneyOperation::TYPE_DEPOSIT]
        );
        $this->assertEquals($user->balance + $amount, $resultUser->balance);
        $this->assertEquals($user->bonus_percentage * $amount / 100, $resultUser->bonus_balance);
    }

    /**
     * @covers MoneyOperation::withdraw()
     */
    public function testWithdraw()
    {
        $user = User::create(['email' => 'fake1@gg.cc', 'country' => 'ua']);
        $amount = 100;
        $moneyOperation = MoneyOperation::withdraw(['user_id' => $user->id, 'amount' => $amount]);
        $resultUser = User::find($user->id);

        $this->assertDatabaseHas(
            'money_operation',
            ['id' => $moneyOperation->id, 'type' => MoneyOperation::TYPE_WITHDRAW]
        );
        $this->assertEquals($user->balance - $amount, $resultUser->balance);
    }

    /**
     * @covers MoneyOperation::testReport()
     */
    public function testReport()
    {
        $user = User::create(['email' => 'fake1@gg.cc', 'country' => 'ua']);
        MoneyOperation::deposit(['user_id' => $user->id, 'amount' => 100]);
        MoneyOperation::withdraw(['user_id' => $user->id, 'amount' => 10]);
        MoneyOperation::withdraw(['user_id' => $user->id, 'amount' => 20]);

        $user2 = User::create(['email' => 'fake2@gg.cc', 'country' => 'ua']);
        MoneyOperation::deposit(['user_id' => $user2->id, 'amount' => 140]);
        MoneyOperation::withdraw(['user_id' => $user2->id, 'amount' => 10]);
        MoneyOperation::withdraw(['user_id' => $user2->id, 'amount' => 20]);

        $user3 = User::create(['email' => 'fake3@gg.cc', 'country' => 'es']);
        MoneyOperation::deposit(['user_id' => $user3->id, 'amount' => 111]);
        MoneyOperation::withdraw(['user_id' => $user3->id, 'amount' => 20]);

        $user4 = User::create(['email' => 'fake4@gg.cc', 'country' => 'es']);
        MoneyOperation::deposit(['user_id' => $user4->id, 'amount' => 111]);

        $user5 = User::create(['email' => 'fake5@gg.cc', 'country' => 'es']);
        MoneyOperation::deposit(['user_id' => $user5->id, 'amount' => 11]);

        $dateStart = date('Y-m-d');
        $dateEnd = $dateStart;

        $reportResult = MoneyOperation::report($dateStart, $dateEnd);

        $this->assertEquals(2, count($reportResult));
        $this->assertEquals([
            'date' => $dateStart,
            'unique_customers' => 3,
            'country' => 'es',
            'number_of_deposits' => '3',
            'total_deposit_amount' => '233',
            'number_of_withdraws' => '1',
            'total_withdraws_amount' => '20',
        ], (array)$reportResult[0]);

        $this->assertEquals([
            'date' => $dateStart,
            'unique_customers' => 2,
            'country' => 'ua',
            'number_of_deposits' => '2',
            'total_deposit_amount' => '240',
            'number_of_withdraws' => '4',
            'total_withdraws_amount' => '60',
        ], (array)$reportResult[1]);
    }
}
