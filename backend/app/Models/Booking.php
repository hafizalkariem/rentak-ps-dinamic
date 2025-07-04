<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'console_id',
        'booking_date',
        'start_time',
        'duration_hours',
        'end_time',
        'total_amount',
        'status',
        'payment_status',
        'notes',
        'customer_name',
        'customer_phone',
        'customer_email'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'duration_hours' => 'integer',
        'total_amount' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($booking) {
            if ($booking->start_time && $booking->duration_hours) {
                $startTime = Carbon::parse($booking->start_time);
                $booking->end_time = $startTime->addHours($booking->duration_hours)->format('H:i');
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function console(): BelongsTo
    {
        return $this->belongsTo(Console::class);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['confirmed', 'in_progress']);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('booking_date', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', today());
    }
}
