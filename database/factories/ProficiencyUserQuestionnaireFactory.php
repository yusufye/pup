<?php

namespace Database\Factories;

use App\Models\Proficiency;
use App\Models\ProficiencyUser;
use App\Models\ProficiencyQuestionnaire;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProficiencyUserQuestionnaire>
 */
class ProficiencyUserQuestionnaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => fake()->randomDigitNot(2)
        ];
        
        
    }
}
