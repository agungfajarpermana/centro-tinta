<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\ProductDetails;
use Faker\Generator as Faker;

$factory->define(ProductDetails::class, function (Faker $faker) {
    return [
        // 'product_id'    => $faker->name,
        'harga'         => $faker->numberBetween(1000,100000),
        'stok_awal'     => $faker->randomDigit,
        'stok_masuk'    => $faker->randomDigit,
        'stok_keluar'   => $faker->randomDigit,
        'penjualan'     => $faker->randomDigit,
        'stok_akhir'    => $faker->randomDigit
    ];
});
