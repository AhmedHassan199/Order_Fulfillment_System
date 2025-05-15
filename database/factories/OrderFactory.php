<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition()
    {
        return [
            'customer_id' => \App\Models\Customer::factory(),
            'status' => 'Draft',
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
            'discount_amount' => $this->faker->randomFloat(2, 0, 1000),
            'final_amount' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
