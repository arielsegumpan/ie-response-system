<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\BlogSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'aye',
        //     'email' => 'aye@gmail.com',
        //     'password' => bcrypt('qwerty12345'),

        // ]);

        $this->call([
            UserSeeder::class,
            CategoryTagSeeder::class,
            BlogSeeder::class,
            IncidentTypeSeeder::class,
            OrganizationTypeSeeder::class,
            OrganizationSeeder::class,
        ]);
    }
}
