<?php

namespace Tests\Unit;

use App\Entity\Currency;
use App\Entity\Money;
use App\Repository\Contracts\CurrencyRepository;
use App\Repository\Contracts\LotRepository;
use App\Repository\Contracts\MoneyRepository;
use App\Repository\Contracts\TradeRepository;
use App\Repository\Contracts\UserRepository;
use App\Repository\Contracts\WalletRepository;
use App\Request\AddLotRequest;
use App\Request\BuyLotRequest;
use App\Request\Contracts\AddCurrencyRequest;
use App\Request\MoneyRequest;
use App\Service\CurrencyService;
use App\Service\MarketService;
use App\Service\WalletService;
use App\User;
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
//        $request = new AddLotRequest(3, 3, strtotime('-1day'), strtotime('+2days'), 2.33);
//        $request = new BuyLotRequest(1, 3, 1);
//        factory(Money::class)->create();
//        $repoL = app(LotRepository::class);
//        $repoU = app(UserRepository::class);
//        $repoC = app(CurrencyRepository::class);
//        $repoT = app(TradeRepository::class);
//        $repoM = app(MoneyRepository::class);
//        $walletC = app(\App\Service\Contracts\WalletService::class);
//        $market = (new MarketService($repoL, $repoU, $repoC, $repoT, $repoM, $walletC))->buyLot($request);
//        $market = (new MarketService($repoL, $repoU, $repoC, $repoT, $repoM, $walletC))->addLot($request);
//
//        dump($market);
//        dump($repoM->findByUserAndCurrency(1, 1));
//    }
}
