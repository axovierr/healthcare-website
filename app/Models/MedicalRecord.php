<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'visit_date',
        'diagnosis',
        'doctor_notes',
        'attachment_path',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    /**
     * Relasi ke Appointment (1:1)
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Relasi ke Prescription (1:N)
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    /* |--------------------------------------------------------------------------
    | RELASI KRITIS UNTUK ARCHIVE/ARSIP
    | Menggunakan hasOneThrough karena FK Pasien/Dokter berada di tabel Appointments.
    |--------------------------------------------------------------------------
    */

    /**
     * Mendapatkan Pasien melalui Appointment.
     * $this->hasOneThrough(FinalModel, IntermediateModel, IntermediateFK, FinalFK, LocalKey, IntermediateLocalKey)
     */
    public function patient()
    {
        return $this->hasOneThrough(
            Patient::class,
            Appointment::class,
            'id',             // FK di tabel appointments
            'id',             // FK di tabel patients
            'appointment_id', // Local key di medical_records
            'patient_id'      // Local key di appointments yang menunjuk ke patient
        );
    }

    /**
     * Mendapatkan Dokter melalui Appointment.
     */
    public function doctor()
    {
        return $this->hasOneThrough(
            Doctor::class,
            Appointment::class,
            'id',             // FK di tabel appointments
            'id',             // FK di tabel doctors
            'appointment_id', // Local key di medical_records
            'doctor_id'       // Local key di appointments yang menunjuk ke doctor
        );
    }
}