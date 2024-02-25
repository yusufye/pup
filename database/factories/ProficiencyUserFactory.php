<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Proficiency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProficiencyUser>
 */
class ProficiencyUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user=User::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'proficiency_id' => function () {
                return Proficiency::inRandomOrder()->first()->id;
            },
            'client_id' =>$user->client_id
        ];
    }
}
