<?php
declare(strict_types=1);

namespace App;

/**
 * @property-read string $balance
 * @property-read string $accountNumber
 * @property-read array $history
 */
class Account extends Component implements AccountInterface
{
    protected string $balance = '0.00';
    protected array $history = [];

    public function __construct(
        readonly protected string $accountNumber
    ) {
    }

    public function getBalance(): string
    {
        return $this->balance;
    }

    public function addDeposit(string $amount): self
    {
        if (bccomp('0', $amount) == 1) {
            throw new \RuntimeException('Amount must be a positive number');
        }

        $this->balance = bcadd($this->balance, $amount);
        $this->history[] = [
            'type' => TransactionType::Deposit,
            'amount' => $amount
        ];

        return $this;
    }

    public function addWithdrawal(string $amount): self
    {
        if (bccomp('0', $amount) == 1) {
            throw new \RuntimeException('Amount must be a positive number');
        }

        if (bccomp($amount, $this->balance) == 1) {
            throw new \RuntimeException('Insufficient amount, available: ' . $this->balance);
        }

        $this->balance = bcsub($this->balance, $amount);
        $this->history[] = [
            'type' => TransactionType::Withdraw,
            'amount' => $amount
        ];

        return $this;
    }

    public function getHistory(?TransactionType $filterByType = null): array
    {
        return array_values(
            array_filter($this->history, fn (array $row) => !$filterByType || $filterByType == $row['type'])
        );
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }
}
