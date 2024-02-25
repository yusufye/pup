<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProficiencyUserPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProficiencyUserPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProficiencyUserPackage::factory()->count(4)->create();
        
    }
}
