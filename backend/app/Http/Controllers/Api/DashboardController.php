<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Console;
use App\Models\Game;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getStats(): JsonResponse
    {
        $activeConsoles = Console::where('status', 'available')->count();
        $todayBookings = Booking::whereDate('booking_date', Carbon::today())->count();
        $totalGames = Game::where('is_active', true)->count();
        $upcomingEvents = Event::where('status', 'upcoming')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'active_consoles' => $activeConsoles,
                'today_bookings' => $todayBookings,
                'total_games' => $totalGames,
                'upcoming_events' => $upcomingEvents
            ]
        ]);
    }
}