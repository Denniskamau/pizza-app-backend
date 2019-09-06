<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Orders;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Orders::class, function (Faker $faker) {
    return [
        'pizza' => Str::random(10),
        'size' => Str::random(10),
        'toppings' => Str::random(10),
        'location' => Str::random(10),
        'quantity' => $faker->randomNumber()
    ];
});
