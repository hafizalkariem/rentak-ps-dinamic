<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Event::with(['game', 'participants'])
                     ->withCount('participants');
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('type')) {
            $query->byType($request->type);
        }
        
        if ($request->has('featured')) {
            $query->featured();
        }
        
        if ($request->has('upcoming')) {
            $query->upcoming();
        }
        
        $events = $query->orderBy('is_featured', 'desc')
                       ->orderBy('event_date', 'asc')
                       ->get();
        
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    public function show(Event $event): JsonResponse
    {
        $event->load(['game', 'participants']);
        $event->loadCount('participants');
        
        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:tournament,party,workshop,competition',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_participants' => 'nullable|integer|min:1',
            'entry_fee' => 'nullable|integer|min:0',
            'prize_pool' => 'nullable|string|max:255',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'image_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'game_id' => 'nullable|exists:games,id|required_if:event_type,tournament'
        ]);
        
        $event = Event::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Event created successfully',
            'data' => $event
        ], 201);
    }

    public function update(Request $request, Event $event): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'sometimes|in:tournament,party,workshop,competition',
            'event_date' => 'sometimes|date|after_or_equal:today',
            'start_time' => 'sometimes|date_format:H:i',
            'end_time' => 'sometimes|date_format:H:i|after:start_time',
            'max_participants' => 'nullable|integer|min:1',
            'entry_fee' => 'nullable|integer|min:0',
            'prize_pool' => 'nullable|string|max:255',
            'status' => 'sometimes|in:upcoming,ongoing,completed,cancelled',
            'image_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'game_id' => 'nullable|exists:games,id|required_if:event_type,tournament'
        ]);
        
        $event->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully',
            'data' => $event
        ]);
    }

    public function destroy(Event $event): JsonResponse
    {
        $event->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }

    public function register(Request $request, Event $event): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }
        
        // Debug log
        \Log::info('Event registration attempt', [
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);

        // Check if already registered
        if ($event->participants()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this event'
            ], 400);
        }

        // Check if event is full
        if ($event->participants()->count() >= $event->max_participants) {
            return response()->json([
                'success' => false,
                'message' => 'Event is full'
            ], 400);
        }

        // Create registration
        $participant = $event->participants()->create([
            'user_id' => $user->id,
            'amount_paid' => $event->entry_fee,
            'payment_status' => $event->entry_fee > 0 ? 'pending' : 'paid'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => $participant
        ], 201);
    }
}
