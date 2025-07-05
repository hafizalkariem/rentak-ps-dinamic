<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'payment_status',
        'amount_paid',
        'registered_at'
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'amount_paid' => 'integer'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}