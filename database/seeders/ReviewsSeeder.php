<?php

namespace Database\Seeders;

use App\Models\Review;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Models\Seller;
use App\Models\SellerOrder;
use App\Models\Status;
use App\Models\Order;

class ReviewsSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        foreach(SellerOrder::all()->take(10) as $so) {
            $customer = $so->order->customer;
            $rev = Review::create([
                'description' => $faker->words(rand(5, 10), true),
                'star' => rand(1, 5),
                'reviewable_type' => "App\Models\Seller",
                'reviewable_id' => $so->seller->id,
                'customer_id' => $customer->id
            ]);
            $p = $so->products->first();
            Review::create([
                'description' => $faker->words(rand(5, 10), true),
                'star' => rand(1, 5),
                'reviewable_type' => "App\Models\Product",
                'reviewable_id' => $p->id,
                'customer_id' => $customer->id,
            ]);
        }
    }
}

