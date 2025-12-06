<?php

namespace Database\Seeders;

use App\Models\TelemedicineSession;
use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TelemedicineSessionSeeder extends Seeder
{
    public function run(): void
    {
        $appointment = Appointment::first();
        
        TelemedicineSession::create([
            'appointment_id' => $appointment->id,
            'meet_link' => 'https://meet.google.com/xyz-abc-123',
            'duration_minutes' => 15,
            'status' => 'Finished',
        ]);
    }
}