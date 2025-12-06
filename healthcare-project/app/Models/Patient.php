<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'birth_date',
        'gender',
        'golongan_darah',
        'address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Appointment (1:N)
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Relasi dengan MedicalRecord (1:N melalui Appointment)
    public function medicalRecords()
    {
        return $this->hasManyThrough(MedicalRecord::class, Appointment::class);
    }

    // Relasi dengan Prescription (1:N)
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
    
    // Relasi dengan Notification (1:N)
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Relasi dengan TelemedicineSession (1:N)
    public function telemedicineSessions()
    {
        return $this->hasMany(TelemedicineSession::class);
    }
}