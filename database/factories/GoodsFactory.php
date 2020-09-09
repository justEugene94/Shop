<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\Goods;
use Faker\Generator as Faker;

$factory->define(Goods::class, function (Faker $faker) {
    return [
        'title' => $faker->text(20),
        'description' => $faker->text(200),
        'price' => $faker->numberBetween(100, 400),
        'quantity' => $faker->numberBetween(0, 900)
    ];
});
