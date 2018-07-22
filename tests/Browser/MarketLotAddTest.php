<?php

namespace Tests\Unit;

use App\Entity\Currency;
use App\Entity\Money;
use App\Entity\Wallet;
use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MarketLotAddTest extends DuskTestCase
{
    /**
     * Some shit with money factory............................. TODO
     *
     * @throws \Throwable
     */
    public function testAddLot()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
//            $currency = factory(Currency::class)->create();
//            $wallet = factory(Wallet::class)->create(['user_id' => $user->id]);
//            factory(Money::class)->create([
//                'wallet_id' => $wallet->id,
//                'currency_id' => $currency->id,
//                'amount' => 100
//            ]);
//            factory(Money::class)->create();

            $browser->loginAs($user)
                ->visit('/market/lots/add')
                ->assertPathIs('/market/lots/add')
                ->type('currency_id', 3)
                ->type('seller_id', 4)
                ->type('short_name', 'BiTCoIn')
                ->type('date_time_open', 1587040303)
                ->type('date_time_close', 1587090303)
                ->type('price', 666.99)
                ->press('Add')
                ->pause(1000)
                ->assertSee('Sorry, error has been occurred:');
        });
    }
}
