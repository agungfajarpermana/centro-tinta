<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\Order;
use App\Model\Branch;
use App\Model\Customer;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'no_order'      => $faker->postcode,
        'branch_id'     => function() {
            return Branch::all()->random();
        },
        'customer_id'    => function() {
            return Customer::all()->random();
        },
    ];
});