<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\ConsoleStation;
use App\Models\User;
use Carbon\Carbon;

class FinalBookingSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing bookings
        Booking::query()->delete();
        
        $consoleStations = ConsoleStation::all();
        $users = User::all();
        
        if ($consoleStations->isEmpty() || $users->isEmpty()) {
            return;
        }

        $bookings = [
            // Bookings with user_id (no customer info)
            [
                'user_id' => $users->random()->id,
                'console_station_id' => $consoleStations->random()->id,
                'booking_date' => Carbon::today(),
                'start_time' => '10:00',
                'duration_hours' => 2,
                'end_time' => '12:00',
                'total_amount' => 50000,
                'status' => 'confirmed',
                'payment_status' => 'paid'
            ],
            [
                'user_id' => $users->random()->id,
                'console_station_id' => $consoleStations->random()->id,
                'booking_date' => Carbon::today(),
                'start_time' => '14:00',
                'duration_hours' => 3,
                'end_time' => '17:00',
                'total_amount' => 75000,
                'status' => 'confirmed',
                'payment_status' => 'paid'
            ],
            [
                'console_station_id' => $consoleStations->random()->id,
                'booking_date' => Carbon::today(),
                'start_time' => '19:00',
                'duration_hours' => 2,
                'end_time' => '21:00',
                'total_amount' => 50000,
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'customer_name' => 'Mike Johnson',
                'customer_phone' => '081234567892',
                'customer_email' => 'mike@example.com'
            ],
            [
                'console_station_id' => $consoleStations->random()->id,
                'booking_date' => Carbon::tomorrow(),
                'start_time' => '12:00',
                'duration_hours' => 2,
                'end_time' => '14:00',
                'total_amount' => 50000,
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'customer_name' => 'Sarah Wilson',
                'customer_phone' => '081234567893',
                'customer_email' => 'sarah@example.com'
            ],
            [
                'user_id' => $users->random()->id,
                'console_station_id' => $consoleStations->random()->id,
                'booking_date' => Carbon::tomorrow(),
                'start_time' => '16:00',
                'duration_hours' => 3,
                'end_time' => '19:00',
                'total_amount' => 75000,
                'status' => 'confirmed',
                'payment_status' => 'paid'
            ]
        ];

        foreach ($bookings as $bookingData) {
            Booking::create($bookingData);
        }
    }
}