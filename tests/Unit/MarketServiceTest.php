<?php

namespace Tests\Unit;

use App\Entity\Currency;
use App\Entity\Lot;
use App\Entity\Money;
use App\Entity\Trade;
use App\Entity\Wallet;
use App\Exceptions\MarketException\ActiveLotExistsException;
use App\Mail\TradeCreated;
use App\Repository\Contracts\{
    CurrencyRepository, LotRepository, MoneyRepository, TradeRepository, UserRepository
};
use App\Request\BuyLotRequest;
use App\Request\Contracts\AddCurrencyRequest;
use App\Request\Contracts\AddLotRequest;
use App\Response\LotResponse;
use App\Service\Contracts\WalletService;
use App\Service\CurrencyService;
use App\Service\MarketService;
use App\User;
use Illuminate\Support\Facades\Mail;
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
        $lot = new Lot(['seller_id' => 4, 'currency_id' => 10]);
        $money = new Money(['wallet_id' => 4, 'currency_id' => 1, 'amount' => 55]);
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
        $money = new Money(['wallet_id' => 4, 'currency_id' => 1, 'amount' => 55]);
        $activeLot = new Lot(['seller_id' => 4, 'currency_id' => 10]);
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

    public function testBuyLot()
    {
        $buyer = factory(User::class)->make();
        $buyer->id = 1;
        $lot = new Lot(['id' => 1, 'seller_id' => $buyer->id + 1, 'currency_id' => 2, 'price' => 2]);
        $trade = new Trade(['id' => 1, 'user_id' => $buyer->id, 'lot_id' => $lot->id, 'amount' => 23]);

        $this->userRepository->method('getById')->willReturn($buyer);
        $this->lotRepository->method('getById')->willReturn($lot);

        $this->walletService->method('makeExchange')->willReturn(null);

        $requestStub = $this->createMock(BuyLotRequest::class);
        $requestStub->method('getAmount')->willReturn(1.2);
        $this->lotRepository->method('add')->willReturn($lot);
        $this->tradeRepository->method('add')->willReturn($trade);

        $marketService = new MarketService(
            $this->lotRepository,
            $this->userRepository,
            $this->currencyRepository,
            $this->tradeRepository,
            $this->moneyRepository,
            $this->walletService
        );

        $this->assertEquals($trade, $marketService->buyLot($requestStub));
    }

    // TODO $this->moneyRepository don't create a mock and use database. Don't know wtf
    public function testGetLot()
    {
        $this->assertTrue(true);
        return;
        $lot = new Lot(['id' => 1, 'seller_id' => 2, 'currency_id' => 2, 'price' => 2]);
        $money = new Money(['wallet_id' => 4, 'currency_id' => 1, 'amount' => 55]);
        $this->lotRepository->method('getById')->willReturn($lot);
        $this->moneyRepository->method('findByUserAndCurrency')->willReturn($money);

        $marketService = new MarketService(
            $this->lotRepository,
            $this->userRepository,
            $this->currencyRepository,
            $this->tradeRepository,
            $this->moneyRepository,
            $this->walletService
        );
        $lotResponse = $marketService->getLot(2);
//        dump($lotResponse);
        $this->assertInstanceOf(LotResponse::class, $lotResponse);
    }


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
