<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        // Buat akun Admin utama
        User::create([
            'name' => 'Admin HealthCare',
            'email' => 'adminhealthcare@gmail.com',
            'username' => 'admin',
            'gender' => 'male',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
        ]);
    }
}
