<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\Branch;
use Faker\Generator as Faker;

$factory->define(Branch::class, function (Faker $faker) {
    return [
        'nama_cabang'   => $faker->name,
        'alamat'        => $faker->address,
        'telpon'        => $faker->tollFreePhoneNumber,
        'email'         => $faker->email,
        'fax'           => $faker->e164PhoneNumber,
        'kepala_cabang' => $faker->firstNameMale
    ];
});