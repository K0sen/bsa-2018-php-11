<?php

namespace Tests\Unit;

use App\Entity\Currency;
use App\Entity\Money;
use App\Entity\Wallet;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class LotCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testAddLot()
    {
        $user = factory(User::class)->create();
        $currency = factory(Currency::class)->create();
        $wallet = factory(Wallet::class)->create(['user_id' => $user->id]);
        factory(Money::class)->create([
            'wallet_id' => $wallet->id,
            'currency_id' => $currency->id,
            'amount' => 100
        ]);

        $response = $this->actingAs($user)->json('POST', '/api/v1/lots', [
            "currency_id" => $currency->id,
            'seller_id' => $user->id,
            "date_time_open" => Carbon::now()->toDateTimeString(),
            "date_time_close" => Carbon::tomorrow()->toDateTimeString(),
            "price" => 666.99
        ]);
//        dump($response);
        $response->assertStatus(201);
    }
}
