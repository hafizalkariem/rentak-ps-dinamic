<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Console;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ConsoleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Console::query();
        
        if ($request->has('type')) {
            $query->byType($request->type);
        }
        
        if ($request->has('available')) {
            $query->available();
        }
        
        if ($request->has('with') && $request->with === 'stations') {
            $query->with(['stations' => function($query) {
                $query->withPivot('id');
            }]);
        }
        
        $consoles = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => $consoles
        ]);
    }

    public function show(Console $console): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $console
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:ps3,ps4,ps5',
            'hourly_rate' => 'required|integer|min:0',
            'specifications' => 'nullable|array',
            'image_url' => 'nullable|url'
        ]);
        
        $console = Console::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Console created successfully',
            'data' => $console
        ], 201);
    }

    public function update(Request $request, Console $console): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:ps3,ps4,ps5',
            'hourly_rate' => 'sometimes|integer|min:0',
            'status' => 'sometimes|in:available,occupied,maintenance',
            'specifications' => 'nullable|array',
            'image_url' => 'nullable|url',
            'is_active' => 'sometimes|boolean'
        ]);
        
        $console->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Console updated successfully',
            'data' => $console
        ]);
    }

    public function destroy(Console $console): JsonResponse
    {
        $console->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Console deleted successfully'
        ]);
    }
}
