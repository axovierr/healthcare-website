<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'schedule_id',
        'date',
        'start_time',
        'end_time',
        'complaint',
        'status',
        'type',
        'consultation_fee',
        'payment_status',
        'va_number',
        'payment_url',
        'paid_at',
        'expired_at',
    ];

    protected $casts = [
        'date' => 'date',
        'consultation_fee' => 'decimal:2',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isFailed(): bool
    {
        return $this->payment_status === 'failed';
    }

    public function isPaymentExpired(): bool
    {
        return $this->payment_status === 'expired'
            || ($this->expired_at !== null && now()->isAfter($this->expired_at));
    }

    // Relasi dengan Patient (N:1)
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relasi dengan Doctor (N:1)
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Relasi dengan Schedule (N:1)
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    // Relasi dengan MedicalRecord (1:1)
    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    // Relasi dengan TelemedicineSession (1:1)
    public function telemedicineSession()
    {
        return $this->hasOne(TelemedicineSession::class);
    }
}