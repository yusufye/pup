<?php

namespace Database\Seeders;

use App\Models\Commodity;
use App\Models\Proficiency;
use Illuminate\Database\Seeder;
use App\Models\CommodityPackage;
use App\Models\CommodityDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pup = Proficiency::all()->pluck('id');
        foreach ($pup as $row) {

            Commodity::factory()->count(10)->create(['proficiency_id'=>$row])->each(function($commodity){
        
                //seed commodity package
                $commodity_package = CommodityPackage::factory()->count(3)->make();
                $commodity->package()->saveMany($commodity_package);
    
                //seed commodity document
                $commodity_document = CommodityDocument::factory()->count(1)->make();
                $commodity->document()->saveMany($commodity_document);
            });
        }
    }
}
