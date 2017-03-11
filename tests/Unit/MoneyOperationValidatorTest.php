<?php

namespace Tests\Unit;

use App\Validators\MoneyOperationValidator;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Tests\TestCase;

class MoneyOperationValidatorTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @var MoneyOperationValidator
     */
    private $validator;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->validator = new MoneyOperationValidator();
    }

    /**
     * @covers MoneyOperationValidator::balanceMoreThanWithdrawAmount()
     */
    public function testBalanceMoreThanWithdrawAmount()
    {
        $this->seeInDatabase('user', ['id' => 1, 'balanse' => 100]);
    }
}


