<?php

namespace App\Service\Contracts;

use App\Entity\Money;
use App\Entity\Wallet;
use App\Request\Contracts\CreateWalletRequest;
use App\Request\Contracts\MoneyRequest;
use App\User;

interface WalletService
{
    /**
     * Add wallet to user.
     *
     * @param CreateWalletRequest $walletRequest
     * @return Wallet
     */
    public function addWallet(CreateWalletRequest $walletRequest) : Wallet;

    /**
     * Add money to a wallet.
     *
     * @param MoneyRequest $moneyRequest
     * @return Money
     */
    public function addMoney(MoneyRequest $moneyRequest) : Money;

    /**
     * Take money from a wallet.
     *
     * @param MoneyRequest $moneyRequest
     * @return Money
     */
    public function takeMoney(MoneyRequest $moneyRequest) : Money;

    public function makeExchange(int $sellerId, User $buyer, float $amount, int $currencyId): void;
}
