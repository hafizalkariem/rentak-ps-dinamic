<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Genre;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing games first
        Game::truncate();
        
        $games = [
            [
                'title' => 'Spider-Man 2',
                'genre_id' => Genre::where('name', 'action')->first()->id,
                'console_type' => 'ps5',
                'rating' => 4.8,
                'max_players' => 1,
                'estimated_duration' => '15-20 hours',
                'description' => 'Experience the ultimate Spider-Man adventure with Peter Parker and Miles Morales.',
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202306/1219/1c7b75d8ed9271516546560d219ad0b22ee0a263b4537bd8.png',
                'is_popular' => true,
                'is_new' => true,
                'release_date' => '2023-10-20',
                'is_active' => true
            ],
            [
                'title' => 'FIFA 24',
                'genre_id' => Genre::where('name', 'sports')->first()->id,
                'console_type' => 'ps5',
                'rating' => 4.2,
                'max_players' => 4,
                'estimated_duration' => '90 minutes',
                'description' => 'The world\'s game with HyperMotionV technology and authentic football experience.',
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202305/1210/1684a706a6ab0e1c5b0b6b8d7b5b1b1b.jpg',
                'is_popular' => true,
                'is_new' => false,
                'release_date' => '2023-09-29',
                'is_active' => true
            ],
            [
                'title' => 'Call of Duty: Modern Warfare III',
                'genre_id' => Genre::where('name', 'shooter')->first()->id,
                'console_type' => 'ps5',
                'rating' => 4.5,
                'max_players' => 4,
                'estimated_duration' => '6-8 hours',
                'description' => 'The direct sequel to 2022\'s Modern Warfare II continues the rebooted series.',
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202308/0718/505490c5b5b1b1b1b1b1b1b1b1b1b1b1.jpg',
                'is_popular' => true,
                'is_new' => true,
                'release_date' => '2023-11-10',
                'is_active' => true
            ],
            [
                'title' => 'Gran Turismo 7',
                'genre_id' => Genre::where('name', 'racing')->first()->id,
                'console_type' => 'ps5',
                'rating' => 4.6,
                'max_players' => 2,
                'estimated_duration' => '20+ hours',
                'description' => 'The ultimate racing simulator with stunning graphics and realistic physics.',
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202110/2618/aGhopp3MHppi7kooGE2Dtt8C.png',
                'is_popular' => true,
                'is_new' => false,
                'release_date' => '2022-03-04',
                'is_active' => true
            ],
            [
                'title' => 'God of War Ragnarök',
                'genre_id' => Genre::where('name', 'action')->first()->id,
                'console_type' => 'ps5',
                'rating' => 4.9,
                'max_players' => 1,
                'estimated_duration' => '25-30 hours',
                'description' => 'Kratos and Atreus embark on a mythic journey for answers before Ragnarök arrives.',
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202207/1210/4xJ8XB3bi888QTLZYdl7Oi0s.png',
                'is_popular' => true,
                'is_new' => false,
                'release_date' => '2022-11-09',
                'is_active' => true
            ],
            [
                'title' => 'Tekken 8',
                'genre_id' => Genre::where('name', 'fighting')->first()->id,
                'console_type' => 'ps5',
                'rating' => 4.4,
                'max_players' => 2,
                'estimated_duration' => '2-3 hours',
                'description' => 'The legendary fighting game returns with stunning visuals and new mechanics.',
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202305/1210/505490c5b5b1b1b1b1b1b1b1b1b1b1b1.jpg',
                'is_popular' => true,
                'is_new' => true,
                'release_date' => '2024-01-26',
                'is_active' => true
            ],
            [
                'title' => 'Elden Ring',
                'genre_id' => Genre::where('name', 'rpg')->first()->id,
                'console_type' => 'ps5',
                'rating' => 4.7,
                'max_players' => 4,
                'estimated_duration' => '50+ hours',
                'description' => 'A fantasy action-RPG adventure set in the Lands Between.',
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202110/2000/aGhopp3MHppi7kooGE2Dtt8C.png',
                'is_popular' => true,
                'is_new' => false,
                'release_date' => '2022-02-25',
                'is_active' => true
            ],
            [
                'title' => 'Horizon Forbidden West',
                'genre_id' => Genre::where('name', 'adventure')->first()->id,
                'console_type' => 'ps5',
                'rating' => 4.6,
                'max_players' => 1,
                'estimated_duration' => '30+ hours',
                'description' => 'Join Aloy as she braves the Forbidden West to find the source of a mysterious plague.',
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202107/3100/HO8vkO9pfXhwbHi5WHECQJdN.png',
                'is_popular' => true,
                'is_new' => false,
                'release_date' => '2022-02-18',
                'is_active' => true
            ],
            [
                'title' => 'The Last of Us Part I',
                'genre_id' => Genre::where('name', 'action')->first()->id,
                'console_type' => 'ps4',
                'rating' => 4.8,
                'max_players' => 1,
                'estimated_duration' => '15 hours',
                'description' => 'Experience the emotional storytelling and refined gameplay of this acclaimed adventure.',
                'image_url' => 'https://image.api.playstation.com/vulcan/ap/rnd/202206/0720/eEczyEMDd2BLa3dtkGJVE9Id.png',
                'is_popular' => true,
                'is_new' => false,
                'release_date' => '2022-09-02',
                'is_active' => true
            ],
            [
                'title' => 'Uncharted 4: A Thief\'s End',
                'genre_id' => Genre::where('name', 'adventure')->first()->id,
                'console_type' => 'ps4',
                'rating' => 4.7,
                'max_players' => 1,
                'estimated_duration' => '15 hours',
                'description' => 'Nathan Drake\'s greatest adventure in his final chapter.',
                'image_url' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2618/Y02ljdBodKFBiziorYgqftLE.png',
                'is_popular' => false,
                'is_new' => false,
                'release_date' => '2016-05-10',
                'is_active' => true
            ]
        ];

        foreach ($games as $gameData) {
            Game::create($gameData);
        }
    }
}