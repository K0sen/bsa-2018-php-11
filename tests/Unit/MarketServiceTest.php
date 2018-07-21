<?php

namespace Tests\Unit;

use App\Entity\Lot;
use App\Entity\Money;
use App\Exceptions\MarketException\ActiveLotExistsException;
use App\Repository\Contracts\{
    CurrencyRepository, LotRepository, MoneyRepository, TradeRepository, UserRepository
};
use App\Request\Contracts\AddLotRequest;
use App\Service\Contracts\WalletService;
use App\Service\MarketService;
use Tests\TestCase;

class MarketServiceTest extends TestCase
{
    private $lotRepository;
    private $userRepository;
    private $currencyRepository;
    private $tradeRepository;
    private $moneyRepository;
    private $walletService;

    protected function setUp()
    {
        parent::setUp();

        $this->lotRepository = $this->createMock(LotRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->currencyRepository = $this->createMock(CurrencyRepository::class);
        $this->tradeRepository = $this->createMock(TradeRepository::class);
        $this->moneyRepository = $this->createMock(MoneyRepository::class);
        $this->walletService = $this->createMock(WalletService::class);
    }

    public function testAddLot()
    {
        $money = factory(Money::class)->make();
        $lot = factory(Lot::class)->make();
        $requestStub = $this->createMock(AddLotRequest::class);

        $this->lotRepository->method('findBySellerAndCurrency')
            ->willReturn(null);
        $this->lotRepository->method('add')
            ->willReturn($lot);

        $this->moneyRepository->method('findByUserAndCurrency')
            ->willReturn($money);

        $requestStub->method('getDateTimeOpen')
            ->willReturn(1);
        $requestStub->method('getDateTimeClose')
            ->willReturn(2);
        $requestStub->method('getPrice')
            ->willReturn(5);

        $marketService = new MarketService(
            $this->lotRepository,
            $this->userRepository,
            $this->currencyRepository,
            $this->tradeRepository,
            $this->moneyRepository,
            $this->walletService
        );

        $this->assertEquals($lot, $marketService->addLot($requestStub));
    }

    public function testAddActiveLot()
    {
        $money = factory(Money::class)->make();
        $activeLot = factory(Lot::class)->make();
        $requestStub = $this->createMock(AddLotRequest::class);

        $this->lotRepository->method('findBySellerAndCurrency')
            ->willReturn($activeLot);
        $this->lotRepository->method('add')
            ->willReturn($activeLot);

        $this->moneyRepository->method('findByUserAndCurrency')
            ->willReturn($money);

        $requestStub->method('getDateTimeOpen')
            ->willReturn(1);
        $requestStub->method('getDateTimeClose')
            ->willReturn(2);
        $requestStub->method('getPrice')
            ->willReturn(5);

        $marketService = new MarketService(
            $this->lotRepository,
            $this->userRepository,
            $this->currencyRepository,
            $this->tradeRepository,
            $this->moneyRepository,
            $this->walletService
        );

        $this->expectException(ActiveLotExistsException::class);
        $marketService->addLot($requestStub);
    }

    // TODO

    
//    public function testBuyLot()
//    {
//        $user = factory(User::class)->make();
//        $lot = factory(Lot::class)->make();
//        $requestStub = $this->createMock(BuyLotRequest::class);
//        $requestStub->method('getAmount')
//            ->willReturn($lot->price + 2);
//
//        $this->userRepository->method('getById')
//            ->willReturn($user->id);
//
//        $this->lotRepository->method('getById')
//            ->willReturn($lot->id);
//
//
//        $this->moneyRepository->method('findByUserAndCurrency')
//            ->willReturn($money);
//
//        $requestStub->method('getDateTimeOpen')
//            ->willReturn(1);
//        $requestStub->method('getDateTimeClose')
//            ->willReturn(2);
//        $requestStub->method('getPrice')
//            ->willReturn(5);
//
//        $marketService = new MarketService(
//            $this->lotRepository,
//            $this->userRepository,
//            $this->currencyRepository,
//            $this->tradeRepository,
//            $this->moneyRepository,
//            $this->walletService
//        );
//
//        $this->expectException(ActiveLotExistsException::class);
//        $marketService->addLot($requestStub);
//    }

//    public function testTest()
//    {
//        $request = new AddLotRequest(3, 3, strtotime('-1day'), strtotime('+2days'), 2.33);
//        $request = new BuyLotRequest(1, 3, 1);
//        $repoL = app(LotRepository::class);
//        $repoU = app(UserRepository::class);
//        $repoC = app(CurrencyRepository::class);
//        $repoT = app(TradeRepository::class);
//        $repoM = app(MoneyRepository::class);
//        $walletC = app(\App\Service\Contracts\WalletService::class);
//        $market = (new MarketService($repoL, $repoU, $repoC, $repoT, $repoM, $walletC))->buyLot($request);
//        $market = (new MarketService($repoL, $repoU, $repoC, $repoT, $repoM, $walletC))->addLot($request);
//        dump((new MarketService($repoL, $repoU, $repoC, $repoT, $repoM, $walletC))->getLotList());
//        dump($market);
//        dump($repoM->findByUserAndCurrency(1, 1));
//    }
}
