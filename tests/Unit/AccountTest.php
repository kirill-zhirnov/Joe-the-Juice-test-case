<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Account;
use App\TransactionType;
use Tests\Support\UnitTester;

class AccountTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testAccountNumberAccessibleAsProperty()
    {
        $account = new Account('DK123456');
        $this->assertTrue(isset($account->accountNumber));
        $this->assertEquals('DK123456', $account->accountNumber);
        $this->assertEquals('DK123456', $account->getAccountNumber());
    }

    public function testDepositShouldTopUpAccountAndCreateHistoryRecord()
    {
        $account = new Account('DK123456');

        $account->addDeposit('100');
        $this->assertEquals('100.00', $account->balance);
        $this->assertEquals(1, sizeof($account->history));

        $account->addDeposit('112.23');
        $this->assertEquals('212.23', $account->balance);
        $this->assertEquals(2, sizeof($account->history));

        $this->assertEquals(0, sizeof($account->getHistory(TransactionType::Withdraw)));
        $this->assertEquals(2, sizeof($account->getHistory(TransactionType::Deposit)));
    }

    public function testWidthdrawShouldReduceBalance()
    {
        $account = new Account('DK123456');
        $account->addDeposit('300');

        $account->addWithdrawal('50');
        $account->addWithdrawal('45.45');
        $this->assertEquals('204.55', $account->balance);
        $this->assertEquals(3, sizeof($account->history));
        $this->assertEquals(2, sizeof($account->getHistory(TransactionType::Withdraw)));
        $this->assertEquals(1, sizeof($account->getHistory(TransactionType::Deposit)));
    }
}
