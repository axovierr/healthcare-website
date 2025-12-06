<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Role;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'gender',
        'password',
        'role_id',
        'username',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // -------------------------------------------------------------
    // WAJIB DITAMBAHKAN: RELASI DAN HELPER UNTUK PERAN (ROLE)
    // -------------------------------------------------------------

    /**
     * User belongs to one role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Helper method to get role name.
     * Menggunakan operator nullsafe (?->) untuk menghindari error jika role belum dimuat.
     */
    public function getRoleName(): ?string
    {
        return $this->role?->name ?? null; // <-- PERBAIKAN PENTING DI SINI
    }

    /**
     * Helper method to check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->getRoleName() === 'admin';
    }

    /**
     * Helper method to check if user is a doctor.
     */
    public function isDoctor(): bool
    {
        return $this->getRoleName() === 'doctor';
    }
    
    /**
     * Helper method to check if user is a patient.
     */
    public function isPatient(): bool
    {
        return $this->getRoleName() === 'patient';
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->getRoleName() === $role;
    }

    /**
     * Get the doctor record associated with the user.
     */
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    /**
     * Get the patient record associated with the user.
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
}
