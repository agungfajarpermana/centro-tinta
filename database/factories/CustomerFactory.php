<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\Branch;
use App\Model\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'nama_customer'     => $faker->name,
        'alamat'            => $faker->address,
        'telpon'            => $faker->tollFreePhoneNumber,
        'perusahaan'        => $faker->company
    ];
});