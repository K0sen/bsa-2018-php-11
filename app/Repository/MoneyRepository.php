<?php

namespace App\Repository;

use App\Entity\Money;
use App\Repository\Contracts\MoneyRepository as IMoneyRepository;

class MoneyRepository implements IMoneyRepository
{
    public function save(Money $money): Money
    {
        // TODO: Implement save() method.
    }

    public function findByWalletAndCurrency(int $walletId, int $currencyId): ?Money
    {
        // TODO: Implement findByWalletAndCurrency() method.
    }
}
