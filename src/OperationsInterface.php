<?php
declare(strict_types=1);

namespace App;

interface OperationsInterface
{
    /**
     * Do internal transfer. Returns true on success or false if one of the account isn't internal.
     *
     * @param AccountInterface $fromAccount
     * @param AccountInterface $toAccount
     * @param string $amount
     * @return bool
     */
    public function doInternalTransaction(
        AccountInterface $fromAccount,
        AccountInterface $toAccount,
        string $amount
    ): bool;
}
