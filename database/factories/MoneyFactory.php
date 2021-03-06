<?php

use Faker\Generator as Faker;

$factory->define(App\Entity\Money::class, function (Faker $faker, array $attr) {
    return [
        'wallet_id' => $attr['wallet_id']
            ?? function() { return factory(App\Entity\Wallet::class)->create()->id; },
        'currency_id' => $attr['currency_id']
            ?? function() { return factory(App\Entity\Currency::class)->create()->id; },
        'amount' => $faker->randomFloat(2, 0.5, 100)
    ];
});