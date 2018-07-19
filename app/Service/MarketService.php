<?php

namespace App\Service;

use App\Entity\Lot;
use App\Entity\Trade;
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
    /** {@inheritdoc} */
    public function addLot(AddLotRequest $lotRequest): Lot
    {
        // TODO: Implement addLot() method.
    }

    /** {@inheritdoc} */
    public function buyLot(BuyLotRequest $lotRequest): Trade
    {
        // TODO: Implement buyLot() method.
    }

    /** {@inheritdoc} */
    public function getLot(int $id): LotResponse
    {
        // TODO: Implement getLot() method.
    }

    /** {@inheritdoc} */
    public function getLotList(): array
    {
        // TODO: Implement getLotList() method.
    }
}
