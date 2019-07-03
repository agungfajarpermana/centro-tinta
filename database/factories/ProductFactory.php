<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'nama_product'      => $faker->name,
        'jenis_product'     => $faker->word,
        'kategori_product'  => $faker->word,
        'detail_product'    => $faker->text
    ];
});
