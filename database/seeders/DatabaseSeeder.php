<?php

namespace Database\Seeders;

use App\Models\Tag;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $output = new ConsoleOutput();

        // Start progress bar
        $progressBar = new ProgressBar($output, 3);
        $progressBar->start();

        // Users
        if (User::count() === 0) {
            User::factory(15)->create();
        }
        $progressBar->advance();

        // Categories
        if (PostCategory::count() === 0) {
            PostCategory::factory(10)->create();
        }
        $progressBar->advance();

        // Tags
        if (Tag::count() === 0) {
            Tag::factory(15)->create();
        }
        $progressBar->advance();

        // Posts (With Tags)
        if (Post::count() === 0) {
            $posts = Post::factory(15)->create();
            $tags = Tag::all();

            // Attach random tags to each post
            foreach ($posts as $post) {
                $post->tags()->attach($tags->random(rand(2, 5))->pluck('id')->toArray());
            }
        }
        $progressBar->finish();
        $output->writeln("\n✅ Database seeding completed!");
    }
}
