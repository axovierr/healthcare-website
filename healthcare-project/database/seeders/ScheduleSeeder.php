<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $doctorDian = Doctor::where('username', 'dian.p')->first();

        // KONTROL KRUSIAL: Jika dokter tidak ditemukan, hentikan seeding.
        if (!$doctorDian) {
            // Ini akan membuang error yang jelas jika DoctorSeeder gagal
            throw new \Exception('ERROR: Doctor "dian.p" tidak ditemukan. Pastikan DoctorSeeder berjalan lebih dulu!');
        }

        Schedule::create([
            'doctor_id' => $doctorDian->id,
            'schedule_day' => 'Senin',
            'start_time' => '09:00:00',
            'end_time' => '13:00:00',
            'status' => 'available',
        ]);
    }
}