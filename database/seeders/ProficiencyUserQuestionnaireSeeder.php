<?php

namespace Database\Seeders;

use App\Models\ProficiencyUser;
use Illuminate\Database\Seeder;
use App\Models\ProficiencyQuestionnaire;
use App\Models\ProficiencyUserQuestionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProficiencyUserQuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        $proficiency_user=ProficiencyUser::get()->each(function($proficiency_user){

            $proficiency_questionnaire=ProficiencyQuestionnaire::where('proficiency_id',$proficiency_user->proficiency_id)->get()->each(function($data_questionnaire) use($proficiency_user){
                ProficiencyUserQuestionnaire::factory()->count(1)->create(
                    [
                        'proficiency_user_id' => $proficiency_user->id,
                        'proficiency_questionnaire_id' => $data_questionnaire->id,
                        'value' => fake()->randomDigitNot(2)
                    ]
                );
            });
        });
    }
}
