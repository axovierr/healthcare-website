<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id',
        'doctor_id',
        'patient_id',
        'medication',
        'dosage',
        'instructions',
    ];

    // Relasi dengan MedicalRecord (N:1)
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    // Relasi dengan Doctor (N:1)
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Relasi dengan Patient (N:1)
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}