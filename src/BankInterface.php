<?php

namespace App;

interface BankInterface
{
    /**
     * Returns an Address
     * @return string
     */
    public function getPostalAddressForPrintLabels(): string;

    /**
     * Add an Account
     * @param AccountInterface $account
     * @return $this
     */
    public function addAccount(AccountInterface $account): self;

    /**
     * Returns accounts list.
     * @return array
     */
    public function getAccounts(): array;

    public function findAccount(string $accountNumber): AccountInterface|null;
}
