<?php

namespace App\Providers;

use App\Repository\Contracts\{
    CurrencyRepository as ICurrencyRepository,
    LotRepository as ILotRepository,
    MoneyRepository as IMoneyRepository,
    TradeRepository as ITradeRepository,
    UserRepository as IUserRepository,
    WalletRepository as IWalletRepository
};
use App\Request\AddLotRequest;
use App\Request\Contracts\AddLotRequest as IAddLotRequest;
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
            $moneyRepository = app(IMoneyRepository::class);
            return new WalletService($walletRepository, $moneyRepository);
        });
        app()->bind(IMarketService::class, function () {
            return new MarketService(
                app(ILotRepository::class),
                app(IUserRepository::class),
                app(ICurrencyRepository::class),
                app(ITradeRepository::class),
                app(IMoneyRepository::class),
                app(IWalletService::class)
            );
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
        if ($this->app->environment() === 'local') {
            $this->app->register(\Reliese\Coders\CodersServiceProvider::class);
        }

        app()->bind(ICurrencyRepository::class, CurrencyRepository::class);
        app()->bind(ILotRepository::class, LotRepository::class);
        app()->bind(IMoneyRepository::class, MoneyRepository::class);
        app()->bind(ITradeRepository::class, TradeRepository::class);
        app()->bind(IUserRepository::class, UserRepository::class);
        app()->bind(IWalletRepository::class, WalletRepository::class);
    }
}
