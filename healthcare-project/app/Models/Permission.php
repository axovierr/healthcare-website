<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Penting untuk relasi many-to-many

class Permission extends Model
{
    use HasFactory;

    // ... properti lainnya

    /**
     * Permission belongs to many Roles.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}