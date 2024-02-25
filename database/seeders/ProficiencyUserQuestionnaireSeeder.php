<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProficiencyUserQuestionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProficiencyUserQuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProficiencyUserQuestionnaire::factory()->count(2)->create();
    }
}
