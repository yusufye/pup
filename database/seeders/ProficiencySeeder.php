<?php

namespace Database\Seeders;

use App\Models\Proficiency;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProficiencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array(
            array('years'=>'2022', 'show_report'=> '2023-12-01 10:01:02'),
            array('years'=>'2023', 'show_report'=> '2024-12-01 09:30:45')
            //...
        );
        
        Proficiency::insert($data);
    }
}
