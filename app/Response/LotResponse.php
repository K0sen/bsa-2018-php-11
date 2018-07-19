<?php

namespace App\Response;


use App\Entity\Lot;
use App\Response\Contracts\LotResponse as ILotResponse;

class LotResponse implements ILotResponse
{
    private $id;
    private $userName;
    private $currencyName;
    private $amount;
    private $dateTimeOpen;
    private $dateTimeClose;
    private $price;

    /**
     * LotResponse constructor.
     *
     * @param Lot $lot
     */
    public function __construct(Lot $lot)
    {
        $this->id = $lot->id;
        $this->userName = $lot->seller()->name;
        $this->currencyName = $lot->currency()->name;
        $this->amount = $lot->amount;
        $this->dateTimeOpen = $lot->getDateTimeOpen();
        $this->dateTimeClose = $lot->getDateTimeClose();
        $this->price = $lot->price;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getCurrencyName(): string
    {
        return $this->currencyName;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDateTimeOpen(): string
    {
        return $this->dateTimeOpen;
    }

    public function getDateTimeClose(): string
    {
        return $this->dateTimeClose;
    }

    public function getPrice(): string
    {
        return $this->price;
    }
}
