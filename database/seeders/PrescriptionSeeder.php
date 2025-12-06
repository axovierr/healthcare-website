<?php

namespace Database\Seeders;

use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan Model Relasi (Appointment) dimuat di MedicalRecord
        $medicalRecord = MedicalRecord::with('appointment')->first(); 

        // Pemeriksaan Keamanan
        if (!$medicalRecord || !$medicalRecord->appointment) {
            throw new \Exception('ERROR: Medical Record/Appointment tidak ditemukan. Cek seeder sebelumnya.');
        }

        $doctor = Doctor::find($medicalRecord->appointment->doctor_id);
        $patient = Patient::find($medicalRecord->appointment->patient_id);
        
        Prescription::create([
            'medical_record_id' => $medicalRecord->id,
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            
            // KOLOM LAMA (medicine_list) DIGANTI DENGAN 3 KOLOM BARU:
            'medication' => 'Amoxicillin 500mg dan Paracetamol 500mg', 
            'dosage' => 'Amoxicillin 3x1 hari; Paracetamol jika demam',
            'instructions' => 'Antibiotik harus dihabiskan.',
            
            // Kolom 'note' dari migrasi awal sudah dihapus, jadi tidak perlu lagi
        ]);
    }
}