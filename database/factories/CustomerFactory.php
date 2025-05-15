<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'type' => $this->faker->randomElement(['Regular', 'Wholesale', 'VIP']),
        ];
    }
}
