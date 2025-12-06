<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Penting untuk relasi many-to-many
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    // ... properti lainnya

    // PASTIKAN KOLOM INI ADA
    protected $fillable = [
        'name', // Untuk nama role (code)
        'display_name', // Untuk nama tampilan
        'description', // Jika Anda punya kolom deskripsi
        'is_active', // Jika Anda punya kolom status
    ];

    public function users(): HasMany
    {
        // Menghubungkan Role dengan Model User melalui foreign key 'role_id'
        return $this->hasMany(User::class, 'role_id'); 
    }

    /**
     * Role belongs to many Permissions.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role'); 
    }

}
