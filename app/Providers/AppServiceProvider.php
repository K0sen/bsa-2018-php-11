<?php

namespace App\Providers;

use App\Entity\Lot;
use App\Repository\Contracts\{
    CurrencyRepository as ICurrencyRepository,
    LotRepository as ILotRepository,
    MoneyRepository as IMoneyRepository,
    TradeRepository as ITradeRepository,
    UserRepository as IUserRepository,
    WalletRepository as IWalletRepository
};
use App\Response\LotResponse;
use App\Response\Contracts\LotResponse as ILotResponse;
use App\Service\Contracts\{
    CurrencyService as ICurrencyService,
    WalletService as IWalletService,
    MarketService as IMarketService
};
use App\Repository\{
    CurrencyRepository, LotRepository, MoneyRepository, TradeRepository, UserRepository, WalletRepository
};
use App\Service\{
    CurrencyService, MarketService, WalletService
};
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        app()->bind(ICurrencyService::class, function () {
            $repository = app(ICurrencyRepository::class);
            return new CurrencyService($repository);
        });
        app()->bind(IWalletService::class, function () {
            $walletRepository = app(IWalletRepository::class);
            $moneyRepository = app(IWalletRepository::class);
            return new WalletService($walletRepository, $moneyRepository);
        });
        app()->bind(IMarketService::class, function () {
            $lotRepository = app(ILotRepository::class);
            $currencyRepository = app(ICurrencyRepository::class);
            $userRepository = app(IUserRepository::class);
            return new MarketService($lotRepository, $currencyRepository, $userRepository);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // model generator
        if ($this->app->environment() == 'local') {
            $this->app->register(\Reliese\Coders\CodersServiceProvider::class);
        }

        app()->bind(ICurrencyRepository::class, CurrencyRepository::class);
        app()->bind(ILotRepository::class, LotRepository::class);
        app()->bind(IMoneyRepository::class, MoneyRepository::class);
        app()->bind(ITradeRepository::class, TradeRepository::class);
        app()->bind(IUserRepository::class, UserRepository::class);
        app()->bind(IWalletRepository::class, WalletRepository::class);
        app()->bind(ILotResponse::class, function (Lot $lot) {
            return new LotResponse($lot);
        });
    }
}
