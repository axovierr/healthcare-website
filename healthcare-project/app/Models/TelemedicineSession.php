<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelemedicineSession extends Model
{
    use HasFactory;
    
    // Relasi dengan Appointment (1:1)
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}