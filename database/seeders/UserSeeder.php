<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Database\Factories\SellerFactory;
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
            echo $seller."\n";
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
        });
        $s = Seller::find(1);
        $user = $s->user;
        echo $user."\n";
        echo $user->userable."\n";
        echo $user->is_seller()."\n";
        //User::factory(10)->create();
        /*
        foreach (User::all() as $user) {
            if ($user->is_seller()) {
                $user->userable->create([
                    'company' => Str::random(6),
                    'credit_card' => $faker->creditCardNumber(),
                ]);
            } else {
                $user->userable->create([
                    'credit_card' => $faker->creditCardNumber(),
                    'street' => $faker->streetAddress,
                    'city' => $faker->city,
                ]);
            }
        }

        $user = User::create([
            'name' => 'a',
            'email' => 'a@a.it',
            'password' => Hash::make('a'),
            'remember_token' => Str::random(10),
            'is_seller' => true,
        ]);
        $user->save();
        $seller_tmp = Seller::create([
            'company' => 'A Company',
            'credit_card' => '6666666666666',
        ]);

        $user->seller()->create([
            'company' => 'A Company',
            'credit_card' => '6666666666666',
        ]);

        $user = User::create([
            'name' => 'b',
            'email' => 'b@b.it',
            'password' => Hash::make('b'),
            'remember_token' => Str::random(10),
            'is_seller' => false,
        ]);
        $user->save();
        $user->customer()->create([
            'credit_card' => $faker->creditCardNumber(),
            'street' => $faker->streetAddress,
            'city' => $faker->city,
        ]);
        */
    }
}
