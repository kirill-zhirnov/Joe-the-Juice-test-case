<?php
declare(strict_types=1);

namespace App;

/**
 * @property-read string $name
 * @property-read string $address
 * @property-read AccountInterface[] $accounts
 */
class Bank extends Component implements BankInterface, OperationsInterface
{
    use Operations;

    /**
     * @var AccountInterface[]
     */
    protected array $accounts = [];

    public function __construct(
        protected string $name,
        protected string $address
    ) {
    }

    public function getPostalAddressForPrintLabels(): string
    {
        return $this->name . "\n" . $this->address;
    }

    public function addAccount(AccountInterface $account): self
    {
        $this->accounts[$account->getAccountNumber()] = $account;
        return $this;
    }

    /**
     * @return AccountInterface[]
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    public function findAccount(string $accountNumber): AccountInterface|null
    {
        return $this->accounts[$accountNumber] ?? null;
    }
}
