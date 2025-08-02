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
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@twill.test',
            'password' => Hash::make('password'),
            'published' => true,
            'role_id' => $adminRole->id,
            'phone' => '1234567890',
            'joining_date' => now()->toDateString(),
            'skills' => json_encode(['Laravel', 'Vue', 'Tailwind']),
            'designation' => 'Super Admin',
            'website' => 'https://adminsite.com',
            'city' => 'Dubai',
            'country' => 'UAE',
            'zipcode' => '00000',
            'github_username' => '@admin',
            'dribbble_username' => '@admin_design',
            'pinterest_username' => '@admin_pins',
            'portfolio_website' => 'https://portfolio.adminsite.com',
            'photo' => 'admin_avatar.jpg',
            'cover_image' => 'cover_admin.jpg',
            'title' => 'Master of CMS',
            'description' => 'This is the administrator of the Twill CMS system.',
            'remember_token' => null,
        ]);

        echo "✅ Admin user created successfully. ID: {$user->id}\n";
    }
}
