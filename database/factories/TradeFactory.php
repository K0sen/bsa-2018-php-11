<?php

use Faker\Generator as Faker;

$factory->define(App\Entity\Money::class, function (Faker $faker, array $attr) {
    return [
        'user_id' => $attr['user_id']
            ?? function() { return factory(App\User::class)->create()->id; },
        'lot_id' => $attr['lot_id']
            ?? function() { return factory(App\Entity\Lot::class)->create()->id; },
        'amount' => $faker->randomFloat(2, 0.5, 100)
    ];
});