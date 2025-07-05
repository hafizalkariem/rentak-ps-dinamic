<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConsoleStation extends Model
{
    protected $table = 'console_station';
    
    protected $fillable = [
        'console_id',
        'station_id'
    ];

    public function console(): BelongsTo
    {
        return $this->belongsTo(Console::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'console_station_id');
    }
}