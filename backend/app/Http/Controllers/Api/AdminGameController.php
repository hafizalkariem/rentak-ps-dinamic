<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminGameController extends Controller
{
    public function index(): JsonResponse
    {
        $games = Game::latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $games
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'console_type' => 'required|string|max:50',
            'rating' => 'nullable|numeric|between:0,5',
            'max_players' => 'nullable|integer|min:1',
            'estimated_duration' => 'nullable|string',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_popular' => 'boolean',
            'is_new' => 'boolean',
            'release_date' => 'nullable|date',
            'is_active' => 'boolean'
        ]);

        $game = Game::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Game created successfully',
            'data' => $game
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $game = Game::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $game
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $game = Game::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'genre' => 'sometimes|string|max:100',
            'console_type' => 'sometimes|string|max:50',
            'rating' => 'nullable|numeric|between:0,5',
            'max_players' => 'nullable|integer|min:1',
            'estimated_duration' => 'nullable|string',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_popular' => 'boolean',
            'is_new' => 'boolean',
            'release_date' => 'nullable|date',
            'is_active' => 'boolean'
        ]);

        $game->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Game updated successfully',
            'data' => $game
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return response()->json([
            'success' => true,
            'message' => 'Game deleted successfully'
        ]);
    }
}