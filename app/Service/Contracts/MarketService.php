<?php

namespace App\Service\Contracts;

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

interface MarketService
{
    /**
     * Sell currency.
     *
     * @param AddLotRequest $lotRequest
     *
     * @throws ActiveLotExistsException
     * @throws IncorrectTimeCloseException
     * @throws IncorrectPriceException
     *
     * @return Lot
     */
    public function addLot(AddLotRequest $lotRequest) : Lot;

    /**
     * Buy currency.
     *
     * @param BuyLotRequest $lotRequest
     *
     * @throws BuyOwnCurrencyException
     * @throws IncorrectLotAmountException
     * @throws BuyNegativeAmountException
     * @throws BuyInactiveLotException
     *
     * @return Trade
     */
    public function buyLot(BuyLotRequest $lotRequest) : Trade;

    /**
     * Retrieves lot by an identifier and returns it in LotResponse format
     *
     * @param int $id
     *
     * @throws LotDoesNotExistException
     *
     * @return LotResponse
     */
    public function getLot(int $id) : LotResponse;

    /**
     * Return list of lots.
     *
     * @return LotResponse[]
     */
    public function getLotList() : array;
}
