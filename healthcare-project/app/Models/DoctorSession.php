<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'is_available',
    ];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'schedule_id');
    }

    public $is_booked_override = null;

    public function getIsBookedAttribute()
    {
        if ($this->is_booked_override !== null) {
            return $this->is_booked_override;
        }

        // Check if there's a PAID appointment linked by schedule_id
        if ($this->appointment && $this->appointment->payment_status === 'paid') {
            return true;
        }
        
        // Also check if there's any PAID appointment with matching date, doctor, and time
        return Appointment::where('doctor_id', $this->doctor_id)
            ->whereDate('date', $this->date)
            ->where('start_time', $this->start_time)
            ->where('end_time', $this->end_time)
            ->where('payment_status', 'paid')
            ->exists();
    }
}
