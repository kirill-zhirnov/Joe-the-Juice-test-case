<?php
declare(strict_types=1);

namespace App;

enum TransactionType: string
{
    case Deposit = 'deposit';
    case Withdraw = 'withdraw';
}
