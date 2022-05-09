<?php

namespace Database\Seeders;

use App\Models\Customer;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Models\Order;

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
                'price' => rand(3, 10),
                'created_at' => $created_at,
            ]);
            $customer = Customer::all()
                ->random(1)
                ->first();
            echo $customer."\n";
            /*$s = $customer->shippingInfos()->first();
            $p = $customer->paymentInfo()->first();
            $s->orders()->save($order);
            $p->orders()->save($order);
            echo $s."\n";*/
            $order->payment_info_id = $customer->paymentInfo()->first()->id;
            $order->shipping_info_id = $customer->shippingInfos()->first()->id;
            echo $customer->shippingInfos()->first()."\n";
            $customer->orders()->save($order);
        }
    }
}
