<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\Product;
use App\Model\ProductDetails;
use Faker\Generator as Faker;

$factory->define(ProductDetails::class, function (Faker $faker) {
    return [
        'product_id'    => function() {
            return Product::all()->random();
        },
        'harga'         => $faker->numberBetween(10000,100000),
        'penjualan'     => $faker->numberBetween(0,80),
    ];
});
