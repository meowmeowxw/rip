<?php

namespace Database\Factories;

use App\Models\ShippingInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingInfoFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ShippingInfo::class;

    public function definition()
    {
        return [
            'street' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'cap' => $this->faker->numerify('######'),
        ];
    }
}
