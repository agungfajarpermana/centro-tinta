<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\Model\Product::class, 50)->create();
        factory(App\Model\ProductDetails::class, 50)->create();
        factory(App\Model\Branch::class, 15)->create();
        factory(App\Model\Customer::class, 30)->create();
        factory(App\Model\Order::class, 50)->create();
    }
}
