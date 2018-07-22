<?php

namespace Tests\Unit;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MarketLotAddTest extends DuskTestCase
{
    /**
     * @throws \Throwable
     */
    public function testAddLot()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();

            $browser->loginAs($user)
                ->visit('/market/lots/add')
                ->type('currency_id', 1)
                ->type('seller_id', 2)
                ->type('short_name', 'BiTCoIn')
                ->type('date_time_open', 1587040303)
                ->type('dateTimeClose', 1587040303)
                ->type('price', 666.99)
                ->press('Add')
                ->pause(1000)
                ->assertSee('Lot has been added successfully!');
        });
    }
}
