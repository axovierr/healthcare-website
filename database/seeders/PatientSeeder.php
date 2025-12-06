<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patientRole = Role::where('name', 'patient')->first();

        // LANGKAH 1: Buat Akun di tabel USERS untuk login
        $userPatient = User::create([
            'name' => 'Nur Khevin',
            'email' => 'nur@gmail.com',
            'username' => 'nur.khevin',
            'gender' => 'male',
            'password' => Hash::make('nur123'),
            'role_id' => $patientRole->id,
        ]);
        
        // LANGKAH 2: Simpan data tambahan di tabel PATIENTS
        // Gunakan ID dari user yang baru dibuat
        Patient::create([
            'user_id' => $userPatient->id, // Kolom ini harus ada di Patients Migration
            'username' => 'nur.khevin',
            'birth_date' => '2005-08-28',
            'gender' => 'Male',
            'golongan_darah' => 'O',
            'address' => 'Semarang, Jawa Tengah',
            // HAPUS SEMUA KOLOM OTENTIKASI: 'name', 'email', 'password', 'role_id'
        ]);
    }
}