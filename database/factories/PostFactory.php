<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $posts = [
            "The Importance of Emergency Preparedness",
            "How to Improve Safety Awareness in Your Community",
            "Disaster Relief: What You Can Do to Help",
            "Why Community Safety Matters More Than Ever",
            "Survival Skills Everyone Should Learn",
            "Risk Management: How to Identify and Reduce Hazards",
            "The Role of Crisis Response Teams in Emergencies",
            "How Rescue Operations Work in Natural Disasters",
            "Self-Defense Tips for Personal Safety",
            "The Role of Emergency Services in Disaster Management",
            "The Impact of Climate Change on Natural Disasters",
            "Public Health Safety: Preparing for Disease Outbreaks",
            "Resilience Matters: How to Bounce Back After a Disaster",
            "The Importance of Disaster Recovery Plans",
            "Why Staying Alert Can Save Your Life"
        ];

        $post_title = array_shift($posts);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => PostCategory::inRandomOrder()->first()->id,
            'post_title' => $post_title,
            'post_slug' => Str::slug($post_title),
            'post_content' => "<p>" . fake()->paragraph(5) . "</p><p>" . fake()->paragraph(5) . "</p><p>" . fake()->paragraph(5) . "</p>",
            'featured_image' => "https://source.unsplash.com/800x600/?safety,disaster,preparedness",
            'is_featured' => fake()->boolean(),
            'is_published' => true,
        ];
    }
}
