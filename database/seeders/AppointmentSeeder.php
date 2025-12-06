<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil data dengan username BARU yang sudah diupdate
        $patientNur = Patient::where('username', 'nur.khevin')->first();
        $doctorDian = Doctor::where('username', 'dian.p')->first();

        // Pemeriksaan Kritis: Pastikan data ditemukan
        if (!$patientNur) {
            throw new \Exception('ERROR: Patient "nur.khevin" tidak ditemukan. Cek PatientSeeder.');
        }
        if (!$doctorDian) {
            throw new \Exception('ERROR: Doctor "dian.p" tidak ditemukan. Cek DoctorSeeder.');
        }

        // 2. Ambil jadwal
        $scheduleDian = Schedule::where('doctor_id', $doctorDian->id)->first();
        
        // Pemeriksaan Kritis: Pastikan jadwal ada sebelum mengakses ->id
        if (!$scheduleDian) {
            throw new \Exception('ERROR: Jadwal Doctor Dian tidak ditemukan. Cek ScheduleSeeder.');
        }

        // 3. Buat Appointment
        Appointment::create([
            'patient_id' => $patientNur->id, // Menggunakan ID Pasien yang baru
            'doctor_id' => $doctorDian->id,
            'schedule_id' => $scheduleDian->id, // Dipastikan tidak null
            'date' => '2025-09-22',
            'start_time' => '09:30:00',
            'end_time' => '10:00:00',
            'complaint' => 'Batuk dan sakit tenggorokan selama tiga hari.',
            'status' => 'Scheduled',
            'type' => 'Offline',
        ]);
    }
}