<?php

namespace App\Service;

use App\Entity\Currency;
use App\Repository\Contracts\CurrencyRepository;
use App\Request\Contracts\AddCurrencyRequest;
use App\Service\Contracts\CurrencyService as ICurrencyService;

class CurrencyService implements ICurrencyService
{
    private $currencyRepository;

    /**
     * CurrencyService constructor.
     *
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function addCurrency(AddCurrencyRequest $currencyRequest) : Currency
    {
        return $this->currencyRepository->add(
            new Currency(['name'  => $currencyRequest->getName()])
        );
    }
}
