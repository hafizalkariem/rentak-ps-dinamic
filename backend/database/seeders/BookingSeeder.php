<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = [
            [
                'user_id' => 1,
                'console_id' => 1,
                'booking_date' => Carbon::today()->format('Y-m-d'),
                'start_time' => '10:00',
                'duration_hours' => 2,
                'end_time' => '12:00',
                'total_amount' => 60000,
                'status' => 'confirmed',
                'payment_status' => 'paid'
            ],
            [
                'user_id' => 2,
                'console_id' => 2,
                'booking_date' => Carbon::today()->format('Y-m-d'),
                'start_time' => '14:00',
                'duration_hours' => 3,
                'end_time' => '17:00',
                'total_amount' => 90000,
                'status' => 'confirmed',
                'payment_status' => 'paid'
            ],
            [
                'user_id' => 3,
                'console_id' => 3,
                'booking_date' => Carbon::today()->format('Y-m-d'),
                'start_time' => '19:00',
                'duration_hours' => 4,
                'end_time' => '23:00',
                'total_amount' => 120000,
                'status' => 'in_progress',
                'payment_status' => 'paid'
            ]
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }
    }
}