<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Izinkan kolom ini diisi
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'title',
        'message',
        'is_read'
    ];
    
    // Relasi dengan Pasien (User)
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Relasi dengan Dokter (User)
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}