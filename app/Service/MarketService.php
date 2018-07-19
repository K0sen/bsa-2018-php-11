<?php

namespace App\Service;

use App\Entity\Lot;
use App\Entity\Trade;
use App\Repository\Contracts\CurrencyRepository;
use App\Repository\Contracts\LotRepository;
use App\Repository\Contracts\UserRepository;
use App\Request\Contracts\AddLotRequest;
use App\Request\Contracts\BuyLotRequest;
use App\Response\Contracts\LotResponse;
use App\Exceptions\MarketException\ActiveLotExistsException;
use App\Exceptions\MarketException\IncorrectPriceException;
use App\Exceptions\MarketException\IncorrectTimeCloseException;
use App\Exceptions\MarketException\BuyOwnCurrencyException;
use App\Exceptions\MarketException\IncorrectLotAmountException;
use App\Exceptions\MarketException\BuyNegativeAmountException;
use App\Exceptions\MarketException\BuyInactiveLotException;
use App\Exceptions\MarketException\LotDoesNotExistException;
use App\Service\Contracts\MarketService as IMarketService;

class MarketService implements IMarketService
{
    private $lotRepository;
    private $currencyRepository;
    private $userRepository;

    /**
     * MarketService constructor.
     *
     * @param LotRepository      $lotRepository
     * @param CurrencyRepository $currencyRepository
     * @param UserRepository     $userRepository
     */
    public function __construct(LotRepository $lotRepository,
                                CurrencyRepository $currencyRepository,
                                UserRepository $userRepository
    ) {
        $this->lotRepository = $lotRepository;
        $this->currencyRepository = $currencyRepository;
        $this->userRepository = $userRepository;
    }

    /** {@inheritdoc} */
    public function addLot(AddLotRequest $lotRequest): Lot
    {
        $activeLot = $this->lotRepository
            ->findBySellerAndCurrency($lotRequest->getSellerId(), $lotRequest->getCurrencyId());
        if ($activeLot) {
            throw new ActiveLotExistsException('Active lot of the user and that currency is already exists');
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
                'date_time_open' => $lotRequest->getDateTimeOpen(),
                'date_time_close' => $lotRequest->getDateTimeClose(),
                'price' => $lotRequest->getPrice()
            ])
        );
    }

    /** {@inheritdoc} */
    public function buyLot(BuyLotRequest $lotRequest): Trade
    {
        // TODO: Implement buyLot() method.
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
