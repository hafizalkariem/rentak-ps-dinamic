<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(): JsonResponse
    {
        $bookings = Booking::with(['consoleStation.console', 'consoleStation.station'])->latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'console_station_id' => 'required|exists:console_station,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|string',
            'duration_hours' => 'required|integer|min:1|max:12',
            'total_amount' => 'required|numeric|min:0',
            'customer_name' => 'required_without:user_id|string|max:255',
            'customer_phone' => 'required_without:user_id|string|max:20',
            'customer_email' => 'required_without:user_id|email|max:255',
            'notes' => 'nullable|string'
        ]);

        // Calculate end time
        $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime = $startTime->copy()->addHours($validated['duration_hours']);

        $booking = Booking::create([
            'user_id' => $validated['user_id'] ?? null,
            'console_station_id' => $validated['console_station_id'],
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'duration_hours' => $validated['duration_hours'],
            'end_time' => $endTime->format('H:i'),
            'total_amount' => $validated['total_amount'],
            'customer_name' => $validated['customer_name'] ?? null,
            'customer_phone' => $validated['customer_phone'] ?? null,
            'customer_email' => $validated['customer_email'] ?? null,
            'notes' => $validated['notes'],
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => $booking->load(['consoleStation.console', 'consoleStation.station'])
        ], 201);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => $booking->load('console')
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $booking = Booking::with(['consoleStation.console', 'consoleStation.station'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $booking
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $booking = Booking::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'sometimes|in:pending,confirmed,in_progress,completed,cancelled',
            'payment_status' => 'sometimes|in:pending,paid,failed,refunded'
        ]);

        $booking->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'data' => $booking->load(['consoleStation.console', 'consoleStation.station'])
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully'
        ]);
    }

    public function checkAvailability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'console_station_id' => 'sometimes|exists:console_station,id'
        ]);

        $query = Booking::where('booking_date', $validated['date'])
                       ->whereIn('status', ['confirmed', 'pending']);

        if (isset($validated['console_station_id'])) {
            $query->where('console_station_id', $validated['console_station_id']);
        }

        $bookedSlots = $query->get(['console_station_id', 'start_time', 'end_time']);

        return response()->json([
            'success' => true,
            'data' => $bookedSlots
        ]);
    }
}