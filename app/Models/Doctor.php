<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'license_no',
        'gender',
        'address_clinic',
        'fee',
    ];

    protected $casts = [
        'fee' => 'decimal:2',
    ];

    /**
     * Relasi dengan User (profil dokter)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan DoctorSession (jadwal praktik)
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(DoctorSession::class);
    }

    /**
     * Get only available sessions (jadwal yang masih bisa dibooking)
     */
    public function availableSessions(): HasMany
    {
        return $this->hasMany(DoctorSession::class)
            ->where('is_available', true)
            ->orderBy('date')
            ->orderBy('start_time');
    }

    /**
     * Relasi dengan Appointment (janji temu)
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Relasi dengan Prescription (resep obat)
     */
    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }
    
    /**
     * Relasi dengan Notification (notifikasi)
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Relasi dengan TelemedicineSession (sesi telemedicine)
     */
    public function telemedicineSessions(): HasMany
    {
        return $this->hasMany(TelemedicineSession::class);
    }
}