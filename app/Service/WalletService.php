<?php

namespace App\Service;

use App\Entity\Money;
use App\Entity\Wallet;
use App\Exceptions\MarketException\IncorrectPriceException;
use App\Repository\Contracts\MoneyRepository;
use App\Repository\Contracts\WalletRepository;
use App\Request\Contracts\CreateWalletRequest;
use App\Request\Contracts\MoneyRequest;
use App\Service\Contracts\WalletService as IWalletService;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WalletService implements IWalletService
{
    private $walletRepository;
    private $moneyRepository;

    /**
     * WalletService constructor.
     *
     * @param WalletRepository $walletRepository
     * @param MoneyRepository  $moneyRepository
     */
    public function __construct(WalletRepository $walletRepository, MoneyRepository $moneyRepository)
    {
        $this->walletRepository = $walletRepository;
        $this->moneyRepository = $moneyRepository;
    }

    public function addWallet(CreateWalletRequest $walletRequest): Wallet
    {
        if ($wallet = $this->walletRepository->findByUser($walletRequest->getUserId())) {
            return $wallet;
        }

        return $this->walletRepository->add(
            new Wallet([
                'user_id'  => $walletRequest->getUserId()
            ])
        );
    }

    public function addMoney(MoneyRequest $moneyRequest): Money
    {
        $money = $this->moneyRepository
            ->findByWalletAndCurrency($moneyRequest->getWalletId(), $moneyRequest->getCurrencyId());
        if (!$money) {
            throw new ModelNotFoundException('Money with the wallet or the user not found');
        }

        if ($money->amount <= 0) {
            throw new IncorrectPriceException('You cannot add a negative value');
        }

        $money->amount += $moneyRequest->getAmount();
        return $this->moneyRepository->save($money);
    }

    public function takeMoney(MoneyRequest $moneyRequest): Money
    {
        $money = $this->moneyRepository
            ->findByWalletAndCurrency($moneyRequest->getWalletId(), $moneyRequest->getCurrencyId());
        if (!$money) {
            throw new ModelNotFoundException('Money with the wallet or the user not found');
        }

        if ($money->amount < $moneyRequest->getAmount()) {
            throw new IncorrectPriceException('Have not enough money');
        }

        return $this->moneyRepository->save($money);
    }

    /**
     * Makes exchange between buyer and seller wallets
     *
     * @param int   $sellerId
     * @param User  $buyer
     * @param float $amount
     * @param int   $currencyId
     * @throws \LogicException
     */
    public function makeExchange(int $sellerId, User $buyer, float $amount, int $currencyId): void
    {
        $buyerMoney = $this->moneyRepository->findByUserAndCurrency($buyer->id, $currencyId);
        $sellerMoney = $this->moneyRepository->findByUserAndCurrency($sellerId, $currencyId);
        if (!$buyerMoney) {
            throw new \LogicException('No buyer money found');
        } else if (!$sellerMoney) {
            throw new \LogicException('No seller money found');
        }

        // don't really understand how should happened the process... Don't have much time to mess up here
        $this->takeMoney(
            new \App\Request\MoneyRequest($buyerMoney->id, $currencyId, 1)
        );
        $this->addMoney(
            new \App\Request\MoneyRequest($sellerMoney->id, $currencyId, $amount)
        );
    }
}
