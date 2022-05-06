<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory(10)->create();
        foreach (User::all() as $user) {
            if ($user->is_seller) {
                $user->seller()->create([
                    'company' => Str::random(6),
                    'credit_card' => $faker->creditCardNumber(),
                ]);
            } else {
                $user->customer()->create([
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
    }
}
