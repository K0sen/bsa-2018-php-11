<?php

namespace Tests\Unit;

use App\Entity\Currency;
use App\Repository\Contracts\CurrencyRepository;
use App\Repository\Contracts\MoneyRepository;
use App\Repository\Contracts\WalletRepository;
use App\Request\Contracts\AddCurrencyRequest;
use App\Request\MoneyRequest;
use App\Service\CurrencyService;
use App\Service\WalletService;
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

//    public function testTest()
//    {
//        $request = new MoneyRequest(1, 1, 6.8989);
//        $repoW = app(WalletRepository::class);
//        $repoM = app(MoneyRepository::class);
//        $money = (new WalletService($repoW, $repoM))->takeMoney($request);
//
//        dump($money);
//    }
}
