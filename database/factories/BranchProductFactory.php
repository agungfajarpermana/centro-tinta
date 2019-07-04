<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\Branch;
use App\Model\Product;
use App\Model\BranchProduct;
use Faker\Generator as Faker;

$factory->define(BranchProduct::class, function (Faker $faker) {
    return [
        'branch_id'     => $faker->numberBetween(1,2),
        'product_id'    => function(){
            return Product::all()->random();
        },
        'stok_awal'     => $faker->numberBetween(1,20),
        'stok_masuk'    => $faker->numberBetween(1,15),
        'stok_keluar'   => $faker->numberBetween(1,10),
        'stok_akhir'    => $faker->numberBetween(1, 15),
    ];
});