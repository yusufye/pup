<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProficiencyUserCommodity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProficiencyUserCommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProficiencyUserCommodity::factory()->count(2)->create();
        
    }
}
