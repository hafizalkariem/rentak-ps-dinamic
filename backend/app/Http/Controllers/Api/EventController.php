<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Event::query();
        
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
            'is_featured' => 'boolean'
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
            'is_featured' => 'boolean'
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
}
