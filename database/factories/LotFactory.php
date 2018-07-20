<?php

use Faker\Generator as Faker;

$factory->define(App\Entity\Lot::class, function (Faker $faker) {
    return [
        'seller_id' => function() { return factory(App\User::class)->create()->id; },
        'currency_id' => function() { return factory(App\Entity\Currency::class)->create()->id; }
    ];
});