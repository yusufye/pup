<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company=ucfirst(fake()->company());
        return [
            'name' => 'PT.'.$company,
            'laboratory' => 'Laboratorium '.$company,
            'npwp' => fake()->unique()->randomDigit(6),
            'address' => fake()->address()
        ];
    }
}
