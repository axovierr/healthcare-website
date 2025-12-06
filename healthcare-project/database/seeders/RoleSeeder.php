<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create basic roles
        $roles = [
            ['name' => 'admin', 'display_name' => 'Administrator'],
            ['name' => 'doctor', 'display_name' => 'Doctor'],
            ['name' => 'patient', 'display_name' => 'Patient'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}