<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminUser extends Authenticatable
{
    protected $fillable = [
        'email',
        'password',
        'role',
        'troupe_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function troupe(): BelongsTo
    {
        return $this->belongsTo(Troupe::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isTheaterAdmin(): bool
    {
        return $this->role === 'theater_admin';
    }
}
