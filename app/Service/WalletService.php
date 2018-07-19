<?php

namespace App\Service;

use App\Entity\Money;
use App\Entity\Wallet;
use App\Repository\Contracts\MoneyRepository;
use App\Repository\Contracts\WalletRepository;
use App\Request\Contracts\CreateWalletRequest;
use App\Request\Contracts\MoneyRequest;
use App\Service\Contracts\WalletService as IWalletService;
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

        if ($money->amount > 0) {
            $money->amount += $moneyRequest->getAmount();
            return $this->moneyRepository->save($money);
        }

        return $money;
    }

    public function takeMoney(MoneyRequest $moneyRequest): Money
    {
        $money = $this->moneyRepository
            ->findByWalletAndCurrency($moneyRequest->getWalletId(), $moneyRequest->getCurrencyId());
        if ($money) {
            if ($money->amount >= $moneyRequest->getAmount()) {
                $money->amount -= $moneyRequest->getAmount();
                return $this->moneyRepository->save($money);
            }

            return $money;
        } else {
            throw new ModelNotFoundException('Money with the wallet or the user not found');
        }
    }
}
