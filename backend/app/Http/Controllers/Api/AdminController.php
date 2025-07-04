<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Console;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(): JsonResponse
    {
        $stats = [
            'total_users' => User::count(),
            'total_bookings' => Booking::count(),
            'total_consoles' => Console::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'total_revenue' => Booking::where('payment_status', 'paid')->sum('total_amount'),
            'monthly_revenue' => Booking::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->sum('total_amount')
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    public function users(): JsonResponse
    {
        $users = User::with('roles')->latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function bookings(): JsonResponse
    {
        $bookings = Booking::with(['user', 'console'])
            ->latest()
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    public function updateBookingStatus(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
            'payment_status' => 'sometimes|in:pending,paid,failed,refunded'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'data' => $booking->load(['user', 'console'])
        ]);
    }
}