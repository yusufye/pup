<?php

namespace Database\Seeders;

use App\Models\Proficiency;
use Illuminate\Database\Seeder;
use App\Models\ProficiencyQuestionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProficiencyQuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pup = Proficiency::all()->pluck('id');
        foreach ($pup as $row) {
            ProficiencyQuestionnaire::factory()->count(10)->create(['proficiency_id'=>$row]);
        }
    }
}
