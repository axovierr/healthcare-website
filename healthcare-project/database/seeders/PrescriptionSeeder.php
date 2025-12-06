<?php

namespace Database\Seeders;

use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $medicalRecord = MedicalRecord::first();
        $doctor = Doctor::find($medicalRecord->appointment->doctor_id);
        $patient = Patient::find($medicalRecord->appointment->patient_id);
        
        Prescription::create([
            'medical_record_id' => $medicalRecord->id,
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'medicine_list' => "Amoxicillin 500mg, Paracetamol 500mg",
            'note' => 'Antibiotik dihabiskan. Paracetamol jika demam.',
        ]);
    }
}