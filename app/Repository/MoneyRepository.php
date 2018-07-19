<?php

namespace App\Repository;

use App\Entity\Money;
use App\Repository\Contracts\MoneyRepository as IMoneyRepository;

class MoneyRepository implements IMoneyRepository
{
    public function save(Money $money): Money
    {
        return Money::updateOrCreate(
            ['wallet_id' => $money->wallet_id, 'currency_id' => $money->currency_id],
            ['amount' => $money->amount]
        );
    }

    public function findByWalletAndCurrency(int $walletId, int $currencyId): ?Money
    {
        return Money::where(['wallet_id' => $walletId, 'currency_id' => $currencyId])->first();
    }

    public function findByUserAndCurrency(int $userId, int $currencyId): ?Money
    {
        return Money::where(['user_id' => $userId, 'currency_id' => $currencyId])->first();
    }
}
