<?php

namespace Database\Seeders;

use App\Models\SellerOrder;
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
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            StatusSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            SellerOrderSeeder::class,
            SubOrderSeeder::class,
            ReviewsSeeder::class,
        ]);
    }
}
