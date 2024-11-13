<?php

use App\Bank;
use App\Account;
use App\TransactionType;

require '../helpers/bootstrap.php';
require '../vendor/autoload.php';

/**
 * Example of Usage, for more examples please
 * @see \Tests\Unit\AccountTest
 * @see \Tests\Unit\BankTest
 */

$bankName = 'JOE & THE BANK';
$bankAddress = 'Joe Street,\\nCopenhagen';

$bank = new Bank($bankName, $bankAddress);
$postal_address = $bank->getPostalAddressForPrintLabels();
$expected_postal_address = $bankName . "\n" . $bankAddress;
if ($expected_postal_address !== $postal_address) {
    throw new RuntimeException('Failed to get Postal address');
}

$firstAccount = new Account('ab01');
$secondAccount = new Account('qj42');

$bank
    ->addAccount($firstAccount)
    ->addAccount($secondAccount)
;

if (sizeof($bank->accounts) !== 2){
    throw new RuntimeException('Failed to assign accounts');
}

$firstAccount->addDeposit('100');
$bank->doInternalTransaction($firstAccount, $secondAccount, '100');

if (sizeof($secondAccount->getHistory(TransactionType::Deposit)) !== 1) {
    throw new RuntimeException('Failed to deposit to second account');
}

echo "All seems fine !";
