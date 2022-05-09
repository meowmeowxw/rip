<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use App\Models\ShippingInfo;
use App\Models\PaymentInfo;
use Faker\Generator as Faker;
use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Seller::factory()->count(10)->create()->each(function($seller) {
            //echo $seller."\n";
            $user = User::factory()->create([
                'userable_id' => $seller->id,
                'userable_type' => Seller::class,
            ]);
            $user->save();
        });
        Customer::factory()->count(10)->create()->each(function($customer) {
            $user = User::factory()->create([
                'userable_id' => $customer->id,
                'userable_type' => Customer::class,
            ]);
            $user->save();
            $customer->paymentInfo()->save(PaymentInfo::factory()->make());
            $customer->shippingInfos()->saveMany(ShippingInfo::factory()->count(rand(1, 3))->make());
        });
        $s = Seller::find(1);
        $user = $s->user;
        echo $user."\n";
        echo $user->userable."\n";
        echo $user->is_seller()."\n";
        $seller = Seller::create([
            'company' => 'A Company',
            'description' => $faker->words(rand(5, 10), true),
        ]);
        $customer = Customer::create([]);
        $seller_user = User::create([
            'name' => 'a',
            'email' => 'a@a.it',
            'password' => Hash::make('a'),
            'remember_token' => Str::random(10),
            'is_seller' => true,
            'userable_id' => $seller->id,
            'userable_type' => Seller::class,
        ]);
        $customer_user = User::create([
            'name' => 'b',
            'email' => 'b@b.it',
            'password' => Hash::make('b'),
            'remember_token' => Str::random(10),
            'is_seller' => false,
            'userable_id' => $customer->id,
            'userable_type' => Customer::class,
        ]);
        $seller_user->save();
        $customer_user->save();
        $customer->paymentInfo()->save(PaymentInfo::factory()->make());
        $customer->shippingInfos()->saveMany(ShippingInfo::factory()->count(rand(1, 3))->make());
        $seller->save();
        $customer->save();
    }
}
