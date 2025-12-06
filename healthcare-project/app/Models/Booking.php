<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'note',
    ];

    public function session()
    {
        return $this->belongsTo(DoctorSession::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
