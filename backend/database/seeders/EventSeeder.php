<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing events first
        Event::truncate();
        
        $events = [
            [
                'title' => 'EAFC 25 Championship',
                'description' => 'Join the ultimate EA FC 25 tournament and compete for amazing prizes! Show off your football skills in the latest FIFA experience.',
                'event_type' => 'tournament',
                'event_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'start_time' => '13:00',
                'end_time' => '18:00',
                'max_participants' => 32,
                'entry_fee' => 75000,
                'prize_pool' => 3500000,
                'status' => 'upcoming',
                'is_featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1200&h=800&fit=crop',
                'game_id' => 1
            ],
            [
                'title' => 'Spider-Man 2 Speed Run',
                'description' => 'Race through New York as Spider-Man in this exciting speed run competition. Fastest completion wins!',
                'event_type' => 'tournament',
                'event_date' => Carbon::now()->addDays(8)->format('Y-m-d'),
                'start_time' => '15:00',
                'end_time' => '19:00',
                'max_participants' => 20,
                'entry_fee' => 50000,
                'prize_pool' => 2000000,
                'status' => 'upcoming',
                'is_featured' => false,
                'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=1200&h=800&fit=crop',
                'game_id' => 2
            ],
            [
                'title' => 'PS5 Gaming Marathon',
                'description' => 'Join us for an epic 8-hour gaming marathon featuring the latest PS5 exclusives. Prizes every hour!',
                'event_type' => 'special',
                'event_date' => Carbon::now()->addDays(12)->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '18:00',
                'max_participants' => 50,
                'entry_fee' => 0,
                'prize_pool' => 0,
                'status' => 'upcoming',
                'is_featured' => false,
                'image_url' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?w=1200&h=800&fit=crop'
            ],
            [
                'title' => 'Call of Duty Warzone Tournament',
                'description' => 'Squad up and battle it out in the ultimate Call of Duty Warzone tournament. Team-based competition.',
                'event_type' => 'tournament',
                'event_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
                'start_time' => '14:00',
                'end_time' => '20:00',
                'max_participants' => 48,
                'entry_fee' => 100000,
                'prize_pool' => 5000000,
                'status' => 'upcoming',
                'is_featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1200&h=800&fit=crop',
                'game_id' => 3
            ],
            [
                'title' => 'Retro Gaming Championship',
                'description' => 'Nostalgic tournament featuring classic PlayStation games from PS1 and PS2 era. Relive the golden age!',
                'event_type' => 'tournament',
                'event_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
                'start_time' => '16:00',
                'end_time' => '21:00',
                'max_participants' => 24,
                'entry_fee' => 35000,
                'prize_pool' => 1500000,
                'status' => 'upcoming',
                'is_featured' => false,
                'image_url' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=1200&h=800&fit=crop',
                'game_id' => 4
            ],
            [
                'title' => 'Tekken 8 Fighting Championship',
                'description' => 'Ultimate fighting game tournament featuring Tekken 8. Show your martial arts skills in the ring!',
                'event_type' => 'tournament',
                'event_date' => Carbon::now()->addDays(25)->format('Y-m-d'),
                'start_time' => '13:00',
                'end_time' => '17:00',
                'max_participants' => 32,
                'entry_fee' => 60000,
                'prize_pool' => 2500000,
                'status' => 'upcoming',
                'is_featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=1200&h=800&fit=crop',
                'game_id' => 5
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}