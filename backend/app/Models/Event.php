<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_type',
        'event_date',
        'start_time',
        'end_time',
        'max_participants',
        'entry_fee',
        'prize_pool',
        'status',
        'image_url',
        'is_featured',
        'game_id'
    ];

    protected $casts = [
        'event_date' => 'date',
        'max_participants' => 'integer',
        'entry_fee' => 'integer',
        'is_featured' => 'boolean'
    ];

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', today())
                    ->where('status', 'upcoming');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('event_type', $type);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function participants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function getParticipantsCountAttribute()
    {
        return $this->participants()->count();
    }
}
