<?php

namespace Database\Factories;

use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostCategory>
 */
class PostCategoryFactory extends Factory
{
    protected $model = PostCategory::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $categories = [
            "Road Safety & Traffic Accidents",
            "Workplace Safety & Hazards",
            "Home Safety & Domestic Accidents",
            "Fire Safety & Prevention",
            "First Aid & Emergency Response",
            "Earthquake Preparedness & Safety",
            "Flood & Storm Readiness",
            "Tsunami Awareness & Evacuation Plans",
            "Hurricane & Tornado Preparedness",
            "Wildfire Prevention & Safety",
        ];

        $category = array_shift($categories);

        return [
            'cat_name' => $category,
            'cat_slug' => Str::slug($category),
            'cat_description' => fake()->sentence(),
        ];
    }
}
