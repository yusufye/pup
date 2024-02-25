<?php

namespace Database\Factories;

use App\Models\ProficiencyUser;
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
        $proficiency_user_id=ProficiencyUser::get()->pluck('proficiency_id')->random();
        
        return [
            'proficiency_user_id' => $proficiency_user_id,
            'item' => fake()->words(1, true),
            'value' => fake()->randomDigitNot(2)
        ];
    }
}
