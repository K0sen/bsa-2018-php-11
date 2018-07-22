<?php

use Faker\Generator as Faker;

$factory->define(App\Entity\Wallet::class, function (Faker $faker, array $attr) {
    return [
        'user_id' => $attr['user_id']
            ?? function() { return factory(App\User::class)->create()->id; }
    ];
});