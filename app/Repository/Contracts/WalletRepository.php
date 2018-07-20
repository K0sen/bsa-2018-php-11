<?php

namespace App\Repository\Contracts;

use App\Entity\Wallet;

interface WalletRepository
{
    public function add(Wallet $wallet) : Wallet;

    public function findByUser(int $userId) : ?Wallet;

    public function findByUserAndCurrency(int $userId, int $currencyId): ?Wallet;
}
