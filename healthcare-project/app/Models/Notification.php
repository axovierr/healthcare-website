<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    
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
}