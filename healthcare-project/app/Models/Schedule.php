<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'schedule_day',
        'start_time',
        'end_time',
        'status',
    ];
    
    // Relasi dengan Doctor (N:1)
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Relasi dengan Appointment (1:N)
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}