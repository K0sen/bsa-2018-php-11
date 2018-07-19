<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Repository\Contracts\CurrencyRepository as ICurrencyRepository;

class CurrencyRepository implements ICurrencyRepository
{
    public function add(Currency $currency): Currency
    {
        return Currency::create(['name' => $currency->name]);
    }

    public function getById(int $id): ?Currency
    {
        // TODO: Implement getById() method.
    }

    public function getCurrencyByName(string $name): ?Currency
    {
        // TODO: Implement getCurrencyByName() method.
    }

    /**
     * @return Currency[]
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }
}
