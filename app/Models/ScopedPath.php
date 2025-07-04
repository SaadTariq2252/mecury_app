<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScopedPath extends Model
{
    protected $fillable = [
        'path_identifier',
        'name',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function findByPath(string $path): ?self
    {
        return static::where('path_identifier', $path)
                    ->where('is_active', true)
                    ->first();
    }
}