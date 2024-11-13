<?php

namespace App;

trait Operations
{
    public function doInternalTransaction(
        AccountInterface $fromAccount,
        AccountInterface $toAccount,
        string $amount
    ): bool {
        if ($this->findAccount($fromAccount->getAccountNumber())
            && $this->findAccount($toAccount->getAccountNumber())
        ) {
            $fromAccount->addWithdrawal($amount);
            $toAccount->addDeposit($amount);

            return true;
        }

        return false;
    }
}
