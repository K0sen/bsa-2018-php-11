<?php

use Faker\Generator as Faker;

$factory->define(App\Entity\Lot::class, function (Faker $faker, array $attr) {
    return [
        'seller_id' => $attr['seller_id']
            ?? function() { return factory(App\User::class)->create()->id; },
        'currency_id' => $attr['currency_id']
            ?? function() { return factory(App\Entity\Currency::class)->create()->id; },
        'price' => $faker->randomFloat(2, 1.5, 500)
    ];
});