<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminEventController extends Controller
{
    public function index(): JsonResponse
    {
        $events = Event::latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|string|max:100',
            'event_date' => 'required|date|after:today',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'max_participants' => 'nullable|integer|min:1',
            'entry_fee' => 'nullable|integer|min:0',
            'prize_pool' => 'nullable|integer|min:0',
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

    public function show(string $id): JsonResponse
    {
        $event = Event::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $event = Event::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'event_type' => 'sometimes|string|max:100',
            'event_date' => 'sometimes|date',
            'start_time' => 'sometimes|string',
            'end_time' => 'sometimes|string',
            'max_participants' => 'nullable|integer|min:1',
            'entry_fee' => 'nullable|integer|min:0',
            'prize_pool' => 'nullable|integer|min:0',
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

    public function destroy(string $id): JsonResponse
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }
}