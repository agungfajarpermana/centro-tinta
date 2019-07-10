<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Model\Piutang;
use App\Model\Order;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Piutang::class, function (Faker $faker) {
    return [
        'tgl'           => now(),
        'order_id'      => function(){
            return Order::all()->random();
        },
        'nominal'       => $faker->numberBetween(10000,100000),
        'jenis'         => 'D',
        'ket'           => $faker->word,
        'saldo'         => $faker->numberBetween(10000,100000),
    ];
});
