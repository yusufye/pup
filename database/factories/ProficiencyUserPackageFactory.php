<?php

namespace Database\Factories;

use App\Models\CommodityPackage;
use App\Models\ProficiencyUserCommodity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProficiencyUserPackage>
 */
class ProficiencyUserPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_commodity=ProficiencyUserCommodity::get()->pluck('commodity_id')->random();

        $package=CommodityPackage::with('commodity')->where([
            'commodity_id'=>$user_commodity
        ])->get()->pluck('id')->random();

        return [
            'proficiency_user_commodity_id' => $user_commodity,
            'package_id' => $package
        ];
    }
}
