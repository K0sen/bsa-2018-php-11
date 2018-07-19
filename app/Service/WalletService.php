<?php

namespace App\Service;

use App\Entity\Money;
use App\Entity\Wallet;
use App\Request\Contracts\CreateWalletRequest;
use App\Request\Contracts\MoneyRequest;
use App\Service\Contracts\WalletService as IWalletService;

class WalletService implements IWalletService
{
    public function addWallet(CreateWalletRequest $walletRequest): Wallet
    {
        // TODO: Implement addWallet() method.
    }

    public function addMoney(MoneyRequest $moneyRequest): Money
    {
        // TODO: Implement addMoney() method.
    }

    public function takeMoney(MoneyRequest $moneyRequest): Money
    {
        // TODO: Implement takeMoney() method.
    }
}
