<?php

namespace App\Request;


use App\Request\Contracts\MoneyRequest as IMoneyRequest;

class MoneyRequest implements IMoneyRequest
{
    private $walletId;
    private $currencyId;
    private $amount;

    /**
     * MoneyRequest constructor.
     *
     * @param int   $walletId
     * @param int   $currencyId
     * @param float $amount
     */
    public function __construct(int $walletId, int $currencyId, float $amount)
    {
        $this->walletId = $walletId;
        $this->currencyId = $currencyId;
        $this->amount = $amount;
    }

    /**
     * Gets WalletId.
     *
     * @return int
     */
    public function getWalletId(): int
    {
        return $this->walletId;
    }

    /**
     * Gets CurrencyId.
     *
     * @return int
     */
    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }

    /**
     * Gets Amount.
     *
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}