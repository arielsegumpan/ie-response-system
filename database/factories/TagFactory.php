<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $tags = [
            "Emergency Preparedness", "Safety Awareness", "Disaster Relief",
            "Community Safety", "Survival Skills", "Risk Management",
            "Crisis Response", "Rescue Operations", "Self-Defense",
            "Emergency Services", "Climate Change Impact", "Public Health Safety",
            "Resilience Matters", "Disaster Recovery", "Stay Alert"
        ];

        $tag = array_shift($tags);

        return [
            'tag_name' => $tag,
            'tag_slug' => Str::slug($tag),
            'tag_description' => fake()->sentence(),
        ];
    }
}
