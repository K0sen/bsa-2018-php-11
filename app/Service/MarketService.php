<?php

namespace App\Service;

use App\Entity\Lot;
use App\Entity\Trade;
use App\Mail\TradeCreated;
use App\Repository\Contracts\CurrencyRepository;
use App\Repository\Contracts\LotRepository;
use App\Repository\Contracts\MoneyRepository;
use App\Repository\Contracts\TradeRepository;
use App\Repository\Contracts\UserRepository;
use App\Repository\Contracts\WalletRepository;
use App\Request\Contracts\AddLotRequest;
use App\Request\Contracts\BuyLotRequest;
use App\Request\MoneyRequest;
use App\Response\Contracts\LotResponse;
use App\Service\Contracts\WalletService;
use App\Exceptions\MarketException\ActiveLotExistsException;
use App\Exceptions\MarketException\IncorrectPriceException;
use App\Exceptions\MarketException\IncorrectTimeCloseException;
use App\Exceptions\MarketException\BuyOwnCurrencyException;
use App\Exceptions\MarketException\IncorrectLotAmountException;
use App\Exceptions\MarketException\BuyNegativeAmountException;
use App\Exceptions\MarketException\BuyInactiveLotException;
use App\Exceptions\MarketException\LotDoesNotExistException;
use App\Service\Contracts\MarketService as IMarketService;
use App\User;
use Illuminate\Support\Facades\Mail;

class MarketService implements IMarketService
{
    private $lotRepository;
    private $userRepository;
    private $currencyRepository;
    private $tradeRepository;
    private $moneyRepository;
    private $walletService;

    /**
     * MarketService constructor.
     *
     * @param LotRepository      $lotRepository
     * @param UserRepository     $userRepository
     * @param CurrencyRepository $currencyRepository
     * @param TradeRepository    $tradeRepository
     * @param MoneyRepository    $moneyRepository
     * @param WalletService      $walletService
     */
    public function __construct(LotRepository $lotRepository,
                                UserRepository $userRepository,
                                CurrencyRepository $currencyRepository,
                                TradeRepository $tradeRepository,
                                MoneyRepository $moneyRepository,
                                WalletService $walletService
    ) {
        $this->lotRepository = $lotRepository;
        $this->userRepository = $userRepository;
        $this->currencyRepository = $currencyRepository;
        $this->tradeRepository = $tradeRepository;
        $this->moneyRepository = $moneyRepository;
        $this->walletService = $walletService;
    }

    /** {@inheritdoc} */
    public function addLot(AddLotRequest $lotRequest): Lot
    {
        $activeLot = $this->lotRepository
            ->findBySellerAndCurrency($lotRequest->getSellerId(), $lotRequest->getCurrencyId());
        $money = $this->moneyRepository
            ->findByUserAndCurrency($lotRequest->getSellerId(), $lotRequest->getCurrencyId());
        if ($activeLot) {
            throw new ActiveLotExistsException('Active lot of the user and that currency is already exists');
        }

        if (!$money || $money->amount < 1) {
            throw new IncorrectPriceException('User has no money with given currency');
        }

        if ($lotRequest->getDateTimeOpen() > $lotRequest->getDateTimeClose()) {
            throw new IncorrectTimeCloseException('Time close cannot be smaller then time open');
        }

        if ($lotRequest->getPrice() < 0) {
            throw new IncorrectPriceException('Lot price is incorrect!');
        }

        return $this->lotRepository->add(
            new Lot([
                'currency_id' => $lotRequest->getCurrencyId(),
                'seller_id' => $lotRequest->getSellerId(),
                'date_time_open' => date('Y-m-d H:i:s', $lotRequest->getDateTimeOpen()),
                'date_time_close' => date('Y-m-d H:i:s', $lotRequest->getDateTimeClose()),
                'price' => $lotRequest->getPrice()
            ])
        );
    }

    /** {@inheritdoc} */
    public function buyLot(BuyLotRequest $lotRequest): Trade
    {
        $buyer = $this->userRepository->getById($lotRequest->getUserId());
        $lot = $this->lotRepository->getById($lotRequest->getLotId());

        if (!$buyer || !$lot) {
            throw new LotDoesNotExistException('Lot or user are not exists');
        }

        if ($lot->seller_id === $buyer->id) {
            throw new BuyOwnCurrencyException('You cannot buy own lots');
        }

        if ($lotRequest->getAmount() < 1) {
            throw new BuyNegativeAmountException('Lot amount should be at least 1 c.u.');
        }

        if ($lotRequest->getAmount() > $lot->price) {
            throw new IncorrectLotAmountException('Lot amount is incorrect.');
        }

        if ($lot->getDateTimeClose() < time()) {
            throw new BuyInactiveLotException('Lot is already closed');
        }

        $this->makeExchange($lot->seller_id, $buyer, $lot->price, $lot->currency_id);
        $trade = $this->tradeRepository->add(
            new Trade([
                'user_id' => $lotRequest->getUserId(),
                'lot_id' => $lotRequest->getLotId(),
                'amount' => $lotRequest->getAmount(),
            ])
        );
        Mail::to($buyer)->send(new TradeCreated($trade));

        return $trade;
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

        $this->walletService->takeMoney(
            new MoneyRequest($buyerMoney->id, $currencyId, $amount)
        );
        $this->walletService->addMoney(
            new MoneyRequest($sellerMoney->id, $currencyId, $amount)
        );
    }

    /** {@inheritdoc} */
    public function getLot(int $id): LotResponse
    {
        $lot = $this->lotRepository->getById($id);
        if (!$lot) {
            throw new LotDoesNotExistException('Lot not found');
        }

        return app(LotResponse::class, $lot);
    }

    /** {@inheritdoc} */
    public function getLotList(): array
    {
        $lots = $this->lotRepository->findAll();

        return array_map(function($lot) {
            return app(LotResponse::class, $lot);
        }, $lots);
    }
}
