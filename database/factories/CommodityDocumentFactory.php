<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommodityDocument>
 */
class CommodityDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'document' => fake()->words(1, true),
            'description' => fake()->sentence(),
            'file_path' => '/upload/commodity/document/'.fake()->words(1, true).'.pdf'
        ];
    }
}
