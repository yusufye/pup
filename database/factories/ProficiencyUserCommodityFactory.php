<?php

namespace Database\Factories;

use App\Models\Commodity;
use App\Models\ProficiencyUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProficiencyUserCommodity>
 */
class ProficiencyUserCommodityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $proficiency_user_id=ProficiencyUser::get()->pluck('proficiency_id')->random();
        $commodity=Commodity::with('proficiency')->where([
            'proficiency_id'=>$proficiency_user_id
        ])->inRandomOrder()->get()->pluck('id')->random();

        return [
            'proficiency_user_id' => $proficiency_user_id,
            'commodity_id' => $commodity
        ];
    }
}
