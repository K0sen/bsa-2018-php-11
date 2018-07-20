<?php

namespace App\Response;


use App\Entity\Lot;
use App\Repository\Contracts\MoneyRepository;
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
     * @param MoneyRepository $moneyRepository
     * @param Lot             $lot
     */
    public function __construct(Lot $lot, MoneyRepository $moneyRepository)
    {
        $money = $moneyRepository->findByUserAndCurrency($lot->seller()->id, $lot->currency()->id);

        $this->id = $lot->id;
        $this->userName = $lot->seller()->name;
        $this->currencyName = $lot->currency()->name;
        $this->amount = $money->amount;
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
        return date('Y-m-d H:i:s', $this->dateTimeOpen);
    }

    public function getDateTimeClose(): string
    {
        return date('Y-m-d H:i:s', $this->dateTimeClose);
    }

    public function getPrice(): string
    {
        return $this->price;
    }
}
