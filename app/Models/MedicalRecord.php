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

    // Relasi dengan Appointment (1:1)
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // Relasi dengan Prescription (1:N)
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}