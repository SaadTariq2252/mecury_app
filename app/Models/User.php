<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'scoped_path_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopedPath(): BelongsTo
    {
        return $this->belongsTo(ScopedPath::class);
    }

    public function hasPathAccess(string $pathIdentifier): bool
    {
        if (!$this->scopedPath) {
            return false;
        }

        return $this->scopedPath->path_identifier === $pathIdentifier && 
               $this->scopedPath->is_active;
    }

    public function getAssignedPath(): ?string
    {
        return $this->scopedPath?->path_identifier;
    }
}