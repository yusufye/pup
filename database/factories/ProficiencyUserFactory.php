<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Client;
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
        $client=Client::inRandomOrder()->first();
        return [
            'user_id' => $client->user_id,
            'proficiency_id' => function () {
                return Proficiency::inRandomOrder()->first()->id;
            },
            'client_id' =>$client->id
        ];
    }
}
