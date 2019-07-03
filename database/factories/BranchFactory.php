<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\Branch;
use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(Branch::class, function (Faker $faker) {
    return [
        'product_id'    => function() {
            return Product::all()->random();
        },
        'nama_cabang'   => $faker->name,
        'stok_awal'     => $faker->numberBetween(0,100),
        'stok_masuk'    => $faker->numberBetween(0,100),
        'stok_keluar'   => $faker->numberBetween(0,100),
        'stok_akhir'    => $faker->numberBetween(0,90)
    ];
});