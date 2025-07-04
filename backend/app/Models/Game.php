<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    protected $fillable = [
        'title',
        'genre_id',
        'console_type',
        'rating',
        'max_players',
        'estimated_duration',
        'description',
        'image_url',
        'is_popular',
        'is_new',
        'release_date',
        'is_active'
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'max_players' => 'integer',
        'is_popular' => 'boolean',
        'is_new' => 'boolean',
        'is_active' => 'boolean',
        'release_date' => 'date'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeNew($query)
    {
        return $query->where('is_new', true);
    }

    public function scopeByConsole($query, $console)
    {
        return $query->where('console_type', $console);
    }

    public function scopeByGenre($query, $genreId)
    {
        return $query->where('genre_id', $genreId);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
