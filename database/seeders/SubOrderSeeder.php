<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Order;
use App\Models\SubOrder;
use App\Models\Seller;
use App\Models\SellerOrder;
use App\Models\Product;

class SubOrderSeeder extends Seeder
{
    private const MAX_QUANTITY = 3;
    /**
     * Seed the categories table
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach (SellerOrder::all() as $key => $order) {
            $created_at = $faker->dateTimeThisYear;
            $seller = Seller::find($order->seller_id);
            $products = Product::where('seller_id', $seller->id)
                ->get()
                ->take($faker->numberBetween(1, 6))
                ->mapWithKeys(function($product) use ($faker, $created_at) {
                    $quantity = $faker->numberBetween(1, self::MAX_QUANTITY);
                    return [
                        $product->id => [
                            'ordered_quantity' => $quantity,
                            'total_price' => $product->price * $quantity,
                            'single_price' => $product->price,
                            'created_at' => $created_at,
                            'updated_at' => $created_at,
                            'product_id' => $product->id,
                        ],
                    ];
                })
                ->all();
            $order->products()->attach($products);
            // $order->profit = 0.0;
            /*
            foreach ($order->products as $product) {
                $order->profit += $product->pivot->total_price;
            }
            */
            $order->save();
            echo $order->profit()."\n";
        }

        foreach (Order::all() as $order) {
            $order->price = 0;
            foreach ($order->sellerOrders as $sellerOrder) {
                $order->price += $sellerOrder->profit();
            }
            $order->save();
        }
    }
}
