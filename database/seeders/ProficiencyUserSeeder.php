<?php

namespace Database\Seeders;

use App\Models\ProficiencyUser;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProficiencyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProficiencyUser::factory()->count(2)->create();
    }
}
