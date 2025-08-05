<?php

namespace Database\Seeders;

use A17\Twill\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TwillUsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first() ?? Role::where('name', 'admin')->first();

        if (!$adminRole) {
            echo "❌ Admin role not found. Cannot create admin user.\n";
            return;
        }

        if (User::where('email', 'admin@twill.test')->exists()) {
            echo "ℹ️ Admin user already exists.\n";
            return;
        }

        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'adminuser',
            'email' => 'admin@twill.test',
            'password' => Hash::make('password'),
            'phone' => '1234567890',
            'address' => '123 Admin St, Admin City, Country',
            'photo' => 'admin_avatar.jpg',
            'role_id' => $adminRole->id,
        ]);

        echo "✅ Admin user created successfully. ID: {$user->id}\n";
    }
}
