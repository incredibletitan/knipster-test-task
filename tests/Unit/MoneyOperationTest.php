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
}
