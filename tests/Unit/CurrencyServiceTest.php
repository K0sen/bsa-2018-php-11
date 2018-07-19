<?php

namespace Tests\Unit;

use App\Entity\Currency;
use App\Repository\Contracts\CurrencyRepository;
use App\Request\Contracts\AddCurrencyRequest;
use App\Service\CurrencyService;
use Tests\TestCase;

class CurrencyServiceTest extends TestCase
{
    public function testAdd()
    {
        $currency = factory(Currency::class)->make();
        $requestStub = $this->createMock(AddCurrencyRequest::class);
        $requestStub->method('getName')
            ->willReturn($currency->name);

        $repositoryStub = $this->createMock(CurrencyRepository::class);
        $repositoryStub->method('add')
            ->willReturn($currency);

        $currencyService = new CurrencyService($repositoryStub);
        $this->assertEquals($currency, $currencyService->addCurrency($requestStub));
    }
}
