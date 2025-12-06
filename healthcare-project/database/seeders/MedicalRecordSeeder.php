<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $appointment = Appointment::where('complaint', 'Batuk dan sakit tenggorokan selama tiga hari.')->first();
        
        MedicalRecord::create([
            'appointment_id' => $appointment->id,
            'visit_date' => $appointment->date,
            'diagnosis' => 'Faringitis Akut',
            'doctor_notes' => 'Telah diberikan resep antibiotik dan obat pereda nyeri. Pasien disarankan banyak minum air putih.',
        ]);
    }
}