<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            [
                'name' => 'action',
                'display_name' => 'Action',
                'description' => 'Fast-paced games with combat and adventure',
                'icon' => '⚔️',
                'is_active' => true
            ],
            [
                'name' => 'adventure',
                'display_name' => 'Adventure',
                'description' => 'Story-driven exploration games',
                'icon' => '🗺️',
                'is_active' => true
            ],
            [
                'name' => 'racing',
                'display_name' => 'Racing',
                'description' => 'High-speed racing and driving games',
                'icon' => '🏎️',
                'is_active' => true
            ],
            [
                'name' => 'sports',
                'display_name' => 'Sports',
                'description' => 'Athletic and competitive sports games',
                'icon' => '⚽',
                'is_active' => true
            ],
            [
                'name' => 'fighting',
                'display_name' => 'Fighting',
                'description' => 'Combat and martial arts games',
                'icon' => '👊',
                'is_active' => true
            ],
            [
                'name' => 'rpg',
                'display_name' => 'RPG',
                'description' => 'Role-playing games with character development',
                'icon' => '🧙',
                'is_active' => true
            ],
            [
                'name' => 'shooter',
                'display_name' => 'Shooter',
                'description' => 'First and third-person shooting games',
                'icon' => '🎯',
                'is_active' => true
            ],
            [
                'name' => 'strategy',
                'display_name' => 'Strategy',
                'description' => 'Tactical and strategic thinking games',
                'icon' => '♟️',
                'is_active' => true
            ]
        ];

        foreach ($genres as $genreData) {
            Genre::create($genreData);
        }
    }
}