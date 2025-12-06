<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin role
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            // Create admin user
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@healthcare.test',
                'username' => 'admin',
                'gender' => 'male', // or you can set this to null if you want
                'password' => Hash::make('admin123'), // Change this password in production!
                'role_id' => $adminRole->id,
            ]);
        }
    }
}