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
}
