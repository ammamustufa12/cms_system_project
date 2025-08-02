<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'manager', 'user'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(
                ['name' => $roleName],
                ['slug' => Str::slug($roleName)]
            );
        }
    }
}
