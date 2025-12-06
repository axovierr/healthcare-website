<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User; // Digunakan untuk membuat akun login
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctorRole = Role::where('name', 'doctor')->first();

        // LANGKAH 1: Buat Akun di tabel USERS untuk login
        $userDoctor = User::updateOrCreate(
            ['email' => 'doctor@gmail.com'],
            [
                'name' => 'Dr. Dian Permata',
                'username' => 'dian.p',
                'gender' => 'female',
                'password' => Hash::make('doctor123'),
                'role_id' => $doctorRole->id,
            ]
        );
        
        // LANGKAH 2: Simpan data tambahan di tabel DOCTORS
        Doctor::updateOrCreate(
            ['username' => 'dian.p'],
            [
                'user_id' => $userDoctor->id,
                'license_no' => 'DS-54321',
                'gender' => 'Female',
                'address_clinic' => 'Klinik Sehat Bersama, Semarang',
                'fee' => 150000,
            ]
        );
    }
}