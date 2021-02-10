<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->faker->seed('1');

$factory->define(Product::class, function (Faker $faker) {
    static $num = 0;
    $num++;

    return [
        'name' => '商品名' . $num,
        'desc' => '商品説明' . $num,
        'stock' => $faker->numberBetween($min = 1, $max = 100),
        'price' => $faker->numberBetween($min = 100, $max = 99999),
    ];
});
