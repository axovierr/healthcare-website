<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $patient = Patient::first();
        $doctor = Doctor::first();
        
        Notification::create([
            'patient_id' => $patient->id,
            'doctor_id' => null,
            'title' => 'Pengingat Janji Temu',
            'message' => 'Janji temu Anda besok dengan ' . $doctor->name . ' akan dilaksanakan.',
            'is_read' => false,
        ]);
    }
}