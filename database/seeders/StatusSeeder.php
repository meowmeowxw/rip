<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Seed the categories table
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            ['name' => 'delivered', 'description' => 'The order has been delivered'],
            ['name' => 'shipped', 'description' => 'The order has been shipped and it will arrive in the following days'],
            ['name' => 'confirmed', 'description' => 'The order has been confirmed by the seller'],
            ['name' => 'waiting', 'description' => 'The order is waiting the seller\'s confirmation'],
        ]);
    }
}
