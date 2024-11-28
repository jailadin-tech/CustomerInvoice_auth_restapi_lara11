<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['B', 'I']);
        $name = ($type == 'B') ? $this->faker->company() : $this->faker->name();
        return [
            'name' => $name,
            'type' => $type,
            'email' => $this->faker->safeEmail(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->address(),
            'postal_code' => $this->faker->postcode()
        ];
    }
}