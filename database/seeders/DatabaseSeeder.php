<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Run Role seeder first
    $this->call([
        RolesSeeder::class,
        TwillUsersSeeder::class,
        FieldTypeSeeder::class,
        ContentTypeFieldsSeeder::class,
    ]);
    }
}
