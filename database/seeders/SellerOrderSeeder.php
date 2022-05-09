<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Models\Seller;
use App\Models\SellerOrder;
use App\Models\Status;
use App\Models\Order;

class SellerOrderSeeder extends Seeder
{
    private const NUM_SELLER_ORDERS = 7;

    /**
     * Seed the seller_orders table
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach (Order::all() as $order) {
            $seller_orders = [];
            foreach (range(3, rand(1, self::NUM_SELLER_ORDERS)) as $i) {
                $seller = Seller::inRandomOrder()->first();
                if ($seller->products->count() === 0) {
                    continue;
                }
                $created_at = $faker->dateTimeThisYear();

                $seller_order = new SellerOrder([
                    //'profit' => 0.0,
                    'status_id' => Status::inRandomOrder()->first()->id,
                    'seller_id' => $seller->id,
                    'order_id' => $order->id,
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                ]);
                $seller->orders()->save($seller_order);
                // echo $seller_order->id." ";
                // echo $seller_order->profit()."\n";
                $seller_orders[] = $seller_order;
            }
        }
    }
}
