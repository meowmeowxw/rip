<?php

namespace Database\Factories;

use App\Models\PaymentInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends PaymentInfo
 */
class PaymentInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PaymentInfo::class;

    public function definition()
    {
        return [
            'card_number' => $this->faker->creditCardNumber(),
            'expire' => $this->faker->date(),
        ];
    }
}
