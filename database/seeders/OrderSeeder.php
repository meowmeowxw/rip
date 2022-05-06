<?php

namespace Database\Seeders;

use App\Models\Customer;
use Faker\Generator as Faker;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Order;
use App\Models\SubOrder;

class OrderSeeder extends Seeder
{
    private const NUM_ORDERS = 60;

    /**
     * Seed the categories table
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach (range(1, self::NUM_ORDERS) as $i) {
            $created_at = $faker->dateTimeThisYear();
            $order = new Order([
                'credit_card' => Str::random(16),
                'street' => Str::random(16),
                'city' => Str::random(16),
                'price' => rand(3, 10),
                'created_at' => $created_at,
            ]);
            $customer = Customer::all()
                ->random(1)
                ->first();
            $customer->orders()->save($order);
        }
    }
}
