<?php

namespace App\Repository;

use App\Entity\Money;
use App\Repository\Contracts\MoneyRepository as IMoneyRepository;
use Illuminate\Support\Facades\DB;

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

    /**
     * @param int $userId
     * @param int $currencyId
     * @return Money|null
     */
    public function findByUserAndCurrency(int $userId, int $currencyId): ?Money
    {
        $query = DB::table('users')->where('users.id', $userId)
            ->join('wallets', 'wallets.user_id', '=', 'users.id')
            ->join('money', 'money.wallet_id', '=', 'wallets.id')
            ->where('money.currency_id', $currencyId)
            ->get(['money.id as money_id'])
            ->first();

        return $query ? Money::find($query->money_id) : null;
    }
}
