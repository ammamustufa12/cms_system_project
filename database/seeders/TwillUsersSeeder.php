<?php

namespace Database\Seeders;

use A17\Twill\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TwillUsersSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@twill.test')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@twill.test',
                'password' => Hash::make('password'),
                'published' => true,
                'role' => 'admin',
            ]);
        }
    }
}
