<?php

namespace App\Repository;

use App\Entity\Wallet;
use App\Repository\Contracts\WalletRepository as IWalletRepository;
use Illuminate\Support\Facades\DB;

class WalletRepository implements IWalletRepository
{
    public function add(Wallet $wallet): Wallet
    {
        return Wallet::create(['user_id' => $wallet->user_id]);
    }

    public function findByUser(int $userId): ?Wallet
    {
        return Wallet::where('user_id', $userId)->first();
    }

    public function findByUserAndCurrency(int $userId, int $currencyId): ?Wallet
    {
        return DB::table('users')->where('users.id', $userId)
            ->join('wallets', 'wallets.user_id', '=', 'users.id')
            ->join('money', 'money.wallet_id', '=', 'wallets.id')
            ->where('money.currency_id', $currencyId)
            ->first();
//        return Wallet::where(['user_id' => $userId, 'currency_id' => $currencyId])->first();
    }
}
