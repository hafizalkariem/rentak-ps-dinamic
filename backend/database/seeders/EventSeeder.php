<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'FIFA 24 Championship',
                'description' => 'Join the ultimate FIFA 24 tournament and compete for amazing prizes! Show off your football skills.',
                'event_type' => 'tournament',
                'event_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'start_time' => '14:00',
                'end_time' => '18:00',
                'max_participants' => 32,
                'entry_fee' => 50000,
                'prize_pool' => 'Rp 2,000,000',
                'status' => 'upcoming',
                'is_featured' => true
            ],
            [
                'title' => 'PS5 Launch Party',
                'description' => 'Celebrate the latest PS5 games with fellow gamers. Free snacks and drinks included!',
                'event_type' => 'party',
                'event_date' => Carbon::now()->addDays(14)->format('Y-m-d'),
                'start_time' => '19:00',
                'end_time' => '23:00',
                'max_participants' => 50,
                'entry_fee' => 0,
                'prize_pool' => 'Gaming Merchandise',
                'status' => 'upcoming',
                'is_featured' => false
            ],
            [
                'title' => 'Call of Duty Battle Royale',
                'description' => 'Squad up and battle it out in the ultimate Call of Duty tournament.',
                'event_type' => 'tournament',
                'event_date' => Carbon::now()->addDays(21)->format('Y-m-d'),
                'start_time' => '15:00',
                'end_time' => '19:00',
                'max_participants' => 40,
                'entry_fee' => 75000,
                'prize_pool' => 'Rp 3,000,000',
                'status' => 'upcoming',
                'is_featured' => false
            ],
            [
                'title' => 'Retro Gaming Night',
                'description' => 'Take a trip down memory lane with classic PlayStation games from the PS1 and PS2 era.',
                'event_type' => 'party',
                'event_date' => Carbon::now()->addDays(28)->format('Y-m-d'),
                'start_time' => '18:00',
                'end_time' => '22:00',
                'max_participants' => 30,
                'entry_fee' => 25000,
                'prize_pool' => 'Retro Gaming Collection',
                'status' => 'upcoming',
                'is_featured' => false
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}