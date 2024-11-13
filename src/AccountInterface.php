<?php

namespace App;

interface AccountInterface
{
    /**
     * Top up the account
     *
     * @param string $amount For decimals, use dot, e.g. '100.01'
     * @return $this
     */
    public function addDeposit(string $amount): self;

    /**
     * Withdraw money from the account.
     *
     * @param string $amount For decimals, use dot, e.g. '100.01'
     * @return $this
     */
    public function addWithdrawal(string $amount): self;

    /**
     * Returns current balance
     * @return string
     */
    public function getBalance(): string;

    /**
     * Returns history. History could be filtered by the type of operation.
     *
     * @param TransactionType|null $filterByType
     * @return array
     */
    public function getHistory(?TransactionType $filterByType = null): array;

    public function getAccountNumber(): string;
}
