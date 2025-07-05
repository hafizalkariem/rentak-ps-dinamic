<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Console extends Model
{
    protected $fillable = [
        'name',
        'type',
        'hourly_rate',
        'status',
        'specifications',
        'image_url',
        'is_active'
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_active' => 'boolean',
        'hourly_rate' => 'integer'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function stations(): BelongsToMany
    {
        return $this->belongsToMany(Station::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
