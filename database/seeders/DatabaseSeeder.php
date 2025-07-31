<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Agar aap Laravel default User factory bhi chalana chahte hain:
        // \App\Models\User::factory(10)->create();

        // TwillUsersSeeder ko call karen:
        $this->call([
            TwillUsersSeeder::class,
        ]);
    }
}
