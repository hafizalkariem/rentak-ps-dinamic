<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Game::with('genre')->active();
        
        if ($request->has('console_type')) {
            $query->byConsole($request->console_type);
        }
        
        if ($request->has('genre_id')) {
            $query->byGenre($request->genre_id);
        }
        
        if ($request->has('popular')) {
            $query->popular();
        }
        
        if ($request->has('new')) {
            $query->new();
        }
        
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        $games = $query->orderBy('is_popular', 'desc')
                      ->orderBy('is_new', 'desc')
                      ->orderBy('rating', 'desc')
                      ->get();
        
        return response()->json([
            'success' => true,
            'data' => $games
        ]);
    }

    public function show(Game $game): JsonResponse
    {
        $game->load('genre');
        
        return response()->json([
            'success' => true,
            'data' => $game
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'console_type' => 'required|in:ps3,ps4,ps5',
            'rating' => 'nullable|numeric|between:0,5',
            'max_players' => 'nullable|integer|min:1',
            'estimated_duration' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_popular' => 'boolean',
            'is_new' => 'boolean',
            'release_date' => 'nullable|date'
        ]);
        
        $game = Game::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Game created successfully',
            'data' => $game
        ], 201);
    }

    public function update(Request $request, Game $game): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'genre_id' => 'sometimes|exists:genres,id',
            'console_type' => 'sometimes|in:ps3,ps4,ps5',
            'rating' => 'nullable|numeric|between:0,5',
            'max_players' => 'nullable|integer|min:1',
            'estimated_duration' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_popular' => 'boolean',
            'is_new' => 'boolean',
            'is_active' => 'boolean',
            'release_date' => 'nullable|date'
        ]);
        
        $game->update($validated);
        $game->load('genre');
        
        return response()->json([
            'success' => true,
            'message' => 'Game updated successfully',
            'data' => $game
        ]);
    }

    public function destroy(Game $game): JsonResponse
    {
        $game->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Game deleted successfully'
        ]);
    }
}
