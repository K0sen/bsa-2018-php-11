<?php

namespace App\Request;


use App\Request\Contracts\AddLotRequest as IAddLotRequest;

class AddLotRequest implements IAddLotRequest
{
    private $currencyId;
    private $sellerId;
    private $dateTimeOpen;
    private $dateTimeClose;
    private $price;

    /**
     * AddLotRequest constructor.
     *
     * @param $currencyId
     * @param $sellerId
     * @param $dateTimeOpen
     * @param $dateTimeClose
     * @param $price
     */
    public function __construct(int $currencyId, int $sellerId, $dateTimeOpen, $dateTimeClose, float $price)
    {
        $this->currencyId = $currencyId;
        $this->sellerId = $sellerId;
        $this->dateTimeOpen = $dateTimeOpen;
        $this->dateTimeClose = $dateTimeClose;
        $this->price = $price;
    }

    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }

    public function getSellerId(): int
    {
        return $this->sellerId;
    }

    public function getDateTimeOpen(): int
    {
        return $this->dateTimeOpen;
    }

    public function getDateTimeClose(): int
    {
        return $this->dateTimeClose;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}