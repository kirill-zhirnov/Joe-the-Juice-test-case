<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Account;
use App\Bank;
use Tests\Support\UnitTester;

class BankTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testPostalAddressForPrintLabels()
    {
        $bank = new Bank('Barclays', 'Piccadilly Circus, London, UK');
        $this->assertEquals("Barclays\nPiccadilly Circus, London, UK", $bank->getPostalAddressForPrintLabels());
        $this->assertEquals('Barclays', $bank->name);
        $this->assertEquals('Piccadilly Circus, London, UK', $bank->address);
    }

    public function testAddAndGetAccounts()
    {
        $accountA = new Account('A');
        $accountB = new Account('B');

        $bank = new Bank('Barclays', 'Piccadilly Circus, London, UK');
        $bank
            ->addAccount($accountA)
            ->addAccount($accountB)
        ;

        foreach ($bank->getAccounts() as $key => $account) {
            $this->assertEquals($key, $account->getAccountNumber());
        }
    }

    public function testFindAccount()
    {
        $accountA = new Account('A');
        $accountB = new Account('B');

        $bank = new Bank('Barclays', 'Piccadilly Circus, London, UK');
        $bank
            ->addAccount($accountA)
            ->addAccount($accountB)
        ;

        $this->assertNull($bank->findAccount('C'));
        $this->assertEquals($accountA, $bank->findAccount('A'));
    }

    public function testInternalTransactions()
    {
        $accountA = new Account('A');
        $accountA->addDeposit('100');

        $accountB = new Account('B');
        $this->assertEquals('100.00', $accountA->balance);
        $this->assertEquals('0.00', $accountB->balance);

        $bank = new Bank('Barclays', 'Piccadilly Circus, London, UK');
        $bank
            ->addAccount($accountA)
            ->addAccount($accountB)
        ;

        $this->assertTrue(
            $bank->doInternalTransaction($accountA, $accountB, '100.00')
        );
        $this->assertEquals('0.00', $accountA->balance);
        $this->assertEquals('100.00', $accountB->balance);

        $this->assertFalse(
            $bank->doInternalTransaction(new Account('C'), $accountB, '100.00')
        );
    }
}
