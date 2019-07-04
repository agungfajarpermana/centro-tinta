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
        factory(App\Model\Product::class, 20)->create();
        factory(App\Model\ProductDetails::class, 20)->create();
        factory(App\Model\Branch::class, 20)->create();
        factory(App\Model\BranchProduct::class, 20)->create();
        factory(App\Model\Customer::class, 30)->create();
        factory(App\Model\Order::class, 30)->create();
    }
}
