<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Station extends Model
{
    protected $fillable = [
        'name',
        'location',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function consoles(): BelongsToMany
    {
        return $this->belongsToMany(Console::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}