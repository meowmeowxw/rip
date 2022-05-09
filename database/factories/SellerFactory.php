<?php

namespace Database\Factories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{
    /**
     * Seller corresponding model
     *
     * @var string
     */
    protected $model = Seller::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        echo \App\Models\User::class."\n";
        return [
            'company' => $this->faker->name(),
            'description' => $this->faker->words(rand(5, 10), true),
        ];
    }
}
